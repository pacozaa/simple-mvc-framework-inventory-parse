<?php
namespace Controllers;

use Core\View;
use Core\Controller;
use Helpers\Session;
use Helpers\Password;
use Helpers\Url;
use Helpers\Hooks;
use Parse\ParseObject;
use Parse\ParseUser;
use Parse\ParseException;


class Auth extends Controller{
	public function css(){
		echo '<link href="'.DIR.'app/templates/default/css/auth/login.css" rel="stylesheet" type="text/css">';
	}
	public function js(){
		echo '<script src="'.DIR.'app/templates/default/js/auth/login.js" type="text/javascript"></script>';
	}
	public function login(){	
		Hooks::addHook('js', 'Controllers\auth@js');
		Hooks::addHook('css', 'Controllers\auth@css');
		// if(Session::get('loggedin')){
  //           Url::redirect();
  //       }

		$currentUser = ParseUser::getCurrentUser();
		if ($currentUser) {
		    // do stuff with the user
		    Url::redirect();
		} else {
		    // show the signup or login page
		}
		//==============Sign Up Manually==========================
		// $user = new ParseUser();
		// $user->set("username", "yoak");
		// $user->set("password", "yoakyoak");
		// $user->set("email", "pacosarin@gmail.com");

		// // other fields can be set just like with ParseObject
		// $user->set("phone", "0909814465");

		// try {
		//   $user->signUp();
		//   // Hooray! Let them use the app now.
		//   $error = 'Hooray! Let them use the app now.';
		// } catch (ParseException $ex) {
		//   // Show the error message somewhere and let the user try again.
		//   echo "Error: " . $ex->getCode() . " " . $ex->getMessage();
		// }
		//==============Sign Up Manually==========================
		if(isset($_POST['submit'])){
			$username = $_POST['username'];
			$password = $_POST['password'];
			try {
			  $user = ParseUser::logIn($username, $password);
			  Url::redirect();
			  // Do stuff after successful login.
			} catch (ParseException $ex) {
			  // The login failed. Check error to see why.
				$error = "ParseException: " . $ex->getCode() . " " . $ex->getMessage();
			}
		}
		$data['title'] = 'Login';
		View::rendertemplate('header',$data);
		View::render('auth/login',$data,$error);
		View::rendertemplate('footer',$data);
	}
	public function logout(){
		// Session::destroy();
		ParseUser::logOut();
		Url::redirect();
	}
}

?>