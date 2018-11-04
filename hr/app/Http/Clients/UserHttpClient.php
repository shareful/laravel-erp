<?php

namespace App\Http\Clients;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Support\Collection;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;

/**
 * Class UserHttpClient
 * Http client to communicate with user api
 *
 * @package App\Http\Clients
 * @author Shareful Islam <km.shareful@gmail.com>
 */
class UserHttpClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * JWT Bearer Token
     * 
     * @var string
     */
    private $token;

    /**
     * Headers required to call User Api
     * 
     * @var string
     */
    private $headers;

    /**
     * Authenticated User Id
     * 
     * @var integer
     */
    private $userId;

    /**
     * Authenticated User Info
     * 
     * @var integer
     */
    private $userInfo;

    /**
     * UserHttpClient constructor.
     *
     * @param Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->token = $request->bearerToken();
        $this->headers = [
                'Authorization' => 'Bearer ' . $this->token,        
                'Accept'        => 'application/json',
            ];            
        $this->client = new Client([
            'base_uri' => env("USER_API_BASE_URI", "http://localhost:8081/")
        ]);
    }


    /**
     * Validate user token
     * 
     * @return bool
     */
    public function isAuthentic(): bool
    {
        try {     
            $res = $this->client->request(
                'GET', 
                'api/v1/me', 
                ['headers' => $this->headers]
            );
            if ($res->getStatusCode() == 200) {
                $content = json_decode($res->getBody()
                                ->getContents());
                $this->userInfo = $content->data;
                $this->userId =$this->userInfo->user->id;

                return true;
            } else {
                return false;
            }            
        } catch (BadResponseException $exception) {
            throw new HttpException(
                $exception->getCode(),
                $exception->getResponse()->getBody()->getContents()
            );
        }
    }

    /**
     * Get Auth User Info
     *
     * @return stdClass|null
     */
    public function getAuthUserInfo()
    {
        return $this->userInfo;
    }

    /**
     * get Auth User Id
     * 
     * @return string|null
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
