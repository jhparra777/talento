<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrevistasCandidatosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'entrevistas_candidatos';

    /**
     * Run the migrations.
     * @table entrevistas_candidatos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('candidato_id')->nullable()->default(null);
            $table->integer('fuentes_publicidad_id')->nullable()->default(null);
            $table->text('aspecto_familiar')->nullable()->default(null);
            $table->text('aspectos_experiencia')->nullable()->default(null);
            $table->text('aspectos_personalidad')->nullable()->default(null);
            $table->text('fortalezas_cargo')->nullable()->default(null);
            $table->text('oportunidad_cargo')->nullable()->default(null);
            $table->text('concepto_general');
            $table->string('apto', 45)->nullable()->default(null);
            $table->integer('user_gestion_id')->nullable()->default(null);
            $table->text('aspecto_academico')->nullable()->default(null);
            $table->text('evaluacion_competencias')->nullable()->default(null);
            $table->tinyInteger('activo')->nullable()->default('1');
            $table->tinyInteger('asistio')->nullable()->default(null);
            $table->integer('req_id');

            $table->index(["candidato_id"], 'candidato_id');

            $table->index(["req_id"], 'req_id');
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
