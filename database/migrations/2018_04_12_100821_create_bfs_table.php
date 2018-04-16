<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBfsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bfs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('guest_id');
            $table->string('Status');
            $table->string('HireDate')->nullable();
            $table->string('DateMarried')->nullable();
            $table->string('PlaceMarried')->nullable();
            $table->string('DateDivorced')->nullable();
            $table->char('CourtOrder', 1);
            $table->string('SpouseEmployer')->nullable();
            $table->string('SpouseEmployerAddress')->nullable();
            $table->string('SpouseDateHired')->nullable();
            $table->string('SpouseEmployerNumber')->nullable();
            $table->longText('Signature');
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
        Schema::dropIfExists('bfs');
    }
}
