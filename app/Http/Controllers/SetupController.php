<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use PDOException;
use Exception;

use App\Http\Requests\SetupDatabaseRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;



class SetupController extends Controller
{
    protected $dbConfig;

    public function start()
    {
        return view('setup.start');
    }

    public function requirements()
    {
        [$success, $results] = $this->checkRequirements();
        return view('setup.reuirements', [
            'success' => $success,
            'results' => $results,
        ]);
    }
    public function database()
    {
        return view('setup.database');
    }
    public function saveDatabase(Request $request){

        $this->createTempDatabaseConnection($request->all());
        if ($this->databaseHasData() && !$request->has('overwrite_data')) {
            flash(trans("Caution! We found data in the database you specified! Please make sure that you have a backup of that database and confirm the deletion of all data."), 'danger');
            return redirect()->back()->with('data_present', true)->withInput();
        }

        $migrationResult = $this->migrateDatabase();
        if (!$migrationResult) {
            return redirect()->back()->withInput();
        }

        $this->storeConfigurationInEnv();

        return redirect()->route('setup.account');
    }
    protected function storeConfigurationInEnv(): void
    {
        $envContent = File::get(base_path('.env'));

        $envContent = preg_replace([
            '/DB_HOST=(.*)\S/',
            '/DB_PORT=(.*)\S/',
            '/DB_DATABASE=(.*)\S/',
            '/DB_USERNAME=(.*)\S/',
            '/DB_PASSWORD=(.*)\S/',
        ], [
            'DB_HOST=' . $this->dbConfig['host'],
            'DB_PORT=' . $this->dbConfig['port'],
            'DB_DATABASE=' . $this->dbConfig['database'],
            'DB_USERNAME=' . $this->dbConfig['username'],
            'DB_PASSWORD=' . $this->dbConfig['password'],
        ], $envContent);

        if ($envContent !== null) {
            File::put(base_path('.env'), $envContent);
        }
    }
    protected function migrateDatabase(): bool
    {
        try {
            Artisan::call('migrate:fresh', [
                '--database' => 'setup', // Specify the correct connection
                '--force' => true, // Needed for production
                '--no-interaction' => true,
            ]);
        } catch (\Exception $e) {
            $alert =  'Database could not be configured. Please check your connection details. Details: ' . $e->getMessage();
            flash($alert, 'danger');
            return false;
        }
        return true;
    }

    protected function databaseHasData(): bool
    {
        try {
            $present_tables = DB::connection('setup')
                ->getDoctrineSchemaManager()
                ->listTableNames();
        } catch (\PDOException $e) {
            Log::error($e->getMessage());
            return false;
        }

        return count($present_tables) > 0;
    }
    protected function createTempDatabaseConnection(array $credentials): void
    {

        $this->dbConfig = config('database.connections.mysql');

        $this->dbConfig['host'] = $credentials['db_host'];
        $this->dbConfig['port'] = $credentials['db_port'];
        $this->dbConfig['database'] = $credentials['db_name'];
        $this->dbConfig['username'] = $credentials['db_user'];
        $this->dbConfig['password'] = $credentials['db_password'];

        \Config::set('database.connections.setup', $this->dbConfig);
    }

    protected function checkRequirements(): array
    {
        $results = [
            'php_version' => PHP_VERSION_ID >= 70300,
            'extension_bcmath' => extension_loaded('bcmath'),
            'extension_ctype' => extension_loaded('ctype'),
            'extension_json' => extension_loaded('json'),
            'extension_mbstring' => extension_loaded('mbstring'),
            'extension_openssl' => extension_loaded('openssl'),
            'extension_pdo_mysql' => extension_loaded('pdo_mysql'),
            'extension_tokenizer' => extension_loaded('tokenizer'),
            'extension_xml' => extension_loaded('xml'),
            'env_writable' => File::isWritable(base_path('.env')),
            'storage_writable' => File::isWritable(storage_path()) && File::isWritable(storage_path('logs')),
        ];

        $success = !in_array(false, $results, true);

        return [$success, $results];
    }
}
