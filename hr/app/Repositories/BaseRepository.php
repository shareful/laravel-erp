<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * class BaseRepository 
 * Implements iRepository
 *
 * @package App\Repositories
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class BaseRepository implements iRepository
{
    /**
     * Model property on class instances
     *
     * @var string
     */
    protected $model;

    /**
     * BaseRepository constructor
     * Constructor to bind model to repo
     *
     * @param Illuminate\Database\Eloquent\Model
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all instances of model
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * create a new record in the database
     *
     * @param array
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * update record in the database
     *
     * @param array
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update(array $data, $id)
    {
        $record = $this->find($id);
        return $record->update($data);
    }

    /**
     * Remove record from the database
     * Return 1 on success
     *
     * @param array
     * @return int
     */
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    /**
     * Retrive the record with the given id
     *
     * @param mixed
     * @return int
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Get the associated model
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set the associated model
     *
     * @param Illuminate\Database\Eloquent\Model
     * @return BaseRepository
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * Eager load database relationships
     *
     * @param  array|string  $relations
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
