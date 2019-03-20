RESTful API with Laravel.

Technologies/Patterns/Features:
- PHP7
- Laravel
- Unit & Feature tests
- Repository & Service Pattern
- PSR
- Seeding Database with Model Factory


Installation

Clone repository

`composer install`

`cp .env.example .env`

[Enable geocoding](https://stackoverflow.com/questions/32994634/this-api-project-is-not-authorized-to-use-this-api-please-ensure-that-this-api) in Google Console
and add key in .env

`php artisan key:generate`

`php artisan migrate --seed`
