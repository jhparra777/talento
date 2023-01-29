<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperienciasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'experiencias';

    /**
     * Run the migrations.
     * @table experiencias
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('numero_id');
            $table->integer('user_id');
            $table->string('trabajo_temporal', 1)->nullable()->default(null);
            $table->string('nombre_temporal')->nullable()->default(null);
            $table->string('telefono_temporal')->nullable()->default(null);
            $table->string('nombre_empresa');
            $table->integer('ciudad_id')->nullable()->default(null);
            $table->string('cargo_desempenado');
            $table->string('nombres_jefe');
            $table->string('cargo_jefe');
            $table->string('movil_jefe')->nullable()->default(null);
            $table->string('fijo_jefe')->nullable()->default(null);
            $table->string('ext_jefe')->nullable()->default(null);
            $table->string('empleo_actual', 1);
            $table->date('fecha_inicio')->nullable()->default(null);
            $table->date('fecha_final')->nullable()->default(null);
            $table->string('salario_devengado');
            $table->integer('motivo_retiro')->nullable()->default(null);
            $table->longText('funciones_logros')->nullable()->default(null);
            $table->char('autoriza_solicitar_referencias', 1);
            $table->char('active', 1);
            $table->integer('pais_id')->nullable()->default(null);
            $table->integer('departamento_id')->nullable()->default(null);
            $table->string('cargo_especifico')->nullable()->default(null);

            $table->index(["numero_id"], 'numero_id');

            $table->index(["cargo_especifico"], 'idx_experiencias_cargo_especifico');

            $table->index(["user_id"], 'idx_experiencias_user_id');
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
