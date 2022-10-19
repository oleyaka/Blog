<div id="content">
    <div class="container">
        <div class="row">
            <section class="comments">
                <div class="block">
                    <h3 class="mb-3 mt-3 text-center">Комментарии</h3>
                    <div class="block_content">
                        <div class="articles_container">

                        <?php
                            $comments = mysqli_query($connection, "SELECT * FROM `comments` ORDER BY `id` DESC LIMIT 3");
                        ?>

                        <?php
                            while($comment = mysqli_fetch_assoc($comments)) {
                        ?>
                            <article class="comment">
                                <div class="comment_image" style="background-image: url(https://www.gravatar.com/avatar/<?php echo md5($comment['email']); ?>?s=125);"></div>
                                <div class="comment_info">
                                    <a class="title" href="article.php?id=<?php echo $comment['articles_id'];?>"><?php echo $comment['author']; ?></a>
                            
                                    <div class="preview"><?php echo mb_substr(strip_tags($comment['text']), 0, 100, 'utf-8'); ?></div>
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

