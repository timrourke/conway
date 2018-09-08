git clone https://github.com/Ponup/phpsdl.git
cd phpsdl
phpize --clean
phpize
./configure --with-sdl
make
make test
make install
