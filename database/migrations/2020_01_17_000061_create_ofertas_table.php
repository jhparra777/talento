<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfertasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ofertas';

    /**
     * Run the migrations.
     * @table ofertas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('cargo_generico_id')->nullable()->default(null);
            $table->integer('nivel_estudio_id')->nullable()->default(null);
            $table->date('fecha_vencimiento')->nullable()->default(null);
            $table->date('fecha_publicacion')->nullable()->default(null);
            $table->integer('salario')->nullable()->default(null);
            $table->char('mostrar_salario', 1)->nullable()->default(null);
            $table->integer('anios_experiencia')->nullable()->default(null);
            $table->string('cod_oferta', 100)->nullable()->default(null);
            $table->integer('cantidad_vacantes')->nullable()->default(null);
            $table->string('tipo_contrato', 100)->nullable()->default(null);
            $table->integer('pais_id')->nullable()->default(null);
            $table->integer('departamento_id')->nullable()->default(null);
            $table->integer('ciudad_id')->nullable()->default(null);
            $table->integer('jornada_id')->nullable()->default(null);
            $table->integer('requerimiento_id')->nullable()->default(null);
            $table->longText('descripcion_oferta')->nullable()->default(null);
            $table->char('activo', 1)->nullable()->default(null);
            $table->integer('cliente_id')->nullable()->default(null);
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
