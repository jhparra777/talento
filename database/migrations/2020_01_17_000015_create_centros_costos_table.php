<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCentrosCostosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'centros_costos';

    /**
     * Run the migrations.
     * @table centros_costos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('cliente_id')->nullable()->default(null);
            $table->integer('negocio_id')->nullable()->default(null);
            $table->integer('codigo')->nullable()->default(null);
            $table->string('descripcion', 100)->nullable()->default(null);
            $table->tinyInteger('active')->nullable()->default(null);
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
