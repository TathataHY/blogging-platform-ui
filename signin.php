<?php
$showHeader = false;
include 'partials/header.php';

$username_or_email = $_SESSION['signin_data']['username_or_email'] ?? null;
$password = $_SESSION['signin_data']['password'] ?? null;

unset($_SESSION['signin_data']);
?>

<main>
  <section class="form__section">
    <div class="container form__section-container">
      <h2>Sign In</h2>
      <?php if (isset($_SESSION['signup_success'])) : ?>
        <div class="alert__message success">
          <p><?= $_SESSION['signup_success'];
              unset($_SESSION['signup_success']);  ?></p>
        </div>
      <?php elseif (isset($_SESSION['signin_error'])) : ?>
        <div class="alert__message error">
          <p><?= $_SESSION['signin_error'];
              unset($_SESSION['signin_error']); ?></p>
        </div>
      <?php endif ?>
      <form action="<?= ROOT_URL ?>logic/signin-logic.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="username_or_email" placeholder="Username or Email" required autocomplete="username" inputmode="email" value="<?= $username_or_email ?>" />
        <input type="password" name="password" placeholder="Password" required autocomplete="new-password" value="<?= $password ?>" />
        <button type="submit" name="submit" class="btn">Sign In</button>
        <small>
          Don't have an account? <a href="<?= ROOT_URL ?>signup.php">Sign Up</a>
        </small>
      </form>
    </div>
  </section>
</main>

</body>

</html>