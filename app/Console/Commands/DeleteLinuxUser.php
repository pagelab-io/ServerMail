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
        $name = $this->argument("name");

        if ($name != "") {
            shell_exec("sudo userdel ".$name." 2>&1");
        } else {
            shell_exec("sudo useradd tester -g vmail 2>&1");
        }
    }
}