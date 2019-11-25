# coalesce
An app for bringing people together.

# Setup

## Install dependencies:

```
composer install
```

## Database
Connect to your MySQL instance of choice:

```
cp .env .env.local
```

And change the `DATABASE_URL` in `.env.local` to connect to your database.

If no database exists yet:

```
bin/console doctrine:database:create
```

And run necessary migrations:

```
bin/console doctrine:migrations:migrate
```

## Run local server

Run the local webserver using

```
bin/console server:run
```

# API

You can access the API docs at `/api/docs` where the endpoints are documented and testable.

In order to access the endpoints, you first need to register at `/api/register`, and then login with the same user information:

```
POST /api/login_check

JSON

{
    "username": "username@example.com",
    "password": "password"
}
```

You then receive the token you can use in follow-up requests, by setting the following HTTP header:

```
Authorization: Bearer (token value)
```

When using the OpenAPI frontend, you can click the 'Authorize' button on the top right and paste the token value there (prefixed with 'Bearer').

# Tests

Run the application tests:

```
bin/phpunit
```
