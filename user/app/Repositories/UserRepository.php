<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * class UserRepository 
 * Extends BaseRepository
 *
 * @package App\Repositories
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class UserRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     *
     * @param App\Models\User
     * @return void
     */
	public function __construct(User $model)
    {
       // set the model
       $this->model = $model;
    }

	/**
     * Save New Uses 
     *
     * @param array
     * @return App\Models\User
     */
    public function create(array $data)
    {
        return $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

}
