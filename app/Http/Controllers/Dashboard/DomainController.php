<?php

namespace PageLab\ServerMail\Http\Controllers\Dashboard;

use PageLab\ServerMail\Repositories\DomainRepository;
use PageLab\ServerMail\Http\Controllers\Controller;
use PageLab\ServerMail\Http\Requests;
use PageLab\ServerMail\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{

    /**
     * The domain repository instance.
     *
     * @var DomainRepository
     */
    protected $domainRepository;

    /**
     * Create a new controller instance.
     *
     * @param DomainRepository $domainRepository
     */
    public function __construct(DomainRepository $domainRepository)
    {
        $this->middleware('auth');

        $this->domainRepository = $domainRepository;
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $domains = $this->domainRepository->search2($request);
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

        $domain = $this->domainRepository->createDomain($request);

        if ($domain instanceof Domain) {
            return redirect('dashboard/domains')
                ->with('status', 'Dominio registrado correctamente.')
                ->with('level', 'success');
        } else {
            return redirect('dashboard/domains')
                ->with('status', 'Ocurrio una incidencia al crear el dominio, vuelve a intentarlo.')
                ->with('level', 'warning');
        }


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
     * Update the specified resource in storage.
     *
     * @param  Domain $domain
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Domain $domain, Request $request)
    {
        $this->validate($request, ['name'  => 'required']);

        $data = ['name' => $request->get('name')];
        $domain = $this->domainRepository->updateDomain($data, $domain->id);

        if ($domain) {
            return redirect('dashboard/domains')
                ->with('status', 'Dominio actualizado correctamente')
                ->with('level', 'success');
        } else {
            return redirect('dashboard/domains')
                ->with('status', 'Ocurrio una incidencia al realizar la actualización del dominio, vuelve a intentarlo')
                ->with('level', 'warning');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $deleted = $this->domainRepository->deleteDomain($id);

        if ($deleted)
            return response()->json(['success' => 1]);
        else
            return response()->json(['success' => -1]);

    }

    /**
     * Toggle Status Active
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function toggle($id){

        $domain = Domain::findOrFail($id);
        $data = ['status' => !$domain->status];
        $domain = $this->domainRepository->updateDomain($data, $id);

        if ($domain) {
            return redirect()->route('dashboard.domains.index')
                ->with('status', 'Estatus actualizado correctamente')
                ->with('level', 'success');
        } else {
            return redirect()->route('dashboard.domains.index')
                ->with('status', 'Ocurrio una incidencia al actualizar el estatus, intentalo nuevamente')
                ->with('level', 'warning');
        }

    }

}
