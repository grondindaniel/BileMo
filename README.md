# BileMo
BileMo API

Build with Symfony 5, PHP 7.4.6

How to install the API ?

First :

git clone https://github.com/grondindaniel/BileMo.git

Next : 

cd BileMo

Next :

composer install

Important :

In the .env file configure the database access

Next in your terminal : 

php bin/console doctrine:database:import bilemo.sql

For the token : 

mkdir -p config/jwt

openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096

openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout

Next :

In the .env file change JWT_PASSPHRASE= " with the passphrase you created in token generation step.

Next : 

symfony console server:start -d

see the doc

https://127.0.0.1:8000/documentation/

Then to use the api :

{"username": "phone_market", "password": "xkeyscore"}

It will generate a token ( it will expire in 1 hour) and paste in Authorization :  Token.

Enjoy
