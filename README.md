# BANK ACCOUNT MINI-API CODE TEST

The main goal of the project was creating a miniature API client for Bank Account management.
That being said, Bank Account includes creating a Wallet with desired Currency and then
allowing making deposits and withdraws using requests.

### Installation and running
Before start make sure you have Docker and Docker Compose, PHP 8.2 and Composer 2 installed.

Project is running on Symfony 6.2 and PHP 8.2.

To set up and run the project you need to perform actions listed below:

1. Running Docker container:
```bash
docker compose up -d # or docker-compose up -d, it depends on what is your Docker Compose package
composer install
```
2. Open `bank-app` Docker container's CLI using Docker Desktop or run command:
```bash
docker exec -it bank-app /bin/sh
```
3. Go to the root project directory, create and migrate database
```bash
# In the bank-app container bash

cd ..
php bin/console doctrine:databse:create
php bin/console doctrine:migrations:migrate
```

The application is preconfigured, and it's starting on http://localhost:8000.

### Usage

#### Endpoints

| Endpoint              | Method | Body                                             | Description                                                                                                | Example Response                                               |
|-----------------------|--------|--------------------------------------------------|------------------------------------------------------------------------------------------------------------|----------------------------------------------------------------|
| /wallet               | GET    | -                                                | Get a complete list of all wallets in the database                                                         | [   {     "id": "...",     "balance": "10.00 PLN"   },   ... ] |
| /wallet               | POST   | {   "name": "Some wallet",   "currency": "PLN" } | Create a wallet with given name and currency. Supported currencies are: ["PLN", "EUR"]                     | {   "id": "..." }                                              |
| /wallet/{id}/balance  | GET    | -                                                | Get a balance of a wallet with given id                                                                    | {   "balance": "10.00 EUR"}                                    |
| /wallet/{id}/deposit  | PUT    | {   "amount": 1000}                              | Add a given value to a wallet's balance. A value is represented in 1/100 of unit. 1 full-unit = 100        | {   "balance": "10.00 EUR" }                                   |
| /wallet/{id}/withdraw | PUT    | {   "amount": 500 }                              | Subtract a given value from a wallet's balance. A value is represented in 1/100 of unit. 1 full-unit = 100 | {   "balance": "5.00 EUR" }                                    |

#### Commands

| Command                                 | Description                                                                                   |
|-----------------------------------------|-----------------------------------------------------------------------------------------------|
| app:wallet:history [wallet-id] [format] | Generates a operation history for a given wallet in a given format. Supported format is: csv. |