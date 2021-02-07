# Books API

[![Build Status](https://travis-ci.org/joemccann/dillinger.svg?branch=master)](https://travis-ci.org/joemccann/dillinger)

Coding challenge for Pressbooks, authored by Carlos Bucheli.

> I like to keep my codebase neat and clean, thus, I usually remove
> unnecessary comments and not-used classes and/or components.
> In this case, I'm using one and only one endpoint to return a list
> of items (i.e. books), therefore, not used stuff is simply not included
> in this repo, unless they become necessary.

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

### To Do's

The following items are some improvements that need to be completed (during the next hours):

* Reduce the amount of if statements in the SearchController
* Pass JSON data via Behat/PHPUnit
* Create migrations
