<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargosEspecificosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'cargos_especificos';

    /**
     * Run the migrations.
     * @table cargos_especificos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('descripcion', 100);
            $table->integer('plazo_req')->nullable()->default(null);
            $table->integer('codigo_1')->nullable()->default('0');
            $table->integer('codigo_2')->nullable()->default('0');
            $table->integer('codigo_3')->nullable()->default('0');
            $table->integer('codigo_4')->nullable()->default('0');
            $table->integer('cargo_generico_id');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->dateTime('update_at')->nullable()->default(null);
            $table->integer('clt_codigo')->nullable()->default(null);
            $table->double('cargo_codigo')->nullable()->default('0');
            $table->double('grado_codigo')->nullable()->default('0');
            $table->string('ctra_x_clt_codigo', 10)->nullable()->default('1');
            $table->integer('cxclt_jorn_lab')->nullable()->default('1');
            $table->integer('cxclt_tnom')->nullable()->default('6');
            $table->string('cxclt_tliq', 1)->nullable()->default('q');
            $table->string('cxclt_estado', 3)->nullable()->default('act');
            $table->integer('nest_codigo')->nullable()->default('0');
            $table->string('cxclt_genero', 3)->nullable()->default('3');
            $table->string('cxclt_est_civil', 3)->nullable()->default('amb');
            $table->integer('cxclt_edad_min')->nullable()->default(null);
            $table->integer('cxclt_edad_max')->nullable()->default(null);
            $table->integer('tco_codigo')->nullable()->default('3');
            $table->integer('tsal_codigo')->nullable()->default('1');
            $table->integer('cxclt_sueldo_mensual')->nullable()->default('0');
            $table->integer('cxclt_sueldo_minimo')->nullable()->default('0');
            $table->integer('cxclt_sueldo_maximo')->nullable()->default('0');
            $table->integer('mon_codigo')->nullable()->default('1');
            $table->integer('fp_porc')->nullable()->default('1');
            $table->string('cxclt_codigo', 11)->nullable()->default('0');
            $table->double('cargo_online_cliente')->nullable()->default(null);
            $table->double('cargo_online_id')->nullable()->default(null);
            $table->string('archivo_perfil');
            $table->integer('nivel_cargo')->nullable()->default(null);
            $table->integer('menor5')->nullable()->default(null);
            $table->integer('menor10')->nullable()->default(null);
            $table->integer('menor20')->nullable()->default(null);
            $table->integer('menor30')->nullable()->default(null);
            $table->integer('menor40')->nullable()->default(null);
            $table->integer('menor50')->nullable()->default(null);
            $table->tinyInteger('examesMedicos')->nullable()->default(null);
            $table->tinyInteger('estudioSeguridad')->nullable()->default(null);
            $table->integer('tiempoEvaluacionCliente')->nullable()->default(null);
            $table->integer('menor80')->nullable()->default(null);
            $table->tinyint('active')->nullable()->default('0');
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
