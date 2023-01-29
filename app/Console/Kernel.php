<?php

namespace App\Console;

use App\Jobs\FuncionesGlobales;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\Inspire::class,
        \App\Console\Commands\Log\ClearLogFile::class,
        \App\Console\Commands\Backups\PutBackupS3::class,
        \App\Console\Commands\Contracts\HashContract::class,
        \App\Console\Commands\TusdatosSend::class,
        \App\Console\Commands\Main\CleanBd::class,
        \App\Console\Commands\MigrationCertificationsStudiesAndExperiences::class,
        Commands\OmnisaludDatabase::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //$schedule->command('inspire')->hourly();
        /*$schedule->call("App\Http\Controllers\ReclutamientoController@digiturnoDemonio")->everyMinute();*/
        //$schedule->call("App\Http\Controllers\ReportesController@inicio_mes")->daily();
        //$schedule->call("App\Http\Controllers\AdminController@periodo_prueba")->everyMinute();
        $schedule->call("App\Http\Controllers\ReportesController@cron")->everyMinute();
        $schedule->command('queue:work  --tries=3')->everyMinute()->withoutOverlapping();
        //$schedule->command('backup:s3')->dailyAt('03:30');

        $sitioModulo = FuncionesGlobales::sitioModuloStatic();

        //TusDatos
        if ($sitioModulo->consulta_tusdatos == 'enabled') {
            $schedule->call("App\Http\Controllers\Integrations\TusDatosIntegrationController@consultarResultado")->everyFiveMinutes();
        }

        //TusDatos Estudio Virtual Seguridad
        if ($sitioModulo->consulta_tusdatos_evs == 'enabled') {
            $schedule->call("App\Http\Controllers\Integrations\TusDatosEvsIntegrationController@consultarResultadoEvs")->everyFiveMinutes();
        }

        $schedule->call("App\Http\Controllers\GestionDocumentalController@closeFolderSchedule")->daily();

        if ($sitioModulo->notifica_terminacion_contrato == 'enabled') {
            $schedule->call("App\Http\Controllers\NotificacionTerminacionContratoController@enviar_cartas_terminacion_contrato_diarias")->dailyAt('08:00');
        }
    }
}
