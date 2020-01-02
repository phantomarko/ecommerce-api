E-commerce Symfony API 🎼
======
Symfony 4.4 developed and tested in Homestead environment with PHP 7.3

## Project set up
### 1. Create Environment file
Create a copy of .env as .env.local with your database configuration. Example: 
```bash
DATABASE_URL=mysql://user:password@127.0.0.1:3306/database
```

### 2. Install vendor libraries
Execute compose install:
```bash
composer install
```

### 3. Create database
The project has doctrine migrations to create the database structure and add taxonomies rows by executing this command:
```bash
php bin/console doctrine:migrations:migrate
```

## Endpoints documentation
There is a detailed API doc available by enter to the url /api/doc.json. The available endpoints are:
```bash
GET     /api/doc.json
GET     /api/products
POST    /api/products
```


## Execute tests
Open the terminal and execute the next command to run unit tests created with PHPUnit and Prophecy mock library:
```bash
php bin/phpunit
``` 