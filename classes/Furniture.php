<?php

require_once "../php-includes/connect.inc.php";
require_once "../functions/allowed_params.php";
require_once "../functions/csrf_request_type_functions.php";
require_once "../functions/validation_functions.php";
require_once "../functions/xss_sanitize_functions.php";

class Furniture {
    private static $x_default = 0;
    private static $number_default = 10;
    private static $max_query = "Select Max(id) AS id From furniture";
    private static $get_furniture = "Select * FROM furniture WHERE id <= ?";
    
    function addFurniture() {
        
    }
    
    function __construct(){
        
    }
    
    private function check_presence($params){//checks for presence of vital values and sets to defaults if not present
        if(has_presence($params["x"])){
                    
        }else {
            $params["x"]= $x_default;
        }
        if(has_presence($params["number"])){
            
        } else {
            $params["number"] = $number_default;
        }
    }
    
    private function getFurnitureFailed($query, $db){
        $query->closeCursor();
        $db = null;
        exit;
    }
    
    private function performChecks($params){
        
        $isNumber = true;
        //method that checks if variables have values if not set to defualts
        self::check_presence($params);
        
        foreach ($params as $value){//test if any value is not a number 
            if (!is_numeric($value)){
                return false;
            } 
        }
        return $isNumber;
    }
    
    function getFurniture() {
        $message = "";
        //ignore other paramters by getting the allowed ones
        $params = allowed_get_params(["x", "number"]);
        
        $isNumber = self::performChecks($params);
        
        if ($isNumber){// if not null, not empty and all are numbers...
            //get the values into variables, more readable
            $x = $params["x"];
            $number = $params["number"];
            
            // create the class that access the database
            try {
            
                $db = new FurnitureDB();
                //get a connection
                $db = $db::getConnection();
                
                $query = $db->query(Furniture::$max_query);
                
                $errorInfo = $query->errorInfo();
                if(isset($errorInfo[2])){ // check for errors
                    self::getFurnitureFailed($query, $db);
                    return "<h2 class='error'>There was a problem with the website, we will try to fix this as soon as possible</p>";
                    
                }
                if ($query){// if query succedded
                    $result = $query->fetchAll(PDO::FETCH_ASSOC);
                    $number_of_furniture = $result[0];
                    
                    $total = $number + $x;
                    $query->closeCursor();
                    if ($params["x"]>$number_of_furniture || ($total)>$number_of_furniture ){
                        $message = "<p class='error'>There was a problem with your input, please check the numbers</p>";
                        return $message;
                    } else {
                        $stmt = $db->prepare(Furniture::$get_furniture);
                        
                        $stmt->bindParam(1, $total, PDO::PARAM_INT);
                        $stmt->execute();
                        $errorInfo = $stmt->errorInfo();
                        if(isset($errorInfo[2])){
                            self::getFurnitureFailed($stmt, $db);
                            return "<p class='error'>There was a problem with the database, we will try to fix this as soon as possible</p>";
                        }
                        if ($stmt){ 
                            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
                                $message = $message . "\n" . self::getFurnitureByName($row); 
                                //$message = $message . var_dump($row);
                            }
                        }else {
                          //failed to get any results from database, something very strange happened
                            self::getFurnitureFailed($stmt, $db);
                            $message = "<p class='error'>There was a problem with the database, we will try to fix this as soon as possible</p>";
                            return $message;
                        }
                    }
                }else {
                  //likely no images in the database
                    self::getFurnitureFailed($stmt, $db);
                    $message = "<p class='error'>There was a problem with the database, we will try to fix this as soon as possible</p>";
                    return $message;
                }
            }catch (Exception $e) {return "<h2 class=error>Website encountered a fatal error</h2>";}
        }
        else {
            // was either null, not present or not a number... tell user to try again
            $message = "<p class='error'>There was a problem with your input, please check that they are numbers</p>";
            return $message;
        }
        $db = null;
        return $message;
    }
    
    function getFurnitureByName($row) {
        $filename = $row["filename"];
        $folder = $row["folder"];
        $title = $row["title"];
        $description = $row["description"];
        $price = $row["price"];
        $id = $row["id"];
        $image = "<li class='border'><figure class='center'>
        <img src='". $folder . "/" . $filename ."' alt='picture' class='center'>
        <figcaption><p><span id='title'>" . $title ."</span> <span id='price'>" . $price  . "<span></p><p><span id='description'>" . $description ." </span></p>" .
        "</figcaption>
        
        </figure></li>";
        return $image;
    }
}
?>