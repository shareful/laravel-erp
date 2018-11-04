User Module API Service
=====


This is User Module micro service of Larevl ERP project. Provides API access only. This provides uthentication service for user using JWT for other micro services.

Features Completed
-------

* User Management
	- User Registration
	- User Login
	- User Authentication

To Do
-------

* User List
* Upate User Info
* Access Level Permission on user list and user information update


API Available
-------

1. User Registration
	```
	POST api/v1/register
	Form Values: 
		name
		email
		password
		password_confirmation
	```
2. User Login
	```
	POST api/v1/login
	Form Values: 
		email
		password
	```
3. Get Logged In or Auth User Details
	```
	GET api/v1/me
	```
4. User Logout
	```
	GET api/v1/logout
	```
5. Token Regenerate
	```
	GET api/v1/refresh
	```


Install
-------

* Run `composer install`
* Rename `.env.example` to `.env` file and chnage your configuration as you needs.
* generate APP_KEY by command by `php artisan key:generate`
* Run `php artisan migrate` 
* Run `php artisan serve --port=8081 --host=0.0.0.0` to up the server in port 8081. 


Or, Run From Docker
-------

1. Run `docker-compose build`
2. Run `docker-compose up`
3. Run `docker-compose run user_service php artisan migrate`
4. Deploy Ready now and hit `localhost:8081`