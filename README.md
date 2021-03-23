# snowtricks
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/d90faa5591344e2e9299efda8da22c3a)](https://www.codacy.com/gh/Marc-Alban/snowtricks/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=Marc-Alban/snowtricks&amp;utm_campaign=Badge_Grade)


SnowTricks
Project 6 of OpenClassrooms "PHP/Symfony app developper" course.

Description

Jimmy Sweat is an ambitious snowboarding entrepreneur. Its objective is the creation of a collaborative site to promote this sport to the general public and help with figure learning (tricks).

It wants to capitalize on content provided by Internet users in order to develop rich content that arouses the interest of users of the site. Subsequently, Jimmy wants to develop a business of connecting with snowboard brands thanks to the traffic that the content will have generated.

For this project, we will focus on the technical creation of the site for Jimmy.


Symfony 5.1 / Bootstrap 4 project
Installation
1 - Git clone the project

2 - Install libraries
       -composer install
    
3 - Create database

a) Update DATABASE_URL .env file with your database configuration.
            DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
        
b) Create database:
            php bin/console doctrine:database:create
        
c) Create database structure:
            php bin/console make:migration
        
d) Insert fictive data (optional)
            php bin/console doctrine:fixtures:load
