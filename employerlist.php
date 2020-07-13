<?php
include_once "header.php"; ?>
<!-- <link rel="stylesheet" type="text/css" href="styles/emplist.css"> -->

<script src="js/employer.js"></script>
<style>
    #myBtn:hover {
        background-color: #555;
        /* Add a dark-grey background on hover */
    }

    #myBtn {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Fixed/sticky position */
            bottom: 70px;
            /* Place the button at the bottom of the page */
            right: 30px;
            /* Place the button 30px from the right */
            z-index: 99;
            /* Make sure it does not overlap */
            border: none;
            /* Remove borders */
            outline: none;
            /* Remove outline */
            background-color: red;
            /* Set a background color */
            color: white;
            /* Text color */
            cursor: pointer;
            /* Add a mouse pointer on hover */
            padding: 5px;
            /* Some padding */
            border-radius: 5px;
            /* Rounded corners */
            font-size: 10px;
            font-weight: bolder;
            width: 50px;
            /* Increase font size */
        }

    #jumpmenu {
        position: fixed;
        left: 0;
        top: 95%;
        width: 8em;
        margin-top: -2.5em;
        color: #ffffff;
        list-style: none;
        /*color:red;*/
        background-color: white;
        opacity: 0.5;
    }

    .mybuts {
        color: white;
        height: 20px;
        font-size: 10px;
        line-height: 10px;
    }


    table {
        font-size: 12px;
    }

    .summaries {
        min-height: 200px;
        background-color: rgb(250, 235, 100);
        font-size: 14px;
    }

    @media (max-width: 992px) {}

    @media (max-width: 768px) {}

    @media (max-width: 576px) {}
</style>
<?php include_once "headerbody.php"; ?>
<section class="main-container">
    <div class="main-wrapper">

        <h2>List of Employers</h2>
        <!-- <form class="employer-form" method="post" action="php/changepass.php"> -->
        <div id="emplist">List employers here</div>
    </div>
</section>
<div id="addmodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button><br />
            </div>
            <div class="modal-body">
                <h2 class="modal_title">Add new Entity</h2>
                <form method="post" id="insert_form">
                    <label style='width:150px;'>Name</label>
                    <input type="text" id="empname" name="empname" style='width:250px;' required /><br />
                    <label style='width:150px;'>Location</label>
                    <input type="text" id="phyadd" name="phyadd" style='width:250px;' required /><br />
                    <label style='width:150px;'>District</label>
                    <select id="distcode" name="distcode" style='width:250px;'></select></br>
                    <label style='width:150px;'>Telephone</label>
                    <input type="text" id='emptel' name="emptel" style='width:250px;' /><br />
                    <label style='width:150px;'>Email</label>
                    <input type="text" id='uemail' name="uemail" style='width:250px;' value='0' /><br />
                    <input type="hidden" id="empid" name="empid" />

                    <input type="submit" class='btn btn-success' id='insert' name="insert" value="Insert" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
<script>
    window.onscroll = function() {
        scrollFunction()
    };

    function scrollFunction() {
        if (document.body.scrollTop > 800 || document.documentElement.scrollTop > 800) {
            document.getElementById("myBtn").style.display = "block";
        } else {
            document.getElementById("myBtn").style.display = "none";
        }
    }

    // When the user clicks on the button, scroll to the top of the document
    function topFunction() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
    }
</script>
<?php
include_once "footer.php";
?>