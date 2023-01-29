<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'documentos';

    /**
     * Run the migrations.
     * @table documentos
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->double('numero_id');
            $table->integer('user_id')->unsigned();
            $table->integer('tipo_documento_id')->nullable()->default(null)->unsigned();
            $table->string('nombre_archivo', 100)->nullable()->default(null);
            $table->longText('descripcion_archivo')->nullable()->default(null);
            $table->date('fecha_vencimiento')->nullable()->default(null);
            $table->char('active', 1);
            $table->integer('gestiono')->nullable()->default(null)->unsigned();



            $table->timestamps();


            $table->foreign('user_id')
                ->references('id')->on('users')

                ->onDelete('cascade');

            $table->foreign('tipo_documento_id')
                ->references('id')->on('tipos_documentos')
                ->onDelete('cascade');

            $table->foreign('gestiono')
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
