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
                <section class="content_full">
                    <div class="block">
                        <h3 class="text-center mb-5 mt-3">Все статьи</h3>
                        <div class="block_content">
                            <div class="articles_container">
                            <?php
                                $per_page = 4;
                                $page = 1;
                                $categorie_id = $_GET['categorie'];
                                if (isset($_GET['page'])) {
                                    $page = (int) $_GET['page'];
                                }

                                $total_count_q = mysqli_query($connection, "SELECT COUNT(`id`) AS `total_count` FROM `articles` WHERE `categorie_id` = " . (int) $categorie_id);
                                $total_count = mysqli_fetch_assoc($total_count_q);
                                $total_count = $total_count['total_count'];

                                $total_pages = ceil($total_count / $per_page);
                                if ($page <= 1 || $page > $total_pages) {
                                    $page = 1;
                                }


                                $offset = ($per_page * $page) - $per_page;
                               
                                $sql = "SELECT * FROM `articles` WHERE `categorie_id` = " . (int) $categorie_id . " ORDER BY `id` DESC LIMIT $offset, $per_page";

                                $articles = mysqli_query($connection, $sql);

                                
                                $articles_exit = true;
                                if (mysqli_num_rows($articles) <= 0) {
                                    echo 'Статьи не найдены!';
                                    $articles_exit = false;
                                }

                                while($art = mysqli_fetch_assoc($articles)) {
                            ?>

                                <article class="articles">
                                    <div class="articles_image" style="background-image: url(/css/img/<?php echo $art['image']; ?>);"></div>
                                    <div class="articles_info">
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

                            <?php

                                
                                    if ($articles_exit == true) {
                                    echo '<div class="paginator">';
                                    
                                        if ($page > 1) {
                                            echo '<a style="padding: 10px;" href="/categories.php?page='.($page - 1) . '&categorie=' . $categorie_id . '">&laquo; Назад  </a>';
                                        }
                                        if ($page < $total_pages) {
                                            echo '<a style="padding: 10px;" href="/categories.php?page='.($page + 1) . '&categorie=' . $categorie_id . '">Вперёд &raquo;</a>';
                                        }
                                        echo '</div>';
                                    }
                                
                                
                            ?>

                        </div>
                    </div> 
                </section>
            
            </div>
        </div>
    </div>

        <?php include "includes/footer.php"?>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>