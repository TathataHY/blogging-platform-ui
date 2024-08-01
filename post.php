<?php
include 'partials/header.php';

$id = $_GET['id'];

if (!is_numeric($id)) {
  header('location: ' . ROOT_URL);
  die();
}

$select_post_query = "SELECT posts.*, categories.title AS category_title, users.username, users.avatar AS author_avatar FROM posts JOIN categories ON posts.category_id = categories.id JOIN users ON posts.author_id = users.id WHERE posts.id = $id";
$select_post_result = mysqli_query($connection, $select_post_query);
$post = mysqli_fetch_assoc($select_post_result);
?>

<main>
  <section class="single-post">
    <div class="container single-post__container">
      <h2><?= $post['title'] ?></h2>

      <div class="post__author">
        <div class="post__author-avatar">
          <img src="<?= ROOT_URL ?>images/<?= $post['author_avatar'] ?>" alt="author image" />
        </div>
        <div class="post__author-info">
          <h5>By: <?= $post['username'] ?></h5>
          <small><?= date('F j, Y - H:i', strtotime($post['created_at'])) ?></small>
        </div>
      </div>
      <div class="single-post__thumbnail">
        <img src="<?= ROOT_URL ?>images/<?= $post['thumbnail'] ?>" alt="post image" />
      </div>
      <p>
        <?= $post['body'] ?>
      </p>
    </div>
  </section>
</main>

<?php
include 'partials/footer.php';
?>