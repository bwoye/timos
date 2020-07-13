<?php
include_once "header.php";
?>
<section class="main-container">
    <div class="main-wrapper">
        <h2>Password Change</h2>
        <!-- <form class="employer-form" method="post" action="php/changepass.php"> -->
        <form class="employer-form" id="formpasschange">
        <input type="text" name="oldpass" id="oldpass" placeholder="Current password">
           <input type="text" name="newpass1" id="newpass1" placeholder="new Password">
           <input type="text" name="newpass2" id="newpass2" placeholder="Confirm password">  
           <button type="submit" name="submit">Apply</button>        
        </form>      
    </div>
</section>
<?php
include_once "footer.php";
?>
