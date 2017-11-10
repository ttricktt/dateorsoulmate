<?

function register($username, $email, $passwd)

// register new person with db

// return true or error message

{

// connect to db

$conn = mysql_pconnect("server","database","password");

mysql_select_db("database");

if (!$conn)

return "Could not connect to database server - please try later.";



// check if username is unique 

  $result = mysql_query("select * from register where username='$username' or email='$email'"); 

  if (!$result)

     return "Could not execute query";

  if (mysql_num_rows($result)>0) 

     return "<td>"

			."<font color=red>That username or email is taken.<br>"

			."Press your browsers back button and try again</font>"

			."</td>";



 // if ok, put in db

  $result = mysql_query ("insert into register set

  		username='$username', passwd='$passwd', email='$email'");

	  

  if (!$result)

      return "Could not register you  in database - please try again later.";



  return true;

}





function login($username, $passwd)

// check username and password with db

// if yes, return true

// else return false

{

  // connect to db server

  //$conn = db_connect();

 

  //if (!$conn) (echo "Error: Could not connect to database.");

  if (!$conn)

    return 0;

// Select database to use.	

mysql_select_db('database', $conn)

or die ("Error:db");



// Get username and password

  $result = mysql_query("select * from register 

                         where username='$username'

                         and passwd='$passwd'");

	

  if (!$result)

     return 0;

  

  if (mysql_num_rows($result)>0){

  	global $valid_id;	

  	$logid = mysql_fetch_array($result);

	$valid_id = $logid["id"];

	

	//echo $logged_in_userid;

	//exit;

     return 1;

  }else{ 

     return 0;}

}



function check_valid_user()

// see if somebody is logged in and notify them if not

{

	global $valid_user;

	//global $valid_id;

	if (session_is_registered("valid_user"))

	{

		//echo "logged in as $valid_user.<br>";

		//echo "valid id is $valid_id";

		//echo "<br><br>";

	}

	else

	{

		// they are not logged in

		echo "You are not logged in!<br>";

		exit;

		

	}

}

?>