<?php
include_once "header.php";
?>
<section class="main-container">
    <div class="main-wrapper">
        <h2>New User</h2>
        <form class="signup-form" action="php/register.php" method="POST">
            <input type="text" name="userid" placeholder="userid">
            <input type="text" name="fulname" placeholder="full name">
            <input type="text" name="utype" placeholder="utype">
            <input type="password" name="pkword" placeholder="Password">
            <button name="submit" type="submit">Submit</button>
        </form>
    </div>
</section>
<?php
include_once "footer.php";
?>
  