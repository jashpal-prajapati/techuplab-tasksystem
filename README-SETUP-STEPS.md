## Project Setup Steps

1) Clone project from github. By using below command
	
	git clone <Repository_file_path>

2) After Clone Project Run Composer

	Composer Install

3) Now Create Database [techlab] Into MySql

4) Now Copy .env.example to .env and Add Database Detail into .env file

5) Now Run Migration File. Run Below Command

	php artisan migrate

6) After Done Migration Now Run Seeder Files By Using Below Command

	php artisan db:seed

7) After Run Above All Command Now Import Postman Collection For API 
   [Postman Collection File(Techlab API.postman_collection) Exists In Project Folder]

8) Now Run Project In Terminal By Call Laravel Serve Command

	php artisan serve

9) Test API On Postman [URL: http://localhost:8000/api/<route_action>]
