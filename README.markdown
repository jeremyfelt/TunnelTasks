TunnelTasks, for lack of a better name, is being built with the intent to provide some form of one (or few) click staging and production deployment in a  LAMP (PHP) environment. Right now the specific focus is towards the management of WordPress sites.

## General Warning

This stuff definitely goes around plenty of security principles. If it's not entirely obvious, use at your own risk.

## Requirements

Nothing solid yet, but...

* You'll want at least 2 servers setup to test - one for production, one for staging.

* PHP's Secure Shell2 (http://php.net/manual/en/book.ssh2.php) is required. So far no replacement on a Windows box.

## Get It Working Now

* On 'production' server, download, extract latest version of WordPress
* On 'production' server, create a database with credentials for WordPress
* On 'production' server, install WordPress
* On 'staging' server, create the web directory for staging
* On 'staging' server, create a databse with same WordPress credentials
* On 'staging' server, move config.php.sample to config.php, modify variables.
* On 'staging' server, run example.php
* Production WordPress install should now be available (barely) in the staging web directory.

## SSH2 Notes

This article - http://kevin.vanzonneveld.net/techblog/article/make_ssh_connections_with_php/ - has a long list
of PHP/SSH related stuff. The part that worked for me, thankfully, since I'm on Ubuntu is:

---------
On recent Ubuntu machines, there's no need to do any compiling anymore:

* aptitude install libssh2-1-dev libssh2-php

You can now test if PHP recognizes it's new ssh2 extension by running:

* php -m |grep ssh2

It should return: 'ssh2'
--------
