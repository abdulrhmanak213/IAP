<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CreateRestApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:collection {name} {--i}'; //i to add index resource

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This Command will create controller in additional to resource and request classes in same path';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        Artisan::call('make:controller ' . $name . 'Controller --api');
        Artisan::call('make:resource ' . $name . 'Resource');
        if ($this->option('i')) {
            Artisan::call('make:resource ' . $name . 'IndexResource');
            $this->info($name . "IndexResource generated successfully.");
        }
        Artisan::call('make:request ' . $name . 'Request');
        $this->info($name . "Controller generated successfully.");
        $this->info($name . "Resource generated successfully.");
        $this->info($name . "Request generated successfully.");
    }

    protected function promptForMissingArgumentsUsing()
    {
        return [
            'name' => 'What should the collection be named?',
        ];
    }
}
