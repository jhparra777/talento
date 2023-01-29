<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGestionPruebasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'gestion_pruebas';

    /**
     * Run the migrations.
     * @table gestion_pruebas
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tipo_prueba_id')->nullable()->default(null)->unsigned();
            $table->integer('puntaje')->nullable()->default(null);
            $table->longText('resultado')->nullable()->default(null);
            $table->string('nombre_archivo', 250)->nullable()->default(null);
            $table->date('fecha_vencimiento')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(null)->unsigned();
            $table->integer('candidato_id')->nullable()->default(null)->unsigned();
            $table->string('estado', 1)->nullable()->default(null);
            $table->tinyInteger('activo')->nullable()->default('1');

          
            $table->timestamps();


            $table->foreign('candidato_id')
                ->references('id')->on('users')

                ->onDelete('cascade');

            $table->foreign('tipo_prueba_id')
                ->references('id')->on('tipos_pruebas')
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
