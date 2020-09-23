<!doctype html>
<html lang="he">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home page</title>
    <link rel="stylesheet" href="add_product-css.css">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://kit.fontawesome.com/367d815f02.js" crossorigin="anonymous"></script>
    <?php
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once '../../components/info/server_con.php';
            
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
    
    
            $status= $_POST['status'];
            $GetStatusIdSQL="Select * from status where status='$status'";
            $result1 = $conn->query($GetStatusIdSQL);
            if ($result1->num_rows > 0) {
                while($row1 = $result1->fetch_assoc()) {
                    $status_id=$row1["status_id"];
                }
            }
    
            $category_main= $_POST['category-main'];
            $GetCategory_mainIdSQL="Select * from main_category where Category_name='$category_main'";
            $result2 = $conn->query($GetCategory_mainIdSQL);
            if ($result2->num_rows > 0) {
                while($row3 = $result2->fetch_assoc()) {
                    $category_main_id=$row3["Category_id"];
                }
            }
    
            
            $file=$_FILES['item-details-img_file'];
            
            $fileName=$_FILES['item-details-img_file']['name'];
            $fileTmpName=$_FILES['item-details-img_file']['tmp_name'];
            $fileSize=$_FILES['item-details-img_file']['size'];
            $fileError=$_FILES['item-details-img_file']['error'];
            $fileType=$_FILES['item-details-img_file']['type'];
            
            $fileExt=explode('.',$fileName);
            $fileActualExt=strtolower(end($fileExt));
            
            $allowed= array('jpg','jpeg','png');
            
            if(in_array($fileActualExt,$allowed)){
                if($fileError===0){
                    if($fileSize<500000){
                        $fileNameNew=uniqid('',true).".".$fileActualExt;
                        $fileDestination =  'uploads/'.$fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);
                        $img=$fileNameNew;

                    }
                    else{
                        echo "tour file is to big";
                    }
                }
                else{
                    echo " there was an error upliading you file";
                }
            }else{
                echo  "you cannot upload files of those type!";
            }
            
            
             $name=$_POST['item-name'];
             $discretion=$_POST['description'];
             $price=$_POST['price'];
             $brand= $_POST['item-brand'];
             $user_id= $_POST['customer-details-id'];
             $latitude= $_POST['lat'];
             $longitude= $_POST['lng'];
             $phone= $_POST['phone'];
             $date_of_upload= date("Y-m-d",time());
             $country= "";
             $city= $_POST['city'];
             $street= $_POST['street'];
             $building_number= $_POST['house-number'];
            $operator_code= $_POST['operator_code'];
            
             $insertSql = "INSERT INTO product (id, name, discretion, status_id, price, main_category_id, brand, user_id, latitude, longitude, img, age_id,operator_code,phone, date_of_upload, country, city, street, building_number)"
             ." VALUES (null,'$name','$discretion','$status_id','$price','$category_main_id','$brand','$user_id','$latitude','$longitude','$img','$age_id','$operator_code','$phone','$date_of_upload','ישראל','$city','$street','$building_number')";
            if ($conn->query($insertSql) === TRUE) {
                header('Location:../browse/browse.php');
                die();
            } else {
                echo "Error: " . $insertSql . "<br>" . $conn->error;
            }
            $conn->close();
            
         }
    ?>
</head>

<body>
<?php require_once '../../components/info/Header.php';?>

<div class="main-wrapper">
   <!-- <form action="../home/home.php" method="post" id="add-item-form">-->
    <form  id="add-item-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
    <div class="headline-div">
            <h1> הוספת מוצר</h1>
        </div>
        <div class="details-wrapper">
            <div class="customer-details">
            <div class="customer-details-headline">
               <h2> פרטים אישיים</h2>
            </div>
            <div class="customer-details-email">
                <label for="email">דואר אלקטרוני </label><br>
                <input type="email" id="email" name="email"  disabled value=<?php echo  $_SESSION['email']?>><br>
            </div>
                <div class="customer-details-id" id="customer-details-id1" style="display: none">
                    <input type="number" id="customer-details-id" name="customer-details-id"  value="<?php echo  $_SESSION['user_id']?>" ><br>
                </div>
            <div class="customer-details-name">
                <div class="first-name">
                    <label for="fname">שם פרטי </label><br>
                    <input type="text" id="fname" name="fname" disabled value="<?php echo  $_SESSION['first_name']?>"><br>
                </div>
                <div class="last-name">
                    <label for="lname">שם משפחה </label><br>
                    <input type="text" id="lname" name="lname" disabled value="<?php echo  $_SESSION['last_name']?>"><br>
                </div>
            </div>
            <div class="phone">
                    <label for="phone" class="required">טלפון </label><br>
                <div class="phone_number">
                    <select id="operator_code" name="operator_code" required dir="rtl">
                    <?php
                        require_once '../../components/info/server_con.php';
            
                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
            
                        mysqli_set_charset($conn, 'utf8');
            
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $main_category_quarry = " SELECT * FROM phone_operator_code";
                        $result = $conn->query($main_category_quarry);
                        while($row = $result->fetch_assoc()) { ?>
                
                            <option value = "<?php echo $row["operator_code"];?>"> <?php echo $row["operator_code"];?></option>
                
                            <?php
                        }
                    ?>
                    </select >
                    -
                    <input type="tel" id="phone" name="phone" placeholder ="טלפון" required  pattern=".{7,7}" ><br>
                </div>
                </div>
            <div class="address">
                    <div class="city">
                        <label for="city" class="required">עיר </label><br>
                        <input type="text" id="city" name="city" placeholder ="עיר" required><br>
                    </div>
                    <div class="street">
                        <label for="street">רחוב </label><br>
                        <input type="text" id="street" name="street" placeholder="רחוב"><br>
                    </div>
                    <div class="house-number">
                        <label for="house-number">דירה </label><br>
                        <input type="number" id="house-number" name="house-number" >
                        <br>
                    </div>
                <div class="card-block" id="geometry"></div>
                </div>
        </div>
            <div class="item-details">
            <div class="item-details-headline">
                <h2> פרטי המוצר</h2>
            </div>
            <div class="item-details-name">
                <label for="item-name" class="required">שם המוצר </label><br>
                <input type="text" id="item-name"  name="item-name" placeholder="שם המוצר" required><br>
            </div>
            <div class="item-details-description">
                <label for="description" >תיאור המוצר</label><br>
                <input type="text" id="description" name="description" placeholder="עד 36 תווים" ><br>
            </div>
            <div class="item-details-price">
                <label for="price" class="required">מחיר</label><br>
                <input type="number" id="price" name="price"  value=0  placeholder = 0 required><br>
            </div>
            <div class="item-details-img">
                <div class="img-headline">
                    <label for="item-details-img" class="required">תמונה</label><br>
                </div>
                <div class="img-upload-wrapper">
                <input type="file"  accept="image/*" name="item-details-img_file" id="item-details-img_file"  onchange="loadFile(event)"  dir="rtl" required/>
                <img id="output" />
                </div>
                <script>
                  var loadFile = function(event) {
                    var image = document.getElementById('output');
                    image.src = URL.createObjectURL(event.target.files[0]);
                  };
                </script>
                
            </div>
            <div class="item-details-status">
                <label for="status" class="required">תיאור המוצר</label><br>
                <select id="status" name="status" dir="rtl">
                <?php
                    require_once '../../components/info/server_con.php';
        
                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    // Check connection
        
                    mysqli_set_charset($conn, 'utf8');
        
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $main_category_quarry = " SELECT * FROM status";
                    $result = $conn->query($main_category_quarry);
                    while($row = $result->fetch_assoc()) { ?>
                        
                        <option value = "<?php echo $row["status"];?>"> <?php echo $row["status"];?></option>
                        
                        <?php
                    }
                ?>
                </select><br>
            </div>
            <div class="item-details-age">
                <label for="age" class="required">גיל</label><br>
                <select id="age" name="age" dir="rtl">
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
                </select><br>
            </div>
            <div class="item-details-brand">
                <label for="item-brand" >מותג </label><br>
                <input type="text" id="item-brand" name="item-brand" placeholder="מותג"><br>
            </div>
            <div class="item-details-category">
                <div class="item-details-category-main">
                    <label for="category-main" class="required">קטגוריה</label><br>
                    <select id="category-main" name="category-main" dir="rtl">
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
    
                        <option value = "<?php echo $row["Category_name"];?>"> <?php echo $row["Category_name"];?></option>
    
                        <?php
                        }
                        ?>
                    </select><br>
                </div>
            </div>
        </div>
            <div class="input-div">
                <h2> לסיום</h2>
                <div class="sumbit-text" dir="rtl">
                    <p>
                        בעת לחיצה על כפתור סיום הינני מאשר את תנאי השימוש של האתר, האתר רשאי להשתמש במידע המוזן במערכת.
                    </p>
                    <p>
                        כמו כן, לאתר יש את הזכות למחוק מוצרים שאינם עונים על אופיו של האתר. משתמש שיתנהג בצורה לא הולמת יוסר לצמיתות מהאתר.
                    </p>
                </div>
                <div class="sumbit-img-bottom">
                   <button type="button" onclick="geocode()">לחץ כאן לסיום</button>
                  <input type="submit" value="Submit" id="sumbit_buttom_add_item" name="sumbit_buttom_add_item" style="display: none"/>
                </div>
                
               
            </div>
        </div>
    </form>
    
</div>
    
<?php require_once '../../components/info/Footer.php';?>

<script>

  function geocode(){

    let country = "ישראל"
    let city = document.getElementById('city').value;
    let street = document.getElementById('street').value;
    let house_number = document.getElementById('house-number').value;

    let  location = country + " " + city+" "+ street + " "+ house_number

    axios.get('https://maps.googleapis.com/maps/api/geocode/json',{
      params:{
        address:location,
        key:'AIzaSyD0SUixeWdhXCSRtwhqDAiDespERaUyWjE'
      }
    })
      .then(function(response){
        // Log full response
        console.log(response);

        // Geometry
        const lat = response.data.results[0].geometry.location.lat;
        const lng = response.data.results[0].geometry.location.lng;
        const geometryOutput = `
          
            <input type="text"  name="lat" value =  ${lat} style="display: none">
            <input type="text"  name="lng" value = ${lng} style="display: none">
        `;

        // Output to app
        document.getElementById('geometry').innerHTML = geometryOutput;
        document.getElementById("sumbit_buttom_add_item").click();
      })
      .catch(function(error){
        console.log(error);
      });
    
  }
</script>

</body>
</html>