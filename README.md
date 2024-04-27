Documentation: [Postman Collection](https://documenter.getpostman.com/view/3107567/2sA3Bt3ppu)


To get the project up and running, Pls Do the following after cloning:

RUN `composer install`

RUN `cp .env.example .env` (Then setup ur .env file) or duplicate the .env.example file and name the duplicated one .env

- Set up DB connection in .env

Set up TrackTick authentication in .env

- Provide a valid access token in the **TRACK_TIK_ACCESS_TOKEN** env variable

RUN `php artisan key:generate`

RUN `php artisan serve` (To start the application)

**TO RUN The Tests**

Go to `.env.testing` located on the root directory and provide the correct absolute path for the
`test.sqlite` file in the `database` folder also in the root directory
- Correct PATH should be provided in the `DB_DATABASE` field


RUN `php artisan migrate --env=testing`

RUN `composer test` (To run the tests)
