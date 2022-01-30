<?php
if (isset($_GET["post_id"])) {
    $post_id = $_GET["post_id"];

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

        $prepare = $dbh->prepare("SELECT *, category.cat_name FROM post INNER JOIN category ON post.post_cat_id = category.cat_id WHERE post.post_id= ?");
        $prepare->bindValue(1,(int)$post_id, PDO::PARAM_INT);
        $prepare->execute();
        while ($row = $prepare->fetch(PDO::FETCH_ASSOC)) {
        
        
?>

<div class="row">
    <article class="col-md-11 mx-auto mt-3">

        <div style="border-left: solid navy 6px;">
            <h5 class="ml-2"><?php echo $row["cat_name"]; ?></h5>
            <h2 class="bung ml-2"><?php echo $row["post_title"]; ?></h2>
        </div>

        
        <div>
            <a href="<?php echo $row['post_source_url']; ?>" class="text-info"><small>Source: <?php echo $row["post_source"]; ?></small></a><br>               
        </div>
        <div class="float-right">
            <i class="fas fa-clock mr-1"></i><small><time><?php echo date("Y/n/j D",  strtotime($row["post_date"])); ?></time></small>               
        </div>

        <!-- PICTURE AREA -->
        <div class="my-5 text-center">
            <img class="img-responsive" src="./images/<?php echo $row["post_image"]; ?>" alt="" style="height:30vw;">
        </div>


        <div class="text-center">
            <!-- CONTENT AREA -->
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <h4>Original</h4>
                    <p class="font"><?php echo $row["post_content_original"]; ?></p>
                </div>
                <div class="col-md-6">
                    <h4>Translation</h4>
                    <p class="font"><?php echo $row["post_content_translation"]; ?></p>
                </div>
            </div>                       
        </div>
        <hr class="post_hr">
        

    </article>
</div>

<?php
        }
    } catch (PDOException $e) {
        $error = $e->getMessage();
    }
}

?>