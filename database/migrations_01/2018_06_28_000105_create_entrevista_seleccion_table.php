<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrevistaSeleccionTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'entrevista_seleccion';

    /**
     * Run the migrations.
     * @table entrevista_seleccion
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
            $table->integer('usuario_id')->nullable()->default(null)->unsigned();
            $table->integer('requerimiento_id')->nullable()->default(null)->unsigned();
            $table->integer('turno_id');
            $table->integer('entrevista_id')->nullable()->default(null)->unsigned();

         
            $table->timestamps();


            $table->foreign('candidato_id')
                ->references('id')->on('users')

                ->onDelete('cascade');

            $table->foreign('usuario_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('entrevista_id')
                ->references('id')->on('entrevistas_candidatos')
                ->onDelete('cascade');

            $table->foreign('requerimiento_id')
                ->references('id')->on('requerimientos')
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
