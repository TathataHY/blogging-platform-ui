<?php
include 'partials/header.php';

$id = $_GET['id'];

if (!is_numeric($id)) {
  header('location: ' . ROOT_URL . 'admin');
  die();
}

$select_categories_query = "SELECT * FROM categories ORDER BY title";
$categories = mysqli_query($connection, $select_categories_query);

$select_post_query = "SELECT * FROM posts WHERE id = $id";
$select_post_result = mysqli_query($connection, $select_post_query);
$post = mysqli_fetch_assoc($select_post_result);

if (!$post) {
  header('location: ' . ROOT_URL . 'admin');
  die();
}
?>

<main>
  <section class="form__section">
    <div class="container form__section-container">
      <h2>Edit Post</h2>
      <?php if (isset($_SESSION['edit_post_error'])) : ?>
        <div class="alert__message error">
          <p><?= $_SESSION['edit_post_error'];
              unset($_SESSION['edit_post_error']); ?></p>
        </div>
      <?php endif ?>

      <form action="<?= ROOT_URL ?>admin/logic/edit-post-logic.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $post['id'] ?>" />
        <input type="hidden" name="previous_thumbnail" value="<?= $post['thumbnail'] ?>" />
        <input type="text" name="title" placeholder="Title" required value="<?= $post['title'] ?>" />
        <label for="category" class="visually-hidden">
          Choose a Category:
        </label>
        <select id="category" name="category" required>
          <option value="">Select Category</option>
          <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
            <option value="<?= $category['id'] ?>" <?= $post['category_id'] === $category['id'] ? 'selected' : '' ?>><?= $category['title'] ?></option>
          <?php endwhile ?>
        </select>
        <textarea name="body" rows="10" placeholder="Body" required><?= $post['body'] ?></textarea>
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) :  ?>
          <div class="form__control inline">
            <input type="checkbox" id="is_featured" name="is_featured" value="1" <?= $post['is_featured'] == 1 ? 'checked' : '' ?> />
            <label for="is_featured">Featured</label>
          </div>
        <?php endif ?>
        <div class="form__control">
          <label for="thumbnail">Thumbnail</label>
          <input type="file" id="thumbnail" name="thumbnail" accept=".png, .jpg, .jpeg" />
        </div>
        <button type="submit" name="submit" class="btn">Edit Post</button>
      </form>
    </div>
  </section>
</main>

<?php
include ROOT_PATH . 'partials/footer.php';
?>