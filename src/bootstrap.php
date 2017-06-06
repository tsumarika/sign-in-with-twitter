<?php

namespace App;

use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

session_start();

$dotenv = new Dotenv(__DIR__ . '/../');
$dotenv->load();