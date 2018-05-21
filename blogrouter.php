<?php 

// PUBLIC PAGE
require_once("config.php");
require_once(SRC_DIR . "bobblog.php");

define("BLOG_HOME_PAGE", 0);
define("BLOG_CATEGORY_PAGE", 1);
define("BLOG_POST_PAGE", 2);
define("BLOG_TAG_PAGE", 3);

$blog_mode = BLOG_HOME_PAGE;

$bb = new BobBlog();

// determine landing page
$uri = $_SERVER['REQUEST_URI'];
$uri = str_replace(BLOG_INSTALL_DIR, "", $uri);
$uri = trim($uri, "/");
$uri = explode("?", $uri)[0];

$main_content = "";
$category_uri = "";

//die;
if ($uri === "") {
//    ob_start();
//    include (SRC_DIR . "blogHomePage.php");
//    $main_content = ob_get_clean();
} else {
//    ob_start();
    $parts = explode("/", $uri);
    if (sizeof($parts) == 1) {
        // post pages have only one part
        $blog_permalink = $uri;
        $blog_mode = BLOG_POST_PAGE;
//        include (SRC_DIR . "blogPage.php");
//        $main_content = ob_get_clean();
    } else {
        $blog_mode = BLOG_CATEGORY_PAGE;
        $category_uri = $parts[0];
        $category_permalink = $parts[1];
        
        if ($category_uri != CATEGORY_URI){
            // error 404 time
//            echo "error 404: invalid category uri";
//            include(SRC_DIR . "error404.php");
            // redirect to blog home page
        } else {
//            $categoryMode = true;
//            include (SRC_DIR . "blogHomePage.php");
//            $main_content = ob_get_clean();
        }
    }
    
}

// prepare all variables, then load the template
//include('mainSiteHTML.html');

