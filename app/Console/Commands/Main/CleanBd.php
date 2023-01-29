<?php

namespace App\Console\Commands\Main;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Sitio;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;


class CleanBd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:bd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar tablas de movimiento';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm('Desea limpiar las tablas de movimiento de la BD? [y|N]')){
            Schema::disableForeignKeyConstraints();
            $arreglo_tablas=config('cleanableTables.CLEANABLE_TABLES');
            
            foreach($arreglo_tablas as $item){

                DB::table($item)->truncate();
            }

            Schema::enableForeignKeyConstraints();

            $this->info('Las tablas fueron vaciadas correctamente');
        }
        

    }
}
