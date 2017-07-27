<?php require './connect.php'; ?> 
<?php require './header.php'; ?>  
<?php
$query = "";
$appez="";
if (isset($_SESSION["CurrentUser"]) && !empty($_SESSION["CurrentUser"]))
    $appez =" and not ID=" . $_SESSION["CurrentUser"]["ID"];

$query = "SELECT * FROM book b INNER JOIN author_id a ON b.Author_ID = a.Author_ID INNER JOIN sem_book sb ON b.Book_ID = sb.Book_ID INNER JOIN student s ON sb.Student_ID = s.ID". $appez;

if($_GET['filter']=="sell")
{
    $query = "SELECT * FROM book b INNER JOIN author_id a ON b.Author_ID = a.Author_ID INNER JOIN sem_book sb ON b.Book_ID = sb.Book_ID INNER JOIN student s ON sb.Student_ID = s.ID where sb.Trans_Type=1".$appez;
    
    $appex = "&filter=" . $_GET['filter'];
}
elseif($_GET['filter']=="buy")
{
    $query = "SELECT * FROM book b INNER JOIN author_id a ON b.Author_ID = a.Author_ID INNER JOIN sem_book sb ON b.Book_ID = sb.Book_ID INNER JOIN student s ON sb.Student_ID = s.ID where sb.Trans_Type=2".$appez;
    $appex = "&filter=" . $_GET['filter'];
}
if(isset($_GET['year']))
{
    $query .= " AND Semester='" . $_GET['year']."'";
    $appey = "&year=" . $_GET['year'];
}

    ?>
    <table>
    <tr>
    <td>
    <div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="width:160px;margin: 0 -15px;text-transform: capitalize;">
        <?php 
        if(isset($_GET['year']))
            echo str_replace("_"," ",$_GET['year']);
        else
            echo "Select Year";
        ?>
                
    <span class="caret"></span>
    </button>
        <ul class="dropdown-menu" style='margin: 0 -15px;'>
            <?php 
               $semqry = "SELECT DISTINCT Semester FROM sem_book";
                if ($stm = $mysqli->prepare($semqry))
                {
                    
                    $stm->execute();
                    // Extract result set and loop rows
                    $result = $stm->get_result();
                    while ($dat = $result->fetch_assoc())
                    {
                        echo "<li><a href='listbook.php?year=". $dat['Semester'] .$appex. "'>" . str_replace("_"," ", $dat['Semester']) . "</a></li>";
                    }
                    echo "<li class='divider'></li>";
                    echo "<li><a href='listbook.php";
                    if (isset($_GET['filter'])) 
                        echo "?filter=".$_GET['filter'];
                    echo "'>Clear</a></li>
                        ";
                }
            ?>
        </ul>
    </div>
    </td>
    <td style="padding-right:50px;"></td>
    <td>
    <div class="dropdown">
    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" style="width:160px;margin: 0 -15px;text-transform: capitalize;">
        
        <?php 
        if(isset($_GET['filter']))
            echo $_GET['filter'];
        else
            echo "Select Type";
        ?>
    <span class="caret"></span></button>
        <ul class="dropdown-menu" style='margin: 0 -15px;'>
             <li><a href="listbook.php?filter=buy<?php echo $appey?>">Buy</a>
             <li><a href="listbook.php?filter=sell<?php echo $appey?>">Sell</a>
             <li class='divider'></li>
             <li><a href='listbook.php<?php if (isset($_GET['year'])) echo "?year=".$_GET['year'];?>'>Clear</a></li>
             
        </ul>
    </div>
    </td>
    <td style="padding-right:50px;"></td>
    <td><a href="listbook.php">Clear</a></td>
    </tr>
    </table>
    <hr>
    <div  class="row" >   

            <?php 
            if ($stmt = $mysqli->prepare($query)) {
            /* execute query */
            $stmt->execute();
            // Extract result set and loop rows
            $result = $stmt->get_result();
            while ($data = $result->fetch_assoc()) { ?>
            <a href="bid.php?sbid=<?php echo $data['Sem_Book_ID'];?>" class="bidlink">
            <div class="panel panel-default">
                    <?php 
                        if($data["Trans_Type"]==1)
                        { 
                            $type= "SELLING";
                            $color = "#05f739";
                        }
                        elseif($data["Trans_Type"]==2){
                            $type= "BUYING";
                            $color = "#ff5541";
                        }
                    ?>
                    <div class="panel-heading"> <?php print $data["Title"]; ?></div>
                    <div class="panel-body">
                        <div style="float:right;color:#123456;padding: 0 4px;background-color:<?php echo $color;?>">
                              <?php echo $type;?>
                        </div>
                        <div> <label>First: <span><?php print $data["Author_First"]; ?></span></label> </div>
                        <div> <label>Last: <span><?php print $data["Author_Last"]; ?></span></label> </div>
                        <div> <label>Book Edition : <span><?php print $data["Book_Edition"]; ?></span></label> </div>
                        <div> <label>ISBN Number: <span><?php print $data["ISBN_Number"]; ?></span></label> </div>
                        <div> <label>Semester: <span><?php print str_replace("_"," ",$data["Semester"]); ?></span></label> </div>
                        <div> <label>Professor Name: <span><?php print $data["Professor_Name"]; ?></span></label> </div>
                        <div> <label>Student Name: <span><?php print $data["Full_Name"]; ?></span></label> </div>  
                        <div> <label>Email: <span><?php print $data["Email"]; ?></span></label> </div> 
                    </div>
                </div>
                </a>
            <?php } ?>
        </div>   

<?php } ?>
<?php require './footer.php'; ?>
