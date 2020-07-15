<?php
include_once "header.php";
?>
<link rel="stylesheet" type="text/css" href="styles/myformcss.css">
<link rel="stylesheet" type="text/css" href="styles/search.css">
<style>
    .fileuplod,
    .suppupload {
        display: inline-flex;
        align-items: center;
        font-size: 15px;
        margin-top: 5px;
    }

    .fileup {
        display: none;
    }

    #mysubmit {
        display: none;
    }

    .btnup,
    .btnimage {
        -webkit-appearance: none;
        background: #009879;
        color: #ffffff;
        border: 2px solid #00745D;
        border-radius: 4px;
        outline: none;
        padding: 0.5em 0.8em;

        margin-right: 15px;
        margin-left: 15px;
        font-size: 1em;
        cursor: pointer;
        font-weight: bold;
        display: inline-flex;
        white-space: nowrap;
    }

    .btnup:active,
    .fileup.active {
        background: #00745D;
    }

    .filenames {
        max-width: 200px;
        font-size: 0.95em;
        /* text-overflow: ellipsis; */
        /* overflow: hidden; */
        white-space: nowrap;
        margin-right: 5px;
    }

    .mydrops {
        background: transparent;
        border-radius: 6px;
        box-sizing: border-box;
        width: 90%;
        padding-left: 2px;
        position: relative
    }

    .mydrops input {
        /* background: transparent; */
        font-size: 15px;
        /* color:#fff; */
        border-style: none;
        outline: none;
    }

    .suggestions {
        position: absolute;
        /* border-top: 2px solid #999; */
        width: inherit;
        background: #000;
        border-radius: 4px;
        max-height: 300px;
        overflow-x: hidden;
        overflow-y: auto;
        z-index: 25;
    }

    .upbuttons {
        display: none;
    }

    .suggestions>div {
        padding-bottom: 7px;
        color: #fff;
        border-top: 1px solid #666;
    }

    .suggestions>div:hover {
        background: #1e4dd4;
        cursor: pointer;
    }

    .projsuggest {
        position: absolute;
        /* border-top: 2px solid #999; */
        width: inherit;
        background: #000;
        border-radius: 4px;
        max-height: 300px;
        overflow-x: hidden;
        overflow-y: auto;
        z-index: 25;
    }

    .projsuggest>div {
        padding-bottom: 7px;
        color: #fff;
        border-top: 1px solid #666;
    }

    .projsuggest>div:hover {
        background: #000;
        cursor: pointer;
    }

    .injpdiv>div {
        padding-bottom: 7px;
        color: #fff;
        border-top: 1px solid #666;
    }

    .injpdiv>div:hover {
        background: #1e4dd4;
        cursor: pointer;
    }

    .mymodal {
        display:none; 
        position: fixed;
        z-index: 2;
        left: 0;
        top: 0;
        height: 100%;
        width: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .myhead {
        background-color: #f4f4f4;
        margin: 20% auto;
        padding: 20px;
        width: 60%;
        box-shadow: 0 5px 8px 0 rgba(0, 0, 0, 0.2);
    }   

    .closeBtn {
        color: #ccc;
        float: right;
        font-size: 30px;
    }
    .closeBtn:hover {
        color: #000;       
        font-size: 30px;
        cursor: pointer;
    }
</style>

<?php include_once "headerbody.php"; ?>
<section class="main-container">
    <div class="main-wrapper">
        <h2>Accident Report</h2>
        <div style="clear:both"></div>

        <div id="formhere">
            <form action="" id="empdetails" class="allforms">
                <fieldset>
                    <legend>Employer Details</legend>

                    <span class="forminputs"><label for="empdrop">Name</label>
                        <div class="mydrops">
                            <input class="input-class" style="width:95%" type="text" name="empdrop" id="empdrop">
                            <div class="suggestions"></div>
                        </div>
                    </span>

                    <span class="forminputs"><label for="edistcode">District</label>
                        <input type="text" id="edistcode" readonly></span>
                    <span class="forminputs"><label for="phyadd">Address</label>
                        <input type="text" name="phyadd" id="phyadd" readonly></span>
                    <span class="forminputs"><label for="uemail">Email</label>
                        <input type="text" name="uemail" id="uemail" readonly></span>
                    <span class="forminputs"><label for="emptel">Phone</label>
                        <input type="text" name="emptel" id="emptel" readonly></span>
                </fieldset>
                <hr>
                <fieldset>
                    <legend>Particulars of project</legend>

                    <div style="clear:both"></div>

                    <span class="forminputs"><label for="projname">Name of project</label>
                        <div class="mydrops" style="z-index:1;">
                            <input class="projname" style="width:95%" type="text" name="projname" id="projname">
                            <div class="projsuggest"></div>
                        </div>
                    </span>
                    <span class="forminputs"><label for="projnature">Nature of project</label>&nbsp;
                        <input type="text" name="projnature" id="projnature"></span>
                    <span class="forminputs"><label for="projtype">Type of project</label>&nbsp;
                        <input type="text" name="projtype" id="projtype"></span>
                    <span class="forminputs"><label for="projowner">Owner of project</label>&nbsp;
                        <input type="text" name="projowner" id="projowner"></span>
                    <span class="forminputs"><label for="siteaddress">Address of site</label>&nbsp;
                        <input type="text" name="siteaddress" id="siteaddress"></span>
                    <span class="forminputs"><label for="projdistrict">District</label>
                        <select name="projdistrict" id="projdistrict"></select></span>
                    <div style="clear:both"></div>
                    <span class="forminputs"><label for="certno">Certificate number</label>
                        <input type="text" name="certno" id="certno"></span>
                </fieldset>
                <fieldset>
                    <legend>Injured Person Details</legend>
                    <!-- <button id="fromexist" name="fromexist">No existing record</button> -->
                    <!-- <div class="nobutton" style="padding-bottom:20px;margin-bottom:20px;">
                        <button id="recedit" style='margin-right:25px;'>Edit Existing record</button>
                        <button class="recdel">Delete this accident</button>
                    </div> -->
                    <div style="clear:both"></div>
                    <span class="forminputs"><label for="injpname">Name</label>
                        <div class="mydrops">
                            <input class="injpname" style="width:95%" type="text" name="injpname" id="injpname">
                            <div class="injpdiv"></div>
                        </div>
                    </span>
                    <span class="forminputs"><label for="injempadd">Name</label>
                        <input type="text" name="injempadd" id="injempadd" placeholder="Address"></span>
                    <span class="forminputs"><label for="jobtitle">Job Title</label>
                        <select name="jobtitle" id="jobtitle"></select></span>
                    <div style="clear:left"></div>
                    <span class="forminputs"><label for="natid">National ID</label>
                        <input type="text" name="natid" id="natid" placeholder="National Id"></span>
                    <span class="forminputs"><label for="race">Nationality</label>
                        <!-- <input type="text" name="race" id="race" placeholder="race"></span> -->
                        <select id="race" name="race"></select></span>
                    <span class="forminputs"><label for="nextofkin">Next of kin</label>
                        <input type="text" name="nextofkin" id="nextofkin" placeholder="Next of kin"></span>
                    <span class="forminputs"><label for="kinphone">Tel next of kin</label>
                        <input type="text" name="kinphone" id="kinphone" placeholder="Next of kin phone"></span>
                    <span class="forminputs"><label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value='0' disabled="disabled" selected>Gender</option>
                            <option value="M">Male</option>
                            <option value="F">Female</option>
                        </select></span>
                    <span class="forminputs"><label for="empage">Age of employee</label>
                        <input type="number" name="empage" id="empage" placeholder="age"></span>
                    <span class="forminputs"><label for="idistcode">District</label>
                        <select id="idistcode" name="idistcode">
                            <option value="0" selected disabled>Select District</option>
                        </select></span>
                    <span class="forminputs"><label for="saza">Sub county</label>
                        <select name="saza" id="saza"></select></span>
                    <!-- <span class="forminputs"><label for="gombolola">Sub county</label>
                        <input type="text" name="gombolola" id="gombolola" placeholder="gombolola"></span> -->
                    <span class="forminputs"><label for="village">Village</label>
                        <input type="text" name="village" id="village" placeholder="village"></span>
                </fieldset>
                <fieldset>
                    <legend>Employee earnings</legend>
                    <span class="forminputs"><label for="monthly">Monthly wage</label>
                        <input type="number" name="monthly" id="monthly" value="0"></span>
                    <span class="forminputs"><label for="weekly">Weekly wage</label>
                        <input type="number" name="weekly" id="weekly" value="0"></span>
                    <span class="forminputs"><label for="daily">Daily Wage</label>
                        <input type="number" name="daily" id="daily" value="0"></span>
                    <!-- <span class="forminputs"><label for="otherwages">Others</label>
                        <input type="number" name="otherwages" id="otherwages" placeholder="0"></span> -->
                </fieldset>
                <fieldset>

                    <legend>Particulars of accident</legend>

                    <span class="forminputs"><label for="accdate">Date</label>
                        <input type="date" name="accdate" id="accdate"></span>

                    <span class="forminputs"><label for="acctime">Time</label>
                        <input type="time" name="acctime" id="acctime" min="00:00" max="23:59"></span>
                    <span class="forminputs"><label for="accplace">Place of accident</label>
                        <select name="accplace" id="accplace"></select></span>
                    <div style="clear:both"></div>
                    <span class="forminputs"><label for="accdescription">Description of cause of accident</label>
                        <input type="text" name="accdescription" id="accdescription"></span>
                    <span class="forminputs"><label for="workno">Did Accident occur at work place</label>
                        <select name="workno" id="workno">
                            <option value='no'>No</option>
                            <option value='yes'>Yes</option>
                        </select></span>

                    <span class="forminputs"><label for="doingwhat">What was Person doing</label>
                        <select name="doingwhat" id="doingwhat"></select></span>
                    <!-- <div style="clear:both"></div> -->
                    <div style="clear:both"></div>

                    <span class="forminputs"><label for="acctype">Type of accident</label>
                        <select name="acctype" id="acctype"></select></span>
                    <span class="forminputs"><label for="accagent">Agent involved in accident</label>
                        <select name="accagent" id="accagent"></select></span>

                    <span class="forminputs"><label for="accresult">Result of accident</label>
                        <input type="text" name="accresult" id="accresult"></span>
                    <span class="forminputs"><label for="accinjuries">Nature of injuries</label>
                        <select name="accinjuries" id="accinjuries"></select></span>

                    <span class="forminputs"><label for="bodyinjury">Part of Body injured</label>
                        <select name="bodyinjury" id="bodyinjury"></select></span>
                    <span class="forminputs"><label for="hospital">Hospital</label>
                        <input type="text" name="hospital" id="hospital"></span>
                    <span class="forminputs"><label for="supportimage"></label>
                        <button type="button" class="btnup" id="imageup" name="imageup">Upload supporting image</button></span>
                    <span class="forminputs"><label for="medreport"></label>
                        <button type="button" class="btnup" id="repmed" name="repmed">Upload medical report</button></span>
                    <div style="clear:both"></div>

                </fieldset>

                <div style="clear:both"></div>

                <div style="margin-left:auto;padding-bottom:20px;padding-top:10px;margin-right:auto;">
                    <button type="submit" class="medsave" style="margin-left:auto;margin-right:auto;">Save Entry</button>
                </div>
                <div style="clear:both"></div>
            </form>

            <input type="file" class="upbuttons" name="supportimage" id="supportimage">
            <input type="file" class="upbuttons" name="medreport" id="medreport">

            <div style="clear:both"></div>
        </div>
    </div>

    <div id="lookup" style="display:none;width:45%;float:right">This where we do the search from</div>
    <div id="searchresults"></div>
    </div>
    <input type="hidden" id="idno" name="idno">
    <input type="hidden" id="empid" name="empid">
    <input type="hidden" id="projid" name="projid">
    <input type="hidden" id="accid" name="accid">
    <input type="hidden" id="myimagefile" name="myimagefile">
</section>
<div class="mymodal">
    <div class="myhead">   

    </div>
</div>

<script>
    var simage;
    var rrimage;
    Array.prototype.forEach.call(document.querySelectorAll('#imageup'), function(button) {
        const hiddenInput = document.querySelector('#supportimage');

        button.addEventListener('click', function() {
            hiddenInput.click();
        });

       /* hiddenInput.addEventListener('change', function() {
            simage = hiddenInput.files[0]; //document.getElementById('myfile').files[0];
        });*/
    });

    Array.prototype.forEach.call(document.querySelectorAll('#repmed'), function(button) {
        const hiddenInput = document.querySelector('#medreport');

        button.addEventListener('click', function() {
            hiddenInput.click();
        });

        hiddenInput.addEventListener('change', function() {
            rimage = hiddenInput.files[0]; //document.getElementById('myfile').files[0];
        });
    });
</script>
<script src="js/accidentreport.js"></script>
<?php
include_once "footer.php";
?>