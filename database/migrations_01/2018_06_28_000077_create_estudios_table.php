<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstudiosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'estudios';

    /**
     * Run the migrations.
     * @table estudios
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
            $table->integer('user_id')->nullable()->default(null)->unsigned();
            $table->integer('nivel_estudio_id')->nullable()->default(null)->unsigned();
            $table->string('institucion')->nullable()->default(null);
            $table->char('termino_estudios', 1)->nullable()->default(null);
            $table->string('titulo_obtenido')->nullable()->default(null);
            $table->char('estudio_actual', 1)->nullable()->default(null);
            $table->integer('semestres_cursados')->nullable()->default(null);
            $table->date('fecha_finalizacion')->nullable()->default(null);
            $table->char('active', 1)->nullable()->default(null);
            $table->integer('pais_estudio')->nullable()->default(null)->unsigned();
            $table->integer('departamento_estudio')->nullable()->default(null)->unsigned();
            $table->integer('ciudad_estudio')->nullable()->default(null)->unsigned();


            $table->timestamps();


            $table->foreign('ciudad_estudio')
                ->references('id')->on('ciudad')

                ->onDelete('cascade');

            $table->foreign('departamento_estudio')
                ->references('id')->on('departamentos')
                ->onDelete('cascade');

            $table->foreign('nivel_estudio_id')
                ->references('id')->on('niveles_estudios')
                ->onDelete('cascade');

            $table->foreign('pais_estudio')
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
