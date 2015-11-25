<?php

namespace PageLab\ServerMail\Repositories;

use PageLab\ServerMail\Domain;

class DomainRepository
{

    /**
     * Get all of the domains
     *
     * @param $request
     * @return Collection
     */
    public function search($request){

        $domains = Domain::paginate(50);

        // Sets the parameters from the get request to the variables.
        if ($request->get('name')) {
            $name = $request->get('name');
            $domains->where('name', 'like', "%$name%");
        }

        return $domains;
    }

}