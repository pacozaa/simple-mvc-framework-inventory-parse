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
use \DateTime;

class Order extends Controller{
    public function JS(){
       echo '<script src="'.DIR.'app/templates/default/js/fileupload/fileinput.min.js" type="text/javascript"></script>'; 
       echo '<script src="'.DIR.'app/templates/default/js/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>'; 
       echo '<script src="'.DIR.'app/templates/default/js/inventory/order.js" type="text/javascript"></script>'; 
       echo '<script type="text/javascript">
                var url = {    
                Order: "'.DIR.'order",
                Product: "'.DIR.'product"
              }
            </script>';
    }
    public function CSS(){
        echo '<link href="'.DIR.'app/templates/default/css/inventory/dash.css" rel="stylesheet" type="text/css">';      
        echo '<link href="'.DIR.'app/templates/default/css/fileupload/fileinput.min.css" rel="stylesheet" type="text/css">';        
        echo '<link href="'.DIR.'app/templates/default/css/datepicker/bootstrap-datepicker3.css" rel="stylesheet" type="text/css">';        
    	echo '<link href="'.DIR.'app/templates/default/css/datepicker/bootstrap-datepicker.css" rel="stylesheet" type="text/css">';    	
    }
	public function order(){        
        $currentUser = ParseUser::getCurrentUser();
        if ($currentUser) {
            // do stuff with the user            
        } else {
            // show the signup or login page
            Url::redirect('login');
        }

        if(isset($_POST['table'])){            
            View::render('inventory/order-table',$data,$error);    
        }
        elseif(isset($_POST['del']) && isset($_POST['objectId'])){
            $objectId = $_POST['objectId'];
            $query = new ParseQuery('Order');
            try{
                $data = 1;
            } catch(ParseException $ex){
                $data = $ex;
            }
            $query->equalTo('objectId', $objectId);
            $order = $query->first();
            $order->destroy();
            header('Content-type: application/json; charset=utf-8');
            echo json_encode(array('result'=> $data));
        }
        elseif (isset($_POST['update'])){
            $objectId = ((!isset($_POST['objectId']) || trim($_POST['objectId']) == '')? '': $_POST['objectId']);
            $productId = ((!isset($_POST['productId']) || trim($_POST['productId']) == '')? '': $_POST['productId']);
            $productName = ((!isset($_POST['productName']) || trim($_POST['productName']) == '')? '': $_POST['productName']);
            $customerId = ((!isset($_POST['customerId']) || trim($_POST['customerId']) == '')? '': $_POST['customerId']);
            $customerName = ((!isset($_POST['customerName']) || trim($_POST['customerName']) == '')? '': $_POST['customerName']); 
            $lineId = ((!isset($_POST['lineId']) || trim($_POST['lineId']) == '')? '': $_POST['lineId']);        
            $facebook = ((!isset($_POST['facebook']) || trim($_POST['facebook']) == '')? '': $_POST['facebook']);        
            $telephone = ((!isset($_POST['telephone']) || trim($_POST['telephone']) == '')? '': $_POST['telephone']);        
            $transportDate = ((!isset($_POST['transportDate']) || trim($_POST['transportDate']) == '')? null: DateTime::createFromFormat('d/m/Y', $_POST['transportDate']));        
            $address = ((!isset($_POST['address']) || trim($_POST['address']) == '')? '': $_POST['address']);        
            $transportStatus = ((!isset($_POST['transportStatus']) || trim($_POST['transportStatus']) == '')? '': $_POST['transportStatus']);        
            $transferStatus = ((!isset($_POST['transferStatus']) || trim($_POST['transferStatus']) == '')? '': $_POST['transferStatus']);        
            $trackingNumber = ((!isset($_POST['trackingNumber']) || trim($_POST['trackingNumber']) == '')? '': $_POST['trackingNumber']);
            $contact =  ['telephone' => $telephone, 'lineId' => $lineId, 'facebook' => $facebook];           
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
                        $query = new ParseQuery('Order');
                        $query->equalTo('objectId', $objectId);
                        $order = $query->first();                 
                        $order->set('productId', $productId);
                        $order->set('productName', $productName);
                        $order->set('customerName', $customerName);
                        $order->set('customerId', $customerId);
                        $order->setAssociativeArray('contact', $contact);                       
                        $order->set('slipPayin', $imageFile);
                        $order->set('transportDate', $transportDate);
                        $order->set('address', $address);
                        $order->set('transportStatus', $transportStatus);
                        $order->set('transferStatus', $transferStatus);
                        $order->set('trackingNumber', $trackingNumber);                        
                        $order->save();                                                                                                           
                }
            }
            else{
                $query = new ParseQuery('Order');
                $query->equalTo('objectId', $objectId);
                $order = $query->first();
                $order->set('productId', $productId);
                $order->set('productName', $productName);
                $order->set('customerName', $customerName);
                $order->set('customerId', $customerId);
                $order->setAssociativeArray('contact', $contact);                       
                $order->set('transportDate', $transportDate);
                $order->set('address', $address);
                $order->set('transportStatus', $transportStatus);
                $order->set('transferStatus', $transferStatus);
                $order->set('trackingNumber', $trackingNumber);                
                $order->save(); 
            }
            
        }
        else{
            if(isset($_POST['submit'])){
            $productId = ((!isset($_POST['productId']) || trim($_POST['productId']) == '')? '': $_POST['productId']);
            $productName = ((!isset($_POST['productName']) || trim($_POST['productName']) == '')? '': $_POST['productName']);
            $customerId = ((!isset($_POST['customerId']) || trim($_POST['customerId']) == '')? '': $_POST['customerId']);
            $customerName = ((!isset($_POST['customerName']) || trim($_POST['customerName']) == '')? '': $_POST['customerName']); 
            $lineId = ((!isset($_POST['lineId']) || trim($_POST['lineId']) == '')? '': $_POST['lineId']);        
            $facebook = ((!isset($_POST['facebook']) || trim($_POST['facebook']) == '')? '': $_POST['facebook']);        
            $telephone = ((!isset($_POST['telephone']) || trim($_POST['telephone']) == '')? '': $_POST['telephone']);        
            $transportDate = ((!isset($_POST['transportDate']) || trim($_POST['transportDate']) == '')? null: DateTime::createFromFormat('d/m/Y', $_POST['transportDate']));        
            $transportStatus = ((!isset($_POST['transportStatus']) || trim($_POST['transportStatus']) == '')? '': $_POST['transportStatus']);        
            $transferStatus = ((!isset($_POST['transferStatus']) || trim($_POST['transferStatus']) == '')? '': $_POST['transferStatus']);        
            $trackingNumber = ((!isset($_POST['trackingNumber']) || trim($_POST['trackingNumber']) == '')? '': $_POST['trackingNumber']);
            $contact =  ['telephone' => $telephone, 'lineId' => $lineId, 'facebook' => $facebook];        
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
                        $order = new ParseObject('Order');                    
                        $order->set('productId', $productId);
                        $order->set('productName', $productName);
                        $order->set('customerName', $customerName);
                        $order->set('customerId', $customerId);
                        $order->setAssociativeArray('contact', $contact);                       
                        $order->set('slipPayin', $imageFile);
                        $order->set('transportDate', $transportDate);
                        $order->set('address', $address);
                        $order->set('transportStatus', $transportStatus);
                        $order->set('transferStatus', $transferStatus);
                        $order->set('trackingNumber', $trackingNumber);                        
                        $order->save();                                                                
                }
            }
            else{
                $order = new ParseObject('Order');                    
                $order->set('productId', $productId);
                $order->set('productName', $productName);
                $order->set('customerName', $customerName);
                $order->set('customerId', $customerId);
                $order->setAssociativeArray('contact', $contact);                              
                $order->set('transportDate', $transportDate);
                $order->set('address', $address);
                $order->set('transportStatus', $transportStatus);
                $order->set('transferStatus', $transferStatus);
                $order->set('trackingNumber', $trackingNumber);                
                $order->save();  
            }
            Url::redirect('order');           
        }    
        $sidemenu = new ParseQuery('SideMenu');
        $result = $sidemenu->find();
        Hooks::addHook('js', 'Controllers\inventory\Order@JS');
        Hooks::addHook('css', 'Controllers\inventory\Order@CSS');
        $data['title'] = 'รายการสั่งซื้อสินค้า';
        $data['username'] = $currentUser->get('username');
        $data['sidemenu'] = $result;
        View::rendertemplate('header',$data);
        View::render('inventory/order',$data,$error);
        View::rendertemplate('footer',$data);
        }        
	}    
}