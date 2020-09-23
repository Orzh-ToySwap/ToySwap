<?php
    if(isset($_POST['drop_item_button'])){
        require_once '../../components/info/server_con.php';
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        
        mysqli_set_charset($conn, 'utf8');
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $product_id=$_POST['item_id'];
        $delete_ite_sql= "DELETE FROM product WHERE id=$product_id";
        if ($conn->query($delete_ite_sql) === TRUE) {
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
    if(isset($_POST['drop_item_from_fav_button'])){
        require_once '../../components/info/server_con.php';
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        
        mysqli_set_charset($conn, 'utf8');
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $fav_id=$_POST['fav_id'];
        $delete_ite_sql= "DELETE FROM favorites WHERE fav_id=$fav_id";
        if ($conn->query($delete_ite_sql) === TRUE) {
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    }
   
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" />
    <title>Account Overview</title>
    <link rel="stylesheet" href="profile-css.css">
    <script src="https://kit.fontawesome.com/367d815f02.js" crossorigin="anonymous"></script>
</head>
<body>
<div>
    <?php require_once '../../components/info/Header.php';?>
    <?php
        if(isset($_POST['change_pref_bottom_submit'])){
            require_once '../../components/info/server_con.php';
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
        
            mysqli_set_charset($conn, 'utf8');
        
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $age=$_POST['age'];
            $category_main=$_POST['main-category'];
        
        
            $GetAgeSQL="Select * from age where age.age = '$age' ";
            $result = $conn->query($GetAgeSQL);
        
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $age_id=$row["age_id"];
                }
            }
        
            $GetCategory_mainIdSQL="Select * from main_category where Category_name='$category_main'";
            $result2 = $conn->query($GetCategory_mainIdSQL);
            if ($result2->num_rows > 0) {
                while($row3 = $result2->fetch_assoc()) {
                    $category_main_id=$row3["Category_id"];
                }
            }
            
            $user_id=$_SESSION['user_id'];
            $update_user_pref="UPDATE user set age_pref='$age_id', category_pref='$category_main_id'"
                ."WHERE user_id='$user_id'";
            if ($conn->query($update_user_pref) === TRUE) {
                $_SESSION['category_pref']=$category_main_id;
                $_SESSION['age_pref']=$age_id;
            } else {
                echo "Error: " . $update_user_pref . "<br>" . $conn->error;
            }
            $conn->close();
        }
    ?>
</div>
<div class="main-container">
    <div class="header-img-and-title">
        <div class="title">
            <h1>
                ברוך הבא לאזור האישי שלך
            </h1>
        </div>
    </div>
    <div class ="Account-overview">
        <h1>
            פרטי חשבון
        </h1>
        <div class="profile-overview">
            <h2>
                פרטי משתמש
            </h2>
            <div class="Profile-data">
                <div class="profile-data-email">
                <div class="profile-data-name-headline">
                    :מייל
                </div>
                <p>
                     <?php echo $_SESSION['email'] ?>
                </p>
                </div>
                <div class="profile-data-name">
                    <div class="profile-data-name-headline">
                        :שם
                    </div>
                <p>
                
                <?php echo $_SESSION['first_name'] ." " . $_SESSION['last_name'] ?>
                
                </p>
                </div>
                <div class="profile-data-pref">
                    <?php
                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
                        
                        mysqli_set_charset($conn, 'utf8');
                        
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $age_id= $_SESSION['age_pref'];
                        $GetAgeSQL="Select * from age where age.age_id = '$age_id' ";
                        $result = $conn->query($GetAgeSQL);
                        
                        if ($result->num_rows > 0) {
                            // output data of each row
                            while($row = $result->fetch_assoc()) {
                                $age=$row["age"];
                            }
                        }
                        $category_main_id= $_SESSION['category_pref'];
                        $GetCategory_mainIdSQL="Select * from main_category where Category_id='$category_main_id'";
                        $result2 = $conn->query($GetCategory_mainIdSQL);
                        if ($result2->num_rows > 0) {
                            while($row3 = $result2->fetch_assoc()) {
                                $category_main=$row3["Category_name"];
                            }
                        }
                        
                    ?>
                    <div class="profile-data-pref-headline">
                        <h2>
                        העדפות אישיות
                        </h2>
                    </div>
                    <div class="profile-data-pref-category">
                        <div class="profile-data-pref-category-headline">
                            :קטגוריה
                        </div>
                        <p>
                            <?php if(isset($_POST['change_pref_bottom_submit'])){
                                echo $_POST['main-category'];
                            }else{
                                echo $category_main;
                            }
                            ?>
        
                        </p>
                    </div>
                    <div class="profile-data-pref-age">
                        <div class="profile-data-pref-age-headline">
                            :גיל
                        </div>
                        <p>
                            <?php if(isset($_POST['change_pref_bottom_submit'])){
                                echo $_POST['age'];
                            }else{
                                echo $age;
                            }
                             ?>
                        </p>
                    </div>
                    <div class="change_pref_bottom_div">
                        <button class="change_pref_bottom" onclick="show_change_pref()">
                            לחץ כאן בשביל לשנות העדפות
                        </button>
                        <div class="change_pref_bottom_div_drop_box" id="change_pref_bottom_div_drop_box" style="display: none">
                            <form method="post" action="">
                            <div class="main-category-change">
                                <label for="main-category" class="required">:קטגוריה</label><br>
                                <select name="main-category" class="main-category" id="main-category" dir="rtl">
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
                                        while($row = $result->fetch_assoc()) { ?>
                    
                                            <option <?php  if(isset($_GET['main-category'])){
                                                if($_GET['main-category']==$row['Category_name']){
                                                    echo "selected";
                                                }
                                            }
                                            ?>
                                                    value = "<?php echo $row["Category_name"];?>"> <?php echo $row["Category_name"]; ?></option>
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="age-change">
                                <label for="age" class="required">:גיל</label><br>
                                <select id="age" name="age"  class="age" dir="rtl">
                                    <?php
                                        require_once '../../components/info/server_con.php';
                
                                        // Create connection
                                        $conn = new mysqli($servername, $username, $password, $dbname);
                                        // Check connection
                
                                        mysqli_set_charset($conn, 'utf8');
                
                                        if ($conn->connect_error) {
                                            die("Connection failed: " . $conn->connect_error);
                                        }
                                        $main_category_quarry = " SELECT * FROM age";
                                        $result = $conn->query($main_category_quarry);
                                        while($row = $result->fetch_assoc()) { ?>
                    
                                            <option <?php  if(isset($_GET['age'])){
                                                if($_GET['age']==$row['age']){
                                                    echo "selected";
                                                }
                                            }
                                            ?> value = "<?php echo $row["age"];?>"> <?php echo $row["age"];?></option>
                    
                                            <?php
                                        }
                                    ?>
                                </select>
                            </div>
                                <button type="submit" name="change_pref_bottom_submit" class="change_pref_bottom_submit">לחץ כאן לעדכון</button>
                            </form>
                        </div>
                    </div>
                </div>
            <script>
              function show_change_pref() {
                var x = document.getElementById("change_pref_bottom_div_drop_box");
                if (x.style.display === "none") {
                  x.style.display = "block";
                } else {
                  x.style.display = "none";
                }
              }
            </script>
            </div>
        </div>
        <div class="Change-password">
            <?php
                $current_password=$new_password="";
                if(isset($_POST['change_password_button'])){
                    
                    $current_password=filter_input(INPUT_POST, 'current_password', FILTER_UNSAFE_RAW);
                    $new_password=filter_input(INPUT_POST, 'new_password', FILTER_UNSAFE_RAW);
                    require_once "../../components/info/server_con.php";
                    
                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    // Check connection
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    if($_SESSION['password']!=$current_password ){
                        echo '<script type = "text/javascript">alert("password is not correct ")</script>';
                    }
                    elseif ($current_password==$new_password){
                        echo '<script type = "text/javascript">alert("new password is the same as the old one ")</script>';
                    }
                    else{
                        $sql3 = "UPDATE  user set password =" .  "'$new_password'"  . " where user_id="  .$_SESSION['user_id'];
                        if ($conn->query($sql3) == TRUE) {
                            echo '<script type = "text/javascript">alert("סיסמא שונתה בהצלחה ")</script>';
                            $_SESSION['password']=$new_password;
                            $conn->close();
                        } else {
                            echo "Error updating record: " . $conn->error;
                        }
                        
                    }
                }
            
            ?>
            
            <h2>שינוי סיסמא </h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post">
                <div class = "Change-password-form">
                    <label>
                        <input type="Password" placeholder="סיסמה נוכחית " name ="current_password" required dir="rtl">
                    </label>
                    <label>
                        <input type="Password" placeholder="סיסמה חדשה " name ="new_password" required dir="rtl">
                    </label>
                    <div class="change_password_button-div">
                        <button type="submit" name="change_password_button" class="Change_password_button">בצע</button>
                    </div>
                    </div>
            </form>
        </div>
        
        
        <div class="Your-plan">
            <div class="your_products">
                <h2>
                    :המוצרים שלי
                </h2>
                <div class="list_of_items">
                    
                        <?php
                            require_once '../../components/info/server_con.php';
    
                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            // Check connection
    
                            mysqli_set_charset($conn, 'utf8');
    
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $user_id=$_SESSION['user_id'];
                            $my_product = " SELECT * FROM product WHERE user_id=$user_id";
                            $result = $conn->query($my_product);
                            while($row = $result->fetch_assoc()) {?>
                                <div class="item_in_list">
                                    
                                        <div class="item-wrapper">
                                            <div class="item_edit" >
                                                <a href="../add_product/update_product.php?item_id=<?php echo $row['id']?>">
                                                &#9998;
                                                </a>
                                            </div>
                                            <a href="../product/product.php?item_id=<?php echo $row['id']?> ">
                                            <div class="item-name">
                                                <section title="<?php echo $row['name']?>">
                                                    ...
                                                    <?php echo mb_substr($row['name'],0,10)?>
                                                </section>
                                            </div>
                                            <div class="item-img">
                                                <div class="ul">
                                                    <div class="li">
                                                <img src="../add_product/uploads/<?php echo $row['img']?>">
                                                <span class="large">
                                                     <img src="../add_product/uploads/<?php echo $row['img']?>" class="large-image">
                                                </span>
                                      </div>
                                                </div>
                                            </div>
                                            <div class="item-description">
                                                <section title="<?php echo $row['discretion']?>">
                                                ...
                                                <?php echo mb_substr($row['discretion'],0,10)?>
                                            </div>
                                            <div class="item-price">
                                                <section>
                                                    <?php echo "$row[price]"?>
                                                </section>
                                            </div>
                                            <div class="item-time">
                                                <?php echo "$row[date_of_upload]"?>
                                            </div>
                                            <form name="drop_item" method="post" action="">
                                                <input type="number" name="item_id" value= <?php echo $row['id']?> style="display: none">
                                            <div class="item-icon">
                                                <button type="submit" name="drop_item_button" class='fas' onclick="return confirm('האם אתה בטוח רוצה למחוק את המוצר?');">
                                                    &#xf1f8;
                                                </button>
                                            </div>
                                            </form>
                                        </div>
                                    </a>
                                </div>
                        <?php
                            }?>
                </div>
            </div>
            <div class="your_orders">
                <h2>
                    :המועדפים שלי
                </h2>
                <div class="list_of_items">
                        <?php
                            require_once '../../components/info/server_con.php';
        
                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            // Check connection
        
                            mysqli_set_charset($conn, 'utf8');
        
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $user_id=$_SESSION['user_id'];
                            $my_product = " SELECT * FROM favorites JOIN product ON favorites.product_id=product.id JOIN user ON product.user_id=user.user_id WHERE favorites.user_id=$user_id";
                            $result = $conn->query($my_product);
                            while($row = $result->fetch_assoc()) {?>
                        <div class="item_in_list">
                            <a href="../product/product.php?item_id=<?php echo "$row[id]"?> ">
                                <div class="item-wrapper">
                                    <div class="item-name">
                                        <section title="<?php echo $row['name']?>">
                                        ...
                                        <?php echo mb_substr($row['name'],0,10)?>
                                        </section>
                                    </div>
                                    <div class="item-img">
                                        <div class="ul">
                                            <div class="li">
                                                <img src="../add_product/uploads/<?php echo $row['img']?>">
                                                <span class="large">
                                                     <img src="../add_product/uploads/<?php echo $row['img']?>" class="large-image">
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item-description">
                                        <section title="<?php echo $row['discretion']?>">
                                        ...
                                        <?php echo mb_substr($row['discretion'],0,10)?>
                                        </section>
                                    </div>
                                    <div class="item-price">
                                        <section>
                                            <?php echo "$row[price]"?>
                                        </section>
                                    </div>
                                    <div class="item-seller-name">
                                        <?php echo "$row[first_name]"." "."$row[last_name]"?>
                                    </div>
                                    <div class="item-time">
                                        <?php echo "$row[date_of_upload]"?>
                                    </div>
                                    <div class="item-icon">
                                        <form name="drop_item_from_fav" method="post" action="">
                                            <input type="number" name="fav_id" value= <?php echo $row['fav_id']?> style="display: none">
                                            <button type="submit" name="drop_item_from_fav_button" class='fas' onclick="return confirm('האם אתה בטוח שאתה רוצה להסיר את המוצר מהמועדפים שלך?');">
                                                &#xf1f8;
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </a>
                        </div>
                                <?php
                            }?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<?php require_once '../../components/info/Footer.php';?>
</html>