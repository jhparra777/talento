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
    public $set_schema_table = 'experiencia_verificada';

    /**
     * Run the migrations.
     * @table experiencia_verificada
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('candidato_id')->nullable()->default(null)->unsigned();
            $table->integer('usuario_gestion')->nullable()->default(null)->unsigned();
            $table->string('nombre_referenciante', 250)->nullable()->default(null);
            $table->string('cargo_referenciante', 100)->nullable()->default(null);
            $table->integer('telefono_oficina')->nullable()->default(null);
            $table->integer('ext')->nullable()->default(null);
            $table->integer('celular')->nullable()->default(null);
            $table->longText('observaciones_empresa')->nullable()->default(null);
            $table->longText('observaciones_candidato')->nullable()->default(null);
            $table->integer('meses_laborados')->nullable()->default(null);
            $table->integer('anios_laborados')->nullable()->default(null);
            $table->integer('motivo_retiro_id')->nullable()->default(null)->unsigned();
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
            $table->integer('experiencia_id')->nullable()->default(null)->unsigned();
            $table->integer('ref_verificada')->nullable()->default(null);

     
            $table->timestamps();


            $table->foreign('candidato_id')
                ->references('id')->on('users')

                ->onDelete('cascade');

            $table->foreign('experiencia_id')
                ->references('id')->on('experiencias')
                ->onDelete('cascade');

            $table->foreign('motivo_retiro_id')
                ->references('id')->on('motivos_retiros')
                ->onDelete('cascade');

            $table->foreign('usuario_gestion')
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
