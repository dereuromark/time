# Timetracking Tool
A simplistic tool to track your or your employees' working hours.

## Install
First of all you need the configuration set up:
`config/app_custom.php` needs to be changed by overwriting it via `config/app_private.php`.
Make sure you also enter valid DB credentials and that your table is accessable.

Then run the [Migration plugin](https://github.com/cakephp/migrations):
```
cake migrations migrate
```

Furthermore:
* chmod -R 777 `app/tmp` and `app/logs`
* create a HTTP auth user and change `.htaccess` to allow him access
* create the same user in the database
