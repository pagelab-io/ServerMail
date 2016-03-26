<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 26/03/2016
 * Time: 01:00 PM
 */

namespace PageLab\ServerMail\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use PageLab\ServerMail\Account;
use PageLab\ServerMail\Domain;
use PageLab\ServerMail\Http\Controllers\Controller;
use PageLab\ServerMail\Repositories\AccountRepository;

class AccountController extends Controller{

    /**
     * The account repository instance
     *
     * @var AccountRepository
     */
    protected $accountRepository;

    /**
     * Creates an AccountController instance
     *
     * @param AccountRepository $accountRepository
     */
    public function __construct(AccountRepository $accountRepository)
    {
        $this->middleware('auth');
        $this->accountRepository = $accountRepository;
    }

    /**
     * List all accounts into the specified domain
     *
     * @param $domain
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function accounts($domain)
    {
        return view('dashboard.domains.accounts.accounts', compact('domain'));
    }

    /**
     * Add an account in the specified domain
     *
     * @param Domain $domain
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function addAccount(Domain $domain, Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $account = $this->accountRepository->createAccount($domain, $request);

        if ($account) {
            return redirect()->route('dashboard.domains.accounts', $domain->id)
                ->with('status', 'Bandeja agregada correctamente.')
                ->with('level', 'success');
        } else {
            return redirect()->route('dashboard.domains.accounts', $domain->id)
                ->with('status', 'Ocurrio una incidendia al agregar la bandeja, intentalo de nuevo.')
                ->with('level', 'warning');
        }


    }

    /**
     * Remove an account from the specified domain
     * @param $account_id
     * @return \Illuminate\Http\JsonResponse|null
     */
    public function removeAccount($account_id)
    {
        $deleted = $this->accountRepository->deleteAccount($account_id);

        if ($deleted) {
            return response()->json(['success' => 1, 'message' => 'Bandeja eliminada correctamente.', 'accounts' => null]);
        } else {
            return response()->json(['success' => -1, 'message' => 'Ocurrio una incidencia al eliminar la bandeja, intentalo de nuevo.', 'accounts' => null]);
        }
    }

} 