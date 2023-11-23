<p  align="center"><a  href="https://laravel.com"  target="_blank"><img  src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"  width="400"></a></p>

## Starter Kit Laravel 9.x and Firebase Jwt

This repository is a starter for back end using laravel 9.x and Firebase Jwt

## Setup

<ul  dir="auto">  <li>Clone Project from Github :</li>  </ul>  <div  class="highlight highlight-source-shell notranslate position-relative overflow-auto"  dir="auto"  data-snippet-clipboard-copy-content="https://github.com/fazarrr/starter-laravel-backend.git"><pre>https://github.com/fazarrr/starter-laravel-backend.git</pre></div>  <ul  dir="auto">  <li>Copy file .env.example and rename become .env</li>  <li>If using MySQL uncomment block "DB_CONNECTION=mysql". If using PostgreSQL uncomment block "DB_CONNECTION=pgsql"</li>  <li>Create a database according to your choice (MySQL / PostgreSQL)</li>  <li>In the .env file, search for and fill in "DB_DATABASE" with the name of the database you created, fill in "DB_USERNAME" with the database username and "DB_PASSWORD" with your database password</li>  <li>Replace JWT_SECRET_KEY in the .env file with a random string for the jwt key</li>  </ul>  <ul  dir="auto">  <li>Execute command :</li>  </ul>  <div  class="highlight highlight-source-shell notranslate position-relative overflow-auto"  dir="auto"  data-snippet-clipboard-copy-content="php artisan key:generate"><pre>php artisan key:generate</pre></div>  <ul  dir="auto">  <li>Execute command :</li>  </ul>  <div  class="highlight highlight-source-shell notranslate position-relative overflow-auto"  dir="auto"  data-snippet-clipboard-copy-content="https://github.com/fazarrr/starter-laravel-backend.git"><pre>composer install</pre></div>  <ul  dir="auto">  <li>Execute command :</li>  </ul>  <div  class="highlight highlight-source-shell notranslate position-relative overflow-auto"  dir="auto"  data-snippet-clipboard-copy-content="php artisan migrate"><pre>php artisan migrate</pre></div>  <ul  dir="auto">  <li>Execute command :</li>  </ul>  <div  class="highlight highlight-source-shell notranslate position-relative overflow-auto"  dir="auto"  data-snippet-clipboard-copy-content="php artisan db:seed --class=AdminUserSeeder"><pre>php artisan db:seed --class=AdminUserSeeder</pre></div>

<p  dir="auto">Email : admin@gmail.com <br> Password : admin</p>

<p  dir="auto">Postmant collection is in storage\app\public\Starter Backend.postman_collection</p>

## License

<p  dir="auto">The MIT license is a free-to-use software license originating from the Massachusetts Institute of Technology (MIT). This license is concise and to the point. This license allows users to do anything with the program code as in the Apache License. This license only requires users to include the author's license and copyright in the redistributed code and there is no prohibition on using the original author's trademark. Apart from that, users also have no right to sue the creator if damage occurs to the software. <a  href="https://opensource.org/licenses/MIT"  rel="nofollow">MIT license</a>.</p>
