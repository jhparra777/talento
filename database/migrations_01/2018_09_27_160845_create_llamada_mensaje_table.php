<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLlamadaMensajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public $set_schema_table = 'llamada_mensaje';
    public function up()
    {
       if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nombre_candidato',255);
            $table->string('telefono_movil',255);
            $table->string('numero_id',255);
           

            $table->integer('req_id')->nullable()->default(null)->unsigned();
            $table->integer('user_llamada')->nullable()->default(null)->unsigned();


             $table->foreign('req_id')->references('id')->on('requerimientos')->onDelete('cascade');
            $table->foreign('user_llamada')
                ->references('id')->on('users')->onDelete('cascade')->onDelete('cascade');
            

            $table->timestamps();


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
