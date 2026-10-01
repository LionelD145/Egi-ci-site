<?php
require 'config.php';

if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Identifiant ou mot de passe incorrect.';
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Connexion — Administration EGI-CI</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    background: #1a1f27;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
  }
  .login-box {
    background: #fff;
    border-radius: 10px;
    padding: 40px;
    width: 100%;
    max-width: 380px;
    box-shadow: 0 10px 40px rgba(0,0,0,.25);
  }
  h1 {
    font-size: 1.3rem;
    margin-bottom: 6px;
    color: #1a1f27;
  }
  p.sub {
    color: #66717D;
    font-size: .85rem;
    margin-bottom: 28px;
  }
  label {
    display: block;
    font-size: .8rem;
    font-weight: 700;
    color: #1a1f27;
    margin-bottom: 6px;
  }
  input {
    width: 100%;
    padding: 11px 12px;
    border: 1px solid #e2e5e9;
    border-radius: 6px;
    font-size: .9rem;
    margin-bottom: 18px;
  }
  input:focus {
    outline: none;
    border-color: #e8622c;
  }
  button {
    width: 100%;
    padding: 12px;
    background: #e8622c;
    color: #fff;
    border: none;
    border-radius: 6px;
    font-weight: 700;
    font-size: .85rem;
    letter-spacing: .03em;
    cursor: pointer;
    transition: .2s;
  }
  button:hover { background: #d1541f; }
  .error {
    background: #fdecea;
    color: #c0392b;
    padding: 10px 12px;
    border-radius: 6px;
    font-size: .82rem;
    margin-bottom: 18px;
  }
</style>
</head>
<body>
  <div class="login-box">
    <h1>Administration EGI-CI</h1>
    <p class="sub">Connectez-vous pour gérer les photos du site.</p>

    <?php if ($error): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
      <label for="username">Identifiant</label>
      <input type="text" id="username" name="username" required autofocus>

      <label for="password">Mot de passe</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">SE CONNECTER</button>
    </form>
  </div>
</body>
</html>
