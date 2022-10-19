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
    <link href="../css/style.css" rel="stylesheet">
    <title><?php echo $config['title'];?></title>
</head>
<body>

   
        <?php include "includes/header.php"?> 


        <?php
            $article = mysqli_query($connection, "SELECT * FROM `articles` WHERE `id` = " . (int) $_GET['id']);

            if (mysqli_num_rows($article) <= 0) {
        ?>
                    <div id="content">
                        <div class="container">
                            <div class="row">
                                <section class="content_full">
                                    <div class="block">
                                        <h3 class="text-center mt-5">Статья не найдена!</h3>
                                        <div class="block_content">
                                            <div class="full-text">
                                                Запрашиваемая вами статья не существует!
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                <?php    
            } else {
                $art = mysqli_fetch_assoc($article);
                mysqli_query($connection, "UPDATE `articles` SET `views` = `views` + 1 WHERE `id` = " . (int) $art['id']);
                ?>
                    <div id="content">
                        <div class="container">
                            <div class="row">
                                <section class="content_full">
                                    <div class="block">
                                        <div class="row">
                                            <h3 class="col-10 mt-3 mb-3"><?php echo $art['title']; ?></h3>
                                            <a class="col-2 mt-3 mb-3"><?php echo $art['views']; ?> просмотров</a>
                                        </div>
                                        
                                        <div class="block_content">
                                            <img class="photo_big col-12" src="css/img/<?php echo $art['image']; ?>">
                                            <div class="full-text mt-3 mb-3"><?php echo $art['text']; ?></div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        </div>
                    </div>
                <?php  
            }
                ?>

      <div class="container">
            <div class="row">
                <section class="comments col-12">
                    <div class="block">
                        <h3 class="mb-3 mt-3 text-center">Комментарии</h3>
                        <div class="block_content">
                            <div class="articles_container"> 

                            <?php
                                $sql = "SELECT * FROM `comments` WHERE `articles_id` = " . (int) $art['id'] . " ORDER BY `id` DESC";
                            
                                $comments = mysqli_query($connection, $sql);
                                
                                
                                if(mysqli_num_rows($comments) <= 0) {
                                    echo '<div class="text-center mb-3">Комментариев пока нет!</div>';
                                }

                                while($comment = mysqli_fetch_assoc($comments)) {
                            ?>
                                <article class="comment">
                                    <div class="comment_image" style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($comment['email']); ?>?s=125);"></div>
                                    <div class="comment_info">
                                        <a class="title" href="pages/article.php?id=<?php echo $comment['articles_id'];?>"><?php echo $comment['author']; ?></a>
                                
                                        <div class="preview"><?php echo $comment['text']; ?></div>
                                    </div>
                                </article>
                            <?php
                                }
                            ?>
                            </div>
                        </div>
                    </div>
                </section>

                <div id="comment-add-form" class="block">
                    <h3 class="text-center mb-3">Добавить комментарий</h3>
                    <div class="block_content">
                        <form class="form" method="POST" action="/article.php?id=<?php echo $art['id']; ?>#comment-add-form">

                        <?php
                            if (isset($_POST['do_post'])) {
                                $errors = array();

                                if($_POST['name'] == '') {
                                    $errors[] = 'Введите имя!'; 
                                }

                                if($_POST['nickname'] == '') {
                                    $errors[] = 'Введите никнейм!'; 
                                }

                                if($_POST['email'] == '') {
                                    $errors[] = 'Введите email!'; 
                                }

                                if($_POST['text'] == '') {
                                    $errors[] = 'Введите текст комментария!'; 
                                }

                                if (empty($errors)) {

                                    $sql = "INSERT INTO `comments` (`author`, `nickname`, `email`, `text`, `pubdate`, `articles_id`) VALUE ('".$_POST['name']."', '".$_POST['nickname']."', '".$_POST['email']."', '".$_POST['text']."', NOW(), '".$art['id']."')";
                                        
                                    mysqli_query($connection, $sql);


                                    echo '<span style="color: green; font-weight: bold; margin-bottom: 10px; display: block;">Комментрий добавлен!</span>'; 
                                } else {
                                    echo '<span style="color: red; font-weight: bold; margin-bottom: 10px; display: block;">'.$errors['0'] . '</span>';
                                    
                                }

                            }
                        ?>


                            <div class="form_group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="name" placeholder="Имя" value="<?php echo $_POST['name']; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="nickname" placeholder="Никнейм" value="<?php echo $_POST['nickname']; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="email" placeholder="Email" value="<?php echo $_POST['email']; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form_group">
                                <textarea class="form-control " name="text" placeholder="Текст комментария..."><?php echo $_POST['text']; ?></textarea>
                            </div>
                            <div class="form_group">
                                <button type="submit" name="do_post" class="form-control" style="background: #F4A460; ">Добавить комментарий</button> 
                            </div>


                        </form>
                    </div>
                </div>




            </div>
        </div>

<?php include "includes/footer.php"?>





<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>