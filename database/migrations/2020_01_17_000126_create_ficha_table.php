<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFichaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'ficha';

    /**
     * Run the migrations.
     * @table ficha
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('sociedad_id')->nullable()->default('0');
            $table->double('cliente_id')->nullable()->default('0');
            $table->string('req_informe_seleccion')->nullable()->default('');
            $table->string('req_visita_domiciliaria')->nullable()->default('');
            $table->string('req_estudio_seguridad')->nullable()->default('');
            $table->double('cargo_generico')->nullable()->default('0');
            $table->double('cargo_cliente')->nullable()->default('0');
            $table->double('cantidad_candidatos_vac')->nullable()->default('0');
            $table->string('criticidad_cargo')->nullable()->default('');
            $table->string('genero')->nullable()->default('');
            $table->double('edad_minima')->nullable()->default('0');
            $table->double('edad_maxima')->nullable()->default('0');
            $table->double('escolaridad')->nullable()->default('0');
            $table->string('otro_estudio', 50)->nullable()->default('');
            $table->string('experiencia')->nullable()->default('');
            $table->string('area_desempeno')->nullable()->default('');
            $table->string('conocimientos_especificos')->nullable()->default('');
            $table->string('competencias_requeridas')->nullable()->default('');
            $table->double('horario')->nullable()->default('0');
            $table->string('observaciones_horario')->nullable()->default('');
            $table->string('variable', 100)->nullable()->default('');
            $table->string('valor_variable', 100)->nullable()->default('');
            $table->string('comision', 100)->nullable()->default('');
            $table->string('valor_comision', 100)->nullable()->default('');
            $table->string('rodamiento', 100)->nullable()->default('');
            $table->string('valor_rodamiento', 100)->nullable()->default('');
            $table->double('rango_salarial')->nullable()->default(null);
            $table->double('tipo_contrato')->nullable()->default(null);
            $table->string('personal_cargo')->nullable()->default('0');
            $table->string('canal_pertenece', 100)->nullable()->default(null);
            $table->string('funciones_realizar')->nullable()->default('');
            $table->double('estatura_minima')->nullable()->default('0');
            $table->double('estatura_maxima')->nullable()->default('0');
            $table->string('talla_camisa')->nullable()->default('');
            $table->string('talla_pantalon')->nullable()->default('');
            $table->string('calzado')->nullable()->default('');
            $table->string('otros_fisicas')->nullable()->default('');
            $table->string('restricciones')->nullable()->default('');
            $table->string('observaciones_generales')->nullable()->default('');
            $table->integer('user_id')->nullable()->default(null);
            $table->integer('active')->nullable()->default(null);
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
