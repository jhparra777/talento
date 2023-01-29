<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespuestasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     public $set_schema_table = 'respuestas';

    public function up()
    {
        
         if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('preg_id')->nullable()->default(null)->unsigned();
            $table->integer('puntuacion');
            $table->integer('req_preg_id')->nullable()->default(null)->unsigned();
            $table->string('descripcion_resp', 100);
            $table->tinyInteger('minimo');

            $table->timestamps();


            $table->foreign('preg_id')
                ->references('id')->on('preguntas')->onDelete('cascade');

            $table->foreign('req_preg_id')
                ->references('id')->on('req_preguntas')->onDelete('cascade');

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
