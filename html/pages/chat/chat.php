<?php
        require_once '../../components/info/server_con.php';
        if(isset($other_user_id)){
            if (isset($_POST['send-massage-bottom-submit'])){
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                $to_user_id=$other_user_id;
                $from_user_id=$_SESSION['user_id'];
                $chat_message=$_POST['write-text'];
                mysqli_set_charset($conn, 'utf8');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $insertMassege_to_DB="INSERT INTO `chat_message`(`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`,`status`) ".
                    "VALUES (null,$to_user_id,$from_user_id,'$chat_message',null,0) ";
                if ($conn->query($insertMassege_to_DB) === TRUE) {
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                $_POST['send-massage-bottom-submit']=1;
            }
        }else{
            if (isset($_POST['send-massage-bottom-submit'])){
                $conn = new mysqli($servername, $username, $password, $dbname);
                // Check connection
                $from_user_id=$_SESSION['user_id'];
                $chat_message=$_POST['write-text'];
                mysqli_set_charset($conn, 'utf8');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $insertMassege_to_DB="INSERT INTO `chat_message`(`chat_message_id`, `to_user_id`, `from_user_id`, `chat_message`, `timestamp`,`status`) ".
                    "VALUES (null,4,$from_user_id,'$chat_message',null,0) ";
                if ($conn->query($insertMassege_to_DB) === TRUE) {
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                $_POST['send-massage-bottom-submit']=1;
            }
        }
       
   
?>
<div class="Chat">
    <?php
        if(isset($_POST['send-massage-bottom-submit'])){
        if ( $_POST['send-massage-bottom-submit']==1){
            ?>
    <style>
        .chat-main-box {display: block}
    </style>
    <?php
        }
        }
    ?>
<button class="open-button" onclick="openForm()">צ'אט</button>
<div class="chat-main-box" id="chat-main-box">
    <div class="chat-massages">
        <?php
            require_once '../../components/info/server_con.php';
            $from_user_id=$_SESSION['user_id'];
            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
    
            mysqli_set_charset($conn, 'utf8');
    
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            if(isset($other_user_id)){
                $to_user_id=$other_user_id;
                $main_category_quarry = " SELECT * FROM chat_message JOIN user ON  chat_message.	from_user_id =user.user_id Where".
                    "(from_user_id = '$from_user_id' OR to_user_id= '$from_user_id') And (from_user_id = '$to_user_id' OR 	to_user_id= '$to_user_id' )order by timestamp ASC " ;
            
              $result = $conn->query($main_category_quarry);
            while($row = $result->fetch_assoc()) {
                  ?>
                <div class="massage-wrapper">
        <?php
                if($row['from_user_id']==$from_user_id){//the user send the massage
                    ?>
                    <div class="user_send">
                        <div class="name">
                            :
                            <?php echo $_SESSION['first_name']?>
                        </div>
                        <?php echo "$row[chat_message]"?>
                    </div>
                    <?php
                }else{// the user resive the massage
                    ?>
                    <div class="user_received">
                        <div class="name">
                            :
                            <?php echo $row['first_name']?>
                        </div>
                        <?php echo "$row[chat_message]"?>
                    </div>
                    <?php
                }
                ?>
                </div>
        <?php
            }
            }else{//not in product
                $main_category_quarry = " SELECT * FROM chat_message JOIN user ON  chat_message.	from_user_id =user.user_id Where 	from_user_id = '$from_user_id' OR 	to_user_id= '$from_user_id'  order by timestamp ASC " ;
            }
        ?>
    </div>
   <div class="send-and-write-box">
       <form  action="" method="post" class="send-and-write-box-form">
       <div class="write-box">
           <label for="write-text"><b></b></label>
           <textarea type="text" placeholder="...כתוב הודעה" name="write-text" required autofocus></textarea>
       </div>
       <div class="send-bottom">
           <button type="submit" class="send-massage-bottom-submit" name="send-massage-bottom-submit">שלח הודעה</button>
           <button type="button" class="cancel" onclick="closeForm()">סגור צאט</button>
       </div>
       </form>
   </div>
</div>
</div>
<script>
  function openForm() {
    document.getElementById("chat-main-box").style.display = "block";
  }

  function closeForm() {
    document.getElementById("chat-main-box").style.display = "none";
      <?php
      $_POST['send-massage-bottom-submit']=0;
      ?>
  }
</script>

