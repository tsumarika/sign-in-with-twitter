<?php

namespace App;

require_once __DIR__ . '/../src/bootstrap.php';

if (isset($_SESSION['access_token'])) {
    $access_token = $_SESSION['access_token'];
    $auth = new Auth($access_token['oauth_token'], $access_token['oauth_token_secret']);
    $user = $auth->getUserInfo();
} else {
    $auth = new Auth();
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Twitter認証の練習</title>
</head>
<body>
<?php
if (isset($user)) {
    // ユーザー情報を取得し、表示する ==========================================
?>
<table>
    <tr>
        <th>profile_image</th>
        <td><img src="<?= htmlspecialchars($user->profile_image_url_https) ?>"></td>
    </tr>
    <tr>
        <th>name</th>
        <td><?= htmlspecialchars($user->name) ?></td>
    </tr>
    <tr>
        <th>screen_name</th>
        <td><?= htmlspecialchars($user->screen_name) ?></td>
    </tr>
    <tr>
        <th>description</th>
        <td><?= htmlspecialchars($user->description) ?></td>
    </tr>
</table>
<a href="./logout.php">ログアウト</a>
<?php

} else {
    // ログインボタンを表示する ==========================================
?>
<a href="./login.php">Twitterでログインする</a>
<?php

}
?>
</body>
</html>