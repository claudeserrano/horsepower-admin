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
            $table->string('value', 64)->unique();
            $table->string('token', 64)->unique();
            $table->integer('throttle')->default(0);
            $table->integer('emp_reg')->default(0);
            $table->integer('build_trade')->default(0);
            $table->integer('gov_id')->default(0);
            $table->integer('gcard')->default(0);
            $table->integer('ssn')->default(0);
            $table->integer('osha')->default(0);
            $table->integer('scaffold')->default(0);
            $table->integer('bank')->default(0);
            $table->integer('marriage')->default(0);
            $table->integer('birth_cert')->default(0);
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
