<?php
include 'partials/header.php';

$title = $_SESSION['add_category_data']['title'] ?? null;
$description = $_SESSION['add_category_data']['description'] ?? null;

unset($_SESSION['add_category_data']);
?>

<main>
  <section class="form__section">
    <div class="container form__section-container">
      <h2>Add Category</h2>
      <?php if (isset($_SESSION['add_category_error'])) : ?>
        <div class="alert__message error">
          <p><?= $_SESSION['add_category_error'];
              unset($_SESSION['add_category_error']); ?></p>
        </div>
      <?php endif ?>

      <form action="<?= ROOT_URL ?>admin/logic/add-category-logic.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required value="<?= $title ?>" />
        <textarea name="description" rows="4" placeholder="Description" required><?= htmlspecialchars($description) ?></textarea>
        <button type="submit" name="submit" class="btn">Add Category</button>
      </form>
    </div>
  </section>
</main>

<?php
include ROOT_PATH . 'partials/footer.php';
?>