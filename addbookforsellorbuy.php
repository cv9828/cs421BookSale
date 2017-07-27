<?php
require './connect.php';
isLogOutGoToHome();
?> 

<?php
if (isset($_POST['book'])) {

    if (empty($_POST['book']) || empty($_POST['course']) || empty($_POST['type']) || empty($_POST['semester']) || empty($_POST['prof'])) {
        $msgWarning = "All fields are required";
    } else {
        $book = $_POST['book'];
        $course = $_POST['course'];
        $semester = $_POST['semester'];
        $prof = $_POST['prof'];
        $type = $_POST['type'];


        $query = "INSERT INTO `sem_book`(`Course_ID`, `Book_ID`, `Student_ID`, `Semester`, `Professor_Name`, `Trans_Type`, `Time`)  " .
                " VALUES (?,?,?,?,?,?,?)";
        if ($stmtb = $mysqli->prepare($query)) {

            /* bind parameters for markers */
            $student_id = $_SESSION["CurrentUser"]["ID"];

            $time = date('Y-m-d h:i');

            $stmtb->bind_param("iiissis", $course, $book, $student_id, $semester, $prof, $type, $time);
            /* execute query */
            $stmtb->execute();

            if ($mysqli->insert_id > 0) {
                $msgSuccess = "Your offer has been successfully added";
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
    <h1>add new Book for sell or buy</h1><br>
    <form  method="post" data-toggle="validator">

        <div class="row border-bloc"> 
            <div class="col-sm-12">
                
                    <div class="form-group">
                        <label> Select book:</label>

<?php
$query = "SELECT * FROM book b inner join author_id ai on b.Author_ID= ai.Author_ID;";
if ($stmt = $mysqli->prepare($query)) {

    /* execute query */
    $stmt->execute();
    // Extract result set and loop rows
    $result = $stmt->get_result();
    $books = array();
    ?>
                            <select name="book"  onchange="bookChanged(this);" class="form-control" placeholder="select book" required>
                            <?php
                            while ($data = $result->fetch_assoc()) {
                                $books[] = $data;
                                ?>
                                    <option value="<?php print $data["Book_ID"]; ?>"> <?php print $data["Title"]; ?> </option>
                                <?php } ?>
                            </select>
                                <?php
                                $dataJson = json_encode($books);
                            }
                            ?>
                        <a href="addbook.php">Add Book</a>
                    </div>
                
            </div>
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label> Edition : <span id="edition" class="label-value"> </span> </label> 
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label> ISBN : <span id="isbn" class="label-value"> </span> </label> 
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label> First : <span id="firstauthor" class="label-value "> </span> </label> 

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label> Last : <span id="lastauthor" class="label-value"> </span> </label> 

                    </div>
                </div>
            </div>
        </div>

        <div class="row border-bloc"> 
            <div class="col-sm-12">
                
                    <div class="form-group">
                        <label>Course</label>
<?php
$query = "select Course_ID,`Course_Name` from `course`";
if ($stmt = $mysqli->prepare($query)) {

    /* execute query */
    $stmt->execute();
    // Extract result set and loop rows
    $result = $stmt->get_result();
    ?>
                            <select  name="course" class="form-control" placeholder="Enter Title" required>
                            <?php while ($data = $result->fetch_assoc()) { ?>
                                    <option value="<?php print $data["Course_ID"]; ?>"> <?php print $data["Course_Name"]; ?> </option>
                                <?php } ?>
                            </select>
                            <?php } ?>
                        <a href="addcourse.php">Add Course</a>
                    </div>
                
                
                    <div class="form-group">
                        <label>Semester</label>
                        <select  name="semester" class="form-control" placeholder="Enter Title" required>
                            <option value="FALL_2017">FALL 2017</option>                                   
                            <option value="SPRING_2017">SPRING 2017</option>
                        </select>
                    </div>
                
            </div>
            <div class="col-sm-12">
                
                    <div class="form-group">
                        <label>Professor Name</label>
                        <input type="name"  name="prof" class="form-control" placeholder="Enter Name" required> 
                    </div>
                
                
                    <div class="form-group">
                        <label>Looking to Sell or Buy?</label>
                        <select  name="type" class="form-control" placeholder="Sell or Request" required>
                            <option value="1"> Sell</option>                                   
                            <option value="2"> Buy</option>
                        </select>
                    </div>
                
            </div>
        </div>
        <input type="submit" name="login"   class="login loginmodal-submit" value="Add">
    </form>
</div>
<script>
    var books =<?php print $dataJson; ?>;
    function bookChanged(element) {
        var id = $(element).val();
        var selectedbook = $.grep(books, function (e) {
            return e.Book_ID == id;
        });
        selectedbook = selectedbook[0];
        $("#lastauthor").text(selectedbook.Author_Last);
        $("#firstauthor").text(selectedbook.Author_First);
        $("#isbn").text(selectedbook.ISBN_Number);
        $("#edition").text(selectedbook.Book_Edition);
    }

    $(document).ready(function () {

        bookChanged($('[name="book"]'));
    });
</script>
<?php require './footer.php'; ?>
