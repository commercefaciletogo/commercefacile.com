<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('code')->nullable();

            $table->string('title');
            $table->enum('condition', ['used', 'new'])->default('new');
            $table->longText('description');
            $table->integer('price');
            $table->boolean('negotiable');

            $table->integer('category_id')->index();
            $table->integer('user_id');

            $table->enum('status', ['pending', 'online', 'rejected', 'offline'])->default('pending');

            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();

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
        Schema::dropIfExists('ads');
    }
}
