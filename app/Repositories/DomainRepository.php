<?php

namespace PageLab\ServerMail\Repositories;

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