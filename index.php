<?php

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/' :
        require __DIR__ . '/albums/photo.php';
        break;
    case '' :
        require __DIR__ . '/albums/photo.php';
        break;
}