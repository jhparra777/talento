<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntrevistaSemiTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'entrevista_semi';

    /**
     * Run the migrations.
     * @table entrevista_semi
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('id');
            $table->integer('candidato_id')->nullable()->default(null);
            $table->integer('user_gestion_id')->nullable()->default(null);
            $table->string('estado_salud')->nullable()->default(null);
            $table->string('especificaciones_cargo')->nullable()->default(null);
            $table->string('apto', 45)->nullable()->default(null);
            $table->tinyInteger('activo')->nullable()->default('1');
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
