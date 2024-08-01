<?php
include 'partials/header.php';

if (isset($_GET['submit']) && isset($_GET['search'])) {
    $search = filter_var($_GET['search'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $search_query = "SELECT posts.*, categories.title AS category_title, users.username, users.avatar AS author_avatar FROM posts JOIN categories ON posts.category_id = categories.id JOIN users ON posts.author_id = users.id WHERE posts.title LIKE '%$search%' ORDER BY posts.created_at DESC";
    $search_result = mysqli_query($connection, $search_query);

    $select_categories_query = "SELECT * FROM categories";
    $categories = mysqli_query($connection, $select_categories_query);
} else {
    header('location: ' . ROOT_URL . 'blog.php');
    die();
}
?>

<main>
    <section class="search__bar">
        <form class="container search__bar-container" action="<?= ROOT_URL ?>search.php" method="GET">
            <div>
                <i class="uil uil-search"></i>
                <input type="search" name="search" placeholder="Search" required value="<?= $search ?>" />
                <button type="submit" name="submit" class="btn">Go</button>
            </div>
        </form>
    </section>

    <section class="posts">
        <div class="container posts__container">
            <?php while ($post = mysqli_fetch_assoc($search_result)) : ?>
                <article class="post">
                    <div class="post__thumbnail">
                        <img src="<?= ROOT_URL ?>images/<?= $post['thumbnail'] ?>" alt="blog" />
                    </div>
                    <div class="post__info">
                        <a href="category-posts.php?id=<?= $post['category_id'] ?>" class="category__button">
                            <?= $post['category_title'] ?>
                        </a>
                        <h3 class="post__title">
                            <a href="post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                        </h3>
                        <p class="post__body">
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

            <?php if (mysqli_num_rows($search_result) == 0) : ?>
                <p class="empty__state">No results found</p>
            <?php endif ?>
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