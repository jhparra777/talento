<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtributosValoresSelectsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'atributos_valores_selects';

    /**
     * Run the migrations.
     * @table atributos_valores_selects
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('opciones_label')->nullable()->default(null);
            $table->string('opciones_valores')->nullable()->default(null);
            $table->integer('cod_atributo')->unsigned();
            $table->timestamps();

           


            $table->foreign('cod_atributo')
                ->references('id')->on('atributos')

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
