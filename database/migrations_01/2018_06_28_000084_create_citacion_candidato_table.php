<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitacionCandidatoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'citacion_candidato';

    /**
     * Run the migrations.
     * @table citacion_candidato
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('user_recepcion')->unsigned();
            $table->integer('id_motivo')->nullable()->default(null)->unsigned();
            $table->string('direccion_cita', 100)->nullable()->default(null);
            $table->date('fecha_cita')->nullable()->default(null);
            $table->string('hora_cita', 50)->nullable()->default(null);
            $table->string('observaciones')->nullable()->default(null);
            $table->string('estado', 20);
            $table->string('tipificacion', 20)->nullable()->default(null);
            $table->integer('call_center')->nullable()->default(null);

          
            $table->timestamps();


            $table->foreign('id_motivo')
                ->references('id')->on('motivo_recepcion')

                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('user_recepcion')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
