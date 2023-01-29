<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstrevistasVirtualesTable extends Migration
{
    /**
      * Run the migrations.
     *
     * @return void
     */
    public $set_schema_table = 'entrevista_virtual';
    public function up()
    {
          if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_gestion')->nullable()->default(null)->unsigned();
            $table->integer('req_id')->nullable()->default(null)->unsigned();
            $table->tinyInteger('activo')->nullable()->default(null);
           
            $table->timestamps();


            $table->foreign('user_gestion')
                ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('req_id')
                ->references('id')->on('requerimientos')->onDelete('cascade');

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
