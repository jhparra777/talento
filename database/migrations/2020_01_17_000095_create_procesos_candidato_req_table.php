<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcesosCandidatoReqTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'procesos_candidato_req';

    /**
     * Run the migrations.
     * @table procesos_candidato_req
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('requerimiento_candidato_id')->nullable()->default(null);
            $table->string('estado', 45)->nullable()->default(null);
            $table->string('proceso', 45)->nullable()->default(null);
            $table->date('fecha_inicio')->nullable()->default(null);
            $table->date('fecha_fin')->nullable()->default(null);
            $table->integer('usuario_envio')->nullable()->default(null);
            $table->integer('requerimiento_id')->nullable()->default(null);
            $table->integer('candidato_id')->nullable()->default(null);
            $table->integer('usuario_terminacion')->nullable()->default(null);
            $table->string('apto', 45)->nullable()->default(null);
            $table->string('numero_contrato', 45)->nullable()->default(null);
            $table->date('fecha_contrato')->nullable()->default(null);
            $table->date('fecha_inicio_contrato')->nullable()->default(null);
            $table->date('fecha_fin_contrato')->nullable()->default(null);
            $table->longText('observaciones')->nullable()->default(null);
            $table->integer('user_autorizacion')->nullable()->default(null);
            $table->integer('motivo_rechazo_id')->nullable()->default(null);
            $table->string('estado_contrato', 2)->nullable()->default(null);
            $table->tinyInteger('cand_presentado_puntual')->default('0');
            $table->tinyInteger('cand_contratado')->default('0');
            $table->string('centro_costos')->nullable()->default(null);
            $table->date('fecha_solicitud_ingreso')->nullable()->default(null);
            $table->date('fecha_real_ingreso')->nullable()->default(null);
            $table->string('hora_entrada', 50)->nullable()->default(null);
            $table->date('fecha_ultimo_contrato')->nullable()->default(null);
            $table->date('fecha_ingreso_contra')->nullable()->default(null);
            $table->string('asistira', 11)->nullable()->default(null);

            $table->index(["candidato_id"], 'candidato_id');

            $table->index(["requerimiento_id"], 'requerimiento_id');

            $table->index(["apto"], 'apto');

            $table->index(["proceso"], 'proceso');

            $table->index(["estado"], 'estado');

            $table->index(["requerimiento_candidato_id"], 'requerimiento_candidato_id');
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
