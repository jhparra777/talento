<?php

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
*/

require __DIR__.'/../vendor/autoload.php';


/*// Instantiate the client
$client = new Google_Client();

// Authorize the client using Application Default Credentials
// @see https://developers.google.com/identity/protocols/application-default-credentials
$client->useApplicationDefaultCredentials();
$client->setScopes(array(
    'https://www.googleapis.com/auth/jobs'
));

// Instantiate the Cloud Talent Solustion Service API
$cloudTalentSolutionClient = new Google_Service_CloudTalentSolution($client);
$projectId = getenv('GOOGLE_CLOUD_PROJECT');
$parent = sprintf('projects/%s', $projectId);

// list companies
$companies = $cloudTalentSolutionClient->projects_companies->listProjectsCompanies(
    $projectId,
    array('parent' => $parent)
);

// Print the companies
echo 'Companies: ' . PHP_EOL;
foreach ($companies as $company) {
    echo $company->name . PHP_EOL;
}*/
/*
|--------------------------------------------------------------------------
| Include The Compiled Class File
|--------------------------------------------------------------------------
|
| To dramatically increase your application's performance, you may use a
| compiled class file which contains all of the classes commonly used
| by a request. The Artisan "optimize" is used to create this file.
|
*/

$compiledPath = __DIR__.'/cache/compiled.php';

if (file_exists($compiledPath)) {
    require $compiledPath;
}
