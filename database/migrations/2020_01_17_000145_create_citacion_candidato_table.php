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
    public $tableName = 'citacion_candidato';

    /**
     * Run the migrations.
     * @table citacion_candidato
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->integer('user_id');
            $table->integer('user_recepcion');
            $table->integer('id_motivo')->nullable()->default(null);
            $table->string('direccion_cita', 100)->nullable()->default(null);
            $table->date('fecha_cita')->nullable()->default(null);
            $table->string('hora_cita', 50)->nullable()->default(null);
            $table->string('observaciones')->nullable()->default(null);
            $table->string('estado', 20);
            $table->string('tipificacion', 20)->nullable()->default(null);
            $table->integer('call_center')->nullable()->default(null);
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
       Schema::dropIfExists($this->tableName);
     }
}
