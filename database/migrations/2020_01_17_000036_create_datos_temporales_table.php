<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatosTemporalesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'datos_temporales';

    /**
     * Run the migrations.
     * @table datos_temporales
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('correo', 100)->nullable()->default(null);
            $table->string('nombres')->nullable()->default(null);
            $table->string('celular')->nullable()->default(null);
            $table->string('mensaje')->nullable()->default(null);
            $table->string('modulo')->nullable()->default(null);
            $table->string('video_entrevista_prueba')->nullable()->default(null);
            $table->integer('numero_id');
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
