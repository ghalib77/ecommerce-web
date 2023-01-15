<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Store extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store',function(Blueprint $table){
         $table->id();
         $table->string("name")->unique();
         $table->binary("store_image")->nullable(true);
         $table->string("location");
         $table->unsignedBigInteger('user_id');
         $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
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
