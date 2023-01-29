<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExperienciasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'experiencias';

    /**
     * Run the migrations.
     * @table experiencias
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('numero_id');
            $table->integer('user_id')->unsigned();
            $table->string('trabajo_temporal', 1)->nullable()->default(null);
            $table->string('nombre_temporal')->nullable()->default(null);
            $table->string('telefono_temporal')->nullable()->default(null);
            $table->string('nombre_empresa');
            $table->integer('ciudad_id')->nullable()->default(null)->unsigned();
            $table->string('cargo_desempenado');
            $table->string('nombres_jefe');
            $table->string('cargo_jefe');
            $table->string('movil_jefe')->nullable()->default(null);
            $table->string('fijo_jefe')->nullable()->default(null);
            $table->string('ext_jefe')->nullable()->default(null);
            $table->string('empleo_actual', 1);
            $table->date('fecha_inicio')->nullable()->default(null);
            $table->date('fecha_final')->nullable()->default(null);
            $table->string('salario_devengado');
            $table->integer('motivo_retiro')->nullable()->default(null)->unsigned();
            $table->longText('funciones_logros')->nullable()->default(null);
            $table->char('autoriza_solicitar_referencias', 1);
            $table->char('active', 1);
            $table->integer('pais_id')->nullable()->default(null)->unsigned();
            $table->integer('departamento_id')->nullable()->default(null)->unsigned();
            $table->string('cargo_especifico')->nullable()->default(null);
            $table->timestamps();

          


            $table->foreign('ciudad_id')
                ->references('id')->on('ciudad')

                ->onDelete('cascade');

            $table->foreign('departamento_id')
                ->references('id')->on('departamentos')
                ->onDelete('cascade');

            $table->foreign('motivo_retiro')
                ->references('id')->on('motivos_retiros')
                ->onDelete('cascade');

            $table->foreign('pais_id')
                ->references('id')->on('paises')
                ->onDelete('cascade');

            $table->foreign('user_id')
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
