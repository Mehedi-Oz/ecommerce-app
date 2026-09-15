<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->restrictOnDelete();
            $table->foreignId('sub_category_id')->constrained('sub_categories')->restrictOnDelete();
            $table->foreignId('brand_id')->constrained()->restrictOnDelete();
            $table->foreignId('unit_id')->constrained()->restrictOnDelete();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('model')->nullable();
            $table->unsignedInteger('stock_amount')->default(0);
            $table->decimal('regular_amount', 10, 2)->default(0);
            $table->decimal('selling_amount', 10, 2)->default(0);
            $table->text('short_description')->nullable();
            $table->longText('long_description')->nullable();
            $table->string('featured_image')->nullable();
            $table->unsignedInteger('hit_count')->default(0);
            $table->unsignedInteger('sales_count')->default(0);
            $table->enum('featured_status', ['featured', 'not_featured'])->default('not_featured');
            $table->enum('status', ['published', 'unpublished'])->default('published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
