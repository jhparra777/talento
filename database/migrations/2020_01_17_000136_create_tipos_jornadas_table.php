<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTiposJornadasTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'tipos_jornadas';

    /**
     * Run the migrations.
     * @table tipos_jornadas
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('descripcion')->nullable()->default(null);
            $table->char('active', 1)->nullable()->default(null);
            $table->string('hora_inicio', 45)->nullable()->default(null);
            $table->string('hora_fin', 45)->nullable()->default(null);
            $table->integer('procentaje_horas')->nullable()->default(null);
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
