<?php

header('Content-Type: text/plain');
define('MYSQL_SERVER', 'db');
define('MYSQL_USER', 'root');
define('MYSQL_PASSWORD', 'damp-mysql-database-root-password');
define('MYSQL_DATABASE', 'mysql');

echo 'Server Information: '."\n";
$hostname = file_get_contents('/etc/hostname');
echo 'hostname: '.$hostname."\n";
echo 'SERVER_NAME: '.$_SERVER['SERVER_NAME']."\n";
echo 'SERVER_ADDR: '.$_SERVER['SERVER_ADDR']."\n";
echo 'SERVER_PORT: '.$_SERVER['SERVER_PORT']."\n";
echo 'REMOTE_ADDR: '.$_SERVER['REMOTE_ADDR']."\n";
echo 'HTTP_HOST: '.$_SERVER['HTTP_HOST']."\n";
echo 'REQUEST_URI: '.$_SERVER['REQUEST_URI']."\n";
echo "\n";
echo '---------------------------------------------------------------------'."\n";
echo 'Database Information: '."\n";
print_r('MYSQL_SERVER: '.MYSQL_SERVER."\n".'MYSQL_USER: '.MYSQL_USER."\n".'MYSQL_PASSWORD: '.MYSQL_PASSWORD."\n".'MYSQL_DATABASE: '.MYSQL_DATABASE."\n");
echo "\n";
echo '---------------------------------------------------------------------'."\n";

if (!MYSQL_SERVER || !MYSQL_USER || !MYSQL_PASSWORD || !MYSQL_DATABASE) {
    echo 'Not enough MySQL configure data. Stop connecting'."\n";
} else {
    $mysqli = new mysqli(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $mysqli->set_charset('utf8mb4');
    echo 'MySQL Connection: '."\n";
    if ($mysqli->connect_errno) {
        echo 'Failed to connect to MySQL: ('.$mysqli->connect_errno.') '.$mysqli->connect_error;
    } else {
        $tables = [];
        $query = 'SHOW tables';
        echo '$query: '.$query."\n";
        $result = $mysqli->query($query);
        $tables = $result->fetch_array(MYSQLI_NUM);
        print_r($tables);
        $result->free();
        echo "\n";

        if ($tables) {
            $selects = [];
            $query = 'SELECT * FROM ';

            foreach ($tables as $key => $table) {
                echo '$query: '.$query.$table."\n";
                $result = $mysqli->query($query.$table);
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $selects[] = $row;
                }
            }

            print_r($selects);
        } else {
            echo '$tables empty '."\n";
        }
    }
    echo "\n";
}
