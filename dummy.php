<?php
include_once "header.php";
?>

<!-- put styles hear -->

<?php include_once "headerbody.php" ?>
<section class="main-container">
    <div class="main-wrapper">
        <h2>Modify Settings</h2>
        <?php
        if(isset($_SESSION['userid'])){
            echo "You are adding districts";
        }
        ?>
        <div id="themenus">
            
        </div>
        <div id="mybodyparts" class="mysettings">
        <h3>Add/Remove Body parts</h3>
        </div>
        <div id="mydistricts" class="mysettings"></div>
        <div id="mycounties" class="mysettings"></div>
        <div id="subcounties" class="mysettings"></div>
        <div id="villages" class="mysettings"></div>
    </div>
</section>
<?php
include_once "footer.php";
?>
