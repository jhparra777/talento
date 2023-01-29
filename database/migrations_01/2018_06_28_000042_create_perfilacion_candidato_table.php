<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilacionCandidatoTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'perfilacion_candidato';

    /**
     * Run the migrations.
     * @table perfilacion_candidato
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->integer('perfil_id')->nullable()->default(null)->unsigned();
            $table->integer('user_id')->nullable()->default(null)->unsigned();
            $table->integer('user_gestion_id')->nullable()->default(null)->unsigned();
            $table->increments('id');
            $table->string('descripcion', 60)->nullable()->default(null);

            $table->index(["perfil_id", "user_id", "user_gestion_id"], 'perfil_id');

            $table->foreign('perfil_id', 'perfil_id')
                ->references('id')->on('perfiles')
                ->onDelete('cascade');
                
            $table->foreign('user_id', 'user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
               
             $table->foreign('user_gestion_id', 'user_gestion_id')
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
