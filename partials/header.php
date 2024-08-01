<?php
require 'config/database.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PHP & MySQL Blog Application with Admin Panel</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css" />
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" />
</head>

<body>
    <?php
    if (!isset($showHeader)) {
        $showHeader = true;
    }

    if ($showHeader) {
    ?>
        <header>
            <nav>
                <div class="container nav__container">
                    <a href="<?= ROOT_URL ?>" class="nav__logo">TATHATA</a>
                    <ul class="nav__items">
                        <li><a href="<?= ROOT_URL ?>blog.php">Blog</a></li>
                        <li><a href="<?= ROOT_URL ?>about.php">About</a></li>
                        <li><a href="<?= ROOT_URL ?>services.php">Services</a></li>
                        <li><a href="<?= ROOT_URL ?>contact.php">Contact</a></li>
                        <?php if (!isset($_SESSION['user_id'])) : ?>
                            <li><a href="<?= ROOT_URL ?>signin.php">Sign In</a></li>
                        <?php else : ?>
                            <li class="nav__profile">
                                <div class="avatar">
                                    <img src="<?= ROOT_URL ?>images/<?= $_SESSION['avatar'] ?>" alt="avatar" />
                                </div>
                                <ul>
                                    <li><a href="<?= ROOT_URL ?>admin">Dashboard</a></li>
                                    <li><a href="<?= ROOT_URL ?>logout.php">Logout</a></li>
                                </ul>
                            </li>
                        <?php endif ?>
                    </ul>

                    <button id="open__nav-btn">
                        <span class="visually-hidden">Open Navigation</span>
                        <i class="uil uil-bars"></i>
                    </button>
                    <button id="close__nav-btn">
                        <span class="visually-hidden">Close Navigation</span>
                        <i class="uil uil-multiply"></i>
                    </button>
                </div>
            </nav>
        </header>
    <?php
    }
    ?>