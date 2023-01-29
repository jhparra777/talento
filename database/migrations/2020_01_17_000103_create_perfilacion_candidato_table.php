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
    public $tableName = 'perfilacion_candidato';

    /**
     * Run the migrations.
     * @table perfilacion_candidato
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'MyISAM';
            $table->integer('perfil_id')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(null);
            $table->integer('user_gestion_id')->nullable()->default(null);
            $table->increments('id');
            $table->string('descripcion', 60)->nullable()->default(null);
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
       Schema::dropIfExists($this->tableName);
     }
}
