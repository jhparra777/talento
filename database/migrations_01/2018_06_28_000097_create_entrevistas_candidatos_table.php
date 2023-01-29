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
    public $set_schema_table = 'entrevistas_candidatos';

    /**
     * Run the migrations.
     * @table entrevistas_candidatos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('candidato_id')->nullable()->default(null)->unsigned();
            $table->integer('fuentes_publicidad_id')->nullable()->default(null)->unsigned();
            $table->integer('req_id')->nullable()->default(null)->unsigned();
            $table->string('aspecto_familiar', 250)->nullable()->default(null);
            $table->string('aspectos_experiencia', 250)->nullable()->default(null);
            $table->string('aspectos_personalidad', 250)->nullable()->default(null);
            $table->string('fortalezas_cargo', 250)->nullable()->default(null);
            $table->string('oportunidad_cargo', 250)->nullable()->default(null);
            $table->string('concepto_general', 250);
            $table->string('apto', 45)->nullable()->default(null);
            $table->integer('user_gestion_id')->nullable()->default(null)->unsigned();
            $table->string('aspecto_academico', 250)->nullable()->default(null);
            $table->string('evaluacion_competencias', 250)->nullable()->default(null);
            $table->tinyInteger('activo')->nullable()->default('1');
            $table->tinyInteger('asistio')->nullable()->default(null);

          
            $table->timestamps();


            $table->foreign('req_id')
                ->references('id')->on('requerimientos')->onDelete('cascade');;

                

                 $table->foreign('candidato_id')
                ->references('id')->on('users')->onDelete('cascade');;

                

            $table->foreign('user_gestion_id')
                ->references('id')->on('users')->onDelete('cascade');;
               

            $table->foreign('fuentes_publicidad_id')
                ->references('id')->on('tipo_fuente')->onDelete('cascade');;
                
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
