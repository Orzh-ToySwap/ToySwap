
<!DOCTYPE html>
<html lang="he">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="product-css.css">
    <link rel="stylesheet" href="../chat/chat-css.css">
    <script src="https://kit.fontawesome.com/367d815f02.js" crossorigin="anonymous"></script>
</head>

<body>
<?php require_once '../../components/info/Header.php';?>
<div class="wrapper-product">
<div class="main-section">
    <?php
    
        require_once '../../components/info/server_con.php';
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        
        mysqli_set_charset($conn, 'utf8');
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $item_id=$_GET['item_id'];
        $sql="SELECT * FROM product JOIN user on product.user_id = user.	user_id WHERE id='$item_id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    ?>
    <div class="product-name">
        <div class="product-name-text">
            <?php echo "$row[name]"?>
        </div>
    </div>

    
    <div class="product-img">
        <?php
        if(isset($_SESSION['email'])){?>
            <div class="heart_icon">
            <?php    //add favorites sql
                if(isset($_POST['heart_id'])){
                    $user_id=$_SESSION['user_id'];
                    require_once '../../components/info/server_con.php';
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    // Check connection
            
                    mysqli_set_charset($conn, 'utf8');
            
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $product_id=$_GET['item_id'];
                    $insert_fav="INSERT INTO favorites (user_id, product_id) VALUES ($user_id,$product_id)";
                    if ($conn->query($insert_fav) === TRUE) {
                    } else {
                        echo "Error: " . $insert_fav . "<br>" . $conn->error;
                    }
                }
                // Create connection
    
            ?>
        <?php
        $user_id=$_SESSION['user_id'];
        require_once '../../components/info/server_con.php';
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
    
        mysqli_set_charset($conn, 'utf8');
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $product_id=$_GET['item_id'];
        $select_fav= "SELECT * FROM `favorites` WHERE user_id=$user_id And product_id =$product_id ";
        $result = $conn->query($select_fav);
        $row_cnt = mysqli_num_rows($result);
        if($row_cnt>0){
            $other_user_id=$row['user_id'];
            ?>
                <button  id="heart_id"  style="color: #FFC3C2;">
                    &#10084;
                </button>
                <?php }else{?>
                <form action="" method="post">
                    <button type="submit" onclick="click_heart()" id="heart_id" name="heart_id">
                        &#10084;
                    </button>
                </form>
                <?php
                }
        ?>
    </div>
    <?php
            }
        ?>
        
        <img src="/ToySwap/html/pages/add_product/uploads/<?php echo "$row[img]"?>" alt="שם של המוצר">
    </div>
    <div class="product-description">
        <div class="product-description-text">
            <?php echo "$row[discretion]"?>
        </div>
        <div class="product-price">
            מחיר :
            <?php echo "$row[price]"?>
        </div>
        <div class="product-city">
            עיר:
            <?php echo "$row[city]"?>
        </div>
        <div class="product-Date">
            תאריך פרסום:
            <?php
            $old_date=$row['date_of_upload'];
            $newDate= date("d-m-Y",strtotime($old_date));
            echo $newDate;?>
        </div>
        <div class="product-seller-name">
            שם המוכר:
            <?php echo "$row[first_name]"." "."$row[last_name]"?>
        </div>
        
        <div class="product-bottoms">
            <div class="send-massage-bottom" >
                <?php  if(isset($_SESSION['email'])) { ?>
                <button onclick="show_phone()">
                    צור קשר עם המוכר/ת
                </button>
            </div>
            <div class="seller-Phone"  id="seller-Phone">
                <div class="phone-number">
                    <a href="tel: <?php echo "$row[operator_code]"?><?php echo "$row[phone]"?>">
                    &#9990;
                    <?php echo "$row[operator_code]"?>
                    -
                    <?php echo "$row[phone]"?>
                    </a>
                </div>
                <div class="send-massage-div">
                    <div class="send-massage-to-seller">
                    <button  onclick="openForm()">
                    שלח הודעה למוכר
                    &#9993;
                    </button>
                    </div>
                </div>
            </div>
        </div>
        <?php
                }else{ ?>
        <div class="send-massage-bottom" >
            <button  onclick="pop_up_log_in()">
            הצג טלפון
            &#9990;
            </button>
        </div>
    </div>
    <?php
                }
                ?>
        <script>
          function show_phone() {
            var x = document.getElementById("seller-Phone");
            if (x.style.display === "none") {
              x.style.display = "block";
            } else {
              x.style.display = "none";
            }
          }
          function pop_up_log_in() {
            var x = document.getElementById("id02");
            if (x.style.display === "none") {
              x.style.display = "block";
            } else {
              x.style.display = "none";
            }
          }
        </script>
    </div>
</div>
</div>
<script>
  function click_heart() {
    var x = document.getElementById("heart_id");
    x.style.color = "#FFC3C2";
    
  }
</script>
<?php  if(isset($_SESSION['email'])){?>

<?php require_once '../chat/chat.php'?>
    <?php
}
?>
</body>
<?php require_once '../../components/info/Footer.php';?>
</html>