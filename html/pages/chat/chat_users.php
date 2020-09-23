
<!doctype html>
<html lang="he">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Browse</title>
    <link rel="stylesheet" href="chat_users_css.css">
    <script src="https://kit.fontawesome.com/367d815f02.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../chat/chat-css.css">
</head>

<body>
<?php require_once '../../components/info/Header.php';?>

<div class="main-div-chat">
<?php
    if(isset($_GET['other_user_id']))  {
        $other_user_id=$_GET['other_user_id'];
    }
?>
<?php  if(isset($_SESSION['email'])) { ?>
    <?php require_once '../chat/chat.php' ?>
    <?php
}
?>
<?php
    if(isset($_GET['other_user_id']))  {
        echo "<script> openForm()</script>";
    }
?>
<div class="Chat_main_wrapper">
    <div class="Chat_main_headline">
        <h1>
            היסטוריית צ'אטים
        </h1>
       
        
    </div>

    <?php
        require_once '../../components/info/server_con.php';
        $conn = new mysqli($servername, $username, $password, $dbname);
        mysqli_set_charset($conn, 'utf8');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $myID=5;
        $myID=$_SESSION['user_id'];
        $distinct_user_array=[];
        
        $get_DISTINCT_users_list="SELECT DISTINCT to_user_id,from_user_id FROM `chat_message` WHERE from_user_id = $myID or to_user_id = $myID";
        $result = $conn->query($get_DISTINCT_users_list);
        while($row = $result->fetch_assoc()) {
            if($row['to_user_id']==$myID){
                array_push($distinct_user_array,$row['from_user_id']);
            }else{
                array_push($distinct_user_array,$row['to_user_id']);
            }
        }
        $distinct_user_array=array_unique($distinct_user_array);
    ?>
    <table>
<?php
    foreach ($distinct_user_array as $user_d){
        $get_user_data_sql="Select * from user where user_id=$user_d";
        $result = $conn->query($get_user_data_sql);
        while($row = $result->fetch_assoc()) {
            ?><tr>
            <div class="user_wrapper">
                <th>
                <div class="user_name">
                    <?php echo "$row[first_name]"." "."$row[last_name]"?>
                </div>
                </th>
                <th>
                <div class="send_massage_bottom" >
                    <a href="chat_users.php?other_user_id=<?php echo "$row[user_id]"?>">
                    <button type="submit" name="send_massage_bottom_submit" class='fas'>
                        &#xf086;
                        שלח הודעה / הצג צ'אט
                    </button>
                    </a>
                </div>
                </th>
            </div>
            </tr>
            <?php
        }
    }
?>
    </table>
</div>
</div>
</body>
<?php require_once '../../components/info/Footer.php';?>
</html>