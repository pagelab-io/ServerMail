<?php
/**
 * User: Emmanuel Sánchez Luna
 * Date: 11/03/2016
 * Time: 07:10 AM
 */

namespace PageLab\ServerMail\Repositories;

use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;
use Mockery\CountValidator\Exception;


abstract class BaseRepository implements IBaseRepository{

    /**
     * @var app
     */
    private $app;

    /**
     * @var
     */
    protected $model;

    public function __construct(App $app) {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * Specify Model class name
     *
     * @return mixed
     */
    abstract function model();

    /**
     * Return Model by each class
     *
     * @return Model
     */
    private function makeModel() {

        $this->model = $this->app->make($this->model());

        if (!$this->model instanceof Model)
            throw new Exception("Class ".$this->model." must be an instance of Illuminate\\Database\\Eloquent\\Model");


        return $this->model;
    }

    /**
     * Return all records
     *
     * @param array $columns
     * @return mixed
     */
    public function all($columns = array('*')){
        return $this->model->get($columns);
    }

    /**
     * Return the selected record by id
     *
     * @param $id
     * @return mixed
     */
    public function byId($id){
        return $this->model->findOrFail($id);
    }

} 