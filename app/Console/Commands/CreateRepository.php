<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;

// Import the Application class

class CreateRepository extends Command implements PromptsForMissingInput
{
    protected $app;

    public function __construct(Application $app)
    {
        parent::__construct();

        $this->app = $app;
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $interfaceName = 'I' . ucfirst($name);
        $className = ucfirst($name);

        // Generate the interface file
        $successInterface = $this->generateFile($interfaceName, 'interface');

        // Generate the class file
        $successClass = $this->generateFile($className, 'class');
        $this->app->bind('App\YourNamespace\\' . $interfaceName, 'App\YourNamespace\\' . $className . 'Repositories');

        $successClass && $successInterface ?
            $this->info("$interfaceName and $className" . "Repositories generated successfully.")
            : '';
    }

    private function generateFile($name, $type)
    {
        $stub = $type === 'interface' ? 'interface.stub' : 'repository-class.stub';
        $classFileName = $name . 'Repository';
        $path = $type === 'interface' ? app_path("Repositories/Contracts/$name.php") : app_path("Repositories/Eloquent/$classFileName.php");
        if (File::exists($path)) {
            $this->error("$name already exists.");
        }
        else {
            try {
                $stub_file = file_get_contents(base_path() . "/stubs/$stub");
                $stub_file = $type === 'interface' ? str_replace('{{ namespace }}', 'App\Repositories\Contracts', $stub_file) : str_replace('{{ namespace }}', 'App\Repositories\Eloquent', $stub_file);
                $stub_file = str_replace('{{ name }}', $name, $stub_file);
                $stub_file = $type != 'interface' ? str_replace('{{ interfaceName }}', 'I' . $name, $stub_file) : $stub_file;
                File::put($path, $stub_file);
                return true;
            }
            catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        }
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'name' => 'What should the repository be named?',
        ];
    }
}
