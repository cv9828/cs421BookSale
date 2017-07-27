<?php
require './connect.php';
isLogOutGoToHome();
?> 
<?php require './header.php'; ?>

<?php
if($_GET['type']=='buy'){
$query = "SELECT * FROM book b INNER JOIN author_id a ON b.Author_ID = a.Author_ID"
        . " INNER JOIN sem_book sb ON b.Book_ID = sb.Book_ID INNER JOIN student s ON"
        . " sb.Student_ID = s.ID where sb.Trans_Type=1 and s.ID=" . $_SESSION["CurrentUser"]["ID"];
if ($stmt = $mysqli->prepare($query)) {
    /* execute query */
    $stmt->execute();
    // Extract result set and loop rows
    $result = $stmt->get_result();
    ?>
    <div  class="row" >   
    <h4>Buy</h4>
    <hr>

    <?php while ($data = $result->fetch_assoc()) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading"> <?php print $data["Title"]; ?></div>
                    <div class="panel-body">
                        <div> <label>Book Edition : <span><?php print $data["Book_Edition"]; ?></span></label> </div>
                        <div> <label>ISBN Number: <span><?php print $data["ISBN_Number"]; ?></span></label> </div>
                        <div> <label>Author First: <span><?php print $data["Author_First"]; ?></span></label> </div>
                        <div> <label>Author Last: <span><?php print $data["Author_Last"]; ?></span></label> </div>
                        <div> <label>Semester: <span><?php print $data["Semester"]; ?></span></label> </div>
                        <div> <label>Professor Name: <span><?php print $data["Professor_Name"]; ?></span></label> </div>
                        <div> <label>Student Name: <span><?php print $data["Full_Name"]; ?></span></label> </div>                   
                    </div>
                </div>
    <?php } ?>
        </div>   
    

<?php }} ?>

<?php
if($_GET['type']=='sell'){
$query = "SELECT * FROM book b INNER JOIN author_id a ON b.Author_ID = a.Author_ID"
        . " INNER JOIN sem_book sb ON b.Book_ID = sb.Book_ID INNER JOIN student s ON"
        . " sb.Student_ID = s.ID where sb.Trans_Type=2 and s.ID=" . $_SESSION["CurrentUser"]["ID"];
if ($stmt = $mysqli->prepare($query)) {
    /* execute query */
    $stmt->execute();
    // Extract result set and loop rows
    $result = $stmt->get_result();
    ?>
    <div  class="row" >   
    <h4>Sell</h4>
    <hr>
    <?php while ($data = $result->fetch_assoc()) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading"> <?php print $data["Title"]; ?></div>
                    <div class="panel-body">
                        <div> <label>Book Edition : <span><?php print $data["Book_Edition"]; ?></span></label> </div>
                        <div> <label>ISBN Number: <span><?php print $data["ISBN_Number"]; ?></span></label> </div>
                        <div> <label>Author First: <span><?php print $data["Author_First"]; ?></span></label> </div>
                        <div> <label>Author Last: <span><?php print $data["Author_Last"]; ?></span></label> </div>
                        <div> <label>Semester: <span><?php print $data["Semester"]; ?></span></label> </div>
                        <div> <label>Professor Name: <span><?php print $data["Professor_Name"]; ?></span></label> </div>
                        <div> <label>Student Name: <span><?php print $data["Full_Name"]; ?></span></label> </div>                   
                    </div>
                </div>
    <?php } ?>
        </div>   

<?php }} ?>

<?php
if(!isset($_GET['type'])){
$query = "SELECT * FROM book b INNER JOIN author_id a ON b.Author_ID = a.Author_ID"
        . " INNER JOIN sem_book sb ON b.Book_ID = sb.Book_ID INNER JOIN student s ON"
        . " sb.Student_ID = s.ID where sb.Trans_Type=1 and s.ID=" . $_SESSION["CurrentUser"]["ID"];
if ($stmt = $mysqli->prepare($query)) {
    /* execute query */
    $stmt->execute();
    // Extract result set and loop rows
    $result = $stmt->get_result();
    ?>
    <div  class="row" >   
    <h4>Buy</h4>
    <hr>
    <?php while ($data = $result->fetch_assoc()) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading"> <?php print $data["Title"]; ?></div>
                    <div class="panel-body">
                        <div> <label>Book Edition : <span><?php print $data["Book_Edition"]; ?></span></label> </div>
                        <div> <label>ISBN Number: <span><?php print $data["ISBN_Number"]; ?></span></label> </div>
                        <div> <label>Author First: <span><?php print $data["Author_First"]; ?></span></label> </div>
                        <div> <label>Author Last: <span><?php print $data["Author_Last"]; ?></span></label> </div>
                        <div> <label>Semester: <span><?php print $data["Semester"]; ?></span></label> </div>
                        <div> <label>Professor Name: <span><?php print $data["Professor_Name"]; ?></span></label> </div>
                        <div> <label>Student Name: <span><?php print $data["Full_Name"]; ?></span></label> </div>                   
                    </div>
                </div>
    <?php } ?>
        </div>   

<?php }
$query = "SELECT * FROM book b INNER JOIN author_id a ON b.Author_ID = a.Author_ID"
        . " INNER JOIN sem_book sb ON b.Book_ID = sb.Book_ID INNER JOIN student s ON"
        . " sb.Student_ID = s.ID where sb.Trans_Type=2 and s.ID=" . $_SESSION["CurrentUser"]["ID"];
if ($stmt = $mysqli->prepare($query)) {
    /* execute query */
    $stmt->execute();
    // Extract result set and loop rows
    $result = $stmt->get_result();
    ?>
    <div  class="row" >   
    <h4>Sell</h4>
    <hr>
    <?php while ($data = $result->fetch_assoc()) { ?>
                <div class="panel panel-default">
                    <div class="panel-heading"> <?php print $data["Title"]; ?></div>
                    <div class="panel-body">
                        <div> <label>Book Edition : <span><?php print $data["Book_Edition"]; ?></span></label> </div>
                        <div> <label>ISBN Number: <span><?php print $data["ISBN_Number"]; ?></span></label> </div>
                        <div> <label>Author First: <span><?php print $data["Author_First"]; ?></span></label> </div>
                        <div> <label>Author Last: <span><?php print $data["Author_Last"]; ?></span></label> </div>
                        <div> <label>Semester: <span><?php print $data["Semester"]; ?></span></label> </div>
                        <div> <label>Professor Name: <span><?php print $data["Professor_Name"]; ?></span></label> </div>
                        <div> <label>Student Name: <span><?php print $data["Full_Name"]; ?></span></label> </div>                   
                    </div>
                </div>
    <?php } ?>
        </div>   

<?php }} ?>

<?php require './footer.php'; ?>