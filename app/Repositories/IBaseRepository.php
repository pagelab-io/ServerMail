<?php
/**
 * User: Emmanuel Sánchez Luna
 * Date: 11/03/2016
 * Time: 06:58 AM
 */

namespace PageLab\ServerMail\Repositories;


interface IBaseRepository {

    /**
     * Return all records
     *
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*'));

    /**
     * Return the selected record by id
     *
     * @param $id
     * @return mixed
     */
    public function byId($id);

}