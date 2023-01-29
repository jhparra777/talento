<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OmnisaludDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'omnisalud:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear las tablas con la información necesaria';

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
        $this->info('Comenzando creación de tablas...');

        $this->call('db:seed', ['--class' => 'OmnisaludCiudadesAtencionSeeder']);
        $this->call('db:seed', ['--class' => 'OmnisaludClienteSeeder']);
        $this->call('db:seed', ['--class' => 'OmnisaludConfigSeeder']);
        $this->call('db:seed', ['--class' => 'OmnisaludExamenesSeeder']);
        $this->call('db:seed', ['--class' => 'OmnisaludRegistrosSeeder']);
        $this->call('db:seed', ['--class' => 'OmnisaludResultadosSeeder']);
        $this->call('db:seed', ['--class' => 'OmnisaludTipoAdmisionSeeder']);

        $this->info('Creación de tablas finalizada.');
    }
}
