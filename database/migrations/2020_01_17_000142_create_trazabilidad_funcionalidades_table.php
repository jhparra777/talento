<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrazabilidadFuncionalidadesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'trazabilidad_funcionalidades';

    /**
     * Run the migrations.
     * @table trazabilidad_funcionalidades
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('control_id');
            $table->integer('tipo_funcionalidad')->nullable()->default(null);
            $table->integer('user_gestion');
            $table->integer('req_id')->nullable()->default(null);
            $table->string('empresa', 100)->nullable()->default(null);
            $table->string('descripcion', 100)->nullable()->default(null);
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
