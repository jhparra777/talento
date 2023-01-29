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
    public $set_schema_table = 'facturacion';

    /**
     * Run the migrations.
     * @table facturacion
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('req_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->tinyInteger('factura_entrega_terna');
            $table->tinyInteger('recaudo_centrega_terna');
            $table->tinyInteger('factura_cierre_proceso');
            $table->tinyInteger('recaudo_cierre_proceso');
            $table->string('estado', 50);
            $table->string('observaciones')->nullable()->default(null);

            
            $table->timestamps();


            $table->foreign('req_id')
                ->references('id')->on('requerimientos')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
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
