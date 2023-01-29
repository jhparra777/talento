<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcesoRequerimientoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'proceso_requerimiento';

    /**
     * Run the migrations.
     * @table proceso_requerimiento
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('tipo_entidad', 100)->nullable()->default(null);
            $table->integer('entidad_id')->nullable()->default(null);
            $table->integer('requerimiento_id')->nullable()->default(null)->unsigned();
            $table->integer('user_id')->nullable()->default(null)->unsigned();
            $table->string('proceso_adicional', 100)->nullable()->default(null);
            $table->string('centro_costos',100)->nullable()->default(null);

         
            $table->timestamps();


            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('requerimiento_id')
                ->references('id')->on('requerimientos')
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
