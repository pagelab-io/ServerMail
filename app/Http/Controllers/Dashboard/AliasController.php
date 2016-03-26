<?php

namespace PageLab\ServerMail\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use PageLab\ServerMail\Domain;
use PageLab\ServerMail\Http\Requests;
use PageLab\ServerMail\Http\Controllers\Controller;
use PageLab\ServerMail\Repositories\AliasRepository;

class AliasController extends Controller
{

    /**
     * The domain repository instance.
     *
     * @var AliasRepository
     */
    protected $aliasRepository;


    public function __construct(AliasRepository $aliasRepository)
    {
        $this->middleware('auth');
        $this->aliasRepository = $aliasRepository;
    }

    /**
     * Display the specified resource.
     *
     * @param  Domain $domain
     * @return \Illuminate\Http\Response
     */
    public function aliases($domain)
    {
        return view('dashboard.domains.aliases.aliases', compact('domain'));
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

        $alias = $this->aliasController->createAlias($request, $domain->id);

        if ($alias) {
            return redirect()->route('dashboard.domains.aliases', $domain->id)
                ->with('status', 'forward agregado correctamente')
                ->with('level', 'success');
        } else {
            return redirect()->route('dashboard.domains.aliases', $domain->id)
                ->with('status', 'Ocurrio una incidencia al agregar el forward')
                ->with('level', 'warning');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $alias_id
     * @return \Illuminate\Http\Response
     */
    public function removeAlias($alias_id){

        $deleted = $this->aliasRepository->deleteAlias($alias_id);

        if ($deleted)
            return response()->json(['success' => 1, 'message' => 'Forward eliminado correctamente.']);
        else
            return response()->json(['success' => -1, 'message' => 'Ocurrio un error al eliminar el forward.']);

    }
}
