<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosFamiliaresTable extends Migration
{   

    public $tableName = 'documentos_familiares';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->tinyint('active',1)->default('1');
            $table->int('usuario_cargo', 11);
            $table->integer('grupo_familiar_id')->nullable()->default(null);
            $table->integer('tipo_documento_id')->nullable()->default(null);
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
