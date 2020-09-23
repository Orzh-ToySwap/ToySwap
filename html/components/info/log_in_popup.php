

<!-- Button to open the modal login form -->
<button class="header-buttom" onclick="document.getElementById('id01').style.display='block'">התחברות</button>

<!-- The Modal -->
<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'"
        class="close" title="Close Modal">&times;</span>
    
    <!-- Modal Content -->
    <form class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>"  method="post">
        <div class="imgcontainer">
            <img src="/ToySwap/html/components/icon/img_avatar2.png" alt="Avatar" class="avatar">
        </div>
        
        <div class="container-login">
            <label for="uname"><b>אימייל</b></label>
            <input type="text" placeholder="הכנס אימייל" name="Log-in-email" required>
            
            <label for="psw"><b>סיסמא</b></label>
            <input type="password" placeholder="הכנס סיסמא" name="loginPassword" required>
            
            <button type="submit" name="login-button">התחבר</button>
            <label>
                <input type="checkbox" checked="checked" name="remember"> זכור אותי
            </label>
        </div>
        <!--
        <div class="container" style="background-color:#f1f1f1">
            <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">ביטול</button>
            <span class="psw">Forgot <a href="#">password?</a></span>
        </div>
        -->
    </form>
</div>
