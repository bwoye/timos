<?php
include_once "header.php";
?>

<!-- put styles hear -->

<?php include_once "headerbody.php" ?>
<section class="main-container">
    <div class="main-wrapper">
        <h2>Home</h2>
        <?php
        if (isset($_SESSION['userid'])) {
            echo "You are logged in";
        }
        ?>
       
        <div><select id="wagetype" name="wagetype" style='width:150px;float:left'><input type="number" id="mypay" name="mypay" style="width:150px;"></select><button class="mybut" style="float:right;">Add wage type</button></div>
        <table id='myrates' style="width:100%;padding:5px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Rate</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        <br>
    </div>
</section>
<?php
include_once "footer.php";
?>
?>