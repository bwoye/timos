<?php
include_once "header.php";
?>

<!-- put other styles here -->
<?php include_once "headerbody.php"; ?>
<section class="main-container">
    <div class="main-wrapper">
        <h2>News</h2>
        <?php
        if(isset($_SESSION['userid'])){
            echo "You are logged in";
        }
        ?>        
    </div>
</section>
<script src="js/starter.js"></script>
<?php
include_once "footer.php";
?>
