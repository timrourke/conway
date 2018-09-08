FROM php:7.2.9-cli-stretch

ADD . ~/conway

WORKDIR ~/conway

RUN apt-get update && apt-get install -y libsdl2-dev git xorg

RUN	./install_phpsdl.sh

RUN docker-php-ext-enable sdl

RUN ./install_phpopengl.sh

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"

RUN mv composer.phar /usr/local/bin/composer

RUN composer install

RUN startx

CMD ["php", "example.php"]
