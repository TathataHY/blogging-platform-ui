<?php
include 'partials/header.php';

$select_categories_query = "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($connection, $select_categories_query);

$title = $_SESSION['add_post_data']['title'] ?? null;
$body = $_SESSION['add_post_data']['body'] ?? null;
$category_id = $_SESSION['add_post_data']['category'] ?? null;
$is_featured = $_SESSION['add_post_data']['is_featured'] ?? null;

unset($_SESSION['add_post_data']);
?>

<main>
  <section class="form__section">
    <div class="container form__section-container">
      <h2>Add Post</h2>
      <?php if (isset($_SESSION['add_post_error'])) : ?>
        <div class="alert__message error">
          <p><?= $_SESSION['add_post_error'];
              unset($_SESSION['add_post_error']); ?></p>
        </div>
      <?php endif ?>

      <form action="<?= ROOT_URL ?>admin/logic/add-post-logic.php" method="POST" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Title" required value="<?= $title ?>" />
        <label for="category" class="visually-hidden">
          Choose a Category:
        </label>
        <select id="category" name="category" required>
          <option value="">Select Category</option>
          <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
            <option value="<?= $category['id'] ?>" <?= $category_id === $category['id'] ? 'selected' : '' ?>><?= $category['title'] ?></option>
          <?php endwhile ?>
        </select>
        <textarea name="body" rows="10" placeholder="Body" required><?= $body ?></textarea>
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) : ?>
          <div class="form__control inline">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" checked />
            <label for="is_featured">Featured</label>
          </div>
        <?php endif ?>
        <div class="form__control">
          <label for="thumbnail">Thumbnail</label>
          <input type="file" id="thumbnail" name="thumbnail" accept=".png, .jpg, .jpeg" required />
        </div>
        <button type="submit" name="submit" class="btn">Add Post</button>
      </form>
    </div>
  </section>
</main>

<?php
include ROOT_PATH . 'partials/footer.php';
?>