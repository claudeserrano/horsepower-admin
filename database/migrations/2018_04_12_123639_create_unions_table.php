<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('guest_id');
            $table->string('WorkPhone')->nullable();
            $table->string('DateHired')->nullable();
            $table->string('PrimaryName');
            $table->string('PrimaryRel');
            $table->string('PrimaryAddress');
            $table->string('SecondaryName')->nullable();
            $table->string('SecondaryRel')->nullable();
            $table->string('SecondaryAddress')->nullable();
            $table->string('TertiaryName')->nullable();
            $table->string('TertiaryRel')->nullable();
            $table->string('TertiaryAddress')->nullable();
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
        Schema::dropIfExists('unions');
    }
}
