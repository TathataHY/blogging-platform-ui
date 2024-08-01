<?php
include 'partials/header.php';

$firstname = $_SESSION['add_user_data']['firstname'] ?? null;
$lastname = $_SESSION['add_user_data']['lastname'] ?? null;
$username = $_SESSION['add_user_data']['username'] ?? null;
$email = $_SESSION['add_user_data']['email'] ?? null;
$password = $_SESSION['add_user_data']['password'] ?? null;
$confirm_password = $_SESSION['add_user_data']['confirm_password'] ?? null;
$role = $_SESSION['add_user_data']['role'] ?? null;

unset($_SESSION['add_user_data']);
?>

<main>
  <section class="form__section">
    <div class="container form__section-container">
      <h2>Add User</h2>
      <?php if (isset($_SESSION['add_user_error'])) : ?>
        <div class="alert__message error">
          <p><?= $_SESSION['add_user_error'];
              unset($_SESSION['add_user_error']); ?></p>
        </div>
      <?php endif ?>
      
      <form action="<?= ROOT_URL ?>admin/logic/add-user-logic.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="firstname" placeholder="First Name" required value="<?= $firstname ?>" />
        <input type="text" name="lastname" placeholder="Last Name" required value="<?= $lastname ?>" />
        <input type="text" name="username" placeholder="Username" required autocomplete="username" value="<?= $username ?>" />
        <input type="email" name="email" placeholder="Email" required autocomplete="email" value="<?= $email ?>" />
        <input type="password" name="password" placeholder="Password" required autocomplete="new-password" value="<?= $password ?>" />
        <input type="password" name="confirm_password" placeholder="Confirm Password" required autocomplete="current-password" value="<?= $confirm_password ?>" />
        <label for="role" class="visually-hidden"> Choose a Role: </label>
        <select id="role" name="role" required>
          <option value="" <?= $role === '' ? 'selected' : '' ?>>Select Role</option>
          <option value="0" <?= $role === '0' ? 'selected' : '' ?>>Author</option>
          <option value="1" <?= $role === '1' ? 'selected' : '' ?>>Admin</option>
        </select>
        <div class="form__control">
          <label for="avatar">Avatar</label>
          <input type="file" id="avatar" name="avatar" accept=".png, .jpg, .jpeg" required autocomplete="photo" />
        </div>
        <button type="submit" name="submit" class="btn">Add User</button>
      </form>
    </div>
  </section>
</main>

<?php
include ROOT_PATH . 'partials/footer.php';
?>