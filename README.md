# Slim Sample Application

You need set your environment variables to define your database parameters or rename .env.example file in project to .env and change the below to your local configuration.


Install package dependencies:

```
    composer install
```

You need set your environment variables to define your database parameters in `.env`

    driver=mysql
    host=127.0.0.1
    username=test
    password=test
    port=3306
    charset=utf8
    collation=utf8_unicode_ci
    database=slim_sample

Finally, boot-up the API service with PHP's Built-in web server:
```
  php -S localhost:8080 -t public/
```
