<?php
include_once "header.php";
?>

<!-- put styles hear -->
<script src="js/addnewsettings.js"></script>
<style>
    .mybuts {
        height: 2.5em;
        line-height: 12px;
        font-size: 12px;
    }

    .mysettings {
        display: none;
        width: 80%;
    }
</style>

<?php include_once "headerbody.php" ?>
<section class="main-container">
    <div class="main-wrapper">
        <h3>Modify Settings</h3>
        <?php
        if (isset($_SESSION['userid'])) {

            echo '<div style="margin:0 auto" class="btn-group btn-group-xs" role="group"><button type="button" class="btn   btn-success btn_dists mybuts">Districts</button><button type="button" class="btn btn-success btn_subcounties mybuts">Sub Counties</button><button type="button" class="btn btn-success btn_parts mybuts">Body Injuries</button><button type="button" class="btn btn-success btn_countries mybuts">Add Country</button><button type="button" class="btn btn-success acc-place mybuts">Accident Place</button><button type="button" class="btn btn-success injury-nature mybuts">Nature of Injury</button><button type="button" class="btn btn-success acc-type mybuts">Accident Type</button><button type="button" class="btn btn-success acc-agent mybuts">Accident Agent</button></div>';
            echo "<div id='mysiblings' style='margin:0 auto'>";            
        }
        ?>
        <div class="holdetails">
        </div>
    </div>
</section>
<div id="distmodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button><br />
            </div>
            <div class="modal-body">
                <h2 class="modal_title">New District</h2>
                <form method="post" id="district_form">
                    <label style="width:150px;">Name</label>
                    <input type="text" id="distname" name="distname" style="width:250px;" required /><br />
                    <label style="width:150px;padding-top:25px">Region</label>
                    <select id="region" name="region" style="width:250px">
                    <option value="N">Nothern</option>
                    <option value="W">Western</option>
                    <option value="S">Southern</option>
                    <option value="E">Eastern</option>
                    <option value="C">Central</option>
                    </select><br />

                    <input type="hidden" id="distcode" name="distcode" />

                    <input type="submit" class="btn btn-success" id="dinsert2" name="dinsert2" value="Insert" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="subcountymodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button><br />
            </div>
            <div class="modal-body">
                <h2 class="modal_title saza-title"><h2>New Subcounty</h2>
                <form method="post" id="subcounty_form">
                    <label style="width:150px;">Name</label>
                    <input type="text" id="cname" name="cname" style="width:250px;" required /><br />

                    <input type="hidden" id="subdistcode" name="subdistcode" />
                    <input type="hidden" id="code" name="code" />

                    <input type="submit" class="btn btn-success" id="dinsert" name="dinsert" value="Insert" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="partsmodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button><br />
            </div>
            <div class="modal-body">
                <h2 class="modal_title">New Body Part</h2>
                <form method="post" id="body_form">
                    <label style="width:150px;">Injury Type</label>
                    <input type="text" id="injtype" name="injtype" style="width:250px;" required /><br />

                    <input type="hidden" id="bno" name="bno" />

                    <input type="submit" class="btn btn-success" id="dinsert3" name="dinsert3" value="Insert" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div id="accidentmodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button><br />
            </div>
            <div class="modal-body">
                <h2 class="modal_title">Accident Places</h2>
                <form method="post" id="accident-place-form">
                    <label style="width:150px;">Accident Place</label>
                    <input type="text" id="place" name="place" style="width:250px;" required /><br />

                    <input type="hidden" id="accplace" name="accplace" />

                    <input type="submit" class="btn btn-success" id="dinsert7" name="dinsert7" value="Insert" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="injurymodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button><br />
            </div>
            <div class="modal-body">
                <h2 class="modal_title">Injury Nature </h2>
                <form method="post" id="injury-form">
                    <label style="width:150px;">nature</label>
                    <input type="text" id="nature" name="nature" style="width:250px;" required /><br />

                    <input type="hidden" id="injnature" name="injnature" />

                    <input type="submit" class="btn btn-success" id="dinsert8" name="dinsert8" value="Insert" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="acctypemodal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button><br />
            </div>
            <div class="modal-body">
                <h2 class="modal_title">Injury Nature </h2>
                <form method="post" id="acctype-form">
                    <label style="width:150px;">nature</label>
                    <input type="text" id="nametype" name="nametype" style="width:250px;" required /><br />

                    <input type="hidden" id="typeno" name="typeno" />

                    <input type="submit" class="btn btn-success" id="dinsert9" name="dinsert9" value="Insert" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php
include_once "footer.php";
?>