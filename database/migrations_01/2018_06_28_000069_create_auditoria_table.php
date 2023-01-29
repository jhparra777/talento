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
    public $set_schema_table = 'auditoria';

    /**
     * Run the migrations.
     * @table auditoria
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tabla_id')->nullable()->default(null);
            $table->string('tabla', 100)->nullable()->default(null);
            $table->longText('valor_antes')->nullable()->default(null);
            $table->longText('valor_despues')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(null)->unsigned();
            $table->longText('observaciones')->nullable()->default(null);
            $table->string('tipo', 45)->nullable()->default(null);

            $table->index(["user_id"], 'user_id');
            $table->timestamps();


            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
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
