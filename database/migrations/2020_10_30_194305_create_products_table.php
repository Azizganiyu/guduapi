<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('modell_id')->nullable();
            $table->unsignedBigInteger('part_id');
            $table->unsignedBigInteger('year_id')->nullable();
            $table->unsignedBigInteger('condition_id');
            $table->unsignedBigInteger('make_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('make_id')->references('id')->on('makes');
            $table->foreign('condition_id')->references('id')->on('conditions');
            $table->foreign('part_id')->references('id')->on('parts');
            $table->foreign('year_id')->references('id')->on('years');
            $table->foreign('modell_id')->references('id')->on('modells');
            $table->foreign('year_id')->references('id')->on('years');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('name');
            $table->text('description');
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->integer('weight')->nullable();
            $table->integer('depth')->nullable();
            $table->integer('discount')->default(0);
            $table->integer('quantity');
            $table->integer('rating');
            $table->integer('price');
            $table->text('tags')->nullable();
            $table->boolean('status')->default(1);
            $table->text('images');
            $table->string('friendly_url');
            $table->string('vin_tag')->nullable();
            $table->string('part_number')->nullable();
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
        Schema::dropIfExists('products');
    }
}
