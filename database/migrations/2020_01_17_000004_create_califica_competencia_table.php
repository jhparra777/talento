<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalificaCompetenciaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'califica_competencia';

    /**
     * Run the migrations.
     * @table califica_competencia
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('entidad_id')->nullable()->default(null);
            $table->integer('competencia_entrevista_id')->nullable()->default(null);
            $table->string('valor', 100)->nullable()->default(null);
            $table->string('descripcion', 250)->nullable()->default(null);
            $table->string('tipo_entidad', 45)->nullable()->default(null);

            $table->index(["entidad_id"], 'entidad_id');

            $table->index(["tipo_entidad"], 'tipo_entidad');
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
