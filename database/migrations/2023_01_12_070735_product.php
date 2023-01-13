<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product',function(Blueprint $table){
            $table->id();
            $table->string("name");
            $table->string('price');
            $table->binary('photo_product');
            $table->text('description');
            $table->string('quantity');
            $table->decimal("product_rating", $precision=2, $scale=0)->default(0);
            $table->unsignedBigInteger('shop_id');
            $table->foreign('shop_id')->references('id')->on('shop')->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('restrict')->onUpdate('cascade'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
