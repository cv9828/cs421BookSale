<?php
require './connect.php';
isLogOutGoToHome();
?> 

<?php
if (isset($_POST['title'])) {

    if (empty($_POST['title']) || empty($_POST['edition']) || empty($_POST['ISBN']) || empty($_POST['author'])) {
        $msgWarning = "All fields are required";
    } else {
        $title = $_POST['title'];
        $edition = $_POST['edition'];
        $ISBN = $_POST['ISBN'];
        $Author = $_POST['author'];



        $query = "INSERT INTO `book`(`Author_ID`, `Title`, `Book_Edition`, `ISBN_Number`)  " .
                " VALUES (?,?,?,?)";
        if ($stmt = $mysqli->prepare($query)) {

            /* bind parameters for markers */

            $stmt->bind_param("isis", $Author, $title, $edition, $ISBN);
            /* execute query */
            $stmt->execute();

            if ($mysqli->insert_id > 0) {
                $msgSuccess = "Your book has been successfully added";
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
    <h1>add new book</h1>
    <br>
    <form  method="post" data-toggle="validator">
        <div class="row border-bloc"> 
            <div class="col-sm-12">
				 <label> Title :</label>
                    <div class="form-group">
                        
                        
                            <input type="name"  name="title" class="form-control" placeholder="Enter Title" required> 
                        
                    </div>
                <style>
                    .border-bloc .form-group {
                        overflow: hidden;
                    }
                </style>
                
				<label> Author :</label>
                    <div class="form-group">

                        
                            <?php
                            $query = "select * from author_id;";
                            if ($stmt = $mysqli->prepare($query)) {

                                /* execute query */
                                $stmt->execute();
                                // Extract result set and loop rows
                                $result = $stmt->get_result();
                                $books = array();
                                ?>
                                <select name="author" class="form-control" placeholder="select author" required>
                                    <?php
                                    while ($data = $result->fetch_assoc()) {
                                        $books[] = $data;
                                        ?>
                                        <option value="<?php print $data["Author_ID"]; ?>"> <?php print $data["Author_First"]; ?> <?php print $data["Author_Last"]; ?> </option>
                                    <?php } ?>
                                </select>
                                <?php
                                $dataJson = json_encode($books);
                            }
                            ?>
							
                        <a href="addauthor.php">Add Author</a>
                    </div>
                
            </div>
            <div class="col-sm-12">
                
                    <div class="form-group">
                        <label> Edition :</label>
                            <input type="number"  name="edition" class="form-control" placeholder="Enter Edition" required>
                        
                    </div>
                
                
				 <label > ISBN :</label>
                    <div class="form-group">
            
                            <input type="name"  name="ISBN" class="form-control" placeholder="Enter ISBN" required> 
                        
                    </div>
                
            </div>
        </div>
        <input type="submit" name="login"   class="login loginmodal-submit" value="add book">
    </form>
</div>

<?php require './footer.php'; ?>

