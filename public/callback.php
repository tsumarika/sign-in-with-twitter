<?php

namespace App;

require_once __DIR__ . '/../src/bootstrap.php';

$request_token['oauth_token'] = $_SESSION['oauth_token'];
$request_token['oauth_token_secret'] = $_SESSION['oauth_token_secret'];

if (isset($_REQUEST['oauth_token']) && $request_token['oauth_token'] !== $_REQUEST['oauth_token']) {
    die( 'Error!' );
}

$auth = new Auth($request_token['oauth_token'], $request_token['oauth_token_secret']);
$auth->setAccessToken($_REQUEST['oauth_verifier']);

// セッションIDをリジェネレート
session_regenerate_id();

// indexへリダイレクト
header('location: '.getenv('APP_URL'));