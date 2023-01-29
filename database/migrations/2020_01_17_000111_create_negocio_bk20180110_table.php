<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNegocioBk20180110Table extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'negocio_bk20180110';

    /**
     * Run the migrations.
     * @table negocio_bk20180110
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
            $table->integer('ans_dias')->nullable()->default(null);
            $table->integer('sociedad')->nullable()->default(null);
            $table->integer('localidad')->nullable()->default(null);
            $table->integer('tipo_negocio')->nullable()->default(null);
            $table->string('linea_servicio')->nullable()->default(null);
            $table->integer('unidad_negocio')->nullable()->default(null);
            $table->string('nombre_negocio')->nullable()->default(null);
            $table->integer('depto_empresa_codigo')->nullable()->default(null);
            $table->integer('depto_geren_codigo')->nullable()->default(null);
            $table->integer('depto_division_codigo')->nullable()->default(null);
            $table->integer('depto_codigo')->nullable()->default(null);
            $table->string('estado', 5)->nullable()->default(null);
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
