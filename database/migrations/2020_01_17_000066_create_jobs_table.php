<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJobsTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'jobs';

    /**
     * Run the migrations.
     * @table jobs
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('queue');
            $table->longText('payload');
            $table->integer('attempts');
            $table->integer('reserved');
            $table->integer('reserved_at')->nullable()->default(null);
            $table->integer('available_at');
            $table->integer('created_at');

            $table->index(["queue", "reserved", "reserved_at"], 'jobs_queue_reserved_reserved_a');
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
