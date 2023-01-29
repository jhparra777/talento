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
    public $set_schema_table = 'siete_contratados';

    /**
     * Run the migrations.
     * @table motivo_recepcion
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('numero_contrato', 50);
            $table->string('fecha_firma_contrato', 50);
            $table->string('cedula', 50);
            $table->string('fecha_repuesta', 50);

        $table->integer('requerimiento_id')->nullable()->default(null)->unsigned();
            $table->integer('candidato_id')->nullable()->default(null)->unsigned();
            $table->timestamps();

             $table->foreign('requerimiento_id')->references('id')->on('requerimientos')->onDelete('cascade');
             $table->foreign('candidato_id')->references('id')->on('users')->onDelete('cascade');


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
