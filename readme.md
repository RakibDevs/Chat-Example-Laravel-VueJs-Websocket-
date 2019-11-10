<p align="center">![alt test](screenshots/chat.png)</p>

Real time chatting application built Laravel with WebSockets package, VueJs, Laravel-Echo, vue-chat-scroll, vue-timeago.

## 
- Clone this repository `git clone git@github.com:qirolab/Laravel-WebSockets-Chat-Example.git`
- `composer install`
- `php artisan key:generate`
- copy .env.example .env and configure your database in .env file.
- Run migration to create tables in database. `php artisan migrate`
- Final step run websockets server. `php artisan websockets:serve`
- Now test it in your browser

Special thanks to [qirolab] (https://github.com/qirolab/Laravel-WebSockets-Chat-Example)
