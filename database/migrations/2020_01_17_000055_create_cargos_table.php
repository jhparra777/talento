<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'cargos';

    /**
     * Run the migrations.
     * @table cargos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('emp_division');
            $table->double('emp_sociedad');
            $table->double('emp_localidad');
            $table->double('cargo_codigo_gen');
            $table->string('cargo_nombre_gen');
            $table->double('grado_codigo');
            $table->string('grado_nombre');
            $table->double('grado_codigo_fic');
            $table->string('grado_nombre_fic');
            $table->double('emp_jornada');
            $table->string('emp_horas_trab', 20);
            $table->double('emp_tipo_nomina');
            $table->string('emp_tipoliq', 2);
            $table->string('porc_arl', 20);
            $table->string('activo', 3);
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
