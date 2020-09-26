<!doctype html>
<html lang="he">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Browse</title>
    <link rel="stylesheet" href="browse_css.css">
    <script src="https://kit.fontawesome.com/367d815f02.js" crossorigin="anonymous"></script>
</head>

<body>
<?php require_once '../../components/info/Header.php';?>
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
        $product_id=$_POST['item_id'];
        $insert_fav="INSERT INTO favorites (user_id, product_id) VALUES ($user_id,$product_id)";
        if ($conn->query($insert_fav) === TRUE) {
        } else {
            echo "Error: " . $insert_fav . "<br>" . $conn->error;
        }
    }
    // Create connection

?>

<div class="main-div">
    <div class="search-bar">
        <div class="input-text-search">
            <input type="text" placeholder="חיפוש חופשי" id="search-text" dir="rtl">
        </div>
        <div class="button-search">
            <button type="submit" name="search_submit"  id="search_btn" onclick="testJS()"><img src="search.png"></button>
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
    <div class="main-wrapper">
        <div class="side-bar">
            <div class="filter-nav">
                <form action="browse.php" id="search-form" method="get">
                    <div class="price-filter">
                        <span id="demo" class="Price_Value"></span>
                        :  מחיר מקסימאלי
                        <br>
                            <div class="slidecontainer">
                                <?php
                                    require_once '../../components/info/server_con.php';
        
                                    // Create connection
                                    $conn = new mysqli($servername, $username, $password, $dbname);
                                    // Check connection
        
                                    mysqli_set_charset($conn, 'utf8');
        
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    $max_price_quarry = " SELECT MAX(price) AS max FROM product";
                                    $result = $conn->query($max_price_quarry);
                                    while($row = $result->fetch_assoc()) {?>
                                <input type="range" min="0" max="<?php echo $row["max"];?>" value="<?php  if(isset($_GET['price_slider'])){
                                    echo $_GET['price_slider'];
                                }else{
                                    echo $row["max"];
                                };?>" class="slider" id="myRange" name="price_slider">
                                        <?php
                                    }
                                ?>
                            </div>
    
                            <script>
                              var slider_price = document.getElementById("myRange");
                              var output_price = document.getElementById("demo");
                              output_price.innerHTML = slider_price.value; // Display the default slider value

                              // Update the current slider value (each time you drag the slider handle)
                              slider_price.oninput = function() {
                                output_price.innerHTML = this.value;
                              }
                            </script>
                            
                    </div>
                    <div class="distance-filter">
                        <span id="distance_Value" class="distance_Value"></span>
                        
                        <br>
                        <div class="slidecontainer ">
                                    <input type="range" min="0" max="600" value="<?php  if(isset($_GET['distance_slider'])){
                                        echo $_GET['distance_slider'];
                                    }else{
                                        echo 150;
                                    };?>" class="slider" id="myRange_distance" name="distance_slider">
                        </div>
    
                        <script>
                          var slider = document.getElementById("myRange_distance");
                          var output = document.getElementById("distance_Value");
                          output.innerHTML =":  מרחק מקסימאלי"+ " "+slider.value+" " +"קמ" ;// Display the default slider value

                          // Update the current slider value (each time you drag the slider handle)
                          slider.oninput = function() {
                            output.innerHTML = ":  מרחק מקסימאלי"+" "+ this.value +" "+"קמ" ;
                          }
                        </script>
                        <div class="position" id="position">
                            <input type=number  id = "lat" name= 'lat'<?php   if(isset($_GET['lat'])){
                                $lat=$_GET['lat'];
                                echo  "value = $lat>";
                            }else{
                                echo ">";
                            };?>
                            <input type=number id = "log" name= 'log' <?php   if(isset($_GET['log'])){
                                $log=$_GET['log'];
                                echo  "value = $log>";
                            }else{
                                echo ">";
                            };?>
                        </div>
            
                    </div>
                    <div class="main-category-filter">
                            <label for="main-category" class="required"><b>:קטגוריה</b></label><br>
                        <select name="main-category" class="main-category" id="main-category" dir="rtl">
                            <option value = "all"> כל הקטגוריות</option>
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
                    <div class="age-filter">
                    <label for="age" class="required"><b>:גיל</b></label><br>
                    <select id="age" name="age"  class="age" dir="rtl">
                        <option value = "all"> כל הגילאים</option>
    
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
                    <div class="status-filter">
                        <br>
                        :מצב מוצר
                        
                        <br>
                        <?php
                            require_once '../../components/info/server_con.php';
                            // Create connection
                            $conn = new mysqli($servername, $username, $password, $dbname);
                            // Check connection
                    
                            mysqli_set_charset($conn, 'utf8');
                    
                            if ($conn->connect_error) {
                                die("Connection failed: " . $conn->connect_error);
                            }
                            $status_quarry = " SELECT * FROM status";
                            $result = $conn->query($status_quarry);
                            while($row = $result->fetch_assoc()) { ?>
                                <label > <?php echo $row["status"]; ?> </label>
                                <input type="checkbox"  <?php
                                if(isset($_GET['status'])){
                                    if($_GET['status']==$row['status']){
                                       echo 'checked';
                                    }
                                }
                                ?>
                                       value = "<?php echo $row["status"];?>" name="status">
                                <br>
                                <?php
                            }
                        ?>
            
                    </div>
                   
            </div>
            <div id="map"></div>
            <script>
              var customLabel = {
                restaurant: {
                  label: 'R'
                },
                bar: {
                  label: 'B'
                }
              };
       
              var map, infoWindow;
              function initMap() {
                map = new google.maps.Map(document.getElementById('map'), {
                  center: {lat: 32.048490, lng: 34.761160},
                  zoom: 12
                });
                infoWindow = new google.maps.InfoWindow;

                // Try HTML5 geolocation.
                if (navigator.geolocation) {
                  navigator.geolocation.getCurrentPosition(function(position) {
                    var pos = {
                      lat: position.coords.latitude,
                      lng: position.coords.longitude
                    };

                    infoWindow.setPosition(pos);
                    infoWindow.setContent('Location found.');
                    infoWindow.open(map);
                    map.setCenter(pos);
                  }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                  });
                } else {
                  var pos={
                      lat:32.048490,
                      lng:34.761160
                  };
                  handleLocationError(false, infoWindow, map.getCenter());
                }
                downloadUrl('../google_api/google_api.php', function(data) {
                  var xml = data.responseXML;
                  var markers = xml.documentElement.getElementsByTagName('marker');
                  Array.prototype.forEach.call(markers, function(markerElem) {
                    var id = markerElem.getAttribute('id');
                    var name = markerElem.getAttribute('name');
                    var address = markerElem.getAttribute('address');
                    var type = markerElem.getAttribute('type');
                    var point = new google.maps.LatLng(
                      parseFloat(markerElem.getAttribute('lat')),
                      parseFloat(markerElem.getAttribute('lng')));

                    var infowincontent = document.createElement('div');
                    var strong = document.createElement('strong');
                    strong.textContent = name
                    infowincontent.appendChild(strong);
                    infowincontent.appendChild(document.createElement('br'));

                    var text = document.createElement('text');
                    text.textContent = address
                    infowincontent.appendChild(text);
                    var icon = customLabel[type] || {};
                    var marker = new google.maps.Marker({
                      map: map,
                      position: point,
                      label: icon.label
                    });
                    marker.addListener('click', function() {
                      infoWindow.setContent(infowincontent);
                      infoWindow.open(map, marker);
                    });
                  });
                });
              }
              function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(browserHasGeolocation ?
                  'Error: The Geolocation service failed.' :
                  'Error: Your browser doesn\'t support geolocation.');
                infoWindow.open(map);
              }
              function downloadUrl(url, callback) {
                var request = window.ActiveXObject ?
                  new ActiveXObject('Microsoft.XMLHTTP') :
                  new XMLHttpRequest;

                request.onreadystatechange = function() {
                  if (request.readyState == 4) {
                    request.onreadystatechange = doNothing;
                    callback(request, request.status);
                  }
                };

                request.open('GET', url, true);
                request.send(null);
              }
              function doNothing() {}
            </script>
            <script defer
                    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7ZJBw8MvtLUSubNtyZCHll1ZWlBm-7_E&callback=initMap">
            </script>
            <div class="submit-bottom-div">
            <input type="button" value="חפש"class="submit-bottom" name="submit-bottom" onclick="get_location()">
            </div>
                </form>
        
        </div>
        
        <div class="main-results">
            <div class="results-list">
                <?php
                    function distance($lat1, $lon1, $lat2, $lon2, $unit) {
                        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
                            return 0;
                        }
                        else {
                            $theta = $lon1 - $lon2;
                            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
                            $dist = acos($dist);
                            $dist = rad2deg($dist);
                            $miles = $dist * 60 * 1.1515;
                            $unit = strtoupper($unit);
            
                            if ($unit == "K") {
                                return ($miles * 1.609344);
                            } else if ($unit == "N") {
                                return ($miles * 0.8684);
                            } else {
                                return $miles;
                            }
                        }
                    }
    
                    require_once '../../components/info/server_con.php';
                
                    // Create connection
                    $conn = new mysqli($servername, $username, $password, $dbname);
                    // Check connection
                
                    mysqli_set_charset($conn, 'utf8');
                
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    if(isset($_GET['price_slider'])){
                        $price_slider=$_GET['price_slider'];
                    }
                    else{
                        $price_slider=100000;
                    }
                    if(isset($_GET['distance_slider'])){
                        $distance=$_GET['distance_slider'];
                    }
                    else{
                        $distance=1000000;
                    }
    
                    if (isset($_GET['main-category'])) {
                        $main_category_id = "";
                        $main_category = $_GET['main-category'];
                        if($main_category=="all"){
                            $main_category_id = "";
                        }
                        else{
                            $main_category_quarry = " SELECT * FROM main_category where Category_name = '$main_category'";
                            $result1 = $conn->query($main_category_quarry);
                            if ($result1->num_rows > 0) {
                                while ($row1 = $result1->fetch_assoc()) {
                                    $main_category_id = $row1["Category_id"];
                                }
                            } else {
                                $main_category_id = "";
                            }
                        }
                    }else{
                        $main_category_id = "";
                    }
                    if (isset($_GET['age'])) {
                        $age= $_GET['age'];
                        if ($age=="all"){
                            $age_id="";
                        }else{
                            $GetAgeIdSQL="Select * from age where age.age = '$age' ";
                            $result = $conn->query($GetAgeIdSQL);
    
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {
                                    $age_id=$row["age_id"];
                                }
                            }
                        }
                    }else{
                        $age_id="";
                    }
                    
                    if (isset($_GET['search'])) {
                        require_once '../../components/info/server_con.php';
                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);
                        // Check connection
        
                        mysqli_set_charset($conn, 'utf8');
        
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $search = mysqli_real_escape_string($conn, $_GET['search']);
                    
                    }else{
                        $search="";
                    }
                    if(isset($_GET['status'])){
                        $status=$_GET['status'];
                    $sql="SELECT * FROM product JOIN status ON product.status_id = status.status_id WHERE status.status like '%$status%' AND product.main_category_id like '%$main_category_id%'  AND product.price <= '$price_slider' AND name LIKE  '%$search%' AND age_id LIKE '%$age_id%' ORDER BY date_of_upload DESC";
                    }
                    else{
                        if (isset($_GET['main-category'])){
                            $sql="SELECT * FROM product WHERE product.price <= '$price_slider'AND product.main_category_id like '%$main_category_id%' AND name LIKE  '%$search%' AND age_id  LIKE '%$age_id%' ORDER BY date_of_upload DESC";
    
                        }else{
                            $sql="SELECT * FROM product WHERE   name LIKE  '%$search%' AND age_id LIKE '%$age_id%' ORDER BY date_of_upload DESC";
                        }
                        }
                    $result = $conn->query($sql)or die($conn->error);
                    $row_cnt = mysqli_num_rows($result);
                    if ($row_cnt==0){
                        echo "אין תוצאות עבור החיפוש הנבחר";
                    }else{
                    while($row = $result->fetch_assoc()) {
                        if(isset($_GET['lat'])){
                            if(distance($_GET['lat'],$_GET['log'],$row['latitude'],$row['longitude'],"K")<= $_GET['distance_slider'] ) {
                            ?>
                                <div class="item-wrapper">
                                    <a href="../product/product.php?item_id=<?php echo "$row[id]"?> ">
                                        <div class="item-img">
                                            <?php if(isset($_SESSION['email'])){?>
                                                <div class="heart_icon">
            
                                                    <?php
                                                        $user_id=$_SESSION['user_id'];
                                                        require_once '../../components/info/server_con.php';
                                                        $conn = new mysqli($servername, $username, $password, $dbname);
                                                        // Check connection
                
                                                        mysqli_set_charset($conn, 'utf8');
                
                                                        if ($conn->connect_error) {
                                                            die("Connection failed: " . $conn->connect_error);
                                                        }
                                                        $product_id=$row['id'];
                                                        $select_fav= "SELECT * FROM `favorites` WHERE user_id=$user_id And product_id =$product_id ";
                                                        $result2 = $conn->query($select_fav);
                                                        $row_cnt = mysqli_num_rows($result2);
                                                        if($row_cnt>0){?>
                                                            <button  id="heart_id"  style="color: #FFC3C2;">
                                                                &#10084;
                                                            </button>
                                                        <?php }else{?>
                                                            <form action="" method="post">
                                                                <input type="number" value=<?php echo "$row[id]"?> name="item_id" style="display: none">
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
                                            <img src=" ../add_product/uploads/<?php echo "$row[img]"?>">
                                        </div>
                                        <div class="text-wrapper">
                                            <div class="item-date">
                                                <?php
                                                    $old_date=$row['date_of_upload'];
                                                    $newDate= date("d-m-Y",strtotime($old_date));
                                                    echo $newDate;?>
                                            </div>
                                            <div class="item-price">
                                                <section><?php echo "$row[price]"?></section>
                                            </div>
                                            <div class="item-location">
                                                <?php echo  "$row[city]"?>
                                            </div>
                                            <div class="item-name">
                                                <section title="<?php echo $row['name']?>">
                                                    ...
                                                    <?php echo mb_substr($row['name'],0,10)?>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                        }else{
                        ?>
                        <div class="item-wrapper">
                            <a href="../product/product.php?item_id=<?php echo "$row[id]"?> ">
                                <div class="item-img">
                                    <?php if(isset($_SESSION['email'])){?>
                                    <div class="heart_icon">
                                        
                                        <?php
                                            $user_id=$_SESSION['user_id'];
                                            require_once '../../components/info/server_con.php';
                                            $conn = new mysqli($servername, $username, $password, $dbname);
                                            // Check connection
        
                                            mysqli_set_charset($conn, 'utf8');
        
                                            if ($conn->connect_error) {
                                                die("Connection failed: " . $conn->connect_error);
                                            }
                                            $product_id=$row['id'];
                                            $select_fav= "SELECT * FROM `favorites` WHERE user_id=$user_id And product_id =$product_id ";
                                            $result2 = $conn->query($select_fav);
                                            $row_cnt = mysqli_num_rows($result2);
                                            if($row_cnt>0){?>
                                                <button  id="heart_id"  style="color: #FFC3C2;">
                                                    &#10084;
                                                </button>
                                            <?php }else{?>
                                                <form action="" method="post">
                                                    <input type="number" value=<?php echo "$row[id]"?> name="item_id" style="display: none">
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
                                    <img src=" ../add_product/uploads/<?php echo "$row[img]"?>">
                                </div>
                                <div class="text-wrapper">
                                    <div class="item-date">
                                        <?php
                                            $old_date=$row['date_of_upload'];
                                            $newDate= date("d-m-Y",strtotime($old_date));
                                            echo $newDate;?>
                                    </div>
                                    <div class="item-price">
                                        <section><?php echo "$row[price]"?></section>
                                    </div>
                                    <div class="item-location">
                                        <?php echo  "$row[city]"?>
                                    </div>
                                    <div class="item-name">
                                        <section title="<?php echo $row['name']?>">
                                            ...
                                            <?php echo mb_substr($row['name'],0,10)?>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php
                            }
                    }//while
                    }//else
                ?>
            </div>
        </div>
    </div>
    
</div>
<script>

  var x = document.getElementById("position");
  document.getElementById("position").style.display = "none";

  function get_location() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
      }

    }
  function showPosition(position) {
    document.getElementById("lat").value=position.coords.latitude;
    document.getElementById("log").value=position.coords.longitude;
    document.getElementById("search-form").submit();
  }
  /*
  function showPosition(position) {
    x.innerHTML = "<input type=number name='lat' value='" + position.coords.latitude + "'>"+
      "<input type=number name='log' value =" + position.coords.longitude + ">";

  }
  
   */
</script>
<script>
  function click_heart() {
    var x = document.getElementById("heart_id");
    x.style.color = "#FFC3C2";
  }
</script>
<?php require_once '../../components/info/Footer.php';?>

</body>


</html>
