# OpenExternalButtons
Software pro Raspberry Pi (ARM64) pro vzdálené ovládání počítačů.

Jak kompilovat(nutno kompilovat přímo na Raspberry Pi):
```sh
git clone  https://github.com/leandraycz/OpenExternalButtons.git
cd Open-External-Buttons
chmod +x build.sh
chmod 775 postinst
./build.sh
```

Jak instalovat:
```sh
sudo apt install apache2 php mariadb-server php-mysql
sudo apt install ./openexternalbuttons_1.0.deb
```

Výchozí přihlašovací údaje:
```txt
Uživatelské jméno: admin 
Heslo: admin123

Uživatelské jméno: user
Heslo: user123
```

Seznam změn:
```txt
1.0.0.0
První vydání

1.0.0.1
Opravy chyb

1.0.0.2
Opravy chyb a zabezpečení(náhodně heslo pro databázi)
Vylepšeno webové rozhraní(možnost odhlásit všechny uživatele)

```
