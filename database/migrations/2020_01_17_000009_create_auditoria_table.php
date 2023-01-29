<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditoriaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'auditoria';

    /**
     * Run the migrations.
     * @table auditoria
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tabla_id')->nullable()->default(null);
            $table->string('tabla', 100)->nullable()->default(null);
            $table->longText('valor_antes')->nullable()->default(null);
            $table->longText('valor_despues')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(null);
            $table->longText('observaciones')->nullable()->default(null);
            $table->string('tipo', 45)->nullable()->default(null);
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
