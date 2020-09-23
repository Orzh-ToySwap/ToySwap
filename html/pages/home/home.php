<!doctype html>
  <html lang="he">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="home_css.css">
    <link rel="stylesheet" href="../chat/chat-css.css">
    <script src="https://kit.fontawesome.com/367d815f02.js" crossorigin="anonymous"></script>

</head>

<body>

<?php require_once '../../components/info/Header_for_home_page.php';?>

<div class="first-banner">
<section>
    <!--
    <div class="h1">ToySwap</div>
    <div class="sub-h1"> קהילה של הורים הרוצים לרכוש משחקים לילדיהם במחיר מופחת או ללא עלות</div>
-->
</section>
</div>

    <div class="content-wrapper">
    
    <div class="category_banner">
        <?php
    
        require_once '../../components/info/server_con.php';
    
    
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
    
        mysqli_set_charset($conn, 'utf8');
    
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $main_category_quarry = " SELECT * FROM main_category";
        $result = $conn->query($main_category_quarry);
        while($row = $result->fetch_assoc()) {?>
        <div class="category_img_wrapper">
            <a href="../browse/browse.php?main-category=<?php echo $row["Category_name"];?>">
            <img src="caterogy_imgs/<?php echo $row["Category_id"];?>.png">
            </a>
        </div>
        <?php
        }
        ?>
    </div>
    
    
<div class="search-bar">
    <div class='add-item' >
        <a href='../../pages/add_product/add_product.php'class='fas' <?php
            if(isset($_SESSION['email'])){
            
            }else{
                echo "
                style=\"pointer-events: none;
                    cursor: default;
            text-decoration: none;
            color: #888888;
            opacity: 0.5\";";
            }
        
        ?>
        > &#xf067;</a>
    </div>
        <div class="input-text-search">
            <input type="text" placeholder="חיפוש..." id="search-text" dir="rtl">
        </div>
    <div class="button-search">
        <button type="submit"  id="search_btn" name="search_submit" onclick="testJS()"><img src="search.png"></button>
    </div>
   
</div>
<script>
  function testJS() {
    var b = document.getElementById('search-text').value,
      url = '../browse/browse.php?search=' + encodeURIComponent(b);
    document.location.href = url;
  }
  var input = document.getElementById("search-text");
  input.addEventListener("keyup", function(event) {
    if (event.keyCode === 13) {
      event.preventDefault();
      document.getElementById("search_btn").click();
    }
  });
</script>
 <div class="Third-banner">
         <div class ="h3">הצעות במיוחד בשבילך</div>
     <?php  if(isset($_SESSION['email'])) { ?>
             <div class="product-list">
                 <?php
                     require_once '../../components/info/server_con.php';
    
                     // Create connection
                     $conn = new mysqli($servername, $username, $password, $dbname);
                     // Check connection
    
                     mysqli_set_charset($conn, 'utf8');
    
                     if ($conn->connect_error) {
                         die("Connection failed: " . $conn->connect_error);
                     }
    
                     $age_id= $_SESSION['age_pref'];
                     $category_main_id= $_SESSION['category_pref'];
                     
                     $sql="SELECT * FROM product  WHERE product.age_id = '$age_id'AND product.main_category_id ='$category_main_id'  ORDER BY date_of_upload DESC LIMIT 4";
                     $result = $conn->query($sql);
                      $row_cnt = $result->num_rows;
                     if($row_cnt !=4){?>
                         <div class="no_results_found">
                         לצערינו אין מוצרים העונים על העדפותיך האישיות
                         </div>
                         <?php
                     }else{
                        while($row = $result->fetch_assoc()) {?>
                            <div class="product-item">
                                <a href="../product/product.php?item_id=<?php echo "$row[id]"?>">
                                    <div class="item-box">
                                        <div class="img-wrapper">
                                            <img src="../add_product/uploads/<?php echo $row['img']?>">
                                        </div>
                                        <div class="price">
                                            <section> <?php echo "$row[price]"?></section>
                                        </div>
                                        <!--
                                        <div class="sealer">
                                            שם מוכר
                                        </div>
                                        -->
                                    </div>
                                </a>
                            </div>
                        
                 <?php
                        }
                     }
                     
                 ?>
             </div>
         <?php
     }else{?>
         <div class="log-in-banner">
             <b>
             התחבר  כדי לצפות בהמלצות מוצרים עבורך
             </b>
                 <br>
             <button onclick="document.getElementById('id01').style.display='block'">התחברות</button>

         </div>
         
         <?php
     }
     ?>
 </div>

        <div class="second-banner">
                <div class="why-using-website">
                    <div class="box">
                        <div class="parents_icon">
                            <img src="blue_check.png">
                        </div>
                        <div class="parents">
                            מעל 400 הורים מרוצים
                        </div>
                    </div>
                    <div class="box">
                        <div class="replace_icon">
                            <img src="green_check.png">
                        </div>
                        <div class="replace">
                            יותר מ-500 החלפות
                        </div>
                    </div>
                    <div class="box">
                        <div class="save_money_img">
                            <img src="purpel_check.png">
                        </div>
                        <div class="save_money">
                            חסכון כספי של מאות שקלים בשנה
                        </div>
                    </div>
                </div>
        </div>
 </div>

<div class="Chat">
    <!--
    <?php  if(isset($_SESSION['email'])) { ?>
        <?php require_once '../chat/chat.php' ?>
        <?php
    }
    ?>
    -->
</div>



</body>

<?php require_once '../../components/info/Footer.php';?>
</html>

