<?php
include 'partials/header.php';

$select_categories_query = "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($connection, $select_categories_query);
?>

<main>
  <section class="dashboard">
    <?php if (isset($_SESSION['add_category_success'])) : ?>
      <div class="alert__message success">
        <p><?= $_SESSION['add_category_success'];
            unset($_SESSION['add_category_success']);  ?></p>
      </div>
    <?php elseif (isset($_SESSION['edit_category_success'])) : ?>
      <div class="alert__message success">
        <p><?= $_SESSION['edit_category_success'];
            unset($_SESSION['edit_category_success']);  ?></p>
      </div>
    <?php elseif (isset($_SESSION['delete_category_success'])) : ?>
      <div class="alert__message success">
        <p><?= $_SESSION['delete_category_success'];
            unset($_SESSION['delete_category_success']);  ?></p>
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
              <a href="<?= ROOT_URL ?>admin/manage-users.php">
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
              <a href="<?= ROOT_URL ?>admin/manage-categories.php" class="active">
                <i class="uil uil-list-ul"></i>
                <h5>Manage Categories</h5>
              </a>
            </li>
          <?php endif ?>
        </ul>
      </aside>
      <main>
        <h2>Manage Categories</h2>
        <table>
          <thead>
            <tr>
              <th>Title</th>
              <th>Edit</th>
              <th>Delete</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
              <tr>
                <td><?= $category['title'] ?></td>
                <td>
                  <a href="<?= ROOT_URL ?>admin/edit-category.php?id=<?= $category['id'] ?>" class="btn sm">
                    <i class="uil uil-edit"></i> Edit
                  </a>
                </td>
                <td>
                  <a href="<?= ROOT_URL ?>admin/delete-category.php?id=<?= $category['id'] ?>" class="btn sm danger">
                    <i class="uil uil-trash"></i> Delete
                  </a>
                </td>
              </tr>
            <?php endwhile ?>
            <?php if (mysqli_num_rows($categories) == 0) : ?>
              <tr>
                <td colspan="3">No categories found</td>
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