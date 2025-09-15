<?php

#####################################################################
session_start();
if ($_SERVER["REQUEST_METHOD"] != "POST") {
   // Unset all of the session variables
   $_SESSION = array();
    
   // Destroy the session.
   session_destroy();
   
   // unset cookies
   if (isset($_SERVER['HTTP_COOKIE'])) {
       $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
       foreach($cookies as $cookie) {
           $parts = explode('=', $cookie);
           $name = trim($parts[0]);
           setcookie($name, '', time()-3600);
           setcookie($name, '', time()-3600, '/');
       }
   }
   
   setcookie('loggedin', "", time() - 3600);
   setcookie("access", "", time() - 3600);
}
$ip = $_SERVER['REMOTE_ADDR'];
require("ipcheck.php");
if (($country !="US") && ($country != "IL") && ($country != "DE"))	{

      header('HTTP/1.1 500 Internal Server Error', true, 500);
      exit;
   
}
###################################################################



// Include config file
require_once "connection.php";
 $nolog = 1;
// Define variables and initialize with empty values
$username = $password = $confirm_password = $company = $firstname = $lastname = $email = $phone = "";
$username_err = $password_err = $confirm_password_err = $company_err = $firstname_err = $lastname_err = $email_err = $phone_err = "";

// Processing form data when form is submitted
	$t = time();
	$r = rand(100,999);
	$newisp = $t.$r;
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
   ##########################################################

      

   
   ##########################################################
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
 #####Validate Email#####
     $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_err = "Invalid email format";
    }
     
     #######Validate Phone#####
     $phone = ($_POST["phone"]);
     //eliminate every char except 0-9
    $justNums = preg_replace("/[^0-9]/", '', $phone);
    
    //eliminate leading 1 if its there
    if (strlen($justNums) == 11) $justNums = preg_replace("/^1/", '',$justNums);
    
    //if we have 10 digits left, it's probably valid.
    if (strlen($justNums) != 10) {
       $phone_err = "Please enter a 10 digit phone number using the XXX-XXX-XXXX format.";
    }

###############VALIDATE Names and Company#############
	$firstname = ($_POST["firstname"]);
	$lastname = ($_POST["lastname"]);
      $phone = $_POST["phone"];
      $email = $_POST["email"];
      $sms = $_POST["sms"];
      if ($sms == ""){$sms = 0;}
      $timezone = $_POST["timezone"];;


	
	
	if (empty($firstname))	{
		$firstname_err = "First Name cannot be blank.";
	}
	if (empty($lastname))	{
		$lastname_err = "Last Name cannot be blank.";
	}




    
    
    // Check input errors before inserting in database

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($firstname_err) && empty($lastname_err) && empty($phone_err)){
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        
        // Prepare an insert statement - This creates an account for the ISP as well as the primary username.
        $sql = "INSERT INTO users (username, password, first_name, last_name, phone, email, notifications, timezone) VALUES (?,?,?,?,?,?,?,?)";

        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssssii", $param_username, $param_password, $firstname, $lastname, $phone, $email, $sms, $timezone);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
               $_SESSION["username"] = $username;
?>    
               <form id="waiver" action="waiver.php" method=post>   
                  <input type=hidden name="username" value="<?php echo $username;?>">               
               </form>
               <script>document.getElementById('waiver').submit();</script>
<?php       } else{
                echo "Something went wrong. Please try again later.";
            }
			
            // Close statement
            mysqli_stmt_close($stmt);
            $last_id = $conn->insert_id;
        }
        ######This adds the user to the user table.
 
        	
        
        
        
        
    }
    
    // Close connection
    mysqli_close($conn);

}
}
$pagetitle = "Register";
$curpage = 'register';
$noConn = 1;
require ("head.php");
?>
 


		        
		        
	        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
		        <div class="truckswrap" id="registerdiv" style="max-width:400px;margin:0 auto;">
		            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
		                <label>Username</label>
		                <input autocomplete="off" type="text" name="username" class="form-control" autocomplete="off" value="<?php echo $username; ?>">
		                <span class="help-block"><?php echo $username_err; ?></span>
		            </div>    
		            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
		                <label>Password</label>
		                <input autocomplete="off" type="password" name="password" class="form-control" value="<?php echo $password; ?>">
		                <span class="help-block"><?php echo $password_err; ?></span>
		            </div>
		            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
		                <label>Confirm Password</label>
		                <input autocomplete="off" type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
		                <span class="help-block"><?php echo $confirm_password_err; ?></span>
		            </div>
                  
                  <div class="form-group <?php echo (!empty($firstname_err)) ? 'has-error' : ''; ?>">
                      <label>First Name</label>
                      <input required type="text" name="firstname" class="form-control" value="<?php echo $firstname; ?>">
                      <span class="help-block"><?php echo $firstname_err; ?></span>
                  </div> 
                  <div class="form-group <?php echo (!empty($lastname_err)) ? 'has-error' : ''; ?>">
                      <label>Last Name</label>
                      <input required type="text" name="lastname" class="form-control" value="<?php echo $lastname; ?>">
                      <span class="help-block"><?php echo $lastname_err         ; ?></span>
                  </div> 
                  <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                      <label>Email Address</label>
                      <input required type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                      <span class="help-block"><?php echo $email_err; ?></span>
                  </div> 
                  <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
                      <label>Phone</label>
                      <input required type="tel" name="phone" class="form-control" value="<?php echo $phone; ?>">
                      <span class="help-block"><?php echo $phone_err; ?></span>
                  </div> 
                  <div class="form-group">
                        <label for="sms">Receive Text Message Notifications & Reminders</label>
                        <input id="sms" type="checkbox" name="sms" class="form-control" value="1" <?php if ($sms == 1){echo " checked";}?>>
                   </div>
                    
                  <div class="form-group" style="margin-top:20px;">
                        <label for="sms">Select Your Timezone</label>
                        <select name="timezone">
                           <option value="1"<?php if ($timezone == "1"){echo " selected";}?>>Eastern</option>
                           <option value="2"<?php if ($timezone == "2"){echo " selected";}?>>Central</option>
                           <option value="3"<?php if ($timezone == "3"){echo " selected";}?>>Mountain</option>
                           <option value="4"<?php if ($timezone == "4"){echo " selected";}?>>Arizona</option>
                           <option value="5"<?php if ($timezone == "5"){echo " selected";}?>>Pacific</option>
                        </select>

                  </div>
                    



		            
		        </div>	 
		                  	            
	            
	            <div class="form-group" style="max-width:400px;margin:0 auto;">
	                <input type="submit" class="btn btn-primary" value="Sign Up!">
<!--	                <input type="reset" class="btn btn-default" value="Reset">-->
	            </div>
	            
	        </form>
<?php
	require ("pagefoot.php");
