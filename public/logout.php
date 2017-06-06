<?php

namespace App;

require_once __DIR__ . '/../src/bootstrap.php';

session_destroy();

// indexへリダイレクト
header('location: http://localhost/sign-in-with-twitter/public/index.php');