<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargosGenericosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'cargos_genericos';

    /**
     * Run the migrations.
     * @table cargos_genericos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('descripcion', 150);
            $table->integer('codigo_1')->nullable()->default(null);
            $table->integer('codigo_2')->nullable()->default(null);
            $table->char('estado', 1);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->dateTime('update_at')->nullable()->default(null);
            $table->integer('tipo_cargo_id')->nullable()->default(null);

            $table->unique(["descripcion"], 'cargos_genericos_descripcion_u');
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
