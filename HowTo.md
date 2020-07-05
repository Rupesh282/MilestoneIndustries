# IMPORTANT STUFF AND COMMANDS 



# If you want to create database manually :
- create product table :
- `create table product(prod_file VARCHAR(50) , prod_name VARCHAR(50) , mainFrame VARCHAR(30) , categories VARCHAR(50) , id INT NOT NULL AUTO_INCREMENT , PRIMARY KEY (id));`

- create categories table : 
- `create table categories(category VARCHAR(100));`

- create email table :
- `create table emails(email VARCHAR(50));`



# for creating new users from root : 
-  `create user '[username]'@'localhost' IDENTIFIED BY '[password]';` <br>
-  `GRANT ALL PRIVILEGES ON *.* TO '[username]'@'localhost';`


# to give read/write permission to apache2 to any folder : 
- `sudo chown -R www-data <foldername>`


# creation of database in your local machine : 
- create database in your local machine using `database_generator.php` present backend folder (just run than file in localhost) 
> [NOTE : before that , don't forget to give your sql credentials in loginfo.php file]


# sql data migration from one server to another : 
-  First on old server , to copy all tables in a database - > (run this commands as root)
    -$ `mysqldump -u root -p [database-name] > [database-name].sql`
-  Now , create a database on the second server with name you want. Then using file generated above -> (run following command as root)
    -$ `mysql -u root -p [new-database-name] < [database-name].sql`
This will copy all data from previous server to new one including all entries in table


# For enabling rewriting of urls : 
- `sudo a2enmod rewrite`
- go to `/etc/apache2/sites-available/000-default.conf ` and add this commands in file : 
- (otherwise you can put it in apache2.conf)
- `<Directory "/var/www/html">
      AllowOverride All
    </Directory>`
- then restart apache server (sudo service apache2 restart)
- useful link -> [StachOverFlow](https://stackoverflow.com/questions/12202387/htaccess-not-working-apache#:~:text=htaccess%20files%20are%20being%20ignored,right%20block%20in%20your%20configuration.)

- also before checking in you local machine , change path in `base` tag present in header
  in show.php to your assets folder containing css (relative to root dir)







