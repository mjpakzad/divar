<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommercialFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commercial_field', function (Blueprint $table) {
            $table->unsignedInteger('commercial_id');
            $table->unsignedInteger('field_id');
            $table->text('value');
            $table->primary(['commercial_id', 'field_id']);
            $table->foreign('commercial_id')->references('id')->on('commercials')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('field_id')->references('id')->on('fields')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('commercial_field');
    }
}
