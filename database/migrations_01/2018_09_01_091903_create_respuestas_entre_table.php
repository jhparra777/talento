<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRespuestasEntreTable extends Migration

    {
    /**
      * Run the migrations.
     *
     * @return void
     */
    public $set_schema_table = 'respuestas_entre';
    public function up()
    {
          if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('respuesta',255);
             $table->string('puntuacion',255)->nullable()->default(null);
            $table->integer('preg_entre_id')->nullable()->default(null)->unsigned();
            $table->integer('candidato_id')->nullable()->default(null)->unsigned();

            $table->timestamps();


            $table->foreign('preg_entre_id')
                ->references('id')->on('preguntas_entre')->onDelete('cascade');

            $table->foreign('candidato_id')
                ->references('id')->on('users')->onDelete('cascade');

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
