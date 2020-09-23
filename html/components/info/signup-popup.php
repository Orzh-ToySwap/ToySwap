<button class="header-buttom" onclick="document.getElementById('id02').style.display='block'" style="width:auto;">הרשמה</button>

<div id="id02" class="modal-singup">
    <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal" id="close_icon">&times;</span>
    <form class="modal-content-singup" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post">
        <div class="container-singup">
            <h1>הרשמה לאתר</h1>
            <p>אנא מלא את הטופס בשביל להירשם לאתר</p>
            <hr>

            <label for="email"><b>אימייל</b></label>
            <input type="text" placeholder="הכנס אימייל" name="email" class="email_sign_up"  dir="rtl"required>

            <label for="psw"><b>סיסמא</b></label>
            <input type="password" placeholder="הכנס סיסמא" name="psw" pattern=".{8,}" title="מינימום 8 תווים"required  dir="rtl">
    
            <label for="fname"><b>שם פרטי</b></label>
            <input type="text" placeholder="שם פרטי" name="fname"   dir="rtl"required>
    
            <label for="lname"><b>שם משפחה</b></label>
            <input type="text" placeholder="שם משפחה" name="lname"  dir="rtl" required>
    
            <label for="main-category"><b>קטגוריה מועדפת</b><br> </label>
            <select name="main-category" id="main-category"  dir="rtl">
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
                        <option value = "<?php echo $row["Category_name"];?>"> <?php echo $row["Category_name"]; ?></option>
                        <?php
                    }
                ?>
            </select>
            <br>
            <label for="age" class="required"><b>גיל</b></label><br>
            <select id="age" name="age"   dir="rtl">
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
                    
                            <option value = "<?php echo $row["age"];?>"> <?php echo $row["age"];?></option>
                    
                            <?php
                        }
                    ?>
                </select>
            <div class="clearfix">
                <!--    <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">בטל</button>
                    -->
                    <button type="submit" class="sign-up-submit" name="sign-up-submit">הירשם</button>
                </div>
            </div>
    </form>
</div>

<script>
  // Get the modal
  var modal = document.getElementById('id02');

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
  var boxid = "id02";
  var boxid1 = "id01";
  window.onkeyup = function (event) {
    if (event.keyCode == 27) {
      document.getElementById(boxid).style.display="none";
      document.getElementById(boxid1).style.display="none";
    }
  }
</script>