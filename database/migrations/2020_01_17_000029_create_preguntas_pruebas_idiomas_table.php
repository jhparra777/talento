<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreguntasPruebasIdiomasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'preguntas_pruebas_idiomas';

    /**
     * Run the migrations.
     * @table preguntas_pruebas_idiomas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->string('descripcion', 100);
            $table->integer('prueba_idio_id')->nullable()->default(null);
            $table->tinyInteger('activo')->default('1');
            $table->integer('tiempo')->nullable()->default('40');
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
