<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('guest_id');
            $table->string('LName');
            $table->string('FName');
            $table->string('MI')->nullable();
            $table->char('SSN1', 3);
            $table->char('SSN2', 2);
            $table->char('SSN3', 4);
            $table->string('Number')->nullable();
            $table->string('Street');
            $table->string('City');
            $table->string('State');
            $table->char('Zip', 5);
            $table->char('AreaCode', 3);
            $table->char('TelNo1', 3);
            $table->char('TelNo2', 4);
            $table->char('AreaCodePhone', 3);
            $table->char('CellNo1', 3);
            $table->char('CellNo2', 4);
            $table->char('DOBMonth', 2);
            $table->char('DOBDay', 2);
            $table->char('DOBYear', 4);
            $table->string('Email');
            $table->char('StartMonth', 2);
            $table->char('StartDay', 2);
            $table->char('StartYear', 4);
            $table->string('EthnicGroup');
            $table->string('Race');
            $table->string('Sex');
            $table->string('Veteran');
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
        Schema::dropIfExists('informations');
    }
}
