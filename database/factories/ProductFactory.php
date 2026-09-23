<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Image filename prefix (slug + "-") to StarTech brand name.
     *
     * Canonical names match BrandFactory::STAR_TECH_BRANDS where possible so
     * seeded products reuse the same brand rows instead of duplicating them.
     *
     * @var array<string, string>
     */
    protected const SLUG_BRANDS = [
        'power-pac-' => 'Power Pac',
        'power-guard-' => 'Power Guard',
        'digital-x-' => 'Digital X',
        'maxgreen-' => 'MaxGreen',
        'marsriva-' => 'Marsriva',
        'trendsonic-' => 'TrendSonic',
        'value-top-' => 'Value-Top',
        'pc-power-' => 'PC Power',
        'eurovision-' => 'Eurovision',
        'gigasonic-' => 'Gigasonic',
        'thunderobot-' => 'Thunderobot',
        'uniview-' => 'Uniview',
        'gigabyte-' => 'Gigabyte',
        'transcend-' => 'Transcend',
        'twinmos-' => 'TwinMOS',
        'blisbond-' => 'Blisbond',
        'acefast-' => 'ACEFAST',
        'insta360-' => 'Insta360',
        'fujifilm-' => 'Fujifilm',
        'peladn-' => 'Peladn',
        'arktek-' => 'ARKTEK',
        'gunnir-' => 'GUNNIR',
        'unika-' => 'Unika',
        'colorful-' => 'Colorful',
        'inno3d-' => 'INNO3D',
        'xenthra-' => 'Xenthra',
        'santak-' => 'Santak',
        'kenson-' => 'Kenson',
        'prolink-' => 'Prolink',
        'addlink-' => 'Addlink',
        'biostar-' => 'Biostar',
        'samsung-' => 'Samsung',
        'walton-' => 'Walton',
        'teclast-' => 'Teclast',
        'lenovo-' => 'Lenovo',
        'philips-' => 'Philips',
        'hikvision-' => 'HikVision',
        'dahua-' => 'DAHUA',
        'kstar-' => 'KSTAR',
        'oscoo-' => 'OSCOO',
        'miphi-' => 'MiPhi',
        'lexar-' => 'Lexar',
        'geesuu-' => 'GEESUU',
        'koorui-' => 'Koorui',
        'asus-' => 'Asus',
        'acer-' => 'Acer',
        'dell-' => 'Dell',
        'chuwi-' => 'Chuwi',
        'smart-' => 'Smart',
        'tecno-' => 'TECNO',
        'honor-' => 'HONOR',
        'huawei-' => 'HUAWEI',
        'canon-' => 'Canon',
        'nikon-' => 'Nikon',
        'sony-' => 'Sony',
        'apple-' => 'Apple',
        'afox-' => 'AFOX',
        'ocpc-' => 'OCPC',
        'abit-' => 'Abit',
        'asrock-' => 'ASRock',
        'netac-' => 'Netac',
        'sjcam-' => 'SJCAM',
        'ausek-' => 'AUSEK',
        'ordro-' => 'ORDRO',
        'gopro-' => 'GoPro',
        'xiaomi-' => 'Xiaomi',
        'redmi-' => 'Redmi',
        'dji-' => 'DJI',
        'amd-' => 'AMD',
        'intel-' => 'Intel',
        'msi-' => 'MSI',
        'hp-' => 'HP',
        'aitc-' => 'AITC',
        'team-' => 'Team',
        'panasonic-' => 'Panasonic',
        'oneplus-' => 'OnePlus',
        'amazon-' => 'Amazon',
        'huion-' => 'Huion',
        'riro-' => 'Riro',
        'arzopa-' => 'Arzopa',
        'fopo-' => 'Fopo',
        'aiwa-' => 'AIWA',
        'apollo-' => 'Apollo',
        'iphone-' => 'Apple',
        'e99-' => 'Generic',
        'flyx-' => 'Generic',
        'v198-' => 'Generic',
        'dk-' => 'Generic',
        'u6-' => 'Generic',
        'pny-' => 'PNY',
        'sapphire-' => 'Sapphire',
        'powercolor-' => 'PowerColor',
        'sandisk-' => 'SanDisk',
        'seagate-' => 'Seagate',
        'kingston-' => 'Kingston',
        'corsair-' => 'Corsair',
        'logitech-' => 'Logitech',
        'jbl-' => 'JBL',
        'anker-' => 'Anker',
        'baseus-' => 'Baseus',
        'havit-' => 'Havit',
        'fantech-' => 'Fantech',
        'razer-' => 'Razer',
        'redragon-' => 'Redragon',
        'edifier-' => 'Edifier',
        'ugreen-' => 'UGREEN',
        'tp-link-' => 'TP-Link',
        'tenda-' => 'Tenda',
        'cudy-' => 'Cudy',
        'd-link-' => 'D-Link',
        'a4tech-' => 'A4Tech',
        'benq-' => 'BenQ',
        'epson-' => 'Epson',
        'brother-' => 'Brother',
        'lg-' => 'LG',
        'aoc-' => 'AOC',
        'viewsonic-' => 'ViewSonic',
        'tcl-' => 'TCL',
        'xtrike-me-' => 'Xtrike Me',
        'xinji-' => 'Xinji',
        'borofone-' => 'Borofone',
        'foneng-' => 'Foneng',
        'yison-' => 'Yison',
        'joyroom-' => 'Joyroom',
        'byz-' => 'Byz',
        'jiayou-' => 'Jiayou',
        'haylou-' => 'Haylou',
        'charg-' => 'Charg',
        'xo-' => 'XO',
        'hiksemi-' => 'HikSemi',
        'apacer-' => 'Apacer',
        'adata-' => 'Adata',
        't-wolf-' => 'T-Wolf',
        'meetion-' => 'Meetion',
        'microlab-' => 'Microlab',
        'mofii-' => 'Mofii',
        'candy-' => 'Candy',
        'elba-' => 'Elba',
        'elica-' => 'Elica',
        'pigeon-' => 'Pigeon',
        'saachi-' => 'Saachi',
        'vention-' => 'Vention',
        'vivanco-' => 'Vivanco',
        'rosenberger-' => 'Rosenberger',
        'ip-com-' => 'IP-COM',
        'totolink-' => 'Totolink',
        'pantum-' => 'Pantum',
        'deli-' => 'Deli',
        'magcubic-' => 'Magcubic',
        'aun-' => 'AUN',
        'cheerlux-' => 'Cheerlux',
        'ricoh-' => 'Ricoh',
        'meari-' => 'Meari',
        'newland-' => 'Newland',
        'jovision-' => 'Jovision',
        'qnap-' => 'QNAP',
        'orico-' => 'Orico',
        'asustor-' => 'Asustor',
        'dateup-' => 'DateUp',
        'cote-' => 'Cote',
        'solitine-' => 'Solitine',
        'nexakey-' => 'Nexakey',
        'toten-' => 'Toten',
        'bijoy-' => 'Bijoy',
        'eset-' => 'ESET',
        'rowa-' => 'Rowa',
        'haier-' => 'Haier',
        'realview-' => 'Realview',
        'hisense-' => 'Hisense',
        'beko-' => 'beko',
        'oraimo-' => 'Oraimo',
        'sharp-' => 'Sharp',
        'bosch-' => 'BOSCH',
        'dgs-' => 'DGS',
        'tplink-' => 'TP-Link',
        'mercusys-' => 'Mercusys',
        'ruijie-' => 'Ruijie',
        'ms-' => 'Microsoft',
        'windows-' => 'Microsoft',
        'adobe-' => 'Adobe',
        'microsoft-' => 'Microsoft',
        'office-' => 'Microsoft',
        'phantom-edge-' => 'Phantom Edge',
        'sjgam-' => 'SJGAM',
        'pxn-' => 'PXN',
        'xbox-' => 'Microsoft',
    ];

    /**
     * Realistic BDT price bands per product line [min, max].
     *
     * @var array<string, array{int, int}>
     */
    protected const PRICE_BANDS = [
        'gaming_laptop' => [65000, 550000],
        'laptop' => [28000, 350000],
        'desktop' => [25000, 450000],
        'monitor' => [7500, 160000],
        'phone' => [12000, 250000],
        'tablet' => [10000, 150000],
        'mirrorless' => [40000, 550000],
        'camera' => [4000, 80000],
        'drone' => [5000, 300000],
        'processor' => [4500, 120000],
        'graphics_card' => [7000, 350000],
        'motherboard' => [5500, 90000],
        'ssd' => [1200, 35000],
        'ups' => [4500, 80000],
        'accessories' => [300, 30000],
        'networking' => [1000, 90000],
        'office' => [5000, 400000],
        'security' => [2000, 120000],
        'server' => [20000, 2000000],
        'software' => [500, 30000],
        'tv' => [20000, 400000],
        'gaming' => [15000, 80000],
        'appliance' => [2000, 150000],
        'default' => [1000, 60000],
    ];

    /**
     * Tokens that stay fully uppercased in product names (PC, MSI, ...).
     *
     * @var array<int, string>
     */
    protected const NAME_ACRONYMS = [
        'PC', 'MSI', 'HP', 'DJI', 'LG', 'IPS', 'LED', 'FHD', 'QHD', 'UHD',
        'USB', 'SSD', 'HDD', 'RAM', 'CPU', 'GPU', 'AI', 'TV', 'AC',
        'RTX', 'GTX', 'RX', 'OS', 'IP', 'PTZ', 'DVR', 'NVR', 'XVR', 'CCTV',
        'NAS', 'QLED', 'OLED', 'XR', 'SF', 'EU',
    ];

    /**
     * Seed fixtures live outside the web root; assigned images are staged
     * into the public uploads folder so seeded products behave exactly
     * like admin-uploaded ones.
     */
    public const SEED_IMAGE_DIRECTORY = 'seeders/images/products';

    public const STAGED_IMAGE_PREFIX = 'uploads/products/';

    /**
     * Filenames cached from the seed image folder for the current process.
     *
     * @var array<int, string>|null
     */
    protected static ?array $seedImages = null;

    /**
     * Images already handed out in this process but not yet inserted.
     *
     * Factory definitions for a whole batch run before any insert, so
     * reservations keep batch mates from picking the same file.
     *
     * @var array<int, string>
     */
    protected static array $reservedImages = [];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $images = static::unusedSeedImages();

        if ($images === []) {
            return static::legacyDefinition();
        }

        return static::attributesForImage(fake()->randomElement($images));
    }

    /**
     * Build a product for one specific seed image file.
     */
    public function forImage(string $file): static
    {
        return $this->state(fn (): array => static::attributesForImage($file));
    }

    /**
     * Build the full attribute set for one seed image basename.
     *
     * @param  string  $file  Basename like "tenda-be12-pro-be7200-router.webp".
     * @return array<string, mixed>
     */
    public static function attributesForImage(string $file): array
    {
        static::$reservedImages[] = $file;

        $slug = pathinfo($file, PATHINFO_FILENAME);
        $brandName = static::brandFromSlug($slug);
        [$categoryName, $subCategoryName, $priceBand] = static::lineFromSlug($slug);

        $category = Category::query()->where('name', $categoryName)->first()
            ?? Category::factory()->create(['name' => $categoryName]);

        $subCategory = SubCategory::query()
            ->where('category_id', $category->getKey())
            ->where('name', $subCategoryName)
            ->first() ?? SubCategory::factory()->create([
                'category_id' => $category->getKey(),
                'name' => $subCategoryName,
            ]);

        $brand = Brand::query()->where('name', $brandName)->first()
            ?? Brand::factory()->create(['name' => $brandName]);

        $unit = Unit::query()->inRandomOrder()->first()
            ?? Unit::factory()->create(['name' => 'Piece', 'code' => '1_piece']);

        $name = static::nameFromSlug($slug);
        [$min, $max] = static::PRICE_BANDS[$priceBand] ?? static::PRICE_BANDS['default'];
        $regular = fake()->randomFloat(2, $min, $max);

        return [
            'category_id' => $category->getKey(),
            'sub_category_id' => $subCategory->getKey(),
            'brand_id' => $brand->getKey(),
            'unit_id' => $unit->getKey(),
            'name' => $name,
            'code' => fake()->unique()->bothify('PRD-#####'),
            'model' => static::modelFromSlug($slug),
            'stock_amount' => fake()->numberBetween(0, 100),
            'regular_amount' => $regular,
            'selling_amount' => round($regular * fake()->randomFloat(2, 0.85, 1), 2),
            'short_description' => "{$name} by {$brandName} — 100% genuine with official warranty. Best price in Bangladesh.",
            'long_description' => "Buy {$name} ({$subCategoryName}) online in Bangladesh at the best price. "
                ."Brand: {$brandName} | Model: ".static::modelFromSlug($slug).'. '
                .'100% genuine product with official warranty, EMI facility and fast nationwide delivery.',
            'featured_image' => static::stageSeedImage($file),
            'hit_count' => 0,
            'sales_count' => 0,
            'featured_status' => fake()->boolean(20) ? 'featured' : 'not_featured',
            'status' => 'published',
        ];
    }

    public function configure(): static
    {
        return $this->afterMaking(function (Product $product): void {
            if ($product->category_id !== null && $product->sub_category_id !== null) {
                $subCategory = SubCategory::query()->whereKey($product->sub_category_id)->first();

                if ($subCategory !== null && (int) $subCategory->category_id !== (int) $product->category_id) {
                    $product->category_id = $subCategory->category_id;
                }
            }
        });
    }

    /**
     * Fallback used when the seed image folder is missing (e.g. fresh clones
     * without the downloaded dataset or CI checkouts).
     *
     * @return array<string, mixed>
     */
    protected static function legacyDefinition(): array
    {
        $regular = fake()->randomFloat(2, 100, 5000);

        return [
            'category_id' => Category::factory(),
            'sub_category_id' => SubCategory::factory(),
            'brand_id' => Brand::factory(),
            'unit_id' => Unit::factory(),
            'name' => fake()->words(3, true),
            'code' => fake()->unique()->bothify('PRD-#####'),
            'model' => fake()->bothify('MDL-####'),
            'stock_amount' => fake()->numberBetween(0, 100),
            'regular_amount' => $regular,
            'selling_amount' => round($regular * 0.9, 2),
            'short_description' => fake()->sentence(),
            'long_description' => fake()->paragraph(),
            'featured_image' => null,
            'hit_count' => 0,
            'sales_count' => 0,
            'featured_status' => 'not_featured',
            'status' => 'published',
        ];
    }

    /**
     * Seed images no product uses yet.
     *
     * Falls back to the full list once every image is taken, so seeding
     * past the size of the dataset still works.
     *
     * @return array<int, string>
     */
    public static function unusedSeedImages(): array
    {
        $files = static::seedFileList();

        if ($files === []) {
            return [];
        }

        $used = Product::query()->whereNotNull('featured_image')->pluck('featured_image')
            ->map(static fn (string $path): string => basename($path))
            ->merge(static::$reservedImages)
            ->all();

        $unused = array_values(array_diff($files, $used));

        return $unused === [] ? $files : $unused;
    }

    /**
     * Pick a random downloaded StarTech image, if the dataset is present.
     */
    protected static function randomSeedImage(): ?string
    {
        $files = static::seedFileList();

        if ($files === []) {
            return null;
        }

        return fake()->randomElement($files);
    }

    /**
     * Copy a seed fixture into the public uploads folder and return the
     * public-relative path for storage, e.g. "uploads/products/foo.webp".
     *
     * Copying keeps one URL scheme for seeded and admin-uploaded images.
     * Skips the copy when the file is already staged, so re-seeding is
     * idempotent. Falls back to the bare staged path when the fixture is
     * missing (e.g. a stale filename in an existing database).
     */
    public static function stageSeedImage(string $file): string
    {
        $target = static::STAGED_IMAGE_PREFIX.$file;
        $source = database_path(static::SEED_IMAGE_DIRECTORY.'/'.$file);

        if (! Storage::disk('public')->exists($target) && is_file($source)) {
            Storage::disk('public')->put($target, file_get_contents($source));
        }

        return $target;
    }

    /**
     * Basenames cached from the seed image folder for the current process.
     *
     * @return array<int, string>
     */
    protected static function seedFileList(): array
    {
        if (static::$seedImages === null) {
            $files = [];
            $directory = database_path(static::SEED_IMAGE_DIRECTORY);

            if (is_dir($directory)) {
                foreach ((glob($directory.'/*.{webp,jpg,jpeg,png}', GLOB_BRACE) ?: []) as $path) {
                    $files[] = basename((string) $path);
                }

                sort($files);
            }

            static::$seedImages = $files;
        }

        return static::$seedImages;
    }

    /**
     * Detect the brand from an image slug like "asus-vivobook-go-15-...".
     */
    public static function brandFromSlug(string $slug): string
    {
        $slug = Str::lower($slug).'-';

        foreach (static::SLUG_BRANDS as $prefix => $brand) {
            if (str_starts_with($slug, Str::lower($prefix))) {
                return $brand;
            }
        }

        return Str::title(Str::before($slug, '-'));
    }

    /**
     * Map an image slug to [category, sub-category, price band].
     *
     * @return array{string, string, string}
     */
    public static function lineFromSlug(string $slug): array
    {
        $slug = Str::lower($slug);
        $tokens = explode('-', $slug);

        if (str_contains($slug, 'gaming-laptop')) {
            return ['Laptop', 'Gaming Laptop', 'gaming_laptop'];
        }

        if (str_contains($slug, 'laptop')) {
            return ['Laptop', 'All Laptop', 'laptop'];
        }

        if (str_contains($slug, 'gaming-monitor')) {
            return ['Monitor', 'Gaming Monitor', 'monitor'];
        }

        if (str_contains($slug, 'monitor')) {
            if (str_contains($slug, 'curved')) {
                return ['Monitor', 'Curved Monitor', 'monitor'];
            }

            if (str_contains($slug, 'touch')) {
                return ['Monitor', 'Touch Monitor', 'monitor'];
            }

            if (in_array('4k', $tokens, true)) {
                return ['Monitor', '4K Monitor', 'monitor'];
            }

            if (str_contains($slug, 'portable')) {
                return ['Monitor', 'Portable Monitor', 'monitor'];
            }

            return ['Monitor', 'Monitor', 'monitor'];
        }

        if (str_contains($slug, 'processor')) {
            return ['Component', 'Processor', 'processor'];
        }

        if (str_contains($slug, 'graphics-card') || str_contains($slug, 'graphic-card')) {
            return ['Component', 'Graphics Card', 'graphics_card'];
        }

        if (str_contains($slug, 'motherboard')) {
            return ['Component', 'Motherboard', 'motherboard'];
        }

        if (in_array('ssd', $tokens, true)) {
            return ['Component', 'SSD', 'ssd'];
        }

        if (str_contains($slug, 'power-station')) {
            return ['Power', 'Portable Power Station', 'ups'];
        }

        if (str_contains($slug, '-ups')) {
            return ['Power', 'UPS', 'ups'];
        }

        if (str_contains($slug, 'vr-headset') || str_contains($slug, 'vision-pro') || str_contains($slug, 'galaxy-xr') || str_contains($slug, 'playstation-vr')) {
            return ['Gaming', 'VR', 'gaming'];
        }

        if (str_starts_with($slug, 'iphone-')) {
            return ['Phone', 'iPhone', 'phone'];
        }

        if (str_contains($slug, 'samsung')) {
            return ['Phone', 'Samsung', 'phone'];
        }

        if (in_array('tv', $tokens, true)) {
            if (str_contains($slug, 'smart-tv') || str_contains($slug, 'google-tv') || str_contains($slug, 'android-tv')) {
                return ['TV', 'Smart TV', 'tv'];
            }

            if (in_array('4k', $tokens, true) || str_contains($slug, 'qled')) {
                return ['TV', '4K TV', 'tv'];
            }

            return ['TV', 'LED TV', 'tv'];
        }

        if (str_contains($slug, 'antivirus')) {
            return ['Software', 'Antivirus', 'software'];
        }

        if (str_contains($slug, 'bangla-software') || str_contains($slug, 'bijoy')) {
            return ['Software', 'Bangla Typing Software', 'software'];
        }

        if (str_starts_with($slug, 'adobe-')) {
            return ['Software', 'Adobe', 'software'];
        }

        if (str_starts_with($slug, 'windows-')) {
            return ['Software', 'Operating System', 'software'];
        }

        if (str_starts_with($slug, 'microsoft-') || str_starts_with($slug, 'ms-office-') || str_starts_with($slug, 'office-')) {
            return ['Software', 'Office Application', 'software'];
        }

        if (str_contains($slug, 'cc-camera')
            || str_contains($slug, 'bullet-camera')
            || str_contains($slug, 'turret-camera')
            || str_contains($slug, 'dome-camera')
            || str_starts_with($slug, 'dahua-hac-')
        ) {
            return ['Security', 'CC Camera', 'security'];
        }

        if (in_array('dvr', $tokens, true)) {
            return ['Security', 'DVR', 'security'];
        }

        if (in_array('nvr', $tokens, true)) {
            return ['Security', 'NVR', 'security'];
        }

        if (in_array('xvr', $tokens, true)) {
            return ['Security', 'XVR', 'security'];
        }

        if (str_contains($slug, 'wifi-camera') || str_contains($slug, 'wi-fi-camera') || in_array('security', $tokens, true)) {
            return ['Security', 'Portable WiFi Camera', 'security'];
        }

        if (str_contains($slug, 'ip-camera')) {
            return ['Security', 'IP Camera', 'security'];
        }

        if (str_contains($slug, 'keyboard')) {
            return ['Accessories', 'Keyboard', 'accessories'];
        }

        if (str_contains($slug, 'mouse')) {
            return ['Accessories', 'Mouse', 'accessories'];
        }

        if (str_contains($slug, 'earbuds') || str_contains($slug, 'earphone')) {
            return ['Accessories', 'Earbuds', 'accessories'];
        }

        if (str_contains($slug, 'headphone') || str_contains($slug, 'headset')) {
            if (str_contains($slug, 'bluetooth')) {
                return ['Accessories', 'Bluetooth Headphone', 'accessories'];
            }

            return ['Accessories', 'Headphone', 'accessories'];
        }

        if (str_contains($slug, 'speaker')) {
            if (str_contains($slug, 'bluetooth')) {
                return ['Accessories', 'Bluetooth Speakers', 'accessories'];
            }

            return ['Accessories', 'Speaker & Home Theater', 'accessories'];
        }

        if (str_contains($slug, 'power-bank')) {
            return ['Accessories', 'Power Bank', 'accessories'];
        }

        if (str_contains($slug, 'pen-drive') || str_contains($slug, 'pendrive') || str_contains($slug, 'flash-drive') || str_starts_with($slug, 'adata-uv')) {
            return ['Accessories', 'Pen Drive', 'accessories'];
        }

        if (str_contains($slug, 'memory-card') || str_contains($slug, 'microsd') || str_contains($slug, 'micro-sd')) {
            return ['Accessories', 'Memory Card', 'accessories'];
        }

        if (str_contains($slug, 'router')) {
            return ['Networking', 'Router', 'networking'];
        }

        if (str_contains($slug, 'access-point') || in_array('cpe', $tokens, true) || str_contains($slug, 'basestation')) {
            return ['Networking', 'Access Point', 'networking'];
        }

        if (str_contains($slug, 'patch-') || str_contains($slug, '-cat-')) {
            return ['Networking', 'Networking Cable', 'networking'];
        }

        if (str_contains($slug, 'faceplate')) {
            return ['Networking', 'Faceplate', 'networking'];
        }

        if (str_contains($slug, 'connector') || str_contains($slug, 'modular-jack')) {
            return ['Networking', 'Connector', 'networking'];
        }

        if (str_starts_with($slug, 'tenda-')) {
            return ['Networking', 'Router', 'networking'];
        }

        if (str_contains($slug, 'printer')) {
            if (str_contains($slug, 'laser')) {
                return ['Office Equipment', 'Laser Printer', 'office'];
            }

            return ['Office Equipment', 'Printer', 'office'];
        }

        if (str_contains($slug, 'projector')) {
            return ['Office Equipment', 'Projector', 'office'];
        }

        if (str_contains($slug, 'photocopier') || str_contains($slug, 'copier') || str_contains($slug, 'document-feeder')) {
            return ['Office Equipment', 'Photocopier', 'office'];
        }

        if (str_contains($slug, 'money-counting')) {
            return ['Office Equipment', 'Money Counting Machine', 'office'];
        }

        if (str_contains($slug, 'scanner')) {
            return ['Office Equipment', 'Scanner', 'office'];
        }

        if (str_contains($slug, 'air-fryer')) {
            return ['Appliance', 'Air Fryer', 'appliance'];
        }

        if (str_contains($slug, 'vacuum-cleaner')) {
            return ['Appliance', 'Vacuum Cleaner', 'appliance'];
        }

        if (in_array('hob', $tokens, true) || str_contains($slug, 'kitchen-hood')) {
            return ['Appliance', 'Appliance', 'appliance'];
        }

        if (str_contains($slug, 'gpu-server')) {
            return ['Server & Storage', 'GPU Server', 'server'];
        }

        if (str_contains($slug, 'server-rack') || in_array('rack', $tokens, true)) {
            return ['Server & Storage', 'Server Rack', 'server'];
        }

        if (in_array('nas', $tokens, true)) {
            return ['Server & Storage', 'NAS Storage', 'server'];
        }

        if (in_array('pdu', $tokens, true)) {
            return ['Server & Storage', 'Server Rack', 'server'];
        }

        $isTablet = array_intersect($tokens, ['tablet', 'tab', 'pad', 'kindle', 'walpad', 'matepad', 'megapad']) !== []
            || str_starts_with($slug, 'teclast-t');

        if (! $isTablet) {
            foreach ($tokens as $token) {
                if (str_ends_with($token, 'pad') || str_ends_with($token, 'tab')) {
                    $isTablet = true;

                    break;
                }
            }
        }

        if ($isTablet) {
            return ['Tablet', 'Tablet', 'tablet'];
        }

        if (str_contains($slug, 'mirrorless')) {
            return ['Camera', 'Mirrorless Camera', 'mirrorless'];
        }

        if (str_contains($slug, 'camera')
            || str_contains($slug, 'osmo')
            || str_contains($slug, 'pocket')
            || str_contains($slug, 'gimbal')
            || str_contains($slug, 'action-')
            || str_starts_with($slug, 'insta360-')
            || str_starts_with($slug, 'gopro-')
        ) {
            return ['Camera', 'Action Camera', 'camera'];
        }

        if (str_contains($slug, 'gaming-console')
            || str_starts_with($slug, 'playstation-')
            || str_starts_with($slug, 'nintendo-')
            || str_starts_with($slug, 'xbox-')
        ) {
            return ['Gaming', 'Gaming Console', 'gaming'];
        }

        if (str_contains($slug, 'gaming-chair')) {
            return ['Gaming', 'Gaming Chair', 'gaming'];
        }

        if (str_contains($slug, 'gaming-desk') && ! str_contains($slug, 'gaming-desktop')) {
            return ['Gaming', 'Gaming Desk', 'gaming'];
        }

        if (str_contains($slug, 'racing-wheel') || str_contains($slug, 'driving-force')) {
            return ['Gaming', 'Racing Wheel', 'gaming'];
        }

        if (str_contains($slug, 'drone') || str_starts_with($slug, 'dji-')) {
            return ['Gadget', 'Drones', 'drone'];
        }

        if (str_contains($slug, 'gaming-pc')) {
            return ['Desktop', 'Gaming PC', 'desktop'];
        }

        if (str_contains($slug, 'brand-pc')) {
            return ['Desktop', 'Brand PC', 'desktop'];
        }

        if (str_contains($slug, '-pc') || str_contains($slug, '-desktop')) {
            return ['Desktop', 'Star PC', 'desktop'];
        }

        if (str_starts_with($slug, 'amd-')) {
            return ['Component', 'Processor', 'processor'];
        }

        return ['Gadget', 'Daily Lifestyle', 'default'];
    }

    /**
     * Turn "asus-vivobook-go-15-e1504ta-laptop" into "Asus Vivobook Go 15 E1504TA Laptop".
     */
    public static function nameFromSlug(string $slug): string
    {
        $titled = Str::title(str_replace('-', ' ', $slug));

        $titled = (string) preg_replace_callback(
            '/(?<=\s|^)(?=\w*\d)\w+/',
            static fn (array $matches): string => strtoupper($matches[0]),
            $titled
        );

        $words = explode(' ', $titled);

        foreach ($words as $index => $word) {
            if (in_array(strtoupper($word), static::NAME_ACRONYMS, true)) {
                $words[$index] = strtoupper($word);
            }
        }

        return implode(' ', $words);
    }

    /**
     * Pull a model-like token (letters + digits) out of the slug.
     */
    public static function modelFromSlug(string $slug): string
    {
        foreach (explode('-', Str::lower($slug)) as $token) {
            if (preg_match('/[a-z]/', $token) === 1 && preg_match('/\d/', $token) === 1) {
                return strtoupper($token);
            }
        }

        return fake()->bothify('MDL-####');
    }
}
