<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReqPreguntasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'req_preguntas';

    /**
     * Run the migrations.
     * @table req_preguntas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('req_id');
            $table->tinyInteger('filtro')->nullable()->default(null);
            $table->integer('tipo_id');
            $table->tinyInteger('activo')->default('1');
            $table->integer('resp_id');
            $table->string('descripcion', 100);
            $table->nullableTimestamps();
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
