<?php

namespace PageLab\ServerMail\Console\Commands;

use Illuminate\Console\Command;

class DeleteLinuxUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linuxuser:delete
                            {name : Name of the selected user to be deleted}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a linux user';

    /**
     * Create a new command instance.
     *
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
        if ($option = $this->argument("name")) {
            $this->info("eliminando el nuevo usuario ...");
        }
    }
}