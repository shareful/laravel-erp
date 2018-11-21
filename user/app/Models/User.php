<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * class User 
 * Extends Illuminate\Foundation\Auth\User
 * Implements Tymon\JWTAuth\Contracts\JWTSubject
 *
 * @package App\Models
 * @author Shareful Islam <km.shareful@gmail.com>
 * 
 * @SWG\Definition(
 *      definition="User",
 *      required={"name", "email", "password"},
 *      type="object",
 *      @SWG\Property(
 *          property="id",
 *          description="User Id",
 *          type="integer",
 *          format="int32"
 *      ),
 *      @SWG\Property(
 *          property="name",
 *          description="User Full Name",
 *          type="string",
 *      ),
 *      @SWG\Property(
 *          property="email",
 *          description="User Email Address",
 *          type="string",
 *          format="email"
 *      ),
 *      @SWG\Property(
 *          property="password",
 *          description="User Password",
 *          type="string",
 *      ),
 * )
 */
class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
