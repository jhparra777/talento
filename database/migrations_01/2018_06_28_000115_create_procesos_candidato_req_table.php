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
    public $set_schema_table = 'procesos_candidato_req';

    /**
     * Run the migrations.
     * @table procesos_candidato_req
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('requerimiento_candidato_id')->nullable()->default(null)->unsigned();
            $table->string('estado', 45)->nullable()->default(null);
            $table->string('proceso', 45)->nullable()->default(null);
            $table->date('fecha_inicio')->nullable()->default(null);
            $table->date('fecha_fin')->nullable()->default(null);
            $table->integer('usuario_envio')->nullable()->default(null)->unsigned();
            $table->integer('requerimiento_id')->nullable()->default(null)->unsigned();
            $table->integer('candidato_id')->nullable()->default(null)->unsigned();
            $table->integer('usuario_terminacion')->nullable()->default(null)->unsigned();
            $table->string('apto', 45)->nullable()->default(null);
            $table->string('numero_contrato', 45)->nullable()->default(null);
            $table->date('fecha_contrato')->nullable()->default(null);
            $table->date('fecha_inicio_contrato')->nullable()->default(null);
            $table->date('fecha_fin_contrato')->nullable()->default(null);
            $table->longText('observaciones')->nullable()->default(null);
            $table->integer('user_autorizacion')->nullable()->default(null)->unsigned();
            $table->integer('motivo_rechazo_id')->nullable()->default(null)->unsigned();
            $table->string('estado_contrato', 2)->nullable()->default(null);
            $table->tinyInteger('cand_presentado_puntual')->default('0');
            $table->tinyInteger('cand_contratado')->default('0');

         
            $table->timestamps();


            $table->foreign('candidato_id')
                ->references('id')->on('users')

                ->onDelete('cascade');


            $table->foreign('user_autorizacion')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('motivo_rechazo_id')
                ->references('id')->on('motivos_rechazos')
                ->onDelete('cascade');

            $table->foreign('requerimiento_id')
                ->references('id')->on('requerimientos')
                ->onDelete('cascade');

            $table->foreign('requerimiento_candidato_id')
                ->references('id')->on('requerimiento_cantidato')
                ->onDelete('cascade');

            $table->foreign('usuario_envio')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('usuario_terminacion')
                ->references('id')->on('users')
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
