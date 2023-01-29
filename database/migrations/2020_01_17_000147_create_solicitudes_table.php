<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'solicitudes';

    /**
     * Run the migrations.
     * @table solicitudes
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('pais_id')->nullable()->default(null);
            $table->integer('departamento_id')->nullable()->default(null);
            $table->integer('ciudad_id')->nullable()->default(null);
            $table->integer('solicitado_por')->nullable()->default(null);
            $table->integer('cargo_generico_id')->nullable()->default(null);
            $table->integer('riesgo_id')->nullable()->default(null);
            $table->integer('jornada_laboral_id')->nullable()->default(null);
            $table->integer('tipo_contrato_id')->nullable()->default(null);
            $table->integer('motivo_requerimiento_id')->nullable()->default(null);
            $table->integer('numero_vacante')->nullable()->default(null);
            $table->integer('nivel_estudio_id')->nullable()->default(null);
            $table->integer('tiempo_experiencia_id')->nullable()->default(null);
            $table->integer('edad_minima')->nullable()->default(null);
            $table->integer('edad_maxima')->nullable()->default(null);
            $table->integer('genero_id')->nullable()->default(null);
            $table->integer('estado_civil_id')->nullable()->default(null);
            $table->text('funciones_realizar')->nullable()->default(null);
            $table->text('observaciones')->nullable()->default(null);
            $table->integer('estado')->nullable()->default(null);
            $table->string('documento', 100)->nullable()->default(null);
            $table->date('fecha_tentativa')->nullable()->default(null);
            $table->text('recursos')->nullable()->default(null);
            $table->integer('salario')->nullable()->default(null);
            $table->nullableTimestamps();
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
