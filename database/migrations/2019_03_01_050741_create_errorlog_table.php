<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateErrorlogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('errorlog', function (Blueprint $table) {
            $table->increments('id');
            $table->longText('error_message')->nullable();
            $table->string('line_number', 191)->nullable();
            $table->string('file_name', 191)->nullable();
            $table->string('browser', 191)->nullable();
            $table->string('operating_system', 191)->nullable();
            $table->integer('loggedin_id')->nullable();
            $table->string('ip_address', 191)->nullable();
            $table->enum('status',['1', '0'])->default('1')->comment="1=Active,0=Deactive";
            $table->enum('deleted',['1', '0'])->default('0')->comment="1=Deleted,0=Not Deleted";
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
        Schema::dropIfExists('errorlog');
    }
}
