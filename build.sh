#!/bin/bash
echo Instalace softwaru potřebného pro kompilaci
sudo apt update
sudo apt install libmariadb-dev gcc git -y

echo Klonování knihovny WiringPi
git clone https://github.com/WiringPi/WiringPi.git
cd WiringPi
./build
cd ..

echo Sestavování hlavního souboru
gcc oeb.c -o oeb -lwiringPi -lmariadb

echo Sestavování debianího souboru
mkdir openexternalbuttons_1.0
mkdir openexternalbuttons_1.0/usr
mkdir openexternalbuttons_1.0/usr/local
mkdir openexternalbuttons_1.0/usr/local/bin
cp oeb openexternalbuttons_1.0/usr/local/bin
mkdir openexternalbuttons_1.0/DEBIAN
cp control openexternalbuttons_1.0/DEBIAN
cp postinst openexternalbuttons_1.0/DEBIAN
mkdir openexternalbuttons_1.0/usr/share
mkdir openexternalbuttons_1.0/usr/share/openexternalbuttons
mkdir openexternalbuttons_1.0/usr/share/openexternalbuttons/files
cp -r html openexternalbuttons_1.0/usr/share/openexternalbuttons/files

dpkg-deb --build openexternalbuttons_1.0

echo Program je sestaven, instalaci spustíte příkazem "sudo apt install ./openexternalbuttons_x.x.deb"
