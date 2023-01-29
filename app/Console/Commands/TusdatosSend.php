<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

//
use App\Http\Controllers\Integrations\TusDatosIntegrationController;

class TusdatosSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tusdatos:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar consultas tusdatos.co.';

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
        //
        $kactus = new TusDatosIntegrationController();
        $kactus->consultarResultado();

        $this->info('Tusdatos consultados.');
    }
}
