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
    /**
        checks for presence of vital values and sets to defaults if not present
        Takes a list of known safe get variables, sanitize first with the get_allowed_params
    */
    private function check_presence($params){//
        if(has_presence($params["x"])){
                    
        }else {
            $params["x"]= $this::$x_default;
        }
        if(has_presence($params["number"])){
            
        } else {
            $params["number"] = $this::$number_default;
        }
    }
    
    private function getFurnitureFailed($query, $db){
        $query->closeCursor();
        $db = null;
        exit;
    }
    
    /**
    First checks if variables are present by calling check_presence
    Second Checks if all allowed params are numbers
    
    Returns a boolean if the received values are numbers or not
    */
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
    
    public function divideNumber($number){
        
    }
    
    /**
        Tests for presence of errors and whether the query has returned false
    
    */
    private function checkQuerySuccess($stmt){
        
        $errorInfo = $stmt->errorInfo();
        if(isset($errorInfo[2]) || !$stmt){
            self::getFurnitureFailed($stmt, $db);
            return $false;
        }
        return true;
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
                
                $success = self::checkQuerySuccess($query);
                
                if ($success){// if query succedded
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
                        
                        $success = self::checkQuerySuccess($stmt);
                        
                        if ($success){ //if found items, loop through all of them and create the html elements
                            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row){
                                $message = $message . "\n" . self::getFurnitureByName($row); 
                                //$message = $message . var_dump($row);
                            }
                            $stmt->closeCursor();
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
    
    /**
        Makes a figure html element out of the database information
    */
    function getFurnitureByName($row) {
        $filename = $row["filename"];
        $folder = $row["folder"];
        $title = $row["title"];
        $description = $row["description"];
        $price = $row["price"];
        $id = $row["id"];
        $image = "<li ><figure class='center'>
        <img src='". $folder . "/" . $filename ."' alt='picture' class='center'>
        <figcaption><p><span class='title'>" . $title ."</span> <span class='price'>" . $price  . "<span></p><p><span class='description'>" . $description ." </span></p>" .
        "</figcaption>
        
        </figure></li>";
        return $image;
    }
}
?>