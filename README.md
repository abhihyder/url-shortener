### About Project


### Project Setup

-   Clone the repository
-   Run "composer install"
-   Run "cp .env.example .env"
-   Run "php artisan key:generate"

### Set some values in .env

-   TIME_ZONE= (UTC, Asia/Dhaka, etc)

-   DB\_ .....= (Database connection related values)

-   MAIL\_.....= (Mail related values)

-   QUEUE_CONNECTION=database

#### After that run those following command:
```shall
php artisan migrate --seed
```
```shall
php artisan serve
```
```shall
php artisan queue:work
```