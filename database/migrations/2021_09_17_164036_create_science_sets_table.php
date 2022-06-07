<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScienceSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('science_sets', function (Blueprint $table) {
            $table->tinyInteger('set');
            $table->string('subject');
            $table->unsignedBigInteger('day_id');
            $table->tinyInteger('nc_year')->default(9);

            $table->foreign('day_id')
                  ->references('id')
                  ->on('prep_days')
                  ->onDelete('restrict');
            $table->unique(['set', 'subject', 'day_id', 'nc_year']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('science_sets');
    }
}
