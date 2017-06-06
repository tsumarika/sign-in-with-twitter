<?php

namespace App;

require_once __DIR__ . '/../src/bootstrap.php';

$auth = new Auth();
$auth->login();