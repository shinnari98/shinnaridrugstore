<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->string('name', 255)->nullable(false);
            $table->integer('category_id')->nullable(false);
            $table->unsignedBigInteger('producer_id')->nullable(false);
            $table->text('description')->nullable(false);
            $table->string('image', 255)->nullable(false);
            $table->float('price')->nullable(false);
            $table->float('star')->nullable();
            $table->integer('like_count')->nullable();
            $table->integer('sold')->nullable();
            $table->timestamps();
        });

        /* DB::table('products')
        ->join('likes', 'products.id', '=', 'likes.product_id')
        ->select('products.id', DB::raw('COUNT(likes.product_id) AS like_count'))
        ->groupBy('products.id')
        ->update(['products.`like_count`' => DB::raw('like_count')]); */
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
