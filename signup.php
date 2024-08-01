<?php
$showHeader = false;
include 'partials/header.php';

$firstname = $_SESSION['signup_data']['firstname'] ?? null;
$lastname = $_SESSION['signup_data']['lastname'] ?? null;
$username = $_SESSION['signup_data']['username'] ?? null;
$email = $_SESSION['signup_data']['email'] ?? null;
$password = $_SESSION['signup_data']['password'] ?? null;
$confirm_password = $_SESSION['signup_data']['confirm_password'] ?? null;

unset($_SESSION['signup_data']);
?>

<main>
  <section class="form__section">
    <div class="container form__section-container">
      <h2>Sign Up</h2>
      <?php if (isset($_SESSION['signup_success'])) : ?>
        <div class="alert__message success">
          <p><?= $_SESSION['signup_success'];
              unset($_SESSION['signup_success']);  ?></p>
        </div>
      <?php elseif (isset($_SESSION['signup_error'])) : ?>
        <div class="alert__message error">
          <p><?= $_SESSION['signup_error'];
              unset($_SESSION['signup_error']); ?></p>
        </div>
      <?php endif ?>
      <form action="<?= ROOT_URL ?>logic/signup-logic.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="firstname" placeholder="First Name" required autocomplete="name" value="<?= $firstname ?>" />
        <input type="text" name="lastname" placeholder="Last Name" required autocomplete="family-name" value="<?= $lastname ?>" />
        <input type="text" name="username" placeholder="Username" required autocomplete="username" value="<?= $username ?>" />
        <input type="email" name="email" placeholder="Email" required autocomplete="email" value="<?= $email ?>" />
        <input type="password" name="password" placeholder="Password" required autocomplete="new-password" value="<?= $password ?>" />
        <input type="password" name="confirm_password" placeholder="Confirm Password" required autocomplete="current-password" value="<?= $confirm_password ?>" />
        <div class="form__control">
          <label for="avatar">Avatar</label>
          <input type="file" name="avatar" id="avatar" required accept=".png, .jpg, .jpeg" autocomplete="photo" />
        </div>
        <button type="submit" name="submit" class="btn">Sign Up</button>
        <small>
          Already have an account? <a href="<?= ROOT_URL ?>signin.php">Sign In</a>
        </small>
      </form>
    </div>
  </section>
</main>

</body>

</html>