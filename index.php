<?php

//$password = 'redcodebluecode';
//$hash = crypt($password, '25');
//echo "password: " . $password . '<br>';
//echo $hash;die;

?>

<?php include 'config.php'; ?>
<?php include 'blogrouter.php' ?>

<!DOCTYPE html>
<html>
    <head>
        <title>Robert Tamayo's Code Blog – Red Code Blue Code</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Press+Start+2P" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Heebo|Roboto" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Fira+Sans:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/public/assets/css/core.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="<?= PUBLIC_ASSETS_URL ?>/js/module/Template.js"></script>
        <script src="<?= PUBLIC_ASSETS_URL ?>/js/module/Guests.js"></script>
        <script src="<?= PUBLIC_ASSETS_URL ?>/js/module/Comments.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/solid.js" integrity="sha384-+Ga2s7YBbhOD6nie0DzrZpJes+b2K1xkpKxTFFcx59QmVPaSA8c7pycsNaFwUK6l" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.8/js/fontawesome.js" integrity="sha384-7ox8Q2yzO/uWircfojVuCQOZl+ZZBg2D2J5nkpLqzH1HY0C1dHlTKIbpRz/LG23c" crossorigin="anonymous"></script>
    </head>
    <body>
        
        <header>
            <a class="redcodebluecode" href="http://www.redcodebluecode.com/" title="Red Code Blue Code home page">
                <div>
                    <div class="redblue">
                        <div class="red">R</div>
                        <div class="blue">B</div>
                    </div>
                    <div class="code">code</div>
                </div>
            </a>
            <div class="page-title">
                <h1>Robert Tamayo's Code Blog</h1>
            </div>
            <nav></nav>
        </header>
        <div class="main">
            <div class="main-left"></div>
            <div class="main-middle">
                <?php
                    if ($blog_mode == BLOG_HOME_PAGE) { 
                    include HOME_DIR . 'embed/blogfeed.php'; 
                    } else if ($blog_mode == BLOG_CATEGORY_PAGE) { 
                    include HOME_DIR . 'embed/catPage.php'; 
                    } else if ($blog_mode == BLOG_POST_PAGE) { 
                    include HOME_DIR . 'embed/blogPage.php'; 
                    } else if ($blog_mode == BLOG_TAG_PAGE) { 
                    } 
                ?>
            </div>
            <div class="main-right"></div>
        </div>
        <footer></footer>
<!--        <script src="/assets/js/core.js"></script>-->
        
    </body>
</html>