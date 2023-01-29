<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReqPreguntasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

     public $set_schema_table = 'req_preguntas';
    public function up()
    {
         if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('req_id')->nullable()->default(null)->unsigned();
            $table->tinyInteger('filtro')->nullable()->default(null);
            $table->integer('tipo_id')->nullable()->default(null)->unsigned();
            $table->string('descripcion', 100);
            $table->tinyInteger('activo')->nullable()->default(1);

            $table->timestamps();


            $table->foreign('req_id')
                ->references('id')->on('requerimientos')->onDelete('cascade');

            $table->foreign('tipo_id')
                ->references('id')->on('tipo_pregunta')->onDelete('cascade');

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
