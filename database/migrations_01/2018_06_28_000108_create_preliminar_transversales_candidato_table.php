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
    public $set_schema_table = 'preliminar_transversales_candidato';

    /**
     * Run the migrations.
     * @table preliminar_transversales_candidato
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
            $table->integer('realizo_id')->nullable()->default(null)->unsigned();
            $table->integer('transversal_id')->nullable()->default(null)->unsigned();
            $table->integer('req_id')->nullable()->default(null)->unsigned();
            $table->integer('puntuacion')->nullable()->default(null);
            $table->integer('estado')->nullable()->default(null);
            $table->integer('resultado')->nullable()->default(null);
            $table->string('descripcion_candidato')->nullable()->default(null);;

            $table->timestamps();


            $table->foreign('candidato_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('realizo_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('req_id')
                ->references('id')->on('requerimientos')
                 ->onDelete('cascade');

            $table->foreign('transversal_id')
                ->references('id')->on('preliminar_transversales')
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
