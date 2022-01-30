<?php include "includes/header.php" ?>
<body>

    <?php include "includes/navigation.php" ?>

    <div class="container-fluid" style="position: relative; min-height:100vh;">

        <div class="row mb-3">
            <div class="ml-auto">
                <form action="index.php?source=search" method="post" class="mr-2">
                    <input name="search_keyword" type="text" placeholder=" Search">                    
                        <button type="submit" name="search_submit" id="search_submit" class="p-1">
                            <i class="fas fa-search"></i>
                        </button>
                </form>
            </div>
        </div>


        <div class="row">

            <div class="col-lg-2" id="sidebar">
                <?php include "includes/sidebar.php" ?>
            </div>


            <div class="col-lg-10" id="main">

                <?php
                if(isset($_GET["source"])){
                    $source = $_GET["source"];
                    switch($source){
                        case "search";
                            include "includes/search.php";
                        break;
                        case "view_post";
                            include "includes/view_post.php";
                        break;            
                    }
                }else{
                
                    showTabsAndPosts();
                }
                ?>       
            </div>  

        </div>
    </div>

    <?php include "includes/footer.php" ?>

</body>
</html>