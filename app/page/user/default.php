<?php

include '../database/class/user.php';
include '../database/koneksi.php';

$page = isset($_GET["act"]) ? $_GET["act"] : '';
switch ($page) {

    default:
        include('index.php');
        break;
}
