<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'clientes';

    /**
     * Run the migrations.
     * @table clientes
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nit', 200)->nullable()->default(null);
            $table->string('nombre')->nullable()->default(null);
            $table->string('direccion')->nullable()->default(null);
            $table->string('telefono')->nullable()->default(null);
            $table->string('pag_web')->nullable()->default(null);
            $table->string('fax')->nullable()->default(null);
            $table->integer('pais_id')->nullable()->default(null);
            $table->integer('departamento_id')->nullable()->default(null);
            $table->integer('ciudad_id')->nullable()->default(null);
            $table->string('estado', 3)->nullable()->default('ACT');
            $table->string('logo', 45)->nullable()->default(null);
            $table->string('contacto', 250)->nullable()->default(null);
            $table->string('correo', 100)->nullable()->default(null);
            $table->string('cargo', 100)->nullable()->default(null);
            $table->integer('cliente_id')->nullable()->default(null);
            $table->longText('procesos_validaciones')->nullable()->default(null);

            $table->unique(["cliente_id"], 'clientes_u01');
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
