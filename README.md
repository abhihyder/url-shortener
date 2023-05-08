## About Project


## Project Setup

-   Clone the repository
-   Run "composer install"
-   Run "cp .env.example .env"
-   Run "php artisan key:generate"

<h4> Set some values in .env</h4>

-   TIME_ZONE= (UTC, Asia/Dhaka, etc)

-   DB\_ .....= (Database connection related values)

-   MAIL\_.....= (Mail related values)

-   QUEUE_CONNECTION=database

<h4>After that run those following command</h4>

php artisan migrate --seed

php artisan serve

php artisan queue:work
