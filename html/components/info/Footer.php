
<footer >
        <a href="/ToySwap/html/pages/home/home.php" class="logo-footer">
        <img src="/ToySwap/html/components/icon/toyswapicon.png" alt="logo-footer">
    </a>
    <nav>
        <div class="footer-main-page">
            <dl>
             <dt >החברה</dt>
                <dd ><a href="../../pages/About/about_us.php" >אודות</a> </dd>
            </dl>
            <dl >
                <dt >לינקים שימושיים</dt>
                <?php
                  if(isset($_SESSION['email'])) {
                    ?>
                  <dd ><a href="../../pages/Profile/Proflie.php"> אזור אישי</a></dd>
                   <dd> <a href="/ToySwap/html/components/info/log-out.php">התנתק</a> </dd>
                <?php
                
                        }else{
                        ?>
                         <dd ><a onclick="document.getElementById('id02').style.display='block'">הרשמה</a> </dd>
                        <dd ><a onclick="document.getElementById('id01').style.display='block'">התחברות</a> </dd>
                      <?php
                  }   ?>
            </dl>
            
            <dl >
                <dt> משרדי<br>TOY SWAP</dt>
                <dd> האקדמית תל אביב יפו</dd>
                <dd>  רח' רבנו ירוחם 2</dd>
                <dd>ישראל</dd>
                <dd>*6086</dd>
                <dd><a href="mailto:office@toyswap.com" >office@toyswap.com</a></dd>
       
           </dl>
        </div>
    </nav>
</footer>