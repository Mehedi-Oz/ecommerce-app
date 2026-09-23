<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductStoreRequest;
use App\Http\Requests\Admin\ProductUpdateRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\Tag;
use App\Models\Unit;
use App\Services\NotificationService;
use App\Traits\FileUpload;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use FileUpload;

    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => Category::all(),
            'subCategories' => SubCategory::all(),
            'brands' => Brand::all(),
            'units' => Unit::all(),
            'tags' => Tag::all(),
        ]);
    }

    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $tagSlugs = $data['tags'] ?? [];
        unset($data['tags']);

        $data['featured_image'] = $this->uploadFile($request->file('featured_image'), 'products');

        $product = Product::create($data);

        $product->tags()->sync($this->tagIdsForSlugs($tagSlugs));

        $this->uploadGalleryImages($product, $request->file('gallery_images', []));

        NotificationService::created();

        return redirect()->route('admin.products.index');
    }

    public function index(): View
    {
        $products = Product::with(['category', 'brand'])->latest()->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function show(Product $product): View
    {
        $product->load(['category', 'subCategory', 'brand', 'unit', 'images']);

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product): View
    {
        $product->load(['images', 'tags']);

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all(),
            'subCategories' => SubCategory::all(),
            'brands' => Brand::all(),
            'units' => Unit::all(),
            'tags' => Tag::all(),
        ]);
    }

    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validated();
        $tagSlugs = $data['tags'] ?? null;
        unset($data['tags']);

        $remainingGalleryCount = $product->images()
            ->whereNotIn('id', $request->input('remove_gallery_images', []))
            ->count();

        if ($remainingGalleryCount + count($request->file('gallery_images', [])) > 5) {
            return back()
                ->withErrors(['gallery_images' => 'A product cannot have more than 5 gallery images.'])
                ->withInput();
        }

        if ($request->hasFile('featured_image')) {
            if ($product->featured_image) {
                $this->deleteFile($product->featured_image);
            }

            $data['featured_image'] = $this->uploadFile($request->file('featured_image'), 'products');
        }

        $product->fill($data);

        if ($product->isDirty()) {
            $product->save();
        }

        if ($tagSlugs !== null) {
            $product->tags()->sync($this->tagIdsForSlugs($tagSlugs));
        }

        $this->removeGalleryImages($product, $request->input('remove_gallery_images', []));
        $this->uploadGalleryImages($product, $request->file('gallery_images', []));

        NotificationService::updated();

        return redirect()->route('admin.products.index');
    }

    public function destroy(Product $product): RedirectResponse
    {
        DB::transaction(function () use ($product) {
            if ($product->featured_image) {
                $this->deleteFile($product->featured_image);
            }

            foreach ($product->images as $image) {
                $this->deleteFile($image->image_path);
            }

            $product->delete();
        });

        NotificationService::deleted();

        return redirect()->route('admin.products.index');
    }

    public function toggleStatus(Product $product): RedirectResponse
    {
        $product->update([
            'status' => $product->status === 'published' ? 'unpublished' : 'published',
        ]);
        NotificationService::updated();

        return redirect()->route('admin.products.index');
    }

    public function toggleFeatured(Product $product): RedirectResponse
    {
        $product->update([
            'featured_status' => $product->featured_status === 'featured' ? 'not_featured' : 'featured',
        ]);
        NotificationService::updated();

        return redirect()->route('admin.products.index');
    }

    private function uploadGalleryImages(Product $product, array $files): void
    {
        $sortOrder = $product->images()->max('sort_order') ?? 0;

        foreach ($files as $file) {
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $sortOrder++;

            ProductImage::create([
                'product_id' => $product->id,
                'image_path' => $this->uploadFile($file, 'products/gallery'),
                'sort_order' => $sortOrder,
            ]);
        }
    }

    private function removeGalleryImages(Product $product, array $imageIds): void
    {
        $images = $product->images()->whereIn('id', $imageIds)->get();

        foreach ($images as $image) {
            $this->deleteFile($image->image_path);
            $image->delete();
        }
    }

    /**
     * @param  array<int, string>  $slugs
     * @return array<int, int>
     */
    private function tagIdsForSlugs(array $slugs): array
    {
        if ($slugs === []) {
            return [];
        }

        return Tag::query()->whereIn('slug', $slugs)->pluck('id')->all();
    }
}
