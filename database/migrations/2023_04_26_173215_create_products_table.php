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
            $table->string('product_code', 127);
            $table->string('barcode', 127)->nullable();
            $table->foreignId('main_category_id')->constrained();
            $table->foreignId('top_category_id')->nullable()->constrained();
            $table->foreignId('sub_category_id')->nullable()->constrained();
            $table->smallInteger('active')->default(0);
            $table->foreignId('product_brand_id')->nullable()->constrained();
            $table->string('name', 255);
            $table->string('description', 255);
            $table->float('list_price');
            $table->float('price');
            $table->float('tax');
            $table->string('currency', 7);
            $table->integer('quantity');
            $table->smallInteger('in_discount')->default(0);
            $table->text('detail');
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
