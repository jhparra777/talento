<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosVerificadosTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $set_schema_table = 'documentos_verificados';

    /**
     * Run the migrations.
     * @table documentos_verificados
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable($this->set_schema_table)) return;
        Schema::create($this->set_schema_table, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('tipo_documento_id')->nullable()->default(null)->unsigned();
            $table->string('nombre_archivo', 100)->nullable()->default(null);
            $table->string('descripcion_archivo', 100)->nullable()->default(null);
            $table->date('fecha_vencimiento')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(null)->unsigned();
            $table->string('gestion_hv', 45)->nullable()->default(null);
            $table->integer('candidato_id')->nullable()->default(null)->unsigned();

         
            $table->timestamps();


            $table->foreign('candidato_id')
                ->references('id')->on('users')

                ->onDelete('cascade');

            $table->foreign('tipo_documento_id')
                ->references('id')->on('tipos_documentos')
                ->onDelete('cascade');

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
