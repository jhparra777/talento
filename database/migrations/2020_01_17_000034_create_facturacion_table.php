<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacturacionTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'facturacion';

    /**
     * Run the migrations.
     * @table facturacion
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('req_id');
            $table->integer('user_id');
            $table->tinyInteger('factura_entrega_terna');
            $table->tinyInteger('recaudo_centrega_terna');
            $table->tinyInteger('factura_cierre_proceso');
            $table->tinyInteger('recaudo_cierre_proceso');
            $table->string('estado', 50);
            $table->string('observaciones')->nullable()->default(null);
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
