<?php

namespace PageLab\ServerMail\Console\Commands;

use Illuminate\Console\Command;
use Log;

class CreateLinuxUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linuxuser:create
                            {name : Name assigned to the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new linux user';

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
        $name = $this->argument("name");

        if ($name != "") {
            Log::info("=== The user name is  :: ". $name. " ===");
            $output = shell_exec("sudo useradd ".$name." -g vmail 2>&1");
            Log::info("=== Output after useradd command :: ".$output." ===");
        } else {
            Log::info("=== The user name is empty ===");
        }
    }
}
