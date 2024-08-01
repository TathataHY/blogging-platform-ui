<?php
include 'partials/header.php';

$select_users_query = "SELECT * FROM users WHERE NOT id = $_SESSION[user_id] ORDER BY firstname";
$users = mysqli_query($connection, $select_users_query);
?>

<main>
  <section class="dashboard">
    <?php if (isset($_SESSION['add_user_success'])) : ?>
      <div class="alert__message success">
        <p><?= $_SESSION['add_user_success'];
            unset($_SESSION['add_user_success']);  ?></p>
      </div>
    <?php elseif (isset($_SESSION['edit_user_success'])) : ?>
      <div class="alert__message success">
        <p><?= $_SESSION['edit_user_success'];
            unset($_SESSION['edit_user_success']);  ?></p>
      </div>
    <?php elseif (isset($_SESSION['delete_user_success'])) : ?>
      <div class="alert__message success">
        <p><?= $_SESSION['delete_user_success'];
            unset($_SESSION['delete_user_success']);  ?></p>
      </div>
    <?php endif ?>

    <div class="container dashboard__container">
      <button class="sidebar__toggle" id="show__sidebar-btn">
        <span class="visually-hidden">Open Sidebar</span>
        <i class="uil uil-angle-right-b"></i>
      </button>
      <button class="sidebar__toggle" id="hide__sidebar-btn">
        <span class="visually-hidden">Close Sidebar</span>
        <i class="uil uil-angle-left-b"></i>
      </button>

      <aside>
        <ul>
          <li>
            <a href="<?= ROOT_URL ?>admin/add-post.php">
              <i class="uil uil-pen"></i>
              <h5>Add Post</h5>
            </a>
          </li>
          <li>
            <a href="<?= ROOT_URL ?>admin">
              <i class="uil uil-postcard"></i>
              <h5>Manage Posts</h5>
            </a>
          </li>
          <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) :  ?>
            <li>
              <a href="<?= ROOT_URL ?>admin/add-user.php">
                <i class="uil uil-user-plus"></i>
                <h5>Add User</h5>
              </a>
            </li>
            <li>
              <a href="<?= ROOT_URL ?>admin/manage-users.php" class="active">
                <i class="uil uil-users-alt"></i>
                <h5>Manage Users</h5>
              </a>
            </li>
            <li>
              <a href="<?= ROOT_URL ?>admin/add-category.php">
                <i class="uil uil-edit"></i>
                <h5>Add Category</h5>
              </a>
            </li>
            <li>
              <a href="<?= ROOT_URL ?>admin/manage-categories.php">
                <i class="uil uil-list-ul"></i>
                <h5>Manage Categories</h5>
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </aside>
      <main>
        <h2>Manage Users</h2>
        <table>
          <thead>
            <tr>
              <th>Name</th>
              <th>Username</th>
              <th>Edit</th>
              <th>Delete</th>
              <th>Admin</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($user = mysqli_fetch_assoc($users)) : ?>
              <tr>
                <td><?= $user['firstname'] . ' ' . $user['lastname'] ?></td>
                <td><?= $user['username'] ?></td>
                <td>
                  <a href="<?= ROOT_URL ?>admin/edit-user.php?id=<?= $user['id'] ?>" class="btn sm">
                    <i class="uil uil-edit"></i> Edit
                  </a>
                </td>
                <td>
                  <a href="<?= ROOT_URL ?>admin/delete-user.php?id=<?= $user['id'] ?>" class="btn sm danger">
                    <i class="uil uil-trash"></i> Delete
                  </a>
                </td>
                <td><?= $user['is_admin'] == 1 ? 'Yes' : 'No' ?></td>
              </tr>
            <?php endwhile ?>
            <?php if (mysqli_num_rows($users) == 0) : ?>
              <tr>
                <td colspan="5">No users found</td>
              </tr>
            <?php endif ?>
          </tbody>
        </table>
      </main>
    </div>
  </section>
</main>

<?php
include ROOT_PATH . 'partials/footer.php';
?>