# Timetracking Tool
A simplistic tool to track your or your employees' working hours.

## Install
First of all we need the database tables.
Run the [Migration plugin](https://github.com/cakephp/migrations):
```
cake migrations migrate
```

Furthermore:
* `config/app_custom.php` needs to be changed by overwriting it via `config/app_private.php`
* chmod -R 777 `app/tmp` and `app/logs`
* create a HTTP auth user and change `.htaccess` to allow him access
* create the same user in the database
