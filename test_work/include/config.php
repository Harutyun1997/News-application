<?php

#configuration file

$link = mysqli_connect('localhost', 'root', '', 'news_db');
$base_url = 'http://localhost/test_work/public_html/';

if (mysqli_connect_errno()) {
    echo 'Error connecting database (' . mysqli_connect_errno() . ') : ' . mysqli_connect_error();
    exit();
}
