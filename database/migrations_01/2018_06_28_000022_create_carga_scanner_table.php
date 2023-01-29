<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCargaScannerTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'carga_scanner';

    /**
     * Run the migrations.
     * @table carga_scanner
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->increments('id');
            $table->integer('user_carga')->nullable()->default(null)->unsigned();
            $table->double('identificacion')->nullable()->default(null);
            $table->string('primer_nombre', 50)->nullable()->default(null);
            $table->string('segundo_nombre', 45)->nullable()->default(null);
            $table->string('primer_apellido', 45)->nullable()->default(null);
            $table->string('segundo_apellido', 45)->nullable()->default(null);
            $table->string('genero', 45)->nullable()->default(null);
            $table->date('fecha_nacimiento')->nullable()->default(null);
            $table->string('rh', 5)->nullable()->default(null);
            $table->integer('user_gestion')->nullable()->default(null)->unsigned();
            $table->tinyInteger('asistencia')->nullable()->default(null);

             $table->foreign('user_gestion')
                ->references('id')->on('users')

                ->onDelete('cascade');

                $table->foreign('user_carga')
                ->references('id')->on('users')

                ->onDelete('cascade');


           
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
