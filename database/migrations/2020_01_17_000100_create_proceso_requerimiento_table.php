<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcesoRequerimientoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'proceso_requerimiento';

    /**
     * Run the migrations.
     * @table proceso_requerimiento
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('tipo_entidad', 100)->nullable()->default(null);
            $table->integer('entidad_id')->nullable()->default(null);
            $table->integer('requerimiento_id')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(null);
            $table->string('proceso_adicional', 100)->nullable()->default(null);
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
