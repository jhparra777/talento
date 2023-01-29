<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequerimientoCantidatoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'requerimiento_cantidato';

    /**
     * Run the migrations.
     * @table requerimiento_cantidato
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('requerimiento_id')->nullable()->default(null);
            $table->integer('candidato_id')->nullable()->default(null);
            $table->increments('id');
            $table->string('estado_candidato', 45)->nullable()->default(null);
            $table->string('otra_fuente', 45)->nullable()->default(null);
            $table->integer('transferido_a_req')->nullable()->default(null);
            $table->string('auxilio_transporte', 20)->nullable()->default(null);
            $table->string('tipo_ingreso', 20)->nullable()->default(null);
            $table->integer('estado_contratacion')->default('1');

            $table->index(["candidato_id"], 'candidato_id');

            $table->index(["estado_candidato"], 'estado_candidato');

            $table->index(["requerimiento_id"], 'requerimiento_id');
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
