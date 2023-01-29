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
    public $set_schema_table = 'negocio';

    /**
     * Run the migrations.
     * @table negocio
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('cliente_id')->nullable()->default(null)->unsigned();
            $table->integer('tipo_contrato_id')->nullable()->default(null)->unsigned();
            $table->integer('tipo_proceso_id')->nullable()->default(null)->unsigned();
            $table->string('num_negocio')->nullable()->default(null);
            $table->integer('tipo_jornada_id')->nullable()->default(null)->unsigned();
            $table->integer('pais_id')->nullable()->default(null)->unsigned();
            $table->integer('departamento_id')->nullable()->default(null)->unsigned();
            $table->integer('ciudad_id')->nullable()->default(null)->unsigned();
            $table->integer('ans_dias')->nullable()->default('3');
            $table->integer('sociedad')->nullable()->default('1')->unsigned();
            $table->integer('localidad')->nullable()->default('1');
            $table->integer('tipo_negocio')->nullable()->default('1')->unsigned();
            $table->string('linea_servicio')->nullable()->default('1');
            $table->string('unidad_negocio', 10)->nullable()->default('1');
            $table->string('nombre_negocio')->nullable()->default('soluciones');
            $table->integer('depto_empresa_codigo')->nullable()->default('1');
            $table->integer('depto_geren_codigo')->nullable()->default('1');
            $table->integer('depto_division_codigo')->nullable()->default('1');
            $table->integer('depto_codigo')->nullable()->default('1');
            $table->string('estado', 5)->nullable()->default('ACT');

            $table->timestamps();



            

            $table->foreign('tipo_proceso_id')
                ->references('id')->on('tipo_proceso')
                ->onDelete('cascade');

            

            $table->foreign('ciudad_id')
                ->references('id')->on('ciudad')
                ->onDelete('cascade');

            $table->foreign('cliente_id')
                ->references('id')->on('clientes')
                ->onDelete('cascade');

            $table->foreign('departamento_id')
                ->references('id')->on('departamentos')
                ->onDelete('cascade');

            $table->foreign('pais_id')
                ->references('id')->on('paises')
                ->onDelete('cascade');

            $table->foreign('sociedad')
                ->references('id')->on('sociedades')
                ->onDelete('cascade');

            $table->foreign('tipo_contrato_id')
                ->references('id')->on('tipos_contratos')
                ->onDelete('cascade');

            $table->foreign('tipo_jornada_id')
                ->references('id')->on('tipos_jornadas')
                ->onDelete('cascade');

            $table->foreign('tipo_negocio')
                ->references('id')->on('tipo_negocios')
                ->onDelete('cascade');
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
