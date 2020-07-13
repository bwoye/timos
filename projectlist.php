<?php
include_once "header.php";
?>

<!-- put styles hear -->
<style>
    #findemp {
        width: 40%;
    }

    #findemp input {
        font-size: 15px;
        border-style: none;
        margin-right: 20px;
        outline: none;
        width: 300px;
    }

    #found {
        position: absolute;
        background: #000;
        border-radius: 4px;
        overflow-x: hidden;
        overflow-y: auto;
        max-height: 250px;
        min-width: 250px;
    }

    #found>div {
        padding-bottom: 7px;
        color: #fff;
        padding: 0.2em 1em;
        /* border-top: 1px solid #666; */
    }

    #found>div:hover {
        background: #1e4dd4;
        cursor: pointer;
    }

    .cdets {
        margin-right: 10px;
    }

    .myform {
        width: 100%;
        margin: 20px auto;
    }

    .myform input,
    select {
        width: 70%;
        float: right;
    }

    .myform span {
        width: 100%;
        display: inline-block;
        margin-bottom: 5px;
    }

    .myform button {
        width: 70%;
        margin: 0 auto;
        display: block;
    }
</style>
<link rel="stylesheet" type="text/css" href="styles/mytab.css">
<script src="js/projectlist.js"></script>
<?php include_once "headerbody.php" ?>
<section class="main-container">
    <div class="main-wrapper">
        <h2>Project List</h2>
        <?php
        if (isset($_SESSION['userid'])) {
            // echo '<div id="findemp">
            // <input type="text" id="existemp" placeholder="Search Employer">
            // <div id="found"></div>
            // </div>';
        }
        ?>
        <div id="copdets" style="display:inline-flex;width:90%">
            <div id="findemp">
                <input type="text" id="existemp" placeholder="Search Employer">
                <div id="found"></div>
            </div>

            <input class="cdets" type="text" id="uemail">
            <input class="cdets" type="text" id="emptel">
            <input class="cdets" type="text" id="seldis">
        </div>
        <button type="button" class="btn-success mybuts btnadd" data-toggle="modal" data-target="#addmodal">Add New Project</button>
        <div id="projtable" style="margin:0 auto;"></div>
        
        <div id="addmodal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button><br />
                    </div>
                    <div class="modal-body">
                        <h4 class="modal_title">Add new Project</h4>
                        <form action="" class="myform" id="newproject">
                            <span><label for="projname">Project Name</label>
                                <input type="text" id="projname"></span>
                            <span><label for="projowner">Project Owner</label>
                                <input type="text" id="projowner" name="projowner"></span>
                            <span><label for="projnature">Project Nature</label>
                                <input type="text" id="projnature" name="projnature"></span>
                            <span><label for="projlocation">Location</label>
                                <input type="text" id="projlocation" name="projlocation"></span>
                            <span><label for="projtype">Project Type</label>
                                <input type="text" id="projtype" name="projtype"></span>
                            <span><label for="projdistrict">District</label>
                                <select id="projdistrict" name="projdistrict"></select></span>
                            <span><label for="certno">Certificate No.</label>
                                <input type="text" id="certno" name="certno"></span>
                            <input type="hidden" id="projid" name="projid">
                            <button type='submit'>Add Project</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="empid" name="empid">
</section>
<?php
include_once "footer.php";
?>