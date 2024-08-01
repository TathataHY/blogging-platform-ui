<?php
include 'partials/header.php';

$id = $_GET['id'];

if (!is_numeric($id)) {
  header('location: ' . ROOT_URL);
  die();
}

$select_category_query = "SELECT * FROM categories WHERE id = $id";
$select_category_result = mysqli_query($connection, $select_category_query);
$category = mysqli_fetch_assoc($select_category_result);

$select_posts_query = "SELECT posts.*, categories.title AS category_title, users.username, users.avatar AS author_avatar FROM posts JOIN categories ON posts.category_id = categories.id JOIN users ON posts.author_id = users.id WHERE posts.category_id = $id ORDER BY posts.created_at DESC";
$posts = mysqli_query($connection, $select_posts_query);

$select_categories_query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $select_categories_query);
?>

<main>
  <section class="category__title">
    <h2><?= $category['title'] ?></h2>
  </section>

  <section class="posts">
    <div class="container posts__container">
      <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
        <article class="post">
          <div class="post__thumbnail">
            <img src="<?= ROOT_URL ?>images/<?= $post['thumbnail'] ?>" alt="blog" />
          </div>
          <div class="post__info">
            <a href="category-posts.php?id=<?= $post['category_id'] ?>" class="category__button">
              <?= $post['category_title'] ?>
            </a>
            <h3 class="post__title">
              <a href="post.php?id=<?= $post['id'] ?>""><?= $post['title'] ?></a>
            </h3>
            <p class=" post__body">
                <?= substr($post['body'], 0, 150) ?>
                </p>
                <div class="post__author">
                  <div class="post__author-avatar">
                    <img src="<?= ROOT_URL ?>images/<?= $post['author_avatar'] ?>" alt="author" />
                  </div>
                  <div class="post__author-info">
                    <h5>By: <?= $post['username'] ?></h5>
                    <small><?= date('F j, Y - H:i', strtotime($post['created_at'])) ?></small>
                  </div>
                </div>
          </div>
        </article>
      <?php endwhile ?>
    </div>
  </section>

  <section class="category__buttons">
    <div class="container category__buttons-container">
      <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
        <a href="category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
      <?php endwhile ?>
    </div>
  </section>
</main>

<?php
include 'partials/footer.php';
?>