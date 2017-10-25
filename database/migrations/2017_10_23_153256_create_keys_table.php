<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keys', function (Blueprint $table) {
            $table->increments('id');
            $table->string('empid', 6)->unique();
            $table->string('full_name', 128);
            $table->string('value', 64)->unique();
            $table->string('token', 64)->unique();
            $table->integer('throttle')->default(0);
            $table->integer('emp_reg')->default(1);
            $table->integer('build_trade')->default(1);
            $table->integer('files')->default(1);
            $table->integer('gov_id')->default(1);
            $table->integer('ssn')->default(1);
            $table->integer('bank')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keys');
    }
}
