<header>
        <div class="header_top">
            <div class="container">
                <nav>
                    <div class="header_logo">
                        <a href="/"><?php echo $config['title'];?></a>
                    </div>
                    <ul class="nav nav-top">
                        <li class="nav-item"><a class="nav-link" href="/">Главная</a></li>
                        <li class="nav-item"><a class="nav-link" href="/pages/about_me.php">Обо мне</a></li>
                        <li class="nav-item"><a class="nav-link" href="https://github.com/oleyaka">GitHub</a></li>
                    </ul>
                </nav>
            </div>
        </div>

        <?php
             $categories = mysqli_query($connection, "SELECT * FROM `articles_categories`");
        ?>
       

        <div class="header_bottom">
            <div class="container text-center">
                <nav>
                    <ul class="nav">
                        <?php
                            while ($cat = mysqli_fetch_assoc($categories)) {
                        ?>
                            <li class="nav-link" style="padding-right: 30px"><a href="/categories.php?categorie=<?php echo $cat['id'];?>"><?php echo $cat['title']; ?></a></li>
                        <?php
                            }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>