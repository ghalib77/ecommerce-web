<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Produk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produk',function(Blueprint $table){
            $table->id();
            $table->string("nama");
            $table->string('harga');
            $table->binary('photo_produk');
            $table->text('deskripsi');
            $table->string('banyak_produk');
            $table->decimal("rating_produk", $precision=2, $scale=0)->default(0);
            $table->unsignedBigInteger('toko_id');
            $table->foreign('toko_id')->references('id')->on('toko')->onUpdate('cascade')->onDelete('cascade');
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
