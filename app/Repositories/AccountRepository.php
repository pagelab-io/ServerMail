<?php

namespace PageLab\ServerMail\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use PageLab\ServerMail\Account;
use PageLab\ServerMail\Domain;

class AccountRepository extends BaseRepository{

    /**
     * Return the namespace for Account Model
     *
     * @return mixed
     */
    function model()
    {
        return "PageLab\\ServerMail\\Account";
    }

    /**
     * Create an account in the specified domain
     *
     * @param Domain $domain
     * @param Request $request
     * @return Account
     */
    public function createAccount(Domain $domain, Request $request)
    {
        // Build new email
        $email = $request->get('name') . '@' . $domain->name;

        $account = new Account();
        $account->domain_id = $domain->id;
        $account->email     = trim($email);
        $account->password  = md5(trim($request->get('password')));


        if(!($account instanceof Account)) return null;


        // if enviroment isn't local try to add a linux user
        if (app()->environment() != 'local') $this->createLinuxUser($request->get('name'));

        $account->save();
        return $account;

    }

    /**
     * Delete an account in the specified domain
     *
     * @param $account_id
     * @return bool
     */
    public function deleteAccount($account_id)
    {

        $account = $this->byId($account_id);
        $response = false;

        if ($account) {
            $account->delete();
            $response = true;
        }

        // if enviroment isn't local try to delete a linux user if necessary
        if (app()->environment() != 'local') $this->deleteLinuxUser($account->email);

        return $response;
    }

    /**
     * Get the accounts by accountName
     * by example:
     * $accountName = support
     * return:
     *  [suppor@domain1.com, support@domain2.com]
     *
     * @param $accountName
     * @return Collection
     */
    public function byAccountName($accountName)
    {

        $accounts = Account::where('email','like',$accountName."@%")->get();
        return $accounts;
    }

    //region Private Methods

    /**
     * Call the command php artisan linuxuser:create [username]
     *
     * @param string $name
     */
    private function createLinuxUser($name)
    {
        // search for accounts with the same name in email
        $accounts = $this->byAccountName($name);

        if (count($accounts) == 0) {

            // add a linux user
            Artisan::call("linuxuser:create",['name' => $name]);

        }
    }

    /**
     * Call the command php artisan linuxuser:delete [username]
     *
     * @param $email
     */
    private function deleteLinuxUser($email) {

        // explode the email
        $explodes = explode('@', $email);
        $name = $explodes[0];

        // search for accounts with the same name in email
        $accounts = $this->byAccountName($name);

        if (count($accounts) == 0) {

            // delete a linux user
            Artisan::call("linuxuser:delete",['name' => $name]);
        }
    }

    //endregion
}