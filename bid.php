<?php
require_once 'connect.php';
isLogOutGoToHome();
?>

<?php require './header.php'; ?>  
<?php

if (isset($_GET['sbid'])) {
    
    if (!empty($_POST['amount'])) {
        
        $Ammount = $_POST['amount'];
        $sbId = $_GET['sbid'];


        $query = "INSERT INTO `bid` ( `Student_ID`, `Sem_Book_ID`, `Bid_Ammount`,Bid_Accepted) VALUES"
                . " ( ?, ?, ?, 0);";
        if ($stmt = $mysqli->prepare($query)) {

            /* bind parameters for markers */
            $student_id = $_SESSION["CurrentUser"]["ID"];
            $stmt->bind_param("iid", $student_id, $sbId, $Ammount);
            /* execute query */
            $stmt->execute();

            if ($mysqli->insert_id > 0) {
                echo  '<div class="alert alert-success">
                        <strong>Bid Placed</strong><br />
                        Your bid was placed.
                        </div>';
            }
        } else {
            echo '<div class="alert alert-danger">
                        <strong>Bid Failed</strong><br />
                        Your bid was not placed.
                    </div>';
        }
    }
    else
    {
        echo '
                <div class="loginmodal-container Book-form">
                    <h1>Order offer </h1><br>
                    <form  method="post" data-toggle="validator">
                        <div class="row border-bloc"> 
                            <div class="col-sm-12">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <input type="number"  name="amount" class="form-control" placeholder="Enter Ammount" required> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <input type="submit" name="login"   class="login loginmodal-submit" value="Send Offer">
                    </form>
                </div>';
    }
}
else
{
?>
<div  class="row" > 
    <!--<h4>Offers</h4><hr>-->
    
    <?php 
    $x=1;
    $qry = "SELECT * FROM book b INNER JOIN author_id a ON b.Author_ID = a.Author_ID INNER JOIN sem_book sb ON b.Book_ID = sb.Book_ID INNER JOIN student s ON sb.Student_ID = s.ID INNER JOIN bid bb ON sb.Sem_Book_ID = bb.Sem_Book_ID INNER JOIN student ss ON ss.ID=bb.Student_ID where sb.Trans_Type=1 and s.ID=". $_SESSION["CurrentUser"]["ID"]. "";
    
    if ($stmt = $mysqli->prepare($qry)) {
        /* execute query */
        $stmt->execute();
        // Extract result set and loop rows
        $result = $stmt->get_result();
        $y=0;
        while ($data = $result->fetch_assoc()) { 
            $x=0;
            if($y==0){
                echo "<h5>These bidder(s) want to buy the book you're selling.</h5><hr>";
                $y=1;
            }
            ?>
            <div class="alert alert-info" role="alert">
                <div> <label>Bidder: <span><?php print $data["Full_Name"]; ?></span></label> </div>
                <div> <label>Bidder's Email: <span><?php print $data["Email"]; ?></span></label> </div>
                <div> <label>Book: <span><?php print $data["Title"]; ?></span></label> </div>
                <div> <label>Bid Amount: <span>$ <?php print $data["Bid_Ammount"]; ?></span></label> </div>
                <div> <label>Phone: <span><?php print "(".substr($data["Phone_Num"], 0, 3).") ".substr($data["Phone_Num"], 3, 3)."-".substr($data["Phone_Num"],6); ?></span></label> </div>
            </div>
            <?php
        }
    }
    echo "";
    
    $qry = "SELECT * FROM book b INNER JOIN author_id a ON b.Author_ID = a.Author_ID INNER JOIN sem_book sb ON b.Book_ID = sb.Book_ID INNER JOIN student s ON sb.Student_ID = s.ID INNER JOIN bid bb ON sb.Sem_Book_ID = bb.Sem_Book_ID INNER JOIN student ss ON ss.ID=bb.Student_ID where sb.Trans_Type=2 and s.ID=". $_SESSION["CurrentUser"]["ID"]. "";
    
    if ($stmt = $mysqli->prepare($qry)) {
        /* execute query */
        $stmt->execute();
        // Extract result set and loop rows
        $result = $stmt->get_result();
        $y=0;
        while ($data = $result->fetch_assoc()) { 
            $x=0;
            if($y==0){
                echo "<h5>These seller(s) want to sell you the book you wanted.</h5><hr>";
                $y=1;
            }
            ?>
            <div class="alert alert-info" role="alert">
                <div> <label>Seller: <span><?php print $data["Full_Name"]; ?></span></label> </div>
                <div> <label>Seller's Email: <span><?php print $data["Email"]; ?></span></label> </div>
                <div> <label>Book: <span><?php print $data["Title"]; ?></span></label> </div>
                <div> <label>Bid Amount: <span>$ <?php print $data["Bid_Ammount"]; ?></span></label> </div>
                <div> <label>Phone: <span><?php print "(".substr($data["Phone_Num"], 0, 3).") ".substr($data["Phone_Num"], 3, 3)."-".substr($data["Phone_Num"],6); ?></span></label> </div>
            </div>
            <?php
        }
    }
    if($x==1)
        echo '<div class="alert alert-warning">
                    <strong>No offers</strong><br />
                    You do not have offers to buy your books.
                </div>';
    ?>
    
    <!--<h4>Bids</h4><hr>-->
    
    <?php 
    $x=1;
    $qry = "SELECT s.Full_Name, s.Email, Title, s.Phone_Num, bb.Bid_Ammount FROM book b INNER JOIN author_id a ON b.Author_ID = a.Author_ID INNER JOIN sem_book sb ON b.Book_ID = sb.Book_ID INNER JOIN student s ON sb.Student_ID = s.ID INNER JOIN bid bb ON sb.Sem_Book_ID = bb.Sem_Book_ID INNER JOIN student ss ON ss.ID=bb.Student_ID where sb.Trans_Type=1 and bb.Student_ID=". $_SESSION["CurrentUser"]["ID"]. "";
    
    if ($stmt = $mysqli->prepare($qry)) {
        /* execute query */
        $stmt->execute();
        // Extract result set and loop rows
        $result = $stmt->get_result();
        
        $y=0;
        while ($data = $result->fetch_assoc()) { 
            $x=0;
            if($y==0){
                echo "<h5>You wanted to buy from these sellers</h5><hr>";
                $y=1;
            }
            ?>
            <div class="alert alert-info" role="alert">
                <div> <label>Seller: <span><?php print $data["Full_Name"]; ?></span></label> </div>
                <div> <label>Seller's Email: <span><?php print $data["Email"]; ?></span></label> </div>
                <div> <label>Book: <span><?php print $data["Title"]; ?></span></label> </div>
                <div> <label>Bid Amount: <span>$ <?php print $data["Bid_Ammount"]; ?></span></label> </div>
                <div> <label>Phone: <span><?php print "(".substr($data["Phone_Num"], 0, 3).") ".substr($data["Phone_Num"], 3, 3)."-".substr($data["Phone_Num"],6); ?></span></label> </div>
            </div>
            <?php
        }
        
    }
     echo "";
    $qry = "SELECT s.Full_Name, s.Email, Title, s.Phone_Num, bb.Bid_Ammount FROM book b INNER JOIN author_id a ON b.Author_ID = a.Author_ID INNER JOIN sem_book sb ON b.Book_ID = sb.Book_ID INNER JOIN student s ON sb.Student_ID = s.ID INNER JOIN bid bb ON sb.Sem_Book_ID = bb.Sem_Book_ID INNER JOIN student ss ON ss.ID=bb.Student_ID where sb.Trans_Type=2 and bb.Student_ID=". $_SESSION["CurrentUser"]["ID"]. "";
    
    if ($stmt = $mysqli->prepare($qry)) {
        /* execute query */
        $stmt->execute();
        // Extract result set and loop rows
        $result = $stmt->get_result();
        
        $y=0;
        while ($data = $result->fetch_assoc()) { 
            $x=0;
            if($y==0){
                echo "<h5>You wanted to sell to these buyers:</h5><hr>";
                $y=1;
            }
            ?>
            <div class="alert alert-info" role="alert">
                <div> <label>Buyer: <span><?php print $data["Full_Name"]; ?></span></label> </div>
                <div> <label>Buyer's Email: <span><?php print $data["Email"]; ?></span></label> </div>
                <div> <label>Book: <span><?php print $data["Title"]; ?></span></label> </div>
                <div> <label>Amount: <span>$ <?php print $data["Bid_Ammount"]; ?></span></label> </div>
                <div> <label>Phone: <span><?php print "(".substr($data["Phone_Num"], 0, 3).") ".substr($data["Phone_Num"], 3, 3)."-".substr($data["Phone_Num"],6); ?></span></label> </div>
            </div>
            <?php
        }
        
    }
    if($x==1)
            echo '<div class="alert alert-warning">
                        <strong>No Bids</strong><br />
                        You have not placed any bids on books.
                    </div>';
    ?>
    
</div>

<?php } ?>
<?php require './footer.php'; ?>