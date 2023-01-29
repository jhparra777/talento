<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCitacionCargaDbTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'citacion_carga_db';

    /**
     * Run the migrations.
     * @table citacion_carga_db
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('lote')->nullable()->default(null);
            $table->integer('user_carga');
            $table->double('identificacion');
            $table->string('nombres', 100)->nullable()->default(null);
            $table->string('primer_apellido', 100)->nullable()->default(null);
            $table->string('segundo_apellido', 100)->nullable()->default(null);
            $table->double('telefono_fijo')->nullable()->default(null);
            $table->double('telefono_movil')->nullable()->default(null);
            $table->string('email', 100)->nullable()->default(null);
            $table->string('estado', 20)->nullable()->default(null);
            $table->string('observaciones')->nullable()->default(null);
            $table->integer('motivo')->nullable()->default(null);
            $table->integer('remitido_call')->nullable()->default(null);
            $table->string('nombre_carga', 250)->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(null);
            $table->integer('req_id')->nullable()->default(null);

            $table->index(["user_id", "req_id"], 'user_id');
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
