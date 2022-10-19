<?php
    require "includes/config.php";
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/fontello.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <title><?php echo $config['title'];?></title>
</head>
<body>
    
    <?php include "includes/header.php"?>

    <div id="content">
        <div class="container">
            <div class="row">
                <section class="content_left">
                    <div class="block">
                        <div class="row">
                            <h3 class="col-9 mb-3 mt-3">Новейшее в блоге</h3>
                            <a class="col-3 mb-3 mt-3" href="articles.php">Все записи</a>
                        </div>
                        
                        <div class="block_content">
                            <div class="articles_container">
                            <?php
                                $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `id` DESC LIMIT 5");
                            ?>

                            <?php
                            while($art = mysqli_fetch_assoc($articles)) {
                                ?>
                                <article class="article">
                                    <div class="article_image" style="background-image: url(/css/img/<?php echo $art['image']; ?>);"></div>
                                    <div class="article_info">

                                        <a class="title" href="article.php?id=<?php echo $art['id'];?>"><?php echo $art['title']; ?></a>
                                        <div class="meta">
                                            <?php
                                                $art_cat = false;
                                                foreach ($categories as $cat) {
                                                    if ($cat['id'] == $art['categorie_id']) {
                                                        $art_cat = $cat;
                                                        break;
                                                    }
                                                }
                                            ?>

                                            <small>Категория: <a href="/categories.php?categorie=<?php echo $cat['id'];?>"><?php echo $cat['title']; ?></a></small>
                                            
                                        </div>
                                        <div class="preview"><?php echo mb_substr(strip_tags($art['text']), 0, 100, 'utf-8') . ' ...'; ?></div>
                                    </div>
                                </article>
                                <?php
                            }
                            ?>
                            </div>
                        </div>
                    </div> 
                </section>
            
                <section class="content_right">
                    <div class="block">
                        <h3 class="mb-3 mt-3 text-center">Топ читаемых статей</h3>
                        <div class="block_content">
                            <div class="articles_container">

                            <?php
                                $articles = mysqli_query($connection, "SELECT * FROM `articles` ORDER BY `views` DESC LIMIT 5");
                            ?>

                            <?php
                            while($art = mysqli_fetch_assoc($articles)) {
                                ?>
                                <article class="article">
                                    <div class="article_image" style="background-image: url(/css/img/<?php echo $art['image']; ?>);"></div>
                                    <div class="article_info">
                                        <a class="title" href="article.php?id=<?php echo $art['id'];?>"><?php echo $art['title']; ?></a>
                                        <div class="meta">
                                            <?php
                                                $art_cat = false;
                                                foreach ($categories as $cat) {
                                                    if ($cat['id'] == $art['categorie_id']) {
                                                        $art_cat = $cat;
                                                        break;
                                                    }
                                                }
                                            ?>

                                            <small>Категория: <a href="/articles.php?categorie=<?php echo $art_cat['id'];?>"><?php echo $art_cat['title']; ?></a></small>
                                        </div>
                                        <div class="preview"><?php echo mb_substr(strip_tags($art['text']), 0, 100, 'utf-8') . ' ...'; ?></div>
                                    </div>
                                </article>
                                <?php
                            }
                            ?>
                            
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

        <?php include "includes/comments.php"?>
        <?php include "includes/footer.php"?>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>