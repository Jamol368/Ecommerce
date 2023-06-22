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
            $table->foreignId('vendor_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('product_brand_id')->constrained();
            $table->string('model', 31)->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('product_code');
            $table->string('description');
            $table->text('detail');
            $table->float('tax')->nullable();
            $table->foreignId('currency_id')->constrained();
            $table->boolean('discount')->default(false);
            $table->foreignId('product_status_id')->constrained();
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
