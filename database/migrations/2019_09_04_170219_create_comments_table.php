<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('commercial_id');
            $table->unsignedInteger('receiver_id');
            $table->unsignedInteger('sender_id')->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->string('name');
            $table->string('mobile');
            $table->text('content');
            $table->boolean('is_private')->default(0);
            $table->boolean('is_approved')->default(0);
            $table->timestamps();
            $table->foreign('commercial_id')->references('id')->on('commercials')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('comments')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
