<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSieteContratadosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'siete_contratados';

    /**
     * Run the migrations.
     * @table siete_contratados
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('requerimiento_id')->default('0');
            $table->integer('candidato_id')->default('0');
            $table->char('numero_contrato', 255)->default('');
            $table->char('fecha_firma_contrato', 20)->default('');
            $table->char('cedula', 20)->default('');
            $table->dateTime('fecha_respuesta')->nullable()->default(null);
            $table->increments('id');
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
