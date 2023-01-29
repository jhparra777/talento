<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCiudadTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ciudad';

    /**
     * Run the migrations.
     * @table ciudad
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre');
            $table->integer('cod_pais');
            $table->integer('cod_departamento');
            $table->integer('cod_ciudad');
            $table->string('agencia')->nullable()->default(null);

            $table->index(["cod_pais", "cod_departamento", "cod_ciudad"], 'ciudad_uk_01');
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
