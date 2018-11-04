HR Module API Service
=====


This is HR Module micro service of Larevl ERP project. Provides API access only. This connects on User Module API Service for user authentication.

Features Completed
-------

* Leave Management
	- Submit Leave Application 
	- Approve Application 
	- Deny Application 
	- Leave Uses Report 

To Do
-------

* Access Level Permission on Approve, Deny and Report
* Create Hr Profile
* Weekend and Holiday Setup


API Available
-------

1. Submit a Leave Application
	```
	POST api/v1/leave/apply
	Form Values: 
		start_date
		end_date
		leave_type (Values Accept: Sick, Casual, Earned, Maternity, Paternity)
		reason
	```
2. Leave Application Approve
	```
	PUT api/v1/leave_application/approve/{application_id}
	```
3. Leave Application Deny
	```
	PUT api/v1/leave_application/deny/{application_id}
	```
4. Get list of all Leave Applications
	```
	GET api/v1/leave_applications/list
	```
5. Get Leave Applications list applied by a user
	```
	GET api/v1/leave_applications/list/{user_id}
	```	
6. Get Leave Applications list applied by looged in or auth user
	```
	GET api/v1/leave_applications/my/list
	```		
7. Leave already uses by an user
	```
	GET api/v1/leave/uses/{user_id}
	Parameters:
		from_date (optional)
		to_date (optional)
	```		
8. Leave already uses by logged in or auth user
	```
	GET api/v1/leave/my/uses
	Parameters:
		from_date (optional)
		to_date (optional)
	```			


Install
-------

* Run `composer install`
* Rename `.env.example` to `.env` file and chnage your configuration as you needs.
* Add a env config with name `USER_API_BASE` and set User Module Microservice API base url. example: http://localhost:8081/ 
* generate APP_KEY by command by `php artisan key:generate`
* Run `php artisan migrate` 


Or, Run From Docker
-------

1. Run `docker-compose build`
2. Run `docker-compose up`
3. Run `docker-compose run hr_service php artisan migrate`
4. Deploy Ready now and hit `localhost:8082`