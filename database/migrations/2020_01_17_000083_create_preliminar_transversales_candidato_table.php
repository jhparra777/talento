<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreliminarTransversalesCandidatoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'preliminar_transversales_candidato';

    /**
     * Run the migrations.
     * @table preliminar_transversales_candidato
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('candidato_id')->nullable()->default(null);
            $table->integer('realizo_id')->nullable()->default(null);
            $table->integer('transversal_id')->nullable()->default(null);
            $table->integer('req_id')->nullable()->default(null);
            $table->integer('puntuacion')->nullable()->default(null);
            $table->integer('estado')->nullable()->default(null);
            $table->integer('resultado')->nullable()->default(null);
            $table->string('descripcion_candidato');
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
