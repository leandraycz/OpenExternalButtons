#!/bin/bash
echo Installing needed software for compiling
sudo apt install libmariadb-dev gcc git -y

echo Cloning wiringpi library
git clone https://github.com/WiringPi/WiringPi.git
cd WiringPi
./build
cd ..

echo Building main file
gcc main.c -o main -lwiringPi -lmariadb

echo Building deb file
mkdir openexternalbuttons_1.0
mkdir openexternalbuttons_1.0/usr
mkdir openexternalbuttons_1.0/usr/local
mkdir openexternalbuttons_1.0/usr/local/bin
cp main openexternalbuttons_1.0/usr/local/bin
mkdir openexternalbuttons_1.0/DEBIAN
cp control openexternalbuttons_1.0/DEBIAN
cp postinst openexternalbuttons_1.0/DEBIAN
mkdir openexternalbuttons_1.0/usr/share
mkdir openexternalbuttons_1.0/usr/share/openexternalbuttons
mkdir openexternalbuttons_1.0/usr/share/openexternalbuttons/files
cp main html
cp -r html openexternalbuttons_1.0/usr/share/openexternalbuttons/files

dpkg-deb --build openexternalbuttons_1.0
