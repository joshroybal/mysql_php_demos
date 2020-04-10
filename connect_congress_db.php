<?php
$dbc = mysqli_connect('localhost', 'db_user', 'db_user_password', 'db_name')
OR die( mysqli_connect_error() );
mysqli_set_charset($dbc, 'utf-8');
