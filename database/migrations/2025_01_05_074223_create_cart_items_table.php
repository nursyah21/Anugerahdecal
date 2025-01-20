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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade'); // ID keranjang yang itemnya terkait
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Produk yang ditambahkan
            $table->string('material'); // Bahan produk
            $table->decimal('material_price', 10, 2); // Harga bahan produk
            $table->string('lamination'); // Laminasi produk
            $table->decimal('lamination_price', 10, 2); // Harga laminasi produk
            $table->decimal('total_price', 10, 2); // Harga total per item (material + laminasi)
            $table->integer('quantity')->default(1); // Jumlah produk
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};
