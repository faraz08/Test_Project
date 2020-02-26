<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedBigInteger('case_id');

            $table->integer('no_of_aligners');
            $table->integer('upper_aligner');
            $table->integer('lower_aligner');
            $table->string('file_before');
            $table->string('file_after');
            $table->string('ipr_form');
            $table->string('operator_name');
            $table->enum('status', array( 'Pending for approval', 'Request for modification', 'Modification uploaded'));
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
        Schema::dropIfExists('patients');
    }
}
