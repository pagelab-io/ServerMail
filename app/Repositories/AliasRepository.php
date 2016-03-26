<?php
/**
 * Created by PhpStorm.
 * User: Emmanuel
 * Date: 25/03/2016
 * Time: 04:51 PM
 */

namespace PageLab\ServerMail\Repositories;


use Illuminate\Http\Request;
use PageLab\ServerMail\Alias;

class AliasRepository extends BaseRepository {

    /**
     * Return the namespace for Alias Model
     *
     * @return mixed|string
     */
    public function model()
    {
        return 'PageLab\ServerMail\Alias';
    }

    /**
     * Create a new task for the User in Session
     *
     * @param Request $request
     * @param $idDomain
     * @return null|Alias
     */
    public function createAlias(Request $request, $idDomain)
    {

        // Build new forward
        $alias = new Alias();
        $alias->domain_id = $idDomain;
        $alias->source = $request->get('source');
        $alias->destination = $request->get('destination');
        $alias->save();

        if(!($alias instanceof Alias)) return null;

        return $alias;
    }

    /**
     * Delete the specific task if exist
     *
     * @param $id
     * @return bool
     */
    public function deleteAlias($id)
    {

        $alias = $this->byId($id);

        if ($alias) {
            $alias->delete();
            return true;
        }

        return false;

    }

} 