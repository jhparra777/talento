<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtributosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'atributos';

    /**
     * Run the migrations.
     * @table atributos
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('cod_atributo');
            $table->string('nombre_atributo')->nullable()->default(null);
            $table->string('nombre_tag_atributo')->nullable()->default(null);
            $table->char('tipo_atributo', 20)->nullable()->default(null);
            $table->longText('atributo_atributos')->nullable()->default(null);
            $table->integer('estado')->nullable()->default(null);
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
