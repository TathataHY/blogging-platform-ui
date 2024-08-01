<?php
include 'partials/header.php';

$id = $_GET['id'];

if (!is_numeric($id)) {
  header('location: ' . ROOT_URL . 'admin/manage-users.php');
  die();
}

$select_user_query = "SELECT * FROM users WHERE id = $id";
$select_user_result = mysqli_query($connection, $select_user_query);
$user = mysqli_fetch_assoc($select_user_result);

if (!$user) {
  header('location: ' . ROOT_URL . 'admin/manage-users.php');
  die();
}
?>

<main>
  <section class="form__section">
    <div class="container form__section-container">
      <h2>Edit User</h2>
      <?php if (isset($_SESSION['edit_user_error'])) : ?>
        <div class="alert__message error">
          <p><?= $_SESSION['edit_user_error'];
              unset($_SESSION['edit_user_error']); ?></p>
        </div>
      <?php endif ?>

      <form action="<?= ROOT_URL ?>admin/logic/edit-user-logic.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $user['id'] ?>" />
        <input type="text" name="firstname" placeholder="First Name" required value="<?= $user['firstname'] ?>" />
        <input type="text" name="lastname" placeholder="Last Name" required value="<?= $user['lastname'] ?>" />
        <label for="role" class="visually-hidden"> Choose a Role: </label>
        <select id="role" name="role" required>
          <option value="" <?= $user['is_admin'] === '' ? 'selected' : '' ?>>Select Role</option>
          <option value="0" <?= $user['is_admin'] === '0' ? 'selected' : '' ?>>Author</option>
          <option value="1" <?= $user['is_admin'] === '1' ? 'selected' : '' ?>>Admin</option>
        </select>
        <button type="submit" name="submit" class="btn">Edit User</button>
      </form>
    </div>
  </section>
</main>

<?php
include ROOT_PATH . 'partials/footer.php';
?>