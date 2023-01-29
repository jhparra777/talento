<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreguntasEntreTable extends Migration
{
    /**
      * Run the migrations.
     *
     * @return void
     */
    public $set_schema_table = 'preguntas_entre';
    public function up()
    {
          if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('descripcion', 255);
            $table->integer('entre_vir_id')->nullable()->default(null)->unsigned();
            $table->tinyInteger('activo')->nullable()->default(1);

            $table->timestamps();


            $table->foreign('entre_vir_id')
                ->references('id')->on('entrevista_virtual');

            

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
