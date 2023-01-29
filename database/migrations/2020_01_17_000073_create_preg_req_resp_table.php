<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePregReqRespTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'preg_req_resp';

    /**
     * Run the migrations.
     * @table preg_req_resp
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('req_id');
            $table->string('descripcion', 200);
            $table->integer('puntuacion');
            $table->integer('user_id');
            $table->integer('cargo_especifico_id');
            $table->integer('preg_id');
            $table->integer('preg_req_id');
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
