<?php
require_once 'connect.php';
isLogOutGoToHome();
?>
<?php require './header.php'; ?>  
<a href="messages.php?send=new">
            <i class="fa fa-telegram" style="font-size:22px;color:#3A5060"></i> write a message
        </a> 
        <hr>
<?php
$query = "SELECT * FROM message m INNER JOIN message a ON m.Message_ID = a.Message_ID INNER JOIN student stu1 on m.Student_ID1 =stu1.ID where m.Student_ID2=" . $_SESSION["CurrentUser"]["ID"] . " ORDER BY m.Time_Sent DESC";

if (isset($_POST['email']) && isset($_POST['subject']) && isset($_POST['message']))
{
    $qry2 = "SELECT ID FROM student where Email='" . $_POST['email'] . "'";
    
    $stmt = $mysqli->prepare($qry2);
    $stmt->execute();
    // Extract result set and loop rows
    $result = $stmt->get_result();
    while ($data = $result->fetch_assoc()) {
       $stu2 =  $data['ID'];
    }
   $qry3 = "INSERT INTO `message`( `Student_ID1`, `Student_ID2`, `Subject`,`Message`,`Time_Sent`)" .
                "  VALUES (" . $_SESSION["CurrentUser"]["ID"] . ", ". $stu2 . ", '" . $_POST['subject'] . "', '" . $_POST['message'] . "', '" . date("Y-m-d")."')";
   
    ?>
    <div class='loginmodal-container Book-form'>
    <h1>Messages</h1><br>
        
    <?php if ($stmt = $mysqli->prepare($qry3)) {
        
        $stmt->execute();

        if ($mysqli->insert_id > 0) {
            echo  '<div class="alert alert-success">
                        <strong>Message Sent</strong><br />
                        Your message was sent.
                    </div>';
        } else {
            echo '<div class="alert alert-danger">
                        <strong>Message Failure</strong><br />
                        Your message was not sent.
                    </div>';
        }
        
    } else {
        echo "The operation was not performed due to a technical error";
    }
    ?>
         <a href='messages.php'>back to messages</a>  
    
    <?php
    
     
}
elseif(isset($_GET['send']))
{
    echo "
        <div class='loginmodal-container Book-form'>
            <h1>send message</h1><br>
            <form method='post' data-toggle='validator'>

                <div class='form-group'>
                    <input type='name' name='email' class='form-control' placeholder='enter email address' required=''> 
                    <input type='name' name='subject' class='form-control' placeholder='subject' required=''> 
                    <textarea type='text' name='message' rows='5' class='form-control'> </textarea> 
                </div>

                <input type='submit' name='login' class='login loginmodal-submit' value='send message'>
            </form>
        </div>
    ";
}
elseif(isset($_GET['reply']))
{
    $qry2 = "SELECT * FROM message m INNER JOIN message a ON m.Message_ID = a.Message_ID INNER JOIN student stu1 on m.Student_ID1 =stu1.ID where m.Message_ID=" . $_GET['reply'] . " and m.Student_ID2=" . $_SESSION["CurrentUser"]["ID"];
    
    $stmt = $mysqli->prepare($qry2);
    $stmt->execute();
    // Extract result set and loop rows
    $result = $stmt->get_result();
    while ($data = $result->fetch_assoc()) {
       echo "";
    
?>
        <div class='loginmodal-container Book-form'>
            <h1>send message</h1><br>
            <strong>original message: </strong>
            <div class="alert alert-info"><?php echo $data['Message'];?>
            </div>
            <hr>
            <form method='post' data-toggle='validator'>

                <div class='form-group'>
                    
                    <input type='name' name='email' class='form-control' placeholder='enter email address' value='<?php echo $data['Email'];?>' required=''> 
                    <input type='name' name='subject' class='form-control' placeholder='subject' value='RE: <?php echo $data['Subject'];?>' required=''> 
                    <textarea type='text' name='message' rows='5' class='form-control'> </textarea> 
                </div>

                <input type='submit' name='login' class='login loginmodal-submit' value='send message'>
            </form>
        </div>
<?php
    }
}
elseif ($stmt = $mysqli->prepare($query)) {
    /* execute query */
    $stmt->execute();
    // Extract result set and loop rows
    $result = $stmt->get_result();
    ?>


    <?php
    $x=1;
    while ($data = $result->fetch_assoc()) { 
        $x=0;
    ?>
       <div class='alert alert-info' role='alert'>
        <a href="messages.php?reply=<?php echo $data['Message_ID'];?>" style="float: right;">
            <i class="fa fa-telegram" style="font-size:18px;color:#3A5060"></i> Reply
        </a>
           <br />
           <hr>
           <?php echo "<strong>SUBJECT: " . $data['Subject'] . "</strong><br />" .
            "From: " .  $data['Full_Name'] . "<br />" .
            "Message: " . $data['Message'] . "<br />" .
            "Date Sent: " . date("D M d, Y", strtotime($data['Time_Sent'])); 
           ?>
        </div>
    
        
        <?php }
        if($x==1)
        {
        echo '<div class="alert alert-warning">
                        <strong>No messages</strong><br />
                        You do not have messages.
                    </div>';
        }
        ?>


<?php } ?>
      </div>  
<?php 
require './footer.php'; ?>

