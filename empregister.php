<?php include_once "header.php"; ?>

<script src="js/employer.js"></script>
<?php include_once "headerbody.php" ; ?>

<section class="main-container">
    <div class="main-wrapper">
        <h2>Employer Registration</h2>
        
        <?php        
        if(isset($_SESSION['userid'])){
           echo '<form class="employer-form" action="php/empreg.php" method="post">
           <input type="text" name="empname" placeholder="Employer Name">
           <input type="text" name="district" placeholder="District">
           <input type="text" name="phyadd" placeholder="physical address">
           <input type="text" name="uemail" placeholder="email">
           <input type="text" name="emptel" placeholder="Phone">
           <button type="submit" name="submit">Register</button>
       </form>' ;

        }else{
            header("Location: index.php");
            exit();
        }
        ?>        
    </div>
    <div id="employers"></div>
</section>
<?php
include_once "footer.php";
?>
