<?php
session_start();
#####################################################################
$ip = $_SERVER['REMOTE_ADDR'];
require("ipcheck.php");
if ($country !="US")	{

	  header('HTTP/1.1 500 Internal Server Error', true, 500);
	  exit;
   
}
###################################################################



// Include config file
require_once "connection.php";
 $nolog = 1;
// Define variables and initialize with empty values
$password = $confirm_password = $company = $firstname = $lastname = $email = $phone = "";
$password_err = $confirm_password_err = $company_err = $firstname_err = $lastname_err = $email_err = $phone_err = "";

// Processing form data when form is submitted
	$t = time();
	$r = rand(100,999);
	$newisp = $t.$r;
if($_SERVER["REQUEST_METHOD"] == "POST"){
	
 

		// Prepare a select statement
		$sql = "SELECT id FROM users WHERE username = ?";
		
		if($stmt = mysqli_prepare($conn, $sql)){
			// Bind variables to the prepared statement as parameters
			mysqli_stmt_bind_param($stmt, "s", $param_username);
			
			// Set parameters
			$param_username = $_SESSION["username"];
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				/* store result */
				mysqli_stmt_store_result($stmt);
				

			} else{
				echo "Oops! Something went wrong. Please try again later.";
			}

			// Close statement
			mysqli_stmt_close($stmt);
		}
	
   ##########################################################

	  

   
   ##########################################################
	if ((!empty($_POST["password"])) && (!empty($_POST["confirm_password"])))	{
		// Validate password
		if(strlen(trim($_POST["password"])) < 6){
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
		$usePw = 1;
	}else{
		$usePw = 0;
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
	$email = $_POST["email"];
	$phone = $_POST["phone"];
	$sms = $_POST["sms"];
	$timezone = $_POST["timezone"];
	
	
	if (empty($firstname))	{
		$firstname_err = "First Name cannot be blank.";
	}
	if (empty($lastname))	{
		$lastname_err = "Last Name cannot be blank.";
	}
	if (empty($phone))	{
		$phone_err = "Last Name cannot be blank.";
	}
	if (empty($email))	{
		$email_err = "Last Name cannot be blank.";
	}




	
	
	// Check input errors before inserting in database

	if(empty($password_err) && empty($confirm_password_err) && empty($email_err) && empty($firstname_err) && empty($lastname_err) && empty($phone_err)){
	if(empty($password_err) && empty($confirm_password_err)){

		
		// Prepare an insert statement - This creates an account for the ISP as well as the primary username.
		if ($usePw === 1)	{
			$sql = "UPDATE users SET password=?, first_name=?, last_name=?, email=?, phone=?, notifications=?, timezone=? WHERE username=?";
		}else{
			$sql = "UPDATE users SET first_name=?, last_name=?, email=?, phone=?, notifications=?, timezone=? WHERE username=?";
		}

		if($stmt = mysqli_prepare($conn, $sql)){
			// Bind variables to the prepared statement as parameters
			if ($usePw === 1)	{
				mysqli_stmt_bind_param($stmt, "sssssisi", $param_password, $firstname, $lastname, $email, $phone, $sms, $timezone, $param_username);
				$param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
			}else{
				mysqli_stmt_bind_param($stmt, "ssssisi", $firstname, $lastname, $email, $phone, $sms, $timezone, $param_username);
			}
			// Set parameters
			$param_username = $_SESSION["username"];
			
			
			// Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt)){
				// Redirect to login page
				#require ("confirm.php");
				#enter confirmation message here and exit.
	   
				?>
				<?php                
			} else{
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
$pagetitle = "Settings";
$curpage = 'settings';
$noConn = 1;
require ("head.php");



$sql="SELECT * FROM users WHERE username=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION["username"]]);
$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = null;

$firstname = $arr[0]["first_name"];
$lastname = $arr[0]["last_name"];
$email = $arr[0]["email"];
$phone = $arr[0]["phone"];
$sms = $arr[0]["notifications"];
 if ($sms == ""){$sms = 0;}
 $timezone = $arr[0]["timezone"];

$packages = json_decode($arr[0]["packages"],true);


if ($_SERVER["REQUEST_METHOD"] != "POST")	{

}else{
?>
	<div style="text-align:center; color:#fff; font-weight:bold;font-size:1.2rem;border:dotted 1px #ccc;background-color:#05a546;padding:20px;margin:20px auto;border-radius:10px;">
		Your profile information has been saved/updated.
		<div style="margin:15px auto 5px auto; width:200px;">
			<input type=button onclick="window.location.href='index.php';" value="Return To Main Page">
		</div>
	</div>
	
	
<?php	
}

?>
 


				
				
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="truckswrap" id="registerdiv" style="max-width:400px;margin:0 auto;">
					<div style="border: dotted 2px #aaa; border-radius:10px; padding:15px; margin-bottom:30px;background-color:#AFF2B4;">
						<h4 style="margin:0 0 10px 0;text-decoration:underline;">Your Current Packages</h3>
<?php
						$sql="SELECT * FROM activities";
						$stmt = $pdo->prepare($sql);
						$stmt->execute();
						$arr2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
						$stmt = null;
						foreach ($arr2 as $row2)	{
							echo "<div style=\"margin-bottom:10px;\">";
							if ((isset($packages[$row2["id"]])) && ($packages[$row2["id"]] > 0))	{
								echo "<span style=\"font-weight:bold;\">".$row2["name"].": </span>".$packages[$row2["id"]]." visits left.";
							}
							echo "</div>";
							
						}
?>						
					</div>
					<a href="memberwaiver.php">Sign Waiver</a>
					
					<div style="margin:20px 0;"><span style="font-weight:bold;">Username:</span> <?php echo $_SESSION["username"];?></div>
  
					<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
						<label>Password <span style="font-weight:normal;">(Leave blank for no changes.)</span></label>
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
				  
				  <div class="form-group <?php echo (!empty($phone_err)) ? 'has-error' : ''; ?>">
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
					<input type="submit" class="btn btn-primary" value="Save Changes">
		            <button type=button onclick="window.location.href='index.php';"  style="margin-top:15px;">Return To Main Page</button>
				</div>
				

				
			</form>
<?php
	require ("pagefoot.php");
