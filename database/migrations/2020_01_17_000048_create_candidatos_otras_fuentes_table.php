<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCandidatosOtrasFuentesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'candidatos_otras_fuentes';

    /**
     * Run the migrations.
     * @table candidatos_otras_fuentes
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->string('nombres', 45)->nullable()->default(null);
            $table->increments('id');
            $table->double('cedula')->nullable()->default(null);
            $table->string('telefono', 100)->nullable()->default(null);
            $table->string('celular', 100)->nullable()->default(null);
            $table->string('email', 100)->nullable()->default(null);
            $table->integer('tipo_fuente_id')->nullable()->default(null);
            $table->integer('requerimiento_id')->nullable()->default(null);
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
