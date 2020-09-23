<?php
    session_start();
    require_once 'server_con.php';
    if (isset($_POST['login-button'])){
        if(filter_input(INPUT_POST, "Log-in-email", FILTER_VALIDATE_EMAIL)){
            $loginEmail = filter_input(INPUT_POST, "Log-in-email", FILTER_SANITIZE_EMAIL);
        }
        else {
            $loginEmail='';
        }
        $loginPassword = filter_input(INPUT_POST, 'loginPassword', FILTER_UNSAFE_RAW);
        //connection to DB
        
        
        $_SESSION['con'] = mysqli_connect("$servername", "$username", "$password", "$dbname");
        mysqli_set_charset($_SESSION['con'], 'utf8');
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $checkUserSql = "select * "
            . "from user "
            . "where email = '$loginEmail' AND password = '$loginPassword'";
        if (!mysqli_query($_SESSION['con'], $checkUserSql)) {
            die('Error:' . mysqli_error($_SESSION['con']));
        }
        $dataset = mysqli_query($_SESSION['con'], $checkUserSql);
        if (mysqli_num_rows($dataset) > 0) {
            $userDetails = mysqli_fetch_array($dataset);//the match row from db
            
            $_SESSION['user_id']=$userDetails[0];
            $_SESSION['first_name'] = $userDetails[1];
            $_SESSION['last_name'] = $userDetails[2];
            $_SESSION['email'] = $userDetails[3];
            $_SESSION['password'] = $userDetails[4];
            $_SESSION['age_pref']=$userDetails[5];
            $_SESSION['category_pref']=$userDetails[6];
            $_SESSION['loggedIn'] = TRUE;
            header('Location:  /ToySwap/html/pages/home/home.php');
            die();
        }
        else {
            echo'<script type="text/javascript">alert("User name and/or password is incorrect")</script>';
        }
        mysqli_close($_SESSION['con']);
        
    }
    if(isset($_POST['sign-up-submit'])){
        if (filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL)) {
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        } else {
            echo "Illegal E-mail address";
        }
        $Password = filter_input(INPUT_POST, "psw", FILTER_SANITIZE_SPECIAL_CHARS);
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        
        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        
        mysqli_set_charset($conn, 'utf8');
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $age= $_POST['age'];
        $GetAgeIdSQL="Select * from age where age.age = '$age' ";
        $result = $conn->query($GetAgeIdSQL);
        
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $age_id=$row["age_id"];
            }
        }
        $category_main= $_POST['main-category'];
        $GetCategory_mainIdSQL="Select * from main_category where Category_name='$category_main'";
        $result2 = $conn->query($GetCategory_mainIdSQL);
        if ($result2->num_rows > 0) {
            while($row3 = $result2->fetch_assoc()) {
                $category_main_id=$row3["Category_id"];
            }
        }
        
        
        //connection to DB
        $_SESSION['con'] = mysqli_connect("$servername", "$username", "$password", "$dbname");
        mysqli_set_charset($_SESSION['con'], 'utf8');
        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        
        $email_quarry  = "SELECT * FROM user WHERE email = '$email'";
        $key = mysqli_query($_SESSION['con'], $email_quarry);
        if (mysqli_num_rows($key) > 0) {//if the email exits
            echo '<script type = "text/javascript">alert("this email already exist ")</script>';
            $_SESSION['emailError'] = 1;
        } else {//if the email does not exits
            $insertSql = "INSERT INTO user (user_id,first_name,last_name,email,password,age_pref,	category_pref) "
                . "VALUES (null,'$fname','$lname','$email','$Password','$age_id','$category_main_id')";
            if (!mysqli_query($_SESSION['con'], $insertSql)) { //if the insert to db doesn't success
                die('Error: ' . mysqli_error($_SESSION['con']));
            } else {//if the insert to DB is successful
                
                /*
                $_SESSION['email'] = $email;
                $_SESSION['first_name'] = $fname;
                $_SESSION['last_name'] = $lname;
                $_SESSION['loggedIn'] = false;
                
                require_once 'server_con.php';
                $conn = new mysqli($servername, $username, $password, $dbname);
                mysqli_set_charset($conn, 'utf8');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
                $get_new_id_sql = "SELECT * FROM user WHERE email = $email";
                $result = $conn->query($get_new_id_sql);
                while($row = $result->fetch_assoc()) {
                    $_SESSION['user_id']=$row[user_id];
                }
                */
                header('Location: home.php');
                die();
            }
        }
        mysqli_close($_SESSION['con']);
    }
?>
<header>
    <div class="Header">
        <nav>
            <div class="nav-links-header">
                <?php
                    if(isset($_SESSION['email'])) {?>
                        <div class="when_log_in_header">
                <div class='hello'>
                     !שלום
                </div>
                <div class='first-name-header'>
        <?php echo $_SESSION['first_name'] . " ".$_SESSION['last_name'] ?>
                </div>
                
                
                <div class="log-out_header">
                <a href='/ToySwap/html/components/info/log-out.php'class='fas'>&#xf2f5;</a>
            </div>
                <div class="profile_header">
                        <a href="../../pages/Profile/Proflie.php" class='fas'>
                            &#xf406;
                        </a>
                    </div>
                <div class="chat">
                        <a href=" ../../pages/chat/chat_users.php" class='fas'>
                            &#xf075;
                        </a>
                    </div>
                <div class='add-item'>
                            <a href='../../pages/add_product/add_product.php'  class='fas'>הוסף מוצר &#xf067</a>
                        </div>
                        </div>
                    <?php
                }
                    else {
                    ?>
                <div class="when_not_log_in">
             <div class="login">
                <?php  require_once '../../components/info/log_in_popup.php' ;?>
            </div>
        <div class="sign-up">
            <?php  require_once '../../components/info/signup-popup.php' ;?>
        </div>
                </div>
    <?php
        }
    ?>
        </div>
    </nav>
    </div>
</header>
