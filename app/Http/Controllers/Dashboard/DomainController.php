<?php

namespace PageLab\ServerMail\Http\Controllers\Dashboard;

use PageLab\ServerMail\Account;
use PageLab\ServerMail\Alias;
use PageLab\ServerMail\Domain;
use PageLab\ServerMail\Repositories\DomainRepository;
use PageLab\ServerMail\Http\Requests;
use PageLab\ServerMail\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DomainController extends Controller
{

    /**
     * The domain repository instance.
     *
     * @var DomainRepository
     */
    protected $domains;

    /**
     * Create a new controller instance.
     *
     * @param DomainRepository $domains
     */
    public function __construct(DomainRepository $domains)
    {
        $this->middleware('auth');

        $this->domains = $domains;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $domains = Domain::orderby('created_at', 'desc');

        if (trim($request->get('name')) != '') {

            $name = trim($request->get('name'));
            $domains->where('name', 'LIKE', '%' . $name . '%');
        }

        $domains = $domains->paginate();

        return view('dashboard.domains.index')
            ->with('domains', $domains);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.domains.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        $domain = new Domain();
        $domain->name = $request->get('name');
        $domain->save();

        return redirect('dashboard/domains')
            ->with('status', 'Domain registered successfully')
            ->with('level', 'success');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Domain $domain
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Domain $domain, Request $request)
    {
        $this->validate($request, [
            'name'  => 'required'
        ]);

        $domain->name = $request->get('name');
        $domain->save();

        return redirect('dashboard/domains')
            ->with('status', 'Domain updated successfully')
            ->with('level', 'success');
    }

    /**
     * Display the specified resource.
     *
     * @param  Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function show($domain)
    {
        return view('dashboard.domains.show', compact('domain'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function edit(Domain $domain)
    {
        return view('dashboard.domains.edit', compact('domain'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Find Domain
        $domain = Domain::findOrFail($id);
        $response = null;

        if ($domain) {
            $domain->delete();

            $response = response()->json(['success' => 1]);
        }

        return $response;
    }

    /**
     * Toggle Status Active
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($id){
        $domain = Domain::findOrFail($id);
        $domain->status = !$domain->status;
        $domain->update();

        return redirect()->route('dashboard.domains.index')
            ->with('status', 'Status domain updated successfully')
            ->with('level', 'success');;
    }

    /**
     * Display the specified resource.
     *
     * @param  Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function accounts($domain)
    {
        return view('dashboard.domains.accounts', compact('domain'));
    }

    /**
     * Display the specified resource.
     *
     * @param  Domain  $domain
     * @return \Illuminate\Http\Response
     */
    public function aliases($domain)
    {
        return view('dashboard.domains.aliases', compact('domain'));
    }

    /**
     * Add a new account to domain
     *
     * @param Domain $domain
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function addAccount(Domain $domain, Request $request){

        $this->validate($request, [
            'name' => 'required'
        ]);

        // Build new email
        $email = $request->get('name') . '@' . $domain->name;

        $account = new Account();
        $account->domain_id = $domain->id;
        $account->email = trim($email);
        $account->password = md5(trim($request->get('password')));
        $account->save();

        return redirect()->route('dashboard.domains.accounts', $domain->id)
            ->with('status', 'Account added successfully')
            ->with('level', 'success');;
    }

    /**
     * Add a new account to domain
     *
     * @param Domain $domain
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function addAlias(Domain $domain, Request $request){

        $this->validate($request, [
            'source' => 'required',
            'destination' => 'required'
        ]);

        // Build new email
        $account = new Alias();
        $account->domain_id = $domain->id;
        $account->source = $request->get('source');
        $account->destination = $request->get('destination');
        $account->save();

        return redirect()->route('dashboard.domains.aliases', $domain->id)
            ->with('status', 'Alias added successfully')
            ->with('level', 'success');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $domain_id
     * @param int $account_id
     * @return \Illuminate\Http\Response
     */
    public function removeAccount($domain_id, $account_id){
        // Find Domain
        $account = Account::findOrFail($account_id);
        $response = null;

        if ($account) {

            $account->delete();
            $response = response()->json(['success' => 1, 'message' => 'Account deleted successfully.']);
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $domain_id
     * @param int $alias_id
     * @return \Illuminate\Http\Response
     */
    public function removeAlias($domain_id, $alias_id){
        // Find Domain
        $alias = Alias::findOrFail($alias_id);
        $response = null;

        if ($alias) {

            $alias->delete();
            $response = response()->json(['success' => 1, 'message' => 'Alias deleted successfully.']);
        }

        return $response;
    }
}
