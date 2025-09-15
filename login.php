<?php
#####################################################################
$ip = $_SERVER['REMOTE_ADDR'];
require("ipcheck.php");
if (($country !="US") && ($country != "IL") && ($country != "DE"))	{

        header('HTTP/1.1 500 Internal Server Error', true, 500);
        exit;
    
}
###################################################################
// Initialize the session
session_start();
$nolog = 1;
require ("connection.php");
function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'Kmphitech_Mk';
    $secret_iv = 'mk_secret_iv';
    // hash
    $key = hash('sha256', $secret_key);
    
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}


// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_COOKIE["loggedin"]) && ($_COOKIE["loggedin"] == "true" || $_COOKIE["loggedin"] == true)){
	$_SESSION["id"] = encrypt_decrypt('decrypt',$_COOKIE['id']);
    $_SESSION["username"] = encrypt_decrypt('decrypt',$_COOKIE['username']);    
    header("location: index.php");
    exit;
    
}
 $t = time();

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement

        $sql = "SELECT id, username, password, admin FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $admin);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            

                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            setcookie('loggedin', "true", time() + (86400 * 30), "/");

                            $_SESSION["id"] = $id;
                            setcookie('id', encrypt_decrypt('encrypt',$id), time() + (86400 * 30), "/");
                            $_SESSION["username"] = $username;    
                           	setcookie('username', encrypt_decrypt('encrypt',$username), time() + (86400 * 30), "/");


                            
                            // Redirect user to welcome page
                            if ($admin == 1)    {
                                $_SESSION["admin"] = 1;
                                header("location: admin.php");
                            }else{
                                $_SESSION["admin"] = 0;
                                header("location: index.php");
                            }
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                            
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No account found with that username.";
                    
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
                
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }else{
            #echo "<div style='position:absolute; z-index:999; background:#ff0000; color:#fff; width:200px; height:200px;'></div>";
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
$pagetitle = "Login";
$curpage = 'login';
$noConn = 1;
require ("head.php");

        if ($_GET["login"] == "1")    {?> 
            <div style="text-align:center; color:#fff; font-weight:bold;font-size:1.2rem;border:dotted 1px #ccc;background-color:#05a546;padding:20px;margin:20px auto;border-radius:10px;">
                Thank You for registering.  Please login now to begin using the system.
            </div>
<?php   }?>
		 	<div class="truckswrap" style="max-width:400px; margin:0 auto;">
		        <h3 class="twh">Login</h3>
		        <form action="login.php" method="post">
		            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
		                <label>Username</label>
		                <input id="USERNAME" type="text" name="username" class="form-control" value="<?php echo $username; ?>">
		                <span class="help-block"><?php echo $username_err; ?></span>
		            </div>    
		            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
		                <label>Password</label>
		                <input id="PASSWORD" type="password" name="password" class="form-control">
		                <span class="help-block"><?php echo $password_err; ?></span>
		            </div>
		            <div class="form-group">
		                <input type="submit" class="btn btn-primary" value="Login">
		            </div>
		            
		        </form>
		 
		        
	        

 
            </div>
            <div class="form-group" style="max-width:400px;margin:20px auto 0 auto;text-align:center; font-weight:bold;">
                Don't have an account?
                <input type="button" class="btn btn-primary" value="Register" onclick="window.location.href='register.php';">
            </div>
            
                    </div> <!-- /content -->
                
                
            <?php #	<div style="margin-bottom:50px; font-size:.8rem;">Powered by <a target="_blank" href="https://supremecoding.com">Supreme Coding</a></div> ?>
            
                </div><!-- /page -->
                
                 </body>
                 </html>