<?php

    session_start();  // ①

    //ログイン済みかを確認

    //ログイン機能
    $message = '';
    if(isset($_POST['login'])){  // ②
        if ($_POST['email'] == 'login@example.com' && $_POST['password'] == 'password'){ // ③
            // ④
            $_SESSION["USER"] = 'user';
            header("Location: top.php");
            exit;
        }
        else{
            // ⑤
            $message = 'メールアドレスかパスワードが間違っています。';
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>ログイン機能</title>
  <link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>

  <body>
    <div class="main_container">
      <h1>ログイン機能</h1>
      <p style="color: red"><?php echo $message ?></p>  <!-- ⑥ -->
      <form method="post" action="login.php">
          <label for="email">メールアドレス</label>
          <input id="email" type="email" name="email">
          <br>
          <label for="password">パスワード</label>
          <input id="password" type="password" name="password">
          <br>
          <input type="submit" name="login" value="ログイン">
      </form>
    </div>
  </body>
</html>