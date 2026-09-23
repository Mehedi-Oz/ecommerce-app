<?php

namespace Database\Seeders;

use App\Models\Product;
use Database\Factories\ProductFactory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    protected const PRODUCT_TARGET = 500;

    protected const GALLERY_MIN = 2;

    protected const GALLERY_MAX = 4;

    /**
     * Categories that must each end up with at least this many products.
     */
    protected const COVERAGE_MINIMUM = 10;

    /**
     * @var array<int, string>
     */
    protected const COVERAGE_CATEGORIES = [
        'Accessories',
        'Appliance',
        'Gaming',
        'Networking',
        'Office Equipment',
        'Security',
        'Server & Storage',
        'Software',
        'TV',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = static::seedImages();

        Product::factory()
            ->count(max(0, static::PRODUCT_TARGET - Product::query()->count()))
            ->create()
            ->each(function (Product $product) use ($files): void {
                foreach (static::galleryFor($product, $files) as $order => $file) {
                    $product->images()->create([
                        'image_path' => ProductFactory::stageSeedImage($file),
                        'sort_order' => $order + 1,
                    ]);
                }
            });

        static::ensureCoverage($files);

        $this->command?->info('Seeded '.Product::query()->count().' products with gallery images.');
    }

    /**
     * Guarantee every coverage category owns real products.
     *
     * @param  array<int, string>  $files
     */
    protected static function ensureCoverage(array $files): void
    {
        if ($files === []) {
            return;
        }

        $used = Product::query()->whereNotNull('featured_image')->pluck('featured_image')
            ->map(static fn (string $path): string => basename($path))
            ->all();

        foreach (static::COVERAGE_CATEGORIES as $category) {
            $have = Product::query()->whereHas(
                'category',
                static fn ($query) => $query->where('name', $category)
            )->count();

            foreach (static::unusedLineImages($files, $used, $category) as $file) {
                if ($have >= static::COVERAGE_MINIMUM) {
                    break;
                }

                $product = Product::factory()->forImage($file)->create();

                foreach (static::galleryFor($product, $files) as $order => $galleryFile) {
                    $product->images()->create([
                        'image_path' => ProductFactory::stageSeedImage($galleryFile),
                        'sort_order' => $order + 1,
                    ]);
                }

                $used[] = $file;
                $have++;
            }
        }
    }

    /**
     * Images of one category line that no product uses yet.
     *
     * @param  array<int, string>  $files
     * @param  array<int, string>  $used
     * @return array<int, string>
     */
    protected static function unusedLineImages(array $files, array $used, string $category): array
    {
        $candidates = [];

        foreach ($files as $file) {
            if (in_array($file, $used, true)) {
                continue;
            }

            [$line] = ProductFactory::lineFromSlug(pathinfo($file, PATHINFO_FILENAME));

            if ($line === $category) {
                $candidates[] = $file;
            }
        }

        shuffle($candidates);

        return $candidates;
    }

    /**
     * Filenames available in the seed image folder.
     *
     * @return array<int, string>
     */
    protected static function seedImages(): array
    {
        $directory = database_path(ProductFactory::SEED_IMAGE_DIRECTORY);

        if (! is_dir($directory)) {
            return [];
        }

        $files = [];

        foreach ((glob($directory.'/*.{webp,jpg,jpeg,png}', GLOB_BRACE) ?: []) as $path) {
            $files[] = basename((string) $path);
        }

        sort($files);

        return $files;
    }

    /**
     * Pick gallery images from the same product line (e.g. other "hp-15"
     * shots for an HP laptop), falling back to random files.
     *
     * @param  array<int, string>  $files
     * @return array<int, string>
     */
    protected static function galleryFor(Product $product, array $files): array
    {
        $featured = $product->featured_image !== null
            ? basename($product->featured_image)
            : null;

        $pool = array_values(array_filter(
            $files,
            static fn (string $file): bool => $file !== $featured
        ));

        if ($pool === []) {
            return [];
        }

        $tokens = explode('-', pathinfo((string) $featured, PATHINFO_FILENAME));
        $prefixes = array_filter([
            implode('-', array_slice($tokens, 0, 3)),
            implode('-', array_slice($tokens, 0, 2)),
            $tokens[0] ?? '',
        ]);

        $family = [];
        $rest = [];

        foreach ($pool as $file) {
            $slug = pathinfo($file, PATHINFO_FILENAME);
            $sameLine = false;

            foreach ($prefixes as $prefix) {
                if (str_starts_with($slug, $prefix.'-')) {
                    $sameLine = true;

                    break;
                }
            }

            if ($sameLine) {
                $family[] = $file;
            } else {
                $rest[] = $file;
            }
        }

        shuffle($rest);

        return array_slice(
            [...$family, ...$rest],
            0,
            min(random_int(static::GALLERY_MIN, static::GALLERY_MAX), count($pool))
        );
    }
}
