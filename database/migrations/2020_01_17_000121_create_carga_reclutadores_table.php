<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargaReclutadoresTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'carga_reclutadores';

    /**
     * Run the migrations.
     * @table carga_reclutadores
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->double('cedula')->nullable()->default(null);
            $table->string('nombre', 100)->nullable()->default(null);
            $table->string('apellidos', 200)->nullable()->default(null);
            $table->double('celular')->nullable()->default(null);
            $table->double('tel_fijo')->nullable()->default(null);
            $table->integer('reclutador_id')->nullable()->default(null);
            $table->integer('lote')->nullable()->default(null);
            $table->string('gestionado', 20)->nullable()->default(null);
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
