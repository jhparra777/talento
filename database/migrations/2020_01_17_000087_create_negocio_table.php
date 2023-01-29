<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNegocioTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'negocio';

    /**
     * Run the migrations.
     * @table negocio
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('cliente_id')->nullable()->default(null);
            $table->integer('tipo_contrato_id')->nullable()->default(null);
            $table->integer('tipo_proceso_id')->nullable()->default(null);
            $table->string('num_negocio')->nullable()->default(null);
            $table->integer('tipo_jornada_id')->nullable()->default(null);
            $table->integer('pais_id')->nullable()->default(null);
            $table->integer('departamento_id')->nullable()->default(null);
            $table->integer('ciudad_id')->nullable()->default(null);
            $table->integer('ans_dias')->nullable()->default('3');
            $table->integer('sociedad')->nullable()->default('1');
            $table->integer('localidad')->nullable()->default('1');
            $table->integer('tipo_negocio')->nullable()->default('1');
            $table->string('linea_servicio')->nullable()->default('1');
            $table->string('unidad_negocio', 10)->nullable()->default('1');
            $table->string('nombre_negocio')->nullable()->default('T3RS');
            $table->integer('depto_empresa_codigo')->nullable()->default('1');
            $table->integer('depto_geren_codigo')->nullable()->default('1');
            $table->integer('depto_division_codigo')->nullable()->default('1');
            $table->integer('depto_codigo')->nullable()->default('1');
            $table->integer('estado')->nullable()->default('1');
            $table->longText('cargo_generico_id');
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
