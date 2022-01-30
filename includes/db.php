<?php
require_once("new_config.php");

class Database {

    public $connection;  //Edwin from the future said it should be "public"!!

    function __construct(){ // Automatically connect to database when instanciate this class
        $this->open_db_connection();
    }

    public function open_db_connection(){
        //Passing the constants to mysli_connect to connect the database
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        // Now, this connection should be working
        
        if($this->connection->connect_errno){
            die("Database connection failed badly" . $this->connection->connect_error);
        }
    }

    // THIS METHOD WILL BE USED IN OTHER CLASSES
    public function query($sql){
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        $result = $this->connection->query($sql);        
        $this->confirm_query($result);
        return $result;   //MAKE SURE TO RETURN THE RESULT!
    }

    private function confirm_query($result){
        if(!$result){
            die("Query failed :(" . $this->connection->error);
        }
    }

    public function escape_string($string){
        $escape_string = $this->connection->real_escape_string($string);
        return $escape_string;
    }

    public function the_insert_id(){
        return $this->connection->insert_id;
    }

}


$database = new Database();

?>
