<?php

namespace App\Console\Commands\Contracts;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Sitio;
use App\Models\FirmaContratos;

class HashContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'contract:hash {firma?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar y mostrar hash de contrato';

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

            $firma_id = $this->argument('firma');
            if($firma_id!=null){
                 $firma=FirmaContratos::find($firma_id);
                 if(count($firma)>0){
                    $contrato=$firma->contrato;
                    if($contrato!=null){

                        if(Storage::disk('public')->has('contratos/'.$contrato)){
                            $firma->hash = hash_file('sha256',public_path('contratos/'.$contrato));
                            $firma->save();
                            $this->info('Hash generado satisfactoriamente');
                        }
                        else{
                            $this->error('Archivo  de contrato '.$contrato.' asociado a la firma no existe en el servidor');
                        }
                        
                    }
                    else{
                        $this->error('La firma no tiene contrato asociado');
                    }
                    

                 }
                 else{
                    $this->error('No existe la firma con el id '.$firma_id);
                 }

                 

            }
            else{
                if ($this->confirm('Desea generar y/o reescribir el hash de todos los contratos? [y|N]')){
                    $firmas=FirmaContratos::whereNotNull("contrato")->select("id","contrato")->get();
                    foreach($firmas as &$item){
                        $contrato=$item->contrato;
                        if($contrato!=null){
                            if(Storage::disk('public')->has('contratos/'.$contrato)){
                                $item->hash = hash_file('sha256',public_path('contratos/'.$contrato));
                                $item->save();
                            }
                            
                        }
                    }

                    $this->info('Hash de firmas con contrato generados satosfactoriamente');
                }
                else{
                    $this->info('Good bye');
                }
            }
           
            
        
       
    }
}
