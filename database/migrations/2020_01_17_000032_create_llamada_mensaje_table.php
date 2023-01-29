<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLlamadaMensajeTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'llamada_mensaje';

    /**
     * Run the migrations.
     * @table llamada_mensaje
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('req_id')->nullable()->default(null);
            $table->string('nombre_candidato')->nullable()->default(null);
            $table->string('telefono_movil')->nullable()->default(null);
            $table->string('numero_id', 50)->nullable()->default(null);
            $table->integer('user_llamada')->nullable()->default(null);
            $table->integer('num_msg')->nullable()->default(null);
            $table->string('content_msg')->nullable()->default(null);
            $table->integer('modulo')->default('1');
            $table->integer('tipo_mensaje')->nullable()->default(null);

            $table->index(["numero_id"], 'numero_id');

            $table->index(["req_id"], 'req_id');
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
