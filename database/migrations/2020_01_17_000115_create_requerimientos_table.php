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
    public $tableName = 'requerimientos';

    /**
     * Run the migrations.
     * @table requerimientos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('negocio_id')->nullable()->default(null);
            $table->integer('num_vacantes')->nullable()->default(null);
            $table->integer('tipo_proceso_id')->nullable()->default(null);
            $table->integer('tipo_contrato_id')->nullable()->default(null);
            $table->string('genero_id', 3)->nullable()->default(null);
            $table->integer('motivo_requerimiento_id')->nullable()->default(null);
            $table->integer('tipo_jornadas_id')->nullable()->default(null);
            $table->integer('salario')->nullable()->default(null);
            $table->string('sitio_trabajo', 250)->nullable()->default(null);
            $table->longText('funciones')->nullable()->default(null);
            $table->longText('formacion_academica')->nullable()->default(null);
            $table->longText('experiencia_laboral')->nullable()->default(null);
            $table->longText('conocimientos_especificos')->nullable()->default(null);
            $table->longText('observaciones')->nullable()->default(null);
            $table->integer('solicitado_por')->nullable()->default(null);
            $table->integer('cargo_especifico_id')->nullable()->default(null);
            $table->integer('pais_id')->nullable()->default(null);
            $table->integer('ciudad_id')->nullable()->default(null);
            $table->integer('departamento_id')->nullable()->default(null);
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
            $table->string('tipo_liquidacion', 1)->nullable()->default(null);
            $table->integer('tipo_salario')->nullable()->default(null);
            $table->integer('tipo_nomina')->nullable()->default(null);
            $table->integer('concepto_pago_id')->nullable()->default(null);
            $table->integer('nivel_estudio')->nullable()->default(null);
            $table->string('estado_civil', 3)->nullable()->default(null);
            $table->date('fecha_ingreso')->nullable()->default(null);
            $table->date('fecha_retiro')->nullable()->default(null);
            $table->date('fecha_recepcion')->nullable()->default(null);
            $table->longText('contenido_email_soporte')->nullable()->default(null);
            $table->integer('cargo_codigo')->nullable()->default(null);
            $table->integer('grado_codigo')->nullable()->default(null);
            $table->integer('cargo_generico_id')->nullable()->default(null);
            $table->integer('dias_gestion')->nullable()->default(null);
            $table->integer('tipo_experiencia_id')->nullable()->default(null);
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
            $table->string('informe_preliminar_id', 150)->nullable()->default(null);
            $table->integer('centro_costo_id')->nullable()->default(null);
            $table->string('justificacion')->nullable()->default(null);
            $table->integer('preperfilados')->nullable()->default(null);
            $table->date('fecha_solicitud_ingreso')->nullable()->default(null);
            $table->date('fecha_real_ingreso')->nullable()->default(null);
            $table->text('documento')->nullable()->default(null);
            $table->text('notas_adicionales')->nullable()->default(null);
            $table->string('enterprise', 200)->nullable()->default(null);
            $table->string('jefe_inmediato', 200)->nullable()->default(null);
            $table->integer('empresa_contrata')->nullable()->default(null);
            $table->text('detalle_dotacion')->nullable()->default(null);
            $table->integer('id_kactus')->nullable()->default(null);
            $table->integer('solicitud_id')->nullable()->default(null);

            $table->index(["cargo_generico_id", "tipo_experiencia_id", "centro_costo_id"], 'cargo_generico_id');

            $table->index(["pais_id", "ciudad_id", "departamento_id"], 'pais_id');

            $table->index(["empresa_contrata", "solicitud_id"], 'empresa_contrata');

            $table->index(["ctra_x_clt_codigo", "centro_costo_produccion"], 'ctra_x_clt_codigo');

            $table->index(["solicitado_por", "cargo_especifico_id"], 'solicitado_por');

            $table->index(["negocio_id", "tipo_proceso_id", "tipo_contrato_id", "genero_id", "motivo_requerimiento_id", "tipo_jornadas_id"], 'negocio_id');
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
