# Bilemo

Bilemo is a REST API built during my [web development learning path](https://openclassrooms.com/fr/paths/59-developpeur-dapplication-php-symfony) with OpenClassrooms.
This API provides a catalog of Phones and Tablets accessible by the Retailers and their Clients.

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/5788f5542f9d46c1a6d8fb9852a9e6d9)](https://www.codacy.com/app/RSHKDL/p7-rest-api?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=RSHKDL/p7-rest-api&amp;utm_campaign=Badge_Grade)

## About

### Back-end

* Symfony 4.4.4 LTS
* Doctrine
* JWTAuthentication

### Friendly with

* PSR-1, PSR-4, PSR-12
* Symfony Best Practices (mostly)

## Install

1. Clone or download the repository `git@github.com:RSHKDL/p7-rest-api.git` into your environment.
2. Change the files **.env.dist** and with your own data.
3. Install the database and inject the fixtures:
    ```
    $ bin/console doctrine:database:create
    $ bin/console doctrine:schema:create
    $ bin/console doctrine:fixtures:load
    ```
4. Generate the JWTAuthentication SSH keys:
    ```
    $ mkdir -p config/jwt
    $ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
    $ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
    ```

## Test the application

1. Make sure you have load the fixtures.
2. Create your (or yours) **Retailers** by running this command:
    ```
    $ bin/console app:retailer:create
    ```
3. Once you have a Retailer, go to this URI: `/api/login_check`, submit this payload:
    ```json
    {
        "username": "your-retailer-email",
        "password": "your-retailer-password"
    }
    ```
4. Grab your token and use it as Bearer for your other request to the API.
5. To test caching in an environment other than production, you need to edit `public/index.php` and replace **prod** by **dev**.

## Documentation

This simple API project is as documented as possible:
You can find a full documentation of API methods by adding `/api/doc` at the end of your API URI.
