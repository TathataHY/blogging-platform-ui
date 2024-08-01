<?php
include 'partials/header.php';

$select_featured_query = "SELECT posts.*, categories.title AS category_title, users.username, users.avatar AS author_avatar FROM posts JOIN categories ON posts.category_id = categories.id JOIN users ON posts.author_id = users.id WHERE is_featured = 1";
$featured_result = mysqli_query($connection, $select_featured_query);
$featured_post = mysqli_fetch_assoc($featured_result);

$select_posts_query = "SELECT posts.*, categories.title AS category_title, users.username, users.avatar AS author_avatar FROM posts JOIN categories ON posts.category_id = categories.id JOIN users ON posts.author_id = users.id WHERE is_featured = 0 ORDER BY posts.created_at DESC LIMIT 9";
$posts = mysqli_query($connection, $select_posts_query);

$select_categories_query = "SELECT * FROM categories";
$categories = mysqli_query($connection, $select_categories_query);
?>

<main>
  <?php if ($featured_post) : ?>
    <section class="featured">
      <div class="container featured__container post">
        <div class="post__thumbnail">
          <img src="<?= ROOT_URL ?>images/<?= $featured_post['thumbnail'] ?>" alt="blog" />
        </div>
        <div class="post__info">
          <a href="category-posts.php?id=<?= $featured_post['category_id'] ?>" class="category__button"><?= $featured_post['category_title'] ?></a>
          <h2 class="post__title">
            <a href="post.php?id=<?= $featured_post['id'] ?>""><?= $featured_post['title'] ?></a>
          </h2>
          <p class=" post__body"><?= $featured_post['body'] ?></p>
              <div class="post__author">
                <div class="post__author-avatar">
                  <img src="<?= ROOT_URL ?>images/<?= $featured_post['author_avatar'] ?>" alt="author" />
                </div>
                <div class="post__author-info">
                  <h5>By: <?= $featured_post['username'] ?></h5>
                  <small><?= date('F j, Y - H:i', strtotime($featured_post['created_at'])) ?></small>
                </div>
              </div>
        </div>
      </div>
    </section>
  <?php endif ?>

  <section class="posts <?= $featured_post ? 'section__extra-margin' : '' ?>">
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