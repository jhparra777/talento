<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstudiosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'estudios';

    /**
     * Run the migrations.
     * @table estudios
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('numero_id');
            $table->integer('user_id')->nullable()->default(null);
            $table->integer('nivel_estudio_id')->nullable()->default(null);
            $table->string('institucion')->nullable()->default(null);
            $table->char('termino_estudios', 1)->nullable()->default(null);
            $table->string('titulo_obtenido')->nullable()->default(null);
            $table->char('estudio_actual', 1)->nullable()->default(null);
            $table->integer('semestres_cursados')->nullable()->default(null);
            $table->date('fecha_finalizacion')->nullable()->default(null);
            $table->char('active', 1)->nullable()->default(null);
            $table->integer('pais_estudio')->nullable()->default(null);
            $table->integer('departamento_estudio')->nullable()->default(null);
            $table->integer('ciudad_estudio')->nullable()->default(null);

            $table->index(["numero_id"], 'numero_id');

            $table->index(["user_id"], 'estudios_user_id_foreign');

            $table->index(["titulo_obtenido"], 'idx_estudios_titulo_obtenido');
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
