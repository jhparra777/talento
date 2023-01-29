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
    public $set_schema_table = 'estados_requerimiento';

    /**
     * Run the migrations.
     * @table estados_requerimiento
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('estado')->nullable()->default(null);
            $table->integer('user_gestion')->nullable()->default(null)->unsigned();
            $table->integer('req_id')->nullable()->default(null)->unsigned();
            $table->longText('observaciones')->nullable()->default(null);
            $table->string('motivo', 20)->nullable()->default(null);

            $table->timestamps();


           

            $table->foreign('req_id')
                ->references('id')->on('requerimientos')
                ->onDelete('cascade');

            $table->foreign('user_gestion')
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
