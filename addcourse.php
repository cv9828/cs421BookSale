<?php
require './connect.php';
isLogOutGoToHome();
?> 
<?php
if (isset($_POST['name'])) {
    if (empty($_POST['name']) || empty($_POST['alpha'])) {
        $msgWarning = "All fields are required";
    } else {


        $query = "INSERT INTO `course`( `Course_Name`, `Alpha_Num`)" .
                "  VALUES (?,?)";
        if ($stmt = $mysqli->prepare($query)) {

        /* bind parameters for markers */
        $name = $_POST['name'];
        $alpha = $_POST['alpha'];

        $stmt->bind_param("ss", $name, $alpha);
        /* execute query */
        $stmt->execute();

        if ($mysqli->insert_id > 0) {
            $msgSuccess = ' successfully';
        } else {
            $msgDanger = "Failed to add course,  try again";
        }
        } else {
        $msgWarning = "The operation was not performed due to a technical error";
        }
    }
}
?>


<?php require './header.php'; ?>  
<?php if (!empty($msgSuccess)) { ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>Success!</strong> <?php print $msgSuccess; ?>.
        <br />
        
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
<div class="loginmodal-container Book-form">
    <h1>add new course </h1><br>
    <form  method="post" data-toggle="validator">

        <div class="form-group">
            <input type="name"  name="name" class="form-control" placeholder="Enter Course name" required> 
        </div>

        <div class="form-group">
            <input type="text"  name="alpha" class="form-control" placeholder="Enter alpha" required> 
        </div>

        <input type="submit" name="login"   class="login loginmodal-submit" value="add course">
    </form>
</div>

<?php require './footer.php'; ?>

