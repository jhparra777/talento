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
    public $set_schema_table = 'ficha';

    /**
     * Run the migrations.
     * @table ficha
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('sociedad_id')->nullable()->default(null)->unsigned();
            $table->integer('cliente_id')->nullable()->default(null)->unsigned();
            $table->string('req_informe_seleccion')->nullable()->default('');
            $table->string('req_visita_domiciliaria')->nullable()->default('');
            $table->string('req_estudio_seguridad')->nullable()->default('');
            $table->integer('cargo_generico')->nullable()->default(null)->unsigned();
            $table->integer('cargo_cliente')->nullable()->default(null);
            $table->double('cantidad_candidatos_vac')->nullable()->default('0');
            $table->string('criticidad_cargo')->nullable()->default('');
            $table->string('genero')->nullable()->default('');
            $table->double('edad_minima')->nullable()->default('0');
            $table->double('edad_maxima')->nullable()->default('0');
            $table->integer('escolaridad')->nullable()->default(null)->unsigned();
            $table->string('otro_estudio', 50)->nullable()->default('');
            $table->string('experiencia')->nullable()->default('');
            $table->string('area_desempeno')->nullable()->default('');
            $table->string('conocimientos_especificos')->nullable()->default('');
            $table->string('competencias_requeridas')->nullable()->default('');
            $table->integer('horario')->nullable()->default(null)->unsigned();
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
            $table->integer('user_id')->nullable()->default(null)->unsigned();
            $table->integer('active')->nullable()->default(null);

          

            
            $table->timestamps();


            $table->foreign('cargo_generico')
                ->references('id')->on('cargos_genericos')
                ->onDelete('cascade');

            $table->foreign('cliente_id')
                ->references('id')->on('clientes')
                ->onDelete('cascade');

            $table->foreign('escolaridad')
                ->references('id')->on('escolaridades')
                ->onDelete('cascade');

            $table->foreign('sociedad_id')
                ->references('id')->on('sociedades')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('horario')
                ->references('id')->on('franja_horaria')
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
