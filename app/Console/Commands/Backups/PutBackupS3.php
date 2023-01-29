<?php

namespace App\Console\Commands\Backups;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Sitio;

class PutBackupS3 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:s3';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar a S3 archivo que contiene backup de documentos de la instancia';

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
        if(Storage::disk('public')->has('respaldo_ftp/bckup.tar.gz')){
            $archivo = Storage::disk('public')->get('respaldo_ftp/bckup.tar.gz');
            $sitio = Sitio::first();
            $folder_site = str_replace(' ', '-', mb_strtolower($sitio->nombre));
            Storage::disk('s3-backup')->put('bck/'.$folder_site.'/bckup.tar.gz',$archivo);
            Storage::disk('public')->delete('respaldo_ftp/bckup.tar.gz');

            $this->info('Archivo de backup movido a S3');
        }
        else{
            $this->info('No existe el archivo de backup');
        }
       
    }
}
