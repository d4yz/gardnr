#! /bin/bash

echo "This will install the Gardnr Base Module on your Raspberry Pi"
echo "Be sure to use 'gardnr' as the password for the mysql database."
read -n1 -r -p "Press Enter key to continue..." key

sudo apt-get update

echo "Downloading required packages..."
sudo apt-get install apache2 -y
sudo apt-get install php5 libapache2-mod-php5 -y
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password gardnr'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password gardnr'
sudo apt-get install mysql-server php5-mysql php5-curl -y

echo "Creating MySQL database..."
sudo cat gardnr.sql | mysql -uroot -pgardnr

echo "Copying Gardnr Web Files..."
#Rename Base folder to Gardnr and Move to Apache Web Folder
sudo rm /var/www/html -r
sudo mv base html
sudo mv html /var/www

echo "Changing File Permissions for Gardnr Web Files..."
#755 all folders and files
#777 for pinglog.txt and datalog.txt
sudo chmod -R 755 /var/www/html/
sudo chmod 777 /var/www/html/pinglog.txt
sudo chmod 777 /var/www/html/datalog.txt

echo "Fin"


#chown -R pi /var/www
