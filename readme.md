-----Steps-----

#1 Run composer update. //This will install all dependies used in the project

#2 Create a Mysql database and add details to the project .env file
 In the project I created a database called jobtest and added the details to .env file as seen below
    DB_DATABASE=jobtest
    DB_USERNAME=root
    DB_PASSWORD=

#3 php artisan migrate //This will create all database tables needed for the project

To test for the questions in the test, access the urls with the request stated in front

#1 Add a new user
-- /api/signup ------ POST  
firstname, 
lastname, 
date_of_birth, 
username, 
email, 
password
 
-- /api/login ------ POST
#parameters
email, 
password, 

-- /api/countries ---------POST
#parameters
name, 
continent, 

-- /api/countries   ---------GET

-- /api/countries/:id ---------- PUT
id is the primary key of the country to update

-- /api/countries/:id ----------- DELETE
id is the primary key of the country to delete

-- /api/users/activities ----- GET
 
