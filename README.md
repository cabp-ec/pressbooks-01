# Books API

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

Coding challenge for Pressbooks, authored by Carlos Bucheli.

> I like to keep my codebase neat and clean, thus, I usually remove
> unnecessary comments and not-used classes and/or components.
> In this case, I'm using one and only one endpoint to return a list
> of items (i.e. books), therefore, not used stuff like the console
> commands kernel and service providers are simply not included
> in this repo.

### Implementation Requirements

  - Must be written in PHP (i.e. Lumen 5.8.0)
  - Must use a MySQL-based database (i.e. MySQL 8.0.20)
  - Must contain at least one unit test (using Behat 3.8)
  - Should provide documentation (i.e. this README.md file)

### Apache Web Server - Virtual Host

This challenge was created locally using PHP 7.4, Apache Web Server 2.4 and MySQL 8.0.20 on MacOS. To setup your own virtual host edit the `httpd-vhosts.conf` file and include the following entry (change the `DocumentRoot`, `ErrorLog` and `CustomLog` to match the ones in your computer):

```sh
<VirtualHost *:80>
 ServerName pressbooks.local
 ServerAlias www.pressbooks.local
 ServerAdmin cabp@carlos-bucheli.com
 DocumentRoot "/Users/cabp/WebPub/pressbooks/test-01/public"
 ErrorLog "/Users/cabp/WebPub/pressbooks/logs/error_log"
 CustomLog "/Users/cabp/WebPub/pressbooks/logs/access_log" common
</VirtualHost>
```

Then include the name of your virtual host to the `hosts` file, as follows. For Windows, you'll find such file under `c:\Windows\System32\drivers\etc\hosts` and for MacOw (and usually any Linux distro) under `/etc/hosts`:

```sh
# PRESSBOOKS
127.0.0.1 pressbooks.local
```

Then restart your webserver, using `Services` on Windows, the console command according to your Linux distro or the following for MacOs:

```sh
sudo apachectl restart
```

### Development Environment

The local development environment is set in the `.env` file, which is NOT included in this repository, you'll find a `.env.example` file. Please create a copy of it and rename it to `.env`.

### Database

The database name is `pressbooks`, you can use any name you want, in that case you'll need to set the new name in the `.env` file. The important entries you need to consider are the name of the database, the connection type, port and credentials:

```sh
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=pressbooks
DB_USERNAME=yourDbUser
DB_PASSWORD=yourDbPass
```

### Database Migrations

In order to create the database you'll need to run a few migrations, entering the following commands in your favorite terminal:

Go to the project directory:
```sh
$ cd /var/www/pressbooks/
```

Run migrations:
```sh
$ php artisan migrate
```

The last command will create 3 tables: `subject`, `language` and `book`. Next you can use the `` file to insert data in the recently created database, the easiest way to do so is by importing the file directly using your terminal:

Go to the `mock data` directory:
```sh
$ cd /var/www/pressbooks/test/mock_data
```

Import the `books.sql` file:
```sh
$ mysql -u username -p pressbooks < books.sql
```

### Test Environment

For testing, you'll need to use the `test.env` file. it's a copy of the `.env.example` file, in it you can customize it according to your needs. For this challenge I'm using [Behat](https://docs.behat.org/en/latest/), test cases are defined in the `behat.yml` file, features can be found in the `test/features` directory, while test implementations in the `test/tests` directory. In order to run test suites open your favorite Terminal and run these commands:

Go to the project directory:
```sh
$ cd /var/www/pressbooks/
```

Tu run ALL test suites:
```sh
$ vendor/bin/behat
```

Tu run specific suites:
```sh
$ vendor/bin/behat --suite=welcome
$ vendor/bin/behat --suite=search
```

### HTTP Request

You can run a GET request to the previously described virtual host (i.e. `http://pressbooks.local/search`) using the following parameters, all optional:

Get request to the :
```sh
{
	"per_page": 1,
	"search": "something",
	"is_original": 1,
	"subject": 2
}
```

### Other Pages

If you want to display results using pages other than `1` just add `?page=N` at the end of the URL, like this:


Display results for page 3
```sh
http://pressbooks.local/search?page=3
```
