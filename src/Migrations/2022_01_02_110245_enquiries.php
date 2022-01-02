<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Enquiries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquiries', function($table){
            $table->id();
            $table->integer('form_id');
            $table->mediumText('data');
            $table->mediumText('mailto');
            $table->integer('user_id')->nullable();
            $table->string('ip_address', 255);
            $table->mediumText('files_keys')->nullable();
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
        Schema::dropIfExists('enquiries');
    }
}