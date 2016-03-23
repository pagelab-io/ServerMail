<?php

namespace PageLab\ServerMail\Repositories;

use Illuminate\Http\Request;
use PageLab\ServerMail\Domain;

class DomainRepository extends BaseRepository
{

    /**
     * Return the namespace for Task Model
     *
     * @return String
     */
    function model()
    {
        return "PageLab\\ServerMail\\Domain";
    }

    /**
     * Get all domains by the specified search
     * @param Request $request
     * @return mixed
     */
    public function search2(Request $request){

        $domains = Domain::orderby('created_at', 'desc');

        if (trim($request->get('name')) != '') {

            $name = trim($request->get('name'));
            $domains->where('name', 'LIKE', '%' . $name . '%');
        }

        $domains = $domains->paginate();

        return $domains;
    }

    /**
     * Create a new domain
     *
     * @param Request $request
     * @return Domain
     */
    public function createDomain(Request $request)
    {
        $domain = new Domain();
        $domain->name = $request->get('name');
        $domain->save();

        if (!($domain instanceof Domain)) return null;

        return $domain;
    }

    public function updateDomain(array $data, $id)
    {
        // retrieve the domain by Id
        $domain = $this->byId($id);

        if (!($domain && $domain instanceof Domain)) return null;

        // update record
        $this->update($data, $id);

        return $domain;

    }

    /**
     * Delete the specified domain
     *
     * @param int $id
     * @return bool
     */
    public function deleteDomain($id)
    {
        $task = $this->byId($id);

        if ($task) {
            $task->delete();
            return true;
        }

        return false;
    }

    /**
     * Get all of the domains by the specified search
     *
     * @param $request
     * @return Collection
     */
    public function search($request)
    {

        $domains = Domain::paginate(50);

        // Sets the parameters from the get request to the variables.
        if ($request->get('name')) {
            $name = $request->get('name');
            $domains->where('name', 'like', "%$name%");
        }

        return $domains;
    }

}