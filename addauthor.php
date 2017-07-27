<?php
require './connect.php';
isLogOutGoToHome();
?> 
<?php
if (isset($_POST['Fname'])) {
    if (empty($_POST['Fname']) || empty($_POST['Lname'])) {
        $msgWarning = "All fields are required";
    } else {


        $query = "INSERT INTO `author_id`( `Author_First`, `Author_Last`)" .
                "  VALUES (?,?)";
        if ($stmt = $mysqli->prepare($query)) {

        /* bind parameters for markers */
        $Fname = $_POST['Fname'];
        $Lname = $_POST['Lname'];

        $stmt->bind_param("ss", $Fname, $Lname);
        /* execute query */
        $stmt->execute();

        if ($mysqli->insert_id > 0) {
            $msgSuccess = ' successfully';
        } else {
            $msgDanger = "Failed to add author,  try again";
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
    <h1>add new author </h1><br>
    <form  method="post" data-toggle="validator">

        <div class="form-group">
            <input type="name"  name="Fname" class="form-control" placeholder="Enter Author First" required> 
        </div>

        <div class="form-group">
            <input type="name"  name="Lname" class="form-control" placeholder="Enter Author Last" required> 
        </div>

        <input type="submit" name="login"   class="login loginmodal-submit" value="add author">
    </form>
</div>

<?php require './footer.php'; ?>

