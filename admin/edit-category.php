<?php
include 'partials/header.php';

$id = $_GET['id'];

if (!is_numeric($id)) {
  header('location: ' . ROOT_URL . 'admin/manage-categories.php');
  die();
}

$select_category_query = "SELECT * FROM categories WHERE id = $id";
$select_category_result = mysqli_query($connection, $select_category_query);
$category = mysqli_fetch_assoc($select_category_result);

if (!$category) {
  header('location: ' . ROOT_URL . 'admin/manage-categories.php');
  die();
}
?>

<main>
  <section class="form__section">
    <div class="container form__section-container">
      <h2>Edit Category</h2>
      <?php if (isset($_SESSION['edit_category_error'])) : ?>
        <div class="alert__message error">
          <p><?= $_SESSION['edit_category_error'];
              unset($_SESSION['edit_category_error']); ?></p>
        </div>
      <?php endif ?>

      <form action="<?= ROOT_URL ?>admin/logic/edit-category-logic.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $category['id'] ?>" />
        <input type="text" name="title" placeholder="Title" required value="<?= $category['title'] ?>" />
        <textarea name="description" rows="4" placeholder="Description" required><?= htmlspecialchars($category['description']) ?></textarea>
        <button type="submit" name="submit" class="btn">Edit Category</button>
      </form>
    </div>
  </section>
</main>

<?php
include ROOT_PATH . 'partials/footer.php';
?>