<?php
 
namespace DidiWijaya\WilIndo;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class WilIndoPublishCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'wilindo:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish WilIndo assets from vendor packages';

    /**
     * Compatiblity for Lumen 5.5.
     *
     * @return void
     */
    public function handle()
    {
        $this->fire();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $this->publishConfig();
        $this->publishMigrations();
        $this->publishSeeds();

        $this->info("Publishing WilIndo complete");
    }


    /**
     * Publish the directory to the given directory.
     *
     * @param  string  $from
     * @param  string  $to
     * @return void
     */
    protected function publishDirectory($from , $to)
    {
        $exclude = array('..' , '.' , '.DS_Store');
        $source = array_diff(scandir($from), $exclude);

        foreach ($source as $item) {
            $this->info("Copying file: " . $to . $item);
            File::copy($from . $item , $to . $item);
        }
    }

    /**
     * Publish config.
     *
     * @return void
     */
    protected function publishConfig()
    {
        $this->publishDirectory(__DIR__.'/config/', app()->configPath()."/");
    }

    /**
     * Publish migrations.
     *
     * @return void
     */
    protected function publishMigrations()
    {
        $this->publishDirectory(__DIR__.'/database/migrations/', app()->databasePath()."/migrations/");
    }

    /**
     * Publish seeds.
     *
     * @return void
     */
    protected function publishSeeds()
    {
        $this->publishDirectory(__DIR__.'/database/seeders/', app()->databasePath()."/seeders/");
    }
}