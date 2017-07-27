 

<?php
// connect to database
require_once 'connect.php';

isLoginGoToHome();
if (isset($_POST['token'])) {
    if ($_POST['token'] != $token) {
        $msg = "Failed to register, refresh page, and try again";
    } else {
        if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['Confirm']) || empty($_POST['tel'])) {
            $msg = "All fields are required";
        } else {
            if ($_POST['password'] != $_POST['Confirm']) {
                $msg = "Passwords do not match";
            } else {
                try {
                    $query = "select ID from student where Email=?";
                    /* create a prepared statement */
                    if ($stmt = $mysqli->prepare($query)) {

                        /* bind parameters for markers */
                        $stmt->bind_param("s", $_POST['email']);

                        /* execute query */
                        $stmt->execute();

                        /* store result */
                        $stmt->store_result();


                        if ($stmt->num_rows > 0) {
                            $msg = "There is a user with this email already";
                        } else {
                            
                            //empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['Confirm']
                            $query = "INSERT INTO `student`(`Full_Name`, `Email`, `Password`, `Phone_Num`, `Sign_up_date`)" .
                                    " VALUES (?,?,?,?,?)";
                            if ($stmt = $mysqli->prepare($query)) {
								// Hash password 
								// creates a new password hash using a strong one-way hashing algorithm. password_hash() is compatible with crypt(). 
								// Therefore, password hashes created by crypt() can be used with password_hash().
								// http://php.net/manual/en/function.password-hash.php
								$password = md5($_POST['password']); 
								/* $password = password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost' => 10)); */
                                /* bind parameters for markers */
                                $name = $_POST['name'];
                                $email = $_POST['email'];
                                $tel = $_POST['tel'];
                                $signdate = date("Y-m-d");
                                $stmt->bind_param("sssss", $name, $email, $password, $tel, $signdate);
                                /* execute query */
                                $stmt->execute();

                               if ($mysqli->insert_id > 0) {
                                    $CurrentUser = array("ID" => $data["ID"], "Name" => $data["Full_Name"]);
                                    $_SESSION["CurrentUser"] = $CurrentUser;
                                    isLoginGoToHome();
                                } else {
                                    $msg = "Failed to register.";
                                }
                            } else {
                                $msg = "The operation was not performed due to a technical error";
                            }
                        }
                    } else {
                        $msg = "The operation was not performed due to a technical error";
                    }
                    /* close statement */
                    $stmt->close();
                    /* close connection */
                    $mysqli->close();
                } catch (Exception $e) {
                    $msg = "The operation was not performed due to a technical error";
                }
            }
        }
    }
}
?>

<?php require './header.php'; ?> 


<div class="loginmodal-container">
    <?php echo $msg;
    ?>
    <h1>Welcome to the Application Portal </h1><br>
    <form  method="post" data-toggle="validator">
        <!-- CSRF token -->
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <div class="form-group">
            <input type="name"  name="name" class="form-control" placeholder="Enter name" required> 
        
            <input type="email"  name="email" class="form-control" placeholder="Enter email address" required> 
       
            <input type="tel"  name="tel" class="form-control" onKeyPress="if(this.value.length==10) return false;" min="0"placeholder="Enter phone number" required> 
        
            <input type="password" name="password" id="inputPassword" data-minlength="6" class="form-control" placeholder="Enter password" required>
            <div class="help-block">Minimum of 6 characters</div>

            <input type="password" name="Confirm" data-match="#inputPassword" data-match-error="Whoops, these don't match" class="form-control" placeholder="Confirm password" required>
        </div>
        <input type="submit" name="login"   class="login loginmodal-submit" value="Register">
    </form>

    <div class="login-help">
        <label> Already registered : <a href="login.php"> Login </a> </label>
    </div>
</div>


<?php require './footer.php'; ?>