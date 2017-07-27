<!--
        File: login.php
        Page where user logs into website 
-->
<?php
// connect to database
require_once 'connect.php';
isLoginGoToHome();
if (isset($_POST['token'])) {
    if ($_POST['token'] != $token) {
        $msgDanger = "Failed to login, refresh page, and try again";
    } else {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $msgWarning = "All fields are required";
        } else {
            $password = md5($_POST['password']); 
			/* $password = password_hash($_POST['password'], PASSWORD_BCRYPT, array('cost' => 10)); */
            $email = $_POST['email'];

            $query = "select ID,Full_Name from `student` where Email=? and Password=?";
            if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param("ss", $email, $password);
                /* execute query */
                $stmt->execute();
                // Extract result set and loop rows
                $result = $stmt->get_result();
                if ($data = $result->fetch_assoc()) {
                    $CurrentUser = array("ID" => $data["ID"], "Name" => $data["Full_Name"]);
                    $_SESSION["CurrentUser"] = $CurrentUser;
                    isLoginGoToHome();
                } else {
                    $msgDanger = "Failed to login, refresh page, and try again";
                }
            } else {
                $msgWarning = "The operation was not performed due to a technical error";
            }
            /* close statement */
            $stmt->close();
            /* close connection */
            $mysqli->close();
        }
    }
}
?> 

<?php require './header.php'; ?>  

<?php if (!empty($msgSuccess)) { ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> <?php print $msgSuccess; ?>.
    </div>
<?php } ?>
<?php if (!empty($msgInfo)) { ?>
    <div class="alert alert-info">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Info!</strong>  <?php print $msgInfo; ?>.
    </div>
<?php } ?>
<?php if (!empty($msgWarning)) { ?>
    <div class="alert alert-warning">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Warning!</strong> <?php print $msgWarning; ?>.
    </div>
<?php } ?>
<?php if (!empty($msgDanger)) { ?>
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Danger!</strong> <?php print $msgDanger; ?>.
    </div>
<?php } ?>

<div class="loginmodal-container">
    <h1>Welcome to the Application Portal </h1><br>
    <form  method="post" data-toggle="validator">
        <!-- CSRF token -->
        <input type="hidden" name="token" value="<?php echo $token; ?>" />
        <div class="form-group">
            <input type="email"  name="email" class="form-control" placeholder="Email Address" required> 
        
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <input type="submit" name="login"   class="login loginmodal-submit" value="Login">
    </form>

    <div class="login-help">
        <a href="register.php">Register</a> - <a href="#">Forgot Password</a>
    </div>
</div>

<?php require './footer.php'; ?>

