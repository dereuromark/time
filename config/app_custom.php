<?php
$debug = env('REMOTE_ADDR') === '127.0.0.1';

return [
/**
 * Debug Level:
 *
 * Production Mode:
 * false: No error messages, errors, or warnings shown.
 *
 * Development Mode:
 * true: Errors and warnings shown.
 */
    'debug' => $debug,

/**
 * Security and encryption configuration
 *
 * - salt - A random string used in security hashing methods.
 *   The salt value is also used as the encryption key.
 *   You should treat it as extremely sensitive data.
 */
    'Security' => [
        'salt' => '',
    ],

/**
 * Connection information used by the ORM to connect
 * to your application's datastores.
 * Drivers include Mysql Postgres Sqlite Sqlserver
 * See vendor\cakephp\cakephp\src\Database\Driver for complete list
 */
    'Datasources' => [
        'default' => [
            'host' => 'localhost',
            /*
            * CakePHP will use the default DB port based on the driver selected
            * MySQL on MAMP uses port 8889, MAMP users will want to uncomment
            * the following line and set the port accordingly
            */
            //'port' => 'nonstandard_port_number',
            'username' => 'root',
            'password' => '',
            'database' => 'cake_time',
            'timezone' => 'UTC',

            /*
            * Set identifier quoting to true if you are using reserved words or
            * special characters in your table or column names. Enabling this
            * setting will result in queries built using the Query Builder having
            * identifiers quoted when creating SQL. It should be noted that this
            * decreases performance because each query needs to be traversed and
            * manipulated before being executed.
            */
            'quoteIdentifiers' => true,

            /*
            * During development, if using MySQL < 5.6, uncommenting the
            * following line could boost the speed at which schema metadata is
            * fetched from the database. It can also be set directly with the
            * mysql configuration directive 'innodb_stats_on_metadata = 0'
            * which is the recommended value in production environments
            */
            //'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
        ],

        /**
         * The test connection is used during the test suite.
         */
        'test' => [
            'host' => 'localhost',
            //'port' => 'nonstandard_port_number',
            'username' => 'root',
            'password' => '',
            'database' => 'test_myapp',
            'timezone' => 'UTC',
            'quoteIdentifiers' => true,
            //'init' => ['SET GLOBAL innodb_stats_on_metadata = 0'],
        ],
    ],

/**
 * Configures logging options
 */
    'Log' => [
        'debug' => [
            'scopes' => false,
        ],
        'error' => [
            'scopes' => false,
        ],
    ],

];
