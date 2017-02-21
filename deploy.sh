docker run -t -p 80:80 --name blog --detach -v $PWD/src:/var/www/html/ php:7.0-apache

