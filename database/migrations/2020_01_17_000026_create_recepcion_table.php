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
    public $tableName = 'recepcion';

    /**
     * Run the migrations.
     * @table recepcion
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->integer('turno')->nullable()->default(null);
            $table->string('estado', 5);
            $table->integer('candidato_id');
            $table->string('user_terminacion', 20)->nullable()->default(null);
            $table->string('proceso', 50)->nullable()->default(null);
            $table->integer('user_envio')->nullable()->default(null);
            $table->integer('motivo')->nullable()->default(null);
            $table->string('numero_ficha', 20)->nullable()->default(null);
            $table->integer('documento_deja')->nullable()->default(null);
            $table->integer('user_seleccion')->nullable()->default(null);
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
