<?php
namespace Controllers\inventory;


use Core\View;
use Core\Controller;
use Helpers\Url;
use Helpers\Hooks;
use Parse\ParseObject;
use Parse\ParseFile;
use Parse\ParseUser;
use Parse\ParseException;
use Parse\ParseQuery;

class Product extends Controller{
    public function JS(){
       echo '<script src="'.DIR.'app/templates/default/js/fileupload/fileinput.min.js" type="text/javascript"></script>'; 
       echo '<script src="'.DIR.'app/templates/default/js/inventory/product.js" type="text/javascript"></script>'; 
       echo '<script type="text/javascript">
                var url = {    
                Product: "'.DIR.'product"
              }
            </script>';
    }
    public function CSS(){
        echo '<link href="'.DIR.'app/templates/default/css/inventory/dash.css" rel="stylesheet" type="text/css">';      
    	echo '<link href="'.DIR.'app/templates/default/css/fileupload/fileinput.min.css" rel="stylesheet" type="text/css">';    	
    }
	public function product(){        
        // if(!Session::get('loggedin')){
        //     Url::redirect('login');
        // }
        $currentUser = ParseUser::getCurrentUser();
        if ($currentUser) {
            // do stuff with the user            
        } else {
            // show the signup or login page
            Url::redirect('login');
        }

        if(isset($_POST['table'])){            
            View::render('inventory/product-table',$data,$error);    
        }
        elseif(isset($_POST['del']) && isset($_POST['objectId'])){
            $objectId = $_POST['objectId'];
            $query = new ParseQuery('Product');
            try{
                $data = 1;
            } catch(ParseException $ex){
                $data = $ex;
            }
            $query->equalTo('objectId', $objectId);
            $product = $query->first();
            $product->destroy();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode(array('result'=> $data));
        }
        elseif (isset($_POST['update'])){
            $objectId = ((!isset($_POST['objectId']) || trim($_POST['objectId']) == '')? '': $_POST['objectId']);
            $name = ((!isset($_POST['productName']) || trim($_POST['productName']) == '')? '': $_POST['productName']);
            $price = ((!isset($_POST['productPrice']) || trim($_POST['productPrice']) == '')? 0: floatval($_POST['productPrice']));
            $description = ((!isset($_POST['productDescription']) || trim($_POST['productDescription']) == '')? '': $_POST['productDescription']);            
            if($_FILES['fileToUpload']['size'] > 0){
                 $target_file = basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));            
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    //echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    //echo "File is not an image.";
                    $uploadOk = 0;
                }            
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    $error = "Sorry, your file is too large.".$error;
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.".$error;
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $error = "Sorry, your file was not uploaded.".$error;
                // if everything is ok, try to upload file
                } else {            
                        $imageFile = ParseFile::createFromData(file_get_contents($_FILES['fileToUpload']['tmp_name']), $target_file);
                        $query = new ParseQuery('Product');
                        $query->equalTo('objectId', $objectId);
                        $product = $query->first();                 
                        $product->set('name', $_POST['productName']);
                        $product->set('price', $price);
                        $product->set('description', $description);
                        $product->set('picture', $imageFile);
                        $product->save();                                                                   
                }
            }
            else{
                $query = new ParseQuery('Product');
                $query->equalTo('objectId', $objectId);
                $product = $query->first();
                $product->set('name', $name);
                $product->set('price', $price);
                $product->set('description', $description);
                $product->save(); 
            }
            
        }
        else{
            if(isset($_POST['submit'])){
            $name = ((!isset($_POST['productName']) || trim($_POST['productName']) == '')? '': $_POST['productName']);
            $price = ((!isset($_POST['productPrice']) || trim($_POST['productPrice']) == '')? 0: floatval($_POST['productPrice']));
            $description = ((!isset($_POST['productDescription']) || trim($_POST['productDescription']) == '')? '': $_POST['productDescription']);            
            if($_FILES['fileToUpload']['size'] > 0){
                 $target_file = basename($_FILES["fileToUpload"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));            
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    //echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    //echo "File is not an image.";
                    $uploadOk = 0;
                }            
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    $error = "Sorry, your file is too large.".$error;
                    $uploadOk = 0;
                }
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.".$error;
                    $uploadOk = 0;
                }
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    $error = "Sorry, your file was not uploaded.".$error;
                // if everything is ok, try to upload file
                } else {            
                        $imageFile = ParseFile::createFromData(file_get_contents($_FILES['fileToUpload']['tmp_name']), $target_file);
                        $product = new ParseObject('Product');                    
                        $product->set('name', $name);
                        $product->set('price', $price);
                        $product->set('description', $description);
                        $product->set('picture', $imageFile);
                        $product->save();                                                                
                }
            }
            else{
                $product = new ParseObject('Product');                    
                $product->set('name', $name);
                $product->set('price', $price);
                $product->set('description', $description);
                $product->save(); 
            }
            Url::redirect('product');           
        }    
        $sidemenu = new ParseQuery('SideMenu');
        $result = $sidemenu->find();
        Hooks::addHook('js', 'Controllers\inventory\Product@JS');
        Hooks::addHook('css', 'Controllers\inventory\Product@CSS');
        $data['title'] = 'สินค้า';
        $data['username'] = $currentUser->get('username');
        $data['sidemenu'] = $result;
        View::rendertemplate('header',$data);
        View::render('inventory/product',$data,$error);
        View::rendertemplate('footer',$data);
        }        
	}    
}