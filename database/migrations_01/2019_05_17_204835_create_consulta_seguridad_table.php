<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConsultaSeguridadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $set_schema_table = 'consulta_seguridad';
    public function up()
    {
        //
        if (Schema::hasTable($this->set_schema_table)) return;

        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->nullable()->default(null)->unsigned();
            $table->integer('user_gestion')->nullable()->default(null)->unsigned();
            $table->integer('req_id')->nullable()->default(null)->unsigned();
            $table->integer('cliente_id')->nullable()->default(null)->unsigned();
            $table->integer('factor_seguridad')->nullable()->default(null);
            $table->integer('contador')->nullable()->default('0');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('user_gestion')
                ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('req_id')
                ->references('id')->on('requerimientos')->onDelete('cascade');

            $table->foreign('cliente_id')
                ->references('id')->on('clientes')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists($this->set_schema_table);
    }
}
