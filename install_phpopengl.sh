git clone git://github.com/phpopengl/extension.git --recursive phpopengl
cd phpopengl
phpize
./configure --enable-opengl
make
make install
