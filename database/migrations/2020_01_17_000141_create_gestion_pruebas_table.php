<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestionPruebasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'gestion_pruebas';

    /**
     * Run the migrations.
     * @table gestion_pruebas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tipo_prueba_id')->nullable()->default(null);
            $table->integer('puntaje')->nullable()->default(null);
            $table->longText('resultado')->nullable()->default(null);
            $table->string('nombre_archivo', 250)->nullable()->default(null);
            $table->date('fecha_vencimiento')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(null);
            $table->integer('candidato_id')->nullable()->default(null);
            $table->string('estado', 1)->nullable()->default(null);
            $table->tinyInteger('activo')->nullable()->default('1');
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
