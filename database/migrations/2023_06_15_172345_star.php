<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stars', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('user_id');
            $table->integer('product_id');
            $table->integer('star_number');
        });

        /* DB::statement("
        UPDATE products
        SET star = (
            SELECT AVG(star_number)
            FROM stars
            WHERE stars.product_id = products.id
            )
        ");

        DB::statement("
        UPDATE products
        SET orders = (
            SELECT SUM(quantity)
            FROM orders
            WHERE orders.product_id = products.id
            )
        "); */
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stars');
    }
};
