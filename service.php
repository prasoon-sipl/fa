<?php 
/* connect to the db */
	$link = mysqli_connect('localhost','root','') or die('Cannot connect to the DB');
	$db_conn = mysqli_select_db($link, 'db_socialapp') or die('Cannot select the DB');

/* Grab posted values */
$request = file_get_contents("php://input"); // gets the raw data
$data = json_decode($request, true);  // (other way $x = json_decode($_GET['x']);)
$user_id = isset($data['user_id']) ? mysql_real_escape_string($data['user_id']) :  "";
$user_post = isset($data['user_post']) ? mysql_real_escape_string($data['user_post']) :  "";
$username = isset($data['username']) ? mysql_real_escape_string($data['username']) :  "";
$password = isset($data['password']) ? mysql_real_escape_string(md5($data['password'])) :  "";
$firstname = isset($data['firstname']) ? mysql_real_escape_string($data['firstname']) :  "";
$lastname = isset($data['lastname']) ? mysql_real_escape_string($data['lastname']) :  "";
$message_to = isset($data['message_to']) ? mysql_real_escape_string($data['message_to']) :  "";
$message_by = isset($data['message_by']) ? mysql_real_escape_string($data['message_by']) :  "";
$message_body = isset($data['message_body']) ? mysql_real_escape_string($data['message_body']) :  "";

/* Set header type */
header('Content-type: application/json');

/* Action based switching */
switch($data['action'])
{

  case 'addpost': addPost($user_id,$user_post);
                  break;
  case 'getpost': getAllPosts();
                  break;
  case 'authenticateuser': authenticateUser($username, $password);
                  break;
  case 'registeruser': registerUser($username, $password, $firstname, $lastname);
                  break;  

 case 'sendmessage': sendMessage($message_to,$message_by,$message_body);
                      break;

  case 'getallusers': getAllUsers();
                      break;                
                  
  default: 'Access prohibited';
}

		

function addPost($user_id,$user_post)
{
    /* Using global db variable*/
	global $db_conn;
	global$link;

	/* grab the posts from the db */
	$query = "insert into tbl_posts (user_id, post) values ('".$user_id."', '".$user_post."')";

	if(mysql_query($query,$link))
	{
	  getAllPosts();
	}

	else
	{
	  echo json_encode(array('status_message' => 'failure'));
	}
	
}

	function getAllPosts()
	{
   /* Using global db variable*/
	global $db_conn;
	global$link;

   /* grab the posts from the db */
	$query = "SELECT * FROM tbl_posts ORDER BY posted_time DESC LIMIT 10";
	$result = mysql_query($query,$link) or die('Errant query:  '.$query);

	/* create one master array of the records */
	$posts = array();
	if(mysql_num_rows($result)) {
		while($post = mysql_fetch_assoc($result)) {
			$posts[] = $post;
		}
		
	echo json_encode(array('status_message' => 'success','post_result' => $posts));
	}
	}

	function getAllMessages()
	{
   /* Using global db variable*/
	global $db_conn;
	global$link;

   /* grab the posts from the db */
	$query = "SELECT * FROM tbl_messages ORDER BY posted_time DESC LIMIT 10";
	$result = mysql_query($query,$link) or die('Errant query:  '.$query);

	/* create one master array of the records */
	$posts = array();
	if(mysql_num_rows($result)) {
		while($post = mysql_fetch_assoc($result)) {
			$posts[] = $post;
		}
		
	echo json_encode(array('status_message' => 'success','post_result' => $posts));
	}

}

/**
	 * Function          :- authenticateUser
	 * Decription        :- It is used for the authenticate user
	 * @return           :- [json]
	 */

	function authenticateUser($username, $password){ 
		/* Using global db variable*/	
		global $db_conn;
		global$link;
		/* Grab the form inputs */
		/*$username = trim($_POST['username']);
		$password = trim($_POST['password']);*/
		/* Checking in the database */
		$query = "SELECT user_id, username, password FROM tbl_users WHERE username = '$username' AND password = '$password'";
		$result = mysqli_query($link, $query) or die('Errant query:  '.$query);
		//if(mysql_num_rows($result)) {
			$data = mysqli_fetch_assoc($result);
			//print_r($data);die('test');
			if($data){
				echo json_encode(array('status_message' => 'success','post_result' => $data));
			}else{
				echo json_encode(array('status_message' => 'failure','post_result' => 'Username or password does not match'));
			}
		//}


	}


	/**
	 * Function          :- registerUser
	 * Decription        :- It is used for registering user
	 * @return           :- [json]
	 */

	function registerUser($username, $password, $firstname, $lastname){

		/* Using global db variable*/	
		global $db_conn;
		global$link;

		/* Checking in the database */
		$query = "INSERT INTO tbl_users(username, password, first_name, last_name, is_active, created_Date) VALUES('".$username."', '".$password."', '".$firstname."', '".$lastname."', '1', '".date('Y-m-d h:i:s')."')";
		$result = mysql_query($query,$link) or die('Errant query:  '.$query);		
		if($result){
			echo json_encode(array('status_message' => 'success','post_result' => 'You have successfully registered'));
		}else{
			echo json_encode(array('status_message' => 'failure','post_result' => 'Oops some error occured'));
		}
	}


function getAllUsers()
{
   /* Using global db variable*/
	global $db_conn;
	global$link;

   /* grab the posts from the db */
	$query = "SELECT * FROM tbl_users ORDER BY first_name, last_name ASC";
	$result = mysql_query($query,$link) or die('Errant query:  '.$query);

	/* create one master array of the records */
	$users = array();
	if(mysql_num_rows($result)) {
		while($user = mysql_fetch_assoc($result)) {
			$users[] = $user;
		}
		
	echo json_encode(array('status_message' => 'success','user_result' => $users));
	}
}


function sendMessage($message_to,$message_by, $message_body)
{
   /* Using global db variable*/
	global $db_conn;
	global$link;

	/* Add the message into db*/
	echo $query = "insert into tbl_messages (sent_by, sent_to, message) values ('".$message_by."', '".$message_to."', '".$message_body."')";

	if(mysql_query($query,$link))
	{
	  echo json_encode(array('status_message' => 'Message Sent Successfully !!!'));
    }
	else
	{
	  echo json_encode(array('status_message' => 'Error Sending Message !!!'));
	}
}
?>

