<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtisanRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artisan_requests', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->string('address');
            $table->string('landmark');
            $table->string('phone');
            $table->string('state');
            $table->string('city');
            $table->unsignedBigInteger('job_id');
            $table->foreign('job_id')->references('id')->on('jobs');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('artisan_requests');
    }
}
