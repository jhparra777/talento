<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequerimientosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'requerimientos';

    /**
     * Run the migrations.
     * @table requerimientos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('negocio_id')->nullable()->default(null)->unsigned();
            $table->integer('num_vacantes')->nullable()->default(null);
            $table->integer('tipo_proceso_id')->nullable()->default(null)->unsigned();
            $table->integer('tipo_contrato_id')->nullable()->default(null)->unsigned();
            $table->integer('genero_id')->nullable()->default(null)->unsigned();
            $table->integer('motivo_requerimiento_id')->nullable()->default(null)->unsigned();
            $table->integer('tipo_jornadas_id')->nullable()->default(null)->unsigned();
            $table->integer('salario')->nullable()->default(null);
            $table->string('sitio_trabajo', 250)->nullable()->default(null);
            $table->longText('funciones')->nullable()->default(null);
            $table->longText('formacion_academica')->nullable()->default(null);
            $table->longText('experiencia_laboral')->nullable()->default(null);
            $table->longText('conocimientos_especificos')->nullable()->default(null);
            $table->longText('observaciones')->nullable()->default(null);
            $table->integer('solicitado_por')->nullable()->default(null)->unsigned();
            $table->integer('cargo_especifico_id')->nullable()->default(null)->unsigned();
            $table->integer('pais_id')->nullable()->default(null)->unsigned();
            $table->integer('ciudad_id')->nullable()->default(null)->unsigned();
            $table->integer('departamento_id')->nullable()->default(null)->unsigned();
            $table->date('fecha_terminacion')->nullable()->default(null);
            $table->longText('descripcion_oferta')->nullable()->default(null);
            $table->date('fecha_publicacion')->nullable()->default(null);
            $table->tinyInteger('estado_publico')->nullable()->default('0')->comment('Estado de la publicacion 0= no publico, 1= si publico');
            $table->integer('edad_minima')->nullable()->default(null);
            $table->integer('edad_maxima')->nullable()->default(null);
            $table->string('telefono_solicitante', 20)->nullable()->default(null);
            $table->integer('ctra_x_clt_codigo')->nullable()->default(null);
            $table->string('centro_costo_contables')->nullable()->default(null);
            $table->string('centro_costo_produccion')->nullable()->default(null);
            $table->string('tipo_liquidacion')->nullable()->default('q');
            $table->integer('tipo_salario')->nullable()->default(null)->unsigned();
            $table->integer('tipo_nomina')->nullable()->default(null)->unsigned();
            $table->integer('concepto_pago_id')->nullable()->default(null)->unsigned();
            $table->integer('nivel_estudio')->nullable()->default(null)->unsigned();
            $table->string('estado_civil', 3)->nullable()->default(null);
            $table->date('fecha_ingreso')->nullable()->default(null);
            $table->date('fecha_retiro')->nullable()->default(null);
            $table->date('fecha_recepcion')->nullable()->default(null);
            $table->longText('contenido_email_soporte')->nullable()->default(null);
            $table->integer('cargo_codigo')->nullable()->default(null);
            $table->integer('grado_codigo')->nullable()->default(null);
            $table->integer('cargo_generico_id')->nullable()->default(null)->unsigned();
            $table->integer('dias_gestion')->nullable()->default(null);
            $table->integer('tipo_experiencia_id')->nullable()->default(null)->unsigned();
             $table->string('informe_preliminar_id')->nullable()->default(null)->unsigned();
            $table->string('num_req_cliente')->nullable()->default(null);
            $table->string('req_prioritario')->nullable()->default(null);
            $table->integer('cuantos_candidatos_presentar')->default('0');
            $table->integer('cuantos_dias_presentar_antes')->default('0');
            $table->dateTime('fecha_presentacion_candidatos')->nullable()->default(null);
            $table->dateTime('fecha_tentativa_cierre_req')->nullable()->default(null);
            $table->integer('cand_presentados_puntual')->default('0');
            $table->integer('cand_presentados_no_puntual')->default('0');
            $table->integer('cand_contratados_puntual')->default('0');
            $table->integer('cand_contratados_no_puntual')->default('0');
            $table->dateTime('fecha_contratacion_candidato')->nullable()->default(null);
            $table->dateTime('fecha_presentacion_oport_cand')->nullable()->default(null);
            $table->integer('esquemas')->nullable()->default(null);

            
            $table->timestamps();


            $table->foreign('cargo_especifico_id')
                ->references('id')->on('cargos_especificos')

                ->onDelete('cascade');

                


            $table->foreign('solicitado_por')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('tipo_contrato_id')
                ->references('id')->on('tipos_contratos')
                ->onDelete('cascade');

            $table->foreign('tipo_experiencia_id')
                ->references('id')->on('tipos_experiencias')
                ->onDelete('cascade');

            $table->foreign('tipo_jornadas_id')
                ->references('id')->on('tipos_jornadas')
                ->onDelete('cascade');

           

            $table->foreign('tipo_nomina')
                ->references('id')->on('tipos_nominas')
                ->onDelete('cascade');

            $table->foreign('tipo_proceso_id')
                ->references('id')->on('tipo_proceso')
                ->onDelete('cascade');

            $table->foreign('tipo_salario')
                ->references('id')->on('tipos_salarios')
                ->onDelete('cascade');

            $table->foreign('cargo_generico_id')
                ->references('id')->on('cargos_genericos')
                ->onDelete('cascade');

            $table->foreign('ciudad_id')
                ->references('id')->on('ciudad')
                ->onDelete('cascade');

            $table->foreign('departamento_id')
                ->references('id')->on('departamentos')
                ->onDelete('cascade');

            $table->foreign('genero_id')
                ->references('id')->on('generos')
                ->onDelete('cascade');

            $table->foreign('motivo_requerimiento_id')
                ->references('id')->on('motivo_requerimiento')
                ->onDelete('cascade');

            $table->foreign('negocio_id')
                ->references('id')->on('negocio')
                ->onDelete('cascade');

            $table->foreign('nivel_estudio')
                ->references('id')->on('escolaridades')
                ->onDelete('cascade');

                $table->foreign('concepto_pago_id')
                ->references('id')->on('conceptos_pagos')
                ->onDelete('cascade');

            $table->foreign('pais_id')
                ->references('id')->on('paises')
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
       Schema::drop($this->set_schema_table);
     }
}
