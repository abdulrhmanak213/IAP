<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CreateService extends Command implements PromptsForMissingInput
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
    protected $signature = 'make:service {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Service class';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $nameSpace = $this->argument('name');
        $segments = collect(explode('/', $nameSpace));
        $name = $segments->last();
        $nameSpace = $segments->slice(0, -1)->implode('\\');

        $stubFile = file_get_contents(base_path('stubs/class.stub'));
        $stubFile = str_replace('{{ nameSpace }}', $nameSpace, $stubFile);
        $stubFile = str_replace('{{ name }}', $name, $stubFile);

        $servicePath = app_path('Services/' . $nameSpace);
        if (!File::isDirectory($servicePath)) {
            File::makeDirectory($servicePath, 0755, true);
        }

        $filePath = $servicePath . '/' . $name . '.php';
        File::put($filePath, $stubFile);
        $this->line('Service [' . $filePath . "] created successfully.");
    }

    /**
     * Prompt for missing input arguments using the returned questions.
     *
     * @return array
     */
    protected function promptForMissingArgumentsUsing()
    {
        return [
            'name' => 'What should the service be named?',
        ];
    }
}
