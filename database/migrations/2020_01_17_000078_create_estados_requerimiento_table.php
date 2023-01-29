<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadosRequerimientoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'estados_requerimiento';

    /**
     * Run the migrations.
     * @table estados_requerimiento
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('estado')->nullable()->default(null);
            $table->integer('user_gestion')->nullable()->default(null);
            $table->integer('req_id')->nullable()->default(null);
            $table->longText('observaciones')->nullable()->default(null);
            $table->string('motivo', 20)->nullable()->default(null);

            $table->index(["estado"], 'estado');

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
