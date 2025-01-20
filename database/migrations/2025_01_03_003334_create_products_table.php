<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama produk
            $table->string('brand'); // Merek produk
            $table->string('material'); // Material produk
            $table->decimal('material_price', 10, 2); // Harga material
            $table->string('lamination'); // Laminasi produk
            $table->decimal('lamination_price', 10, 2); // Harga laminasi
            $table->text('description'); // Deskripsi produk
            $table->string('image'); // Gambar produk
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Kategori produk
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
