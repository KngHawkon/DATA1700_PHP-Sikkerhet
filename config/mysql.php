<?php

function connect_db() {
    $connection = new mysqli('INSERT_HOST','INSERT_USERNAME','INSERT_PASSWORD','INSERT_DB_NAME');
    if ($connection->connect_errno) {
        printf("Connect failed: %s\n", $connection->connect_error);
        exit();
    }
    return $connection;
}
