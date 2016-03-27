<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 26/03/2016
 * Time: 07:42 PM
 */

namespace PageLab\ServerMail\Console\Commands;


use Illuminate\Console\Command;
use Log;

class CreateLinuxDomain extends Command{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'linuxDomain:create
                            {domain_name : Name assigned to the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new linux domain';

    /**
     * Create a new command instance.
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

        $domainName = $this->argument("domain_name");

        if ($domainName == "") {

            Log::info("=== The user name is empty ===");

        } else {

            Log::info("=== begin the process for a new domain ===");

            // step 1
            if($this->createDomainDirectory($domainName))
                if($this->givePermissions($domainName))
                    if($this->createWelcomeFile($domainName))
                        if($this->createVirtualHostFile($domainName))
                            Log::info("=== process for a new domain complete successfully===");

        }
    }


    //region Private Methods

    /**
     * Tries to create a new directory in /var/www for the new Domain.
     *
     * @param $domainName
     * @return bool
     */
    private function createDomainDirectory($domainName)
    {
        Log::info("=== Step 1 :: creating the domain in /var/www/".$domainName." ===");
        $output = shell_exec("sudo mkdir /var/www/".$domainName." 2>&1");


        if (file_exists("/var/www/".$domainName)) {
            Log::info("=== Directory /var/www/".$domainName." created successfully ===");
            return true;
        } else {
            Log::info("=== Directory /var/www/".$domainName." cannot be created ===");
            Log::info($output);
            return false;
        }

    }

    /**
     * Tries to give the necessary permission to the new domain
     * for the first time the permissions are 775 in order to
     * create the welcome file.
     *
     * @param $domainName
     * @return bool
     */
    private function givePermissions($domainName)
    {
        Log::info("=== Step 2 :: givePermissions in /var/www/".$domainName." ===");

        $output = shell_exec("sudo chown -R www-data:www-data /var/www/".$domainName." && sudo chmod -R 775 /var/www/".$domainName." 2>&1");

        // 16893 is the number in fileperms equal to 775
        if (fileperms("/var/www/".$domainName) == 16893) {
            Log::info("=== Permissions changed succesfully ===");
            return true;
        } else {
            Log::info("=== Permissions cannot be changed ===");
            Log::info($output);
            return false;
        }

    }

    /**
     * Create the welcome file in /var/www/[domain_name];
     * @param $domainName
     * @return bool
     */
    private function createWelcomeFile($domainName)
    {
        Log::info("=== Step 3 :: create the welcome file in /var/www/".$domainName." ===");

        $file = fopen("/var/www/".$domainName."/index.html", "w");

        if (file_exists("/var/www/".$domainName."/index.html")){

            fwrite($file, '<html lang="es-MX"><head><meta charset="UTF-8"><title>welcome</title></head><body>it works !</body></html>');
            fclose($file);
            Log::info("=== Welcome file successfully created in /var/www/".$domainName." ===");
            return true;

        }else {

            Log::info("=== Welcome file cannot be created in /var/www/".$domainName." ===");
            return false;
        }
    }

    private function createVirtualHostFile($domainName)
    {
        Log::info("=== Step 4 :: create the virtual host file for ".$domainName." ===");

        $file = fopen("/var/www/".$domainName."/".$domainName.".conf", "w");

        if (file_exists("/var/www/".$domainName."/".$domainName.".conf")) {

            fwrite($file, '
                    <VirtualHost *:80>
                        ServerAlias www'.$domainName.'
                        ServerName '.$domainName.'
                        ServerAdmin webmaster@localhost
                        DocumentRoot /var/www/'.$domainName.'/
                        ErrorLog ${APACHE_LOG_DIR}/error.log
                        CustomLog ${APACHE_LOG_DIR}/access.log combined
                    </VirtualHost>');
            fclose($file);
            Log::info("virtual host file successfully created");

            $output = shell_exec("sudo mv /var/www/".$domainName."/".$domainName.".conf /etc/apache2/sites-available 2>&1");
            if (file_exists("/etc/apache2/sites-available")) {
                Log::info("=== virtual host file moved to /etc/apache2/sites-available ===");
                return true;
            } else {
                Log::info("=== virtual host file cannot be moved to /etc/apache2/sites-available ===");
                Log::info($output);
                return false;
            }

        } else {
            Log::info("=== virtual host file cannot be created in /var/www/".$domainName." ===");
            return false;
        }
    }

    //endregion


} 