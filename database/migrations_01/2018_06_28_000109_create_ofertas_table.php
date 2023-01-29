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
    public $set_schema_table = 'ofertas';

    /**
     * Run the migrations.
     * @table ofertas
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('cargo_generico_id')->nullable()->default(null)->unsigned();
            $table->integer('nivel_estudio_id')->nullable()->default(null)->unsigned();
            $table->date('fecha_vencimiento')->nullable()->default(null);
            $table->date('fecha_publicacion')->nullable()->default(null);
            $table->integer('salario')->nullable()->default(null)->unsigned();
            $table->char('mostrar_salario', 1)->nullable()->default(null);
            $table->integer('anios_experiencia')->nullable()->default(null);
            $table->string('cod_oferta', 100)->nullable()->default(null);
            $table->integer('cantidad_vacantes')->nullable()->default(null);
            $table->integer('tipo_contrato')->nullable()->default(null)->unsigned();
            $table->integer('pais_id')->nullable()->default(null)->unsigned();
            $table->integer('departamento_id')->nullable()->default(null)->unsigned();
            $table->integer('ciudad_id')->nullable()->default(null)->unsigned();
            $table->integer('jornada_id')->nullable()->default(null)->unsigned();
            $table->integer('requerimiento_id')->nullable()->default(null)->unsigned();
            $table->longText('descripcion_oferta')->nullable()->default(null);
            $table->char('activo', 1)->nullable()->default(null);
            $table->integer('cliente_id')->nullable()->default(null)->unsigned();

         


            $table->foreign('cargo_generico_id')
                ->references('id')->on('cargos_genericos')

                ->onDelete('cascade');

            $table->foreign('tipo_contrato')
                ->references('id')->on('tipos_contratos')
                ->onDelete('cascade');

            $table->foreign('ciudad_id')
                ->references('id')->on('ciudad')
                ->onDelete('cascade');

            $table->foreign('cliente_id')
                ->references('id')->on('clientes')
                ->onDelete('cascade');

            $table->foreign('departamento_id')
                ->references('id')->on('departamentos')
                ->onDelete('cascade');

            $table->foreign('jornada_id')
                ->references('id')->on('tipos_jornadas')
                ->onDelete('cascade');

            $table->foreign('nivel_estudio_id')
                ->references('id')->on('escolaridades')
                ->onDelete('cascade');

            $table->foreign('pais_id')
                ->references('id')->on('paises')
                ->onDelete('cascade');

            $table->foreign('requerimiento_id')
                ->references('id')->on('requerimientos')
                ->onDelete('cascade');

            $table->foreign('salario')
                ->references('id')->on('tipos_salarios')
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
