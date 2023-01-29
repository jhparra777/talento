<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecepcionTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'recepcion';

    /**
     * Run the migrations.
     * @table recepcion
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('turno')->nullable()->default(null);
            $table->string('estado', 5);
            $table->integer('candidato_id')->unsigned();
            $table->integer('user_terminacion')->nullable()->default(null)->unsigned();
            $table->string('proceso', 50)->nullable()->default(null);
            $table->integer('user_envio')->nullable()->default(null)->unsigned();
            $table->integer('motivo')->nullable()->default(null);
            $table->string('numero_ficha', 20)->nullable()->default(null);
            $table->integer('documento_deja')->nullable()->default(null)->unsigned();
            $table->integer('user_seleccion')->nullable()->default(null)->unsigned();

           
            $table->timestamps();


            $table->foreign('candidato_id')
                ->references('id')->on('users')

                ->onDelete('cascade');

            $table->foreign('user_terminacion')
                ->references('id')->on('users')
                ->onDelete('cascade');


            $table->foreign('documento_deja')
                ->references('id')->on('tipos_documentos')

                ->onDelete('cascade');

            $table->foreign('user_envio')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('user_seleccion')
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
