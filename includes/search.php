<div class="row">
    <div class="col-md-11 mx-auto">
        <div class="container py-3" style="background-color:#F3F3FF;">


            <?php
            if (isset($_POST["search_submit"])) {
                $keyword = $_POST["search_keyword"];

                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "my_translation_2";
                try {
                    $dbh = new PDO(
                        'mysql:host=' . $servername . ';dbname=' . $dbname . ';charset=utf8',
                        $username,
                        $password,
                        array(
                            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                            PDO::ATTR_EMULATE_PREPARES => false,
                        )
                    );

                    $prepare_getposts = $dbh->prepare("SELECT * FROM post WHERE post_title LIKE ? OR post_content_en LIKE ? OR post_content_jp LIKE ?");
                    $prepare_getposts->bindValue(1, $word);
                    $prepare_getposts->bindValue(2, $word);
                    $prepare_getposts->bindValue(3, $word);
                    $word = '%' . $keyword . '%';
                    $prepare_getposts->execute();
                    $result = $prepare_getposts->fetchAll(PDO::FETCH_ASSOC);
                    //var_dump($result);
                    //$numberofrows = $prepare_getposts->num_rows;
                    //while ($prepare_getposts->fetch(PDO::FETCH_ASSOC)) {

                    if ($result) {
                        // show the publishers



                        //if ($numberofrows > 0) {
                        echo "<h1 class='font my-3'>Search Result for '" . $keyword . "'</h1><div class='row'>";

                        foreach ($result as $row) {

                            ////foreach ($prepare_getposts as $row) {
                            $post_id = $row["post_id"];
                            $post_title = $row["post_title"];
                            $post_date = date("Y/n/j D", +strtotime($row["post_date"]));
                            $post_image = $row["post_image"];
                            $post_content_en = $row["post_content_en"];
                            $post_content_jp = $row["post_content_jp"];
                            $post_lang_from = $row["post_lang_from"];
                            $post_lang_into = $row["post_lang_into"];
                            $post_cat_id = $row["post_cat_id"];

                            $prepare_get_catname = $dbh->prepare("SELECT cat_name FROM category WHERE cat_id = ?");
                            $prepare_get_catname->bindValue(1, $post_cat_id, PDO::PARAM_INT);
                            $prepare_get_catname->execute();
                            foreach ($prepare_get_catname as $row) {
                                $cat_name = $row["cat_name"];
                            }

                            if (strlen($post_title) > 20) {
                                $post_title = substr($post_title, 0, 20) . "..";
                            }
                            if (strlen($post_content_en) > 80) {
                                $post_content_en = substr($post_content_en, 0, 80) . "...";
                            }
                            if (strlen($post_content_jp) > 80) {
                                $post_content_jp = substr($post_content_jp, 0, 80) . "...";
                            }
            ?>
                            <div class="col-lg-3 col-6 p-2 border post">
                                <span class="grey" style="font-size: 0.5em"><?php echo $cat_name; ?></time>

                                    <a href='index.php?source=view_post&post_id=<?php echo $post_id; ?>'>
                                        <span class="grey" style="font-size: 0.5em"></span>
                                        <div class='img_box'>
                                            <img src="images/<?php echo $post_image; ?>" class="image-fluid" alt=''></img>
                                        </div>
                                        <div>
                                            <span class="grey" style="font-size: 0.5em"><i class="fas fa-clock mr-1"></i><time><?php echo $post_date; ?></time>
                                                <span class="float-right text-danger" style="font-size: 0.5em"><?php echo $post_lang_from; ?> <i class="fas fa-caret-right"></i><?php echo $post_lang_into; ?> </span>
                                        </div>
                                        <h4 class='font-weight-bold'><small><?php echo $post_title; ?></small></h4>
                                        <p class='grey m-0' style='font-size: 0.7em'><?php echo $post_content_en; ?></p>
                                        <p class='grey m-0' style='font-size: 0.7em'><?php echo $post_content_jp; ?></p>
                                    </a>
                            </div>
            <?php
                        }
                        /*
                        } else { 
                            echo "<h1 class='font my-3'>Sorry. no result for '" . $keyword . "'</h1><div class='row'>";
                        }    */
                    }
                } catch (PDOException $e) {
                    $error = $e->getMessage();
                }
            } ?>

        </div>
    </div>
</div>
</div>