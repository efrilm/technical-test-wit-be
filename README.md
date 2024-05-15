# Technical Test WIT Backend

Backend With :

Laravel

-   Front End : [Link](https://github.com/efrilm/technical-test-wit-fe)
-   Postman Document API: [Link](https://documenter.getpostman.com/view/14576482/2sA3JRYecQ)

## Project Setup

```
composer install
```

```
cp .env.example .env
```

Change the database name in env

```
php artisan key:generate
```

```
php artisan migrate
```

```
php artisan db:seed
```

```
php artisan storage:link
```

```
php artisan serve
```
