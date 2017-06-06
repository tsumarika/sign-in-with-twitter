<?php

namespace App;

use Abraham\TwitterOAuth\TwitterOAuth;

class Auth
{
    // TwitterOAuth instance
    private $connection;

    /**
     * インスタンスの生成時に設定値を読み込み、セッション開始
     *
     * @param string $oauth_token
     * @param string $oauth_token_secret
     * @return void
     */
    public function __construct($oauth_token = null, $oauth_token_secret = null)
    {
        define('CONSUMER_KEY', getenv('CONSUMER_KEY'));
        define('CONSUMER_SECRET', getenv('CONSUMER_SECRET'));
        define('OAUTH_CALLBACK', getenv('OAUTH_CALLBACK'));

        $this->connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $oauth_token, $oauth_token_secret);
    }


    /**
     * トークンを取得し、セッションに格納
     *
     * @return void
     */
    private function setRequestToken()
    {
        // https://dev.twitter.com/oauth/reference/post/oauth/request_token
        $request_token = $this->connection->oauth('oauth/request_token', ['oauth_callback' => OAUTH_CALLBACK]);

        $_SESSION['oauth_token'] = $request_token['oauth_token'];
        $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
    }

    /**
     * アクセストークンを取得し、セッションに格納
     *
     * @param string $oauth_verifier
     * @return void
     */
    public function setAccessToken($oauth_verifier)
    {
        $_SESSION['access_token'] = $this->connection->oauth("oauth/access_token", ["oauth_verifier" => $oauth_verifier]);
    }

    /**
     * ユーザー情報を取得する
     *
     * @return stdClass
     */
    public function getUserInfo()
    {
        // https://dev.twitter.com/rest/reference/get/account/verify_credentials
        $user = $this->connection->get("account/verify_credentials");

        return $user;
    }

    /**
     * ログイン
     * Twitterの認証画面へリダイレクトする。
     *
     * @return void
     */
    public function login()
    {
        $this->setRequestToken();

        // Twitterの認証画面URLを取得
        // https://dev.twitter.com/oauth/reference/get/oauth/authenticate
        $url = $this->connection->url('oauth/authenticate', ['oauth_token' => $_SESSION['oauth_token']]);

        // Twitterの認証画面へリダイレクト
        header('location: '. $url);
    }
}
