<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePregReqRespTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $set_schema_table = 'preg_req_resp';
    public function up()
    {
          if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('preg_req_id')->nullable()->default(null)->unsigned();
            $table->integer('puntuacion');
            $table->integer('user_id')->nullable()->default(null)->unsigned();
            $table->string('descripcion', 100);
            $table->tinyInteger('minimo');

            $table->timestamps();


            $table->foreign('preg_req_id')
                ->references('id')->on('req_preguntas')->onDelete('cascade');

            $table->foreign('user_id')
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
