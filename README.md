# How to Use
1. Copy `.env.example` to `.env`
2. Fill the Database and Mailer setting
3. Run `composer install` or `php composer.phar install`
4. Run `php artisan migrate`
5. Run `php artisan db:seed` to run seeders, if you need it
6. Run `php artisan serve`
7. Run `php artisan command:send_posts_to_users` to run the command to send email
8. Run `php artisan queue:work` to run the queue
9. You can found the Postman example at file `Simple-Subscription-Laravel.postman_collection.json` at this repository