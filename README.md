To get the project up and running, Pls Do the following After Cloning:

RUN composer install

RUN cp .env.example .env (Then setup ur .env file) or duplicate the .env.example file and name the duplicated one .env

Set up TrackTick authentication in .env

- Provide a valid access token in the **TRACK_TIK_ACCESS_TOKEN** env variable

RUN php artisan key:generate

RUN php artisan serve (To start the application)

TO RUN The Tests

RUN composer test (To run the tests)
