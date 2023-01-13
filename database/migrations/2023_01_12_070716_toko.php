<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Toko extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop',function(Blueprint $table){
         $table->id();
         $table->string("name");
         $table->decimal("shop_rating", $precision=2, $scale=0)->default(0);
         $table->unsignedBigInteger('user_id');
         $table->foreign('user_id')->references('id')->on('user')->onUpdate('cascade')->onDelete('cascade');
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
