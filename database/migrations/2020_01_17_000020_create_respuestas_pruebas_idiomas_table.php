<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespuestasPruebasIdiomasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'respuestas_pruebas_idiomas';

    /**
     * Run the migrations.
     * @table respuestas_pruebas_idiomas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('puntuacion', 100)->nullable()->default(null);
            $table->integer('preg_prueba_id')->nullable()->default(null);
            $table->integer('candidato_id')->nullable()->default(null);
            $table->string('respuesta')->nullable()->default(null);
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
