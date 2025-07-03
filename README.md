# p-api – Laravel Products API

## Steps to Set Up
1. Clone the repository
   `git clone https://github.com/hixvmx/p-api.git`

2. Change Directory
   `cd p-api`

3. Install dependencies
   `composer install`

4. Set up environment file
   `php artisan key:generate`

5. Run Xampp and create database `p_api`

6. Run migrations and seeders
   `php artisan migrate --seed`

7. Run the API
   `php artisan serve --port=1030`
   API is now running at: http://127.0.0.1:1030/api/products


---


## Postman Collection
I’ve included a Postman collection to test the API.

Download Postman Collection: ./POSTMAN_COLLECTION.json

1. Import it into Postman
2. Test all endpoints with ready-to-use examples.

Tech Stack
- Laravel 11
- MySQL
- RESTful API


---

## 🚀 Built by **https://www.hixvm.com**