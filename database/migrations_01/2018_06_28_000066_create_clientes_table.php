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
    public $set_schema_table = 'clientes';

    /**
     * Run the migrations.
     * @table clientes
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nit', 200)->nullable()->default(null);
            $table->string('nombre')->nullable()->default(null);
            $table->string('direccion')->nullable()->default(null);
            $table->string('telefono')->nullable()->default(null);
            $table->string('pag_web')->nullable()->default(null);
            $table->string('fax')->nullable()->default(null);
            $table->integer('pais_id')->nullable()->default(null)->unsigned();
            $table->integer('departamento_id')->nullable()->default(null)->unsigned();
            $table->integer('ciudad_id')->nullable()->default(null)->unsigned();
            $table->string('estado', 3)->nullable()->default('ACT');
            $table->string('logo', 45)->nullable()->default(null);
            $table->string('contacto', 250)->nullable()->default(null);
            $table->string('correo', 100)->nullable()->default(null);
            $table->string('cargo', 100)->nullable()->default(null);
            $table->integer('cliente_id')->nullable()->default(null);
            $table->longText('procesos_validaciones')->nullable()->default(null);

            $table->index(["pais_id", "departamento_id", "ciudad_id"], 'pais_id');

            $table->index(["ciudad_id"], 'ciudad_id');

            $table->index(["departamento_id"], 'departamento_id');
            $table->timestamps();


            $table->foreign('ciudad_id')
                ->references('id')->on('ciudad')

                ->onDelete('cascade');

            $table->foreign('pais_id')
                ->references('id')->on('paises')
                ->onDelete('cascade');

            $table->foreign('departamento_id')
                ->references('id')->on('departamentos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->set_schema_table);
     }
}
