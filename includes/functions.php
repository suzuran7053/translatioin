<?php

// THIS IS A SAFETY PRICAUTION. IN CASE WE FORGET TO INCLUDE FILES THAT HAVE CLASS DECLARED
// AUTOMATICALLY LOAD A CLASS THAT IS NOT INCLUDED(=UNDECLARED CLASS)
// This is going to be scanning our application and looking for undeclared objects in "index.php"
// If the class 'User' is undecleared, it's going to catch it and pass it in as a parameter
function classAutoLoader($class){
    $class = strtolower($class); // Lowercase or Uppercase, whatever you select
    $the_path = "includes/{$class}.php";  // We need to go out of this directory as this function will look through in index.php
    
    if(is_file($the_path) && !class_exists($class)){
        require_once($the_path);
    }else{
        die("File name '{$class}.php' was not found");
    }
}
spl_autoload_register('classAutoLoader');


function redirect($location){
    header("Location: $location");
}

/* $found_user = User::find_user_by_id(2);
echo $found_user->username; */
            

function showTabsAndPosts(){
    global $database;
    echo '<div class="row">
            <div class="col-md-11 mx-auto">';

    // TABS
    echo '<ul class="nav nav-tabs">';
    //THE FIRST TAB
    
    $category1 = Category::find_category_by_id(1);
    echo '<li class="nav-item mr-1">
                <a class="nav-link bg-light active" data-toggle="tab" href="#' . $category1->cat_name . '">' . $category1->cat_name . '</a>
            </li>';

    //THE OTHER TABS
    $sql = 'SELECT * FROM category ORDER BY cat_id ASC LIMIT 20 OFFSET 1';
    $category_other = Category::find_this_query($sql);
    foreach ($category_other as $key => $value) {
        if($key == "cat_name"){ $cat_name = $value;};
        echo '<li class="nav-item mr-1">
            <a class="nav-link bg-light" data-toggle="tab" href="#' . $cat_name . '">' . $cat_name . '</a>
        </li>';
    }
    echo '</ul>';


    // TAB CONTENT
    echo '<div class="tab-content container py-3" style="background-color:#F3F3FF;">';

    // GET THE CONTENT OF THE FIRST CATEGORY ($cat_id_1)
    // cat_name                        
    $found_category = Category::find_category_by_id(1);
    echo '<div id="' . $found_category->cat_name . '" class="tab-pane active">
                <h1>' . $found_category->cat_name . '</h1>
                <a href="" class="text-danger"><i class="fas fa-book-open mr-1"></i>Terminology</a>
                    <div class="row">';

    // posts
    $sql = 'SELECT * FROM post WHERE post_cat_id = 1 ORDER BY post_id DESC';
    $found_post = Post::find_this_query($sql);        
    while ($row = $found_post) {
        $post_title = $found_post->post_title;
        $post_date = date("Y/n/j D", strtotime($found_post->post_date));
        $post_content_original = $found_post->post_content_original;
        $post_content_translation = $found_post->post_content_translation;
        if (mb_strlen($post_title) > 20) {
            $post_title = mb_strimwidth($post_title, 0, 20, '...', 'utf8');
        }
        if (strlen($post_content_original) > 80) {
            $post_content_original = substr($post_content_original, 0, 80) . "...";
        }
        if (mb_strlen($post_content_translation) > 80) {
            $post_content_translation = mb_strimwidth($post_content_translation, 0, 80, '...', 'utf8');
        }
        echo '<div class="col-lg-3 col-6 p-3 border post">
        <a href="index.php?source=view_post&post_id=' . $found_post->post_id . '">
            <div class="img_box">
                <img src="./images/' . $found_post->post_image . '" class="image-fluid" alt=""></img>
            </div>
            <div>
                <span class="grey" style="font-size: 0.8em"><i class="fas fa-clock mr-1"></i><time>' . $post_date . '</time>
                <span class="grey float-right text-danger" style="font-size: 0.8em">' . $found_post->post_lang_from . ' <i class="fas fa-caret-right"></i> ' . $found_post->post_lang_into . '</span>
            </div>
            <h4 class="font-weight-bold"><small>' . $post_title . '</small></h4>
            <p class="grey" style="font-size: 0.9em">' . $post_content_original . '</p>
            <p class="grey" style="font-size: 0.9em">' . $post_content_translation . '</p>
        </a>
    </div>';
    }
    echo '</div></div>';

    // GET THE CONTENT OF THE OTHER CATEGORY
    // cat_name 
    $sql = 'SELECT * FROM category ORDER BY cat_id ASC LIMIT 20 OFFSET 1';
    $found_category = Category::find_this_query($sql);
    while ($row = $found_category) {
        $selected_cat_id = $found_category->cat_id;
        echo '<div id="' . $found_category->cat_name . '" class="tab-pane fade">
                    <h1>' . $found_category->cat_name . '</h1>
                    <a href="" class="text-danger"><i class="fas fa-book-open mr-1"></i>Terminology</a>                    
                    <div class="row">';
        // posts
        $sql = 'SELECT * FROM post WHERE post_cat_id = $selected_cat_id ORDER BY post_id DESC';
        $found_post = Post::find_this_query($sql);        
        while ($row = $found_post) {
            $post_title = $found_post->post_title;
            $post_date = date("Y/n/j D", strtotime($found_post->post_date));
            $post_content_original = $found_post->post_content_original;
            $post_content_translation = $found_post->post_content_translation;
            if (mb_strlen($post_title) > 20) {
                $post_title = mb_strimwidth($post_title, 0, 20, '...', 'utf8');
            }
            if (strlen($post_content_original) > 80) {
                $post_content_original = substr($post_content_original, 0, 80) . "...";
            }
            if (mb_strlen($post_content_translation) > 80) {
                $post_content_translation = mb_strimwidth($post_content_translation, 0, 80, '...', 'utf8');
            }
            echo '<div class="col-lg-3 col-6 p-3 border post">
            <a href="index.php?source=view_post&post_id=' . $found_post->post_id . '">
                <div class="img_box">
                    <img src="./images/' . $found_post->post_image . '" class="image-fluid" alt=""></img>
                </div>
                <div>
                    <span class="grey" style="font-size: 0.8em"><i class="fas fa-clock mr-1"></i><time>' . $post_date . '</time>
                    <span class="grey float-right text-danger" style="font-size: 0.8em">' . $found_post->post_lang_from . ' <i class="fas fa-caret-right"></i> ' . $found_post->post_lang_into . '</span>
                </div>
                <h4 class="font-weight-bold"><small>' . $post_title . '</small></h4>
                <p class="grey" style="font-size: 0.9em">' . $post_content_original . '</p>
                <p class="grey" style="font-size: 0.9em">' . $post_content_translation . '</p>
                    </a>
                </div>';
        }
            echo '</div></div>';
    }
        echo '</div>';

}
    echo '</div></div>';

?>