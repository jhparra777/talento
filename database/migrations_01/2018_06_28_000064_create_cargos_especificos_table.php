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
    public $set_schema_table = 'cargos_especificos';

    /**
     * Run the migrations.
     * @table cargos_especificos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('descripcion', 100);
            $table->integer('codigo_1')->nullable()->default('0');
            $table->integer('codigo_2')->nullable()->default('0');
            $table->integer('codigo_3')->nullable()->default('0');
            $table->integer('codigo_4')->nullable()->default('0');
            $table->integer('cargo_generico_id')->unsigned();
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
            $table->integer('cxclt_codigo')->nullable()->default('0');
            $table->double('cargo_online_cliente')->nullable()->default(null);
            $table->double('cargo_online_id')->nullable()->default(null);
            $table->string('archivo_perfil');

            $table->index(["cargo_generico_id"], 'cargo_generico_id');


            $table->foreign('cargo_generico_id', 'cargo_generico_id')
                ->references('id')->on('cargos_genericos')
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
