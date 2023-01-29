<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperienciaVerificadaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'experiencia_verificada';

    /**
     * Run the migrations.
     * @table experiencia_verificada
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('candidato_id')->nullable()->default(null);
            $table->integer('usuario_gestion')->nullable()->default(null);
            $table->string('nombre_referenciante', 250)->nullable()->default(null);
            $table->string('cargo_referenciante', 100)->nullable()->default(null);
            $table->integer('telefono_oficina')->nullable()->default(null);
            $table->integer('ext')->nullable()->default(null);
            $table->integer('celular')->nullable()->default(null);
            $table->longText('observaciones_empresa')->nullable()->default(null);
            $table->longText('observaciones_candidato')->nullable()->default(null);
            $table->integer('meses_laborados')->nullable()->default(null);
            $table->integer('anios_laborados')->nullable()->default(null);
            $table->integer('motivo_retiro_id')->nullable()->default(null);
            $table->longText('observaciones')->nullable()->default(null);
            $table->string('personas_cargo', 20)->nullable()->default(null);
            $table->integer('cuantas_personas')->nullable()->default(null);
            $table->string('volver_contratarlo', 20)->nullable()->default(null);
            $table->longText('porque_obj')->nullable()->default(null);
            $table->longText('aspectos_mejorar')->nullable()->default(null);
            $table->string('cargo2', 200)->nullable()->default(null);
            $table->date('fecha_inicio')->nullable()->default(null);
            $table->date('fecha_retiro')->nullable()->default(null);
            $table->string('anotacion_hv', 20)->nullable()->default(null);
            $table->longText('cuales_anotacion')->nullable()->default(null);
            $table->string('vinculo_familiar', 20)->nullable()->default(null);
            $table->longText('vinculo_familiar_cual')->nullable()->default(null);
            $table->string('adecuado', 45)->nullable()->default(null);
            $table->string('estado_referencia', 45)->nullable()->default(null);
            $table->longText('observaciones_referencias')->nullable()->default(null);
            $table->integer('experiencia_id')->nullable()->default(null);
            $table->integer('ref_verificada')->nullable()->default(null);
            $table->integer('empleo_actual')->nullable()->default('0');
            $table->string('relacion_laboral', 250)->nullable()->default(null);
            $table->string('tiempo_juntos', 110)->nullable()->default(null);
            $table->text('desempenio_candidato')->nullable()->default(null);
            $table->text('reforzar_desempenio')->nullable()->default(null);
            $table->text('mayores_logros')->nullable()->default(null);
            $table->text('relacion_companieros')->nullable()->default(null);
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
