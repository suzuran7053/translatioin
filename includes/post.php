<?php

// SUMMERISED IN Lesson.51 
class Post {
    public $post_id;
    public $post_date;
    public $post_title;
    public $post_cat_id;
    public $post_image;
    public $post_content_original;
    public $post_content_translation;
    public $post_source;
    public $post_source_url;
    public $post_lang_from;
    public $post_lang_into;


    // This function will be used only to get all posts. $sql is defined here.
    public static function find_all_posts(){
        return self::find_this_query("SELECT * FROM post");
    }

    // This function will be userd only to get a post by its id. $sql is defined here.
    public static function find_user_by_id($id){
        global $database;
        $the_result_array = self::find_this_query("SELECT * FROM post WHERE id = $id LIMIT 1");
        // IF IT'S NOT EMPTY, GET THE FIRST OBJECT IN THE ARRAY
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    

    // We won't need to use while roop with mysqli_fetch_array anymore once we make this method
    // We will be able to use the returned value (associative array of the result) with just a normal roop
    public static function find_this_query($sql){
        global $database;
        // Assign the result of the query into $result_set (using a method created in database.php)
        $result_set = $database->query($sql);
        $the_object_array = array(); //First, create an empty array
        // fetch the database(table) and assign them into the array, just like we used to do before
        while($row = mysqli_fetch_array($result_set)){  // Now, $row has the data table of the result set
            // We're putting all objects in here
            $the_object_array[] = self::instantiation($row); // Assign the returned value of instantiation method into the array
        }
        return $the_object_array;  
        //各行ごと(ユーザーごと)に作られたインスタンス(User)が丸ごと入ってる。構造は以下の通り。
    }   /*　↓　  ↓
        var_dump(User::find_all_users()); ( = var_dump(User::find_this_query("SELECT * FROM users"));
            array(3) {
                [0]=> object(User)#7 (5) {
                    ["id"]=> string(1) "1" 
                    ["username"]=> string(4) "rico" 
                    ["password"]=> string(3) "123" 
                    ["first_name"]=> string(4) "John" 
                    ["last_name"]=> string(3) "Doe" 
                } [1]=> object(User)#8 (5) {
                    ["id"]=> string(1) "2" 
                    ["username"]=> string(4) "Momo" 

                    ["password"]=> string(4) "momo" 
                    ["first_name"]=> string(4) "Momo" 
                    ["last_name"]=> string(6) "Morris"
                }
            }
        */
         


    // What for? --> CREATE A NEW USER INSTANCE (各ユーザーのインスタンスを作成するんだと思う)
    // --> This method roops through the $the_record(=$row, which has columns and records that we get from the database) and assign the values-properties-set into the new instance
    public static function instantiation($the_record){
        $the_object = new self();        
        foreach ($the_record as $the_attribute => $value) { // loop through the $row (passed as a parameter)
            if($the_object->has_the_attribute($the_attribute)){  // If $the_attribute is same as the one the parent class(User) has, 
                $the_object->$the_attribute = $value; // Assigning property-value-set into the instance
                // Don't forget the $ sign (...->$the_attribute)
            }
        }
        return $the_object;
    }


    // What for? --> TO CHECK THE PROPERTIES THAT A NEW INSTANCE IS GOING TO HAVE IS SAME AS THE PROPERTIES THAT THE USER CLASS(PARENT) HAS
    private function has_the_attribute($the_attribute){
        // getting all the properties of User Class(=$this) and asign them into the variable $object_properties as an array
        $object_properties = get_object_vars($this);  
        return array_key_exists($the_attribute, $object_properties); // Will return boolean of if the attribute ($the_attribute) exists in the array ($object_peoperties)          
    }

}


?>