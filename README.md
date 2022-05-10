# Matcher microservice

A microservice app to match customer profiles with properties profiles.

## Setting up

To setup the app, clone the github repo using the command `git clone https://github.com/sdkcodes/reomatchmicro.git`

Once cloned, `cd` into the project root directory and run `cp .env.example .env` to create the .env file from the example .env file.

Run `php artisan key:generate` to generate the app key for security.

Fill in the database details in the .env file

Note: You can also use the prepackage sqlite db by setting the `DB_CONNECTION` value to `sqlite`

## Testing

To run the app tests, run the command `php artisan test`

The test contains a few use cases to show you how the app works.
