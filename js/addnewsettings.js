jq = $.noConflict();
jq(document).ready(function () {

    //Things to do with districts
    jq(document).on('click', '.btn_dists', function () {

        jq.post('php/addnewsettings.php', { dists: "yes" }, function (some) {
            let mines = JSON.parse(some);
            let dins = mines.districts;
            let tt = '';
            tt += "<h3>Districts</h3>";
            tt += "<button class='adddist hdbut' data-toggle='modal' data-target='#distmodal'>Add District</button>";
            tt += "<table id='dists'>";
            tt += "<thead><tr><th></th><th>Name</th><th>Region</th><th></th></tr></thead>";
            tt += "<tboby>";
            let k = 0;
            dins.forEach(m => {
                tt += `<tr rowid='${m.distcode}'><td align='right'>${++k}</td><td>${m.distname}</td>
                <td>${m.Region}</td><td><button class='editdist rowbut' data-toggle='modal' data-target='#distmodal'>Edit</button><button class='deldist rowbut'>Delete</button></td></tr>`
            });
            tt += "</tbody></table>";
            jq(document).find('.holdetails').html(tt);
        });
    });

    jq(document).on('click', '.adddist', function () {
        jq(document).find('#distmodal .modal-dialog .modal-content .modal-body .modal_title').html("<h3>Add District</h3>");
        jq('#distname').val('');
        jq('#region').val('');
        jq('#distcode').val('');
    });

    jq('#district_form').on('submit', function (ev) {
        ev.preventDefault();
        var snd;
        if (jq('#distcode').val() == '') {
            snd = {
                distname: jq('#distname').val(),
                Region: jq('#region').val(),
                distadd: "yes"
            }

            jq.post('php/addnewsettings.php', snd, function (some) {
                let mines = JSON.parse(some);
                var tr = `<tr rowid='${mines.distcode}'><td>0</td><td>${mines.distname}</td>
                <td>${mines.Region}</td>
                <td><button class='editdist rowbut' data-toggle='modal' data-target='#distmodal'>Edit</button><button class='deldist rowbut'>Delete</button></td></tr>`
                if (jq('#dists tbody tr').length < 1) {
                    jq('#dists tbody').append(tr);
                } else {
                    var trow = jq('#dists tbody tr').eq(0);
                    trow.before(tr);
                }
                var kk = 0;
                jq('#dists tbody tr', function () {
                    kk += 1;
                    jq(this).find('td:eq(0)').text(kk);
                });
            });
        } else {
            snd = {
                distname: jq('#distname').val(),
                Region: jq('#region').val(),
                distcode: jq('#distcode').val(),
                editdist: "yes"
            };
            jq.post('php/addnewsettings.php', snd, function (some) {
                let mines = JSON.parse(some);
                console.log(mines);
                if (mines.error === false) {
                    var tr = jq("#dists tbody tr[rowid='" + mines.distcode + "']");
                    tr.find('td:eq(1)').text(mines.distname);
                    tr.find('td:eq(2)').text(mines.Region);
                    tr.css({ 'background-color': 'blue', 'color': 'white' });
                }
            });
        }
        jq('#distmodal').modal('hide');

    });

    jq(document).on('click', '.editdist', function () {
        let myrow = jq(this).closest('tr');
        jq(document).find('#distmodal .modal-dialog .modal-content .modal-body .modal_title').html("<h3>Edit District</h3>");
        jq('#distname').val(myrow.find('td:eq(1)').text());
        jq('#region').val(myrow.find('td:eq(2)').text());
        jq('#distcode').val(myrow.attr('rowid'));
    });

    jq(document).on('click', '.deldist', function () {
        let myrow = jq(this).closest('tr');
        let myid = myrow.find('td:eq(1)').attr('rowid');

        jq.post('php/addnewsettings.php', { distdel: myid }, function (some) {
            let mines = JSON.parse(some);
        });
    });
    //District things end here-----------------------------------------------------------------------------------------

    //Sub counties start here ===========================================================================================
    jq(document).on('click', '.btn_subcounties', function () {
        let tt = '';
        tt += "Edit / Add Sub counties<br>";
        jq(document).find('.holdetails').html(tt);
        var xl = "<select id='mydistselect' name='mydistselect'></select>";
        jq(document).find('.holdetails').append(xl);
        jq('#mydistselect').empty();
        jq.post('php/addnewsettings.php', { dists: "getall" }, function (some) {
            var mines = JSON.parse(some);
            jq('#mydistselect').append("<option value='0' selected disabled>Select district</option>");

            for (s in mines.districts) {
                jq('#mydistselect').append("<option value='" + mines.districts[s].distcode + "'>" + mines.districts[s].distname + "</option>");
            }
        });
    });

    jq(document).on('change', '#mydistselect', function () {
        let fr = jq(this).val();
        const yy = document.getElementsByTagName("table");
        let jk = yy.length;

        for (let i = 0; i < jk; i++) {
            yy[0].remove();
        }

        jq.post('php/addnewsettings.php', { masaza: fr }, function (some) {
            var mines = JSON.parse(some);
            var saza = mines.sazas;

            console.log(saza)
            let tt = '';
            tt += "<table id='tsazas'>";
            tt += "<thead><tr><th colspan='3'><button class='addsaza hdbut' data-toggle='modal' data-target='#subcountymodal' >Add Subcounty</button></th></tr>";
            tt += "<tr><th></th><th>Name</th><th></th></tr></thead>";
            tt += "<tbody>";
            let k = 0;
            saza.forEach(h => {
                tt += `<tr rowid='${h.code}' distcode='${h.distcode}'><td align='right'>${++k}</td><td>${h.name}
                </td><td><button class='editsaza rowbut' data-toggle='modal' data-target='#subcountymodal' >Edit</button><button class='deletesaza rowbut'>Delete</button></td></tr>`
            });
            tt += "</tbody></table>";

            jq(document).find('.holdetails').append(tt);
        });
    });

    jq(document).on('click','.addsaza',function(){
        //jq('.saza-title').empty();
        //jq('.saza-title').html("<h2>Add new Subcounty");
        jq('#subdistcode').val('');
        jq('#cname').val('');
        jq('#code').val('');
    });

    jq(document).on('click', '.editsaza', function () {
        var myrow = jq(this).closest('tr');
        jq('#cname').val(myrow.find('td:eq(1)').text());
        jq('#code').val(myrow.attr('distcode'));
        jq('#subdistcode').val(myrow.attr('rowid'));
    })

    jq('#subcounty_form').on('submit', function (ev) {
        ev.preventDefault();
        if (jq('#subdistcode').val() === '') {
            var snd = {
                name: jq('#cname').val(),
                distcode: jq('#code').val(),
                addsubs: "yes"
            }

            jq.post('php/addnewsettings.php', snd, function () {
                var mines = JSON.parse(some);
                alert(mines.errmsg);
            });
        } else {
            var snd = {
                distcode: jq('#code').val(),
                code: jq('#subdistcode').val(),
                name: jq('#cname').val(),
                editsubs: "yes"
            }

            jq.post('php/addnewsettings.php', snd, function (some) {
                var mines = JSON.parse(some);
                var tr = jq("#tsazas tbody tr[rowid='" + mines.code + "']");

                tr.find('td:eq(1)').text(mines.name);
                tr.css({ "background-color": "black", "color": "white" });
            });
        }

        jq('#subcountymodal').modal('hide');
    });


    //Sub counties end here ==================================================================================

    //Let us do body parts now
    jq(document).on('click', '.btn_parts', function () {

        jq.post('php/addnewsettings.php', { bpbody: "yes" }, function (some) {
            var mines = JSON.parse(some);
            var c = mines.bparts;

            let tt = '';
            tt += "<table id='bparts'>";
            tt += "<thead><tr><th colspan='2'><button class='hdbut add-bparts' data-toggle='modal' data-target='#partsmodal'>Add parts</button><th></tr>";
            tt +="<tr><th></th><th>name</th><th></th></tr></thead>";
            tt += "<tbody>";
            let k = 0;
            c.forEach(d => {
                tt += `<tr rowid='${d.bno}'><td align='right'>${++k}</td>
                <td>${d.bparts}</td>
                <td><button class='body-injure rowbut' data-toggle='modal' data-target='#partsmodal'>Edit</button><button class='butdelete rowbut'>Delete</button></td></tr>`
            });
            tt += "</tbody></table>";
            jq(document).find('.holdetails').html(tt);
        });
    });

    jq(document).on('click', '.body-injure', function () {
        var myrow = jq(this).closest('tr');
        jq('#injtype').val(myrow.find('td:eq(1)').text());
        jq('#bno').val(myrow.attr('rowid'));
    });

    jq('#partsmodal').on('submit', function (ev) {
        ev.preventDefault();
        if (jq('#bno').val() != '') {
            var snd = {
                bno: jq('#bno').val(),
                injtype: jq('#injtype').val(),
                injedit: "yes"
            }

            jq.post('php/addnewsettings.php', snd, function (some) {
                var mines = JSON.parse(some);
                var tr = jq("#bparts tbody tr[rowid='" + mines.bno + "']");
                tr.find('td:eq(1)').text(mines.injtype);
                tr.css({ "background-color": "black", "color": "white" });
            });
        } else {
            var snd ={
                
                injtype:jq('#injtype').val(),
                injadd:"yes"
            }

            jq.post('php/addnewsettings.php',snd,function(some){
                var mines = JSON.parse(some);
                alert(mines.errmsg);
            })
        }
    });

    //Body parts end here===============================================================================================


    //Let us do countries
    jq(document).on('click', '.btn_countries', function () {

        jq.post('php/addnewsettings.php', { cts: "yes" }, function (some) {
            var mines = JSON.parse(some);

            let tt = '';
            tt += "Edit countries";
            tt += "<table id='countries'>";
            tt += "<thead><tr><th></th><th>Name</th></tr></thead>";
            tt += "<tbody>";
            let k = 0;
            mines.forEach(l => {
                tt += `<tr><td align='right'>${++k}</td>
            <td cid='${l.idno}'>${l.namex}</td>
            <td><button class='editcountry rowbut'>Edit</button><button class='delcountry rowbut'>Delete</button></td></tr>`
            });
            tt += "<tbody></table>";
            jq(document).find('.holdetails').html(tt);
        });

    });

    //Counties end here =========================================================================================

    jq(document).on('click', '.acc-place', function () {
        jq.post('php/addnewsettings.php', { accidents: "yes" }, function (some) {
            var mined = JSON.parse(some);
            mines = mined.places;
            let tt = '';
            tt += "Edit Accident Places";
            tt += "<table id='accident-table'>";
            tt += "<thead><tr><th colspan='3'><button class='hdbut add-accident' data-toggle='modal' data-target='#accidentmodal'>Add Accident Place</button><th></tr>";
            tt += "<tr><th></th><th>Name</th></tr></thead>";
            tt += "<tbody>";
            let k = 0;
            mines.forEach(l => {
                tt += `<tr cid='${l.accplace}'><td align='right'>${++k}</td>
            <td>${l.place}</td>
            <td><button class='btn-accplace rowbut' data-toggle='modal' data-target='#accidentmodal'>Edit</button><button claas='btndel-accplace rowbut'>Delete</button></td></tr>`
            });
            tt += "</tbody></table>";
            jq(document).find('.holdetails').html(tt);
        });
    });

    jq(document).on('click','.btn-accplace',function(){
        var myrow = jq(this).closest('tr');
        jq('#place').val(myrow.find('td:eq(1)').text());
        jq('#accplace').val(myrow.attr('cid'));
    });

    jq(document).on('click','.add-accident',function(){
        jq('#place').val();
        jq('#accplace').val();
    });

    jq('#accident-place-form').on('submit',function(ev){
        ev.preventDefault();
        if(jq('#accplace').val() == ''){
            var snd ={
                place:jq('#place').val(),
                accplace:jq('#accplace').val(),
                newaccident:"yes"
            }
            jq.post('php/addnewsettings.php',snd,function(some){
                var mines = JSON.parse(some);
                var tr = "<tr cid='"+mines.accplace+"'><td align='0'>"+mines.place+" <td><button class='btn-accplace rowbut' data-toggle='modal' data-target='#accidentmodal'>Edit</button><button claas='btndel-accplace rowbut'>Delete</button></td></tr>";
                tr.css({"background-color":"black","color":"white"});
                if(jq('#accident-table tbody tr').length < 1){
                    jq('#accident-table tbody').append(tr);
                }else{
                    trow = jq('#accident-table tbody tr').eq(0);
                    tr.before(trow);
                }

            });
        }else{
            var snd ={
                place:jq('#place').val(),
                accplace:jq('#accplace').val(),
                editaccident:"yes"
            }

            jq.post('php/addnewsettings.php',snd,function(some){
                var mines = JSON.parse(some);
                var tr = jq("#accident-table tbody tr[cid='"+mines.accplace+"']");
                tr.find('td:eq(1)').text(mines.place);
                tr.css({"background-color":"black","color":"white"});
            });
        }
        jq('#accidentmodal').modal('hide');
    });
    //Accident places ends here ================================================================================

    jq(document).on('click', '.injury-nature', function () {

        jq.post('php/addnewsettings.php', { injnature: "yes" }, function (some) {
            var mines = JSON.parse(some);

            let tt = '';
            tt += "Injury Nature";
            tt += "<table id='injury-table'>";
            tt += "<thead><tr><th colspan='2'><button class='hdbtn add-inj-nature' data-toggle='modal' data-target='#injurymodal'>Add Injury nature</th></tr>"
            tt += "<tr><th></th><th>Name</th></tr></thead>";
            tt += "<tbody>";
            let k = 0;
            mines.forEach(l => {
                tt += `<tr cid='${l.injnature}'><td align='right'>${++k}</td>
                <td>${l.nature}</td>
                <td><button class='btn-edit-injury rowbut' data-toggle='modal' data-target='#injurymodal'>Edit</button><button class='btn-delete-injury rowbut'>Delete</button></td></tr>`
            });
            tt += "<tbody></table>";
            jq(document).find('.holdetails').html(tt);
        });
    });

    jq(document).on('click','#add-inj-nature',function(){
        jq('#nature').val('');
        jq('#injnature').val('');
    });


    jq(document).on('click','.btn-edit-injury',function(){
        var myrow = jq(this).closest('tr');
        jq('#nature').val(myrow.find('td:eq(1)').text);
        jq('#injnature').val(myrow.attr('cid'));
    });


    jq('#injury-form').on('submit',function(){
        if(jq('#injnature').val() == ''){
            var snd = {
                injnature:jq('#injnature').val(),
                place:jq('#place').val(),
                addinginj:"yes"
            }
            jq.post('php/addnewsettings.php',snd,function(some){
                var mines = JSON.parse(some);
                tr = `<tr cid='${mines.injnature}'><td align='right'>0</td>
                <td>${mines.nature}</td>
                <td><button class='btn-edit-injury rowbut' data-toggle='modal' data-target='#injurymodal'>Edit</button><button class='btn-delete-injury rowbut'>Delete</button></td></tr>`

                tr.css({"background-color":"black","color":"white"});
            });
        }else{
            var snd = {
                injnature:jq('#injnature').val(),
                place:jq('#place').val(),
                editinj:"yes"
            }

            jq.post('php/addnewsettings.php',snd,function(some){
                var mines = JSON.parse(some);

                var tr = jq("#injury-table tbody tr[cid='"+mines.injnature+"']");
                tr.find('td:eq(1)').text(mines.nature);
                tr.css({"background-color":"black","color":"white"});
            });
        }
    });


    ///End og injury things ===================================================================================

    //Accident type begins here
    jq(document).on('click','.acc-type',function(){
        jq.post('php/addnewsettings.php',{acctype:'yes'},function(some){
            var mines = JSON.parse(some);
            var tt = '';
            tt += "<table id='acctype-table'>";
            tt += "<thead><tr><th colspan='2'><button class='hdbtn btnaccnew'>Add new Accident type</button></th></tr>";
            tt += "<tr><th></th><th>name</th><th></th></tr></thead>";
            let k = 0;
            tt += "<tbody>";
            mines.forEach(g => {
                tt += `<tr rowid='${g.typeno}'><td align='right'>${++k}</td>
                <td>${g.nametype}</td>
                <td><button class='editactype rowbut'>Edit</button><button class='rowbut delacctype'>Delete</button></td></tr>`
            });
            tt +="</tbody></table>";
            jq(document).find('.holdetails').html(tt);
        });
    });

    jq(document).on('click','.btnaccnew',function(){
        jq('#nametype').val();
        jq('#typeno').val();
    });

    jq(document).on('click','.editactype',function(){
        var myrow = jq(this).closest('tr');
        jq('#nametype').val(myrow.find('td:eq(1)').text());
        jq('#typeno').val(myrow.attr('rowid'));
    });

    jq('#acctype-form').on('submit',function(ev){

        if(jq('#typeno').val() == ''){
            var snd = {
                nametype:jq('#nametype').val(),
                acctypeadd:"yes"
            }

            jq.post('php/addnesettings.php',snd,function(some){
                var mines = JSON.parse(some);
                var tr = `<tr rowid='${mines.typeno}'><td align='right'>0</td>
                <td>${mines.nametype}</td>
                <td><button class='editactype rowbut'>Edit</button><button class='rowbut delacctype'>Delete</button></td></tr>`;
                tr.css({"background-color":"black","color":"white"});
                if(jq('#acctype-table tbody tr').length < 1){
                    jq('#acctype-table tbody').appenf(tr);
                }else{
                    var trow = jq('#acctype-table tbody tr').eq(0);
                    tr.before(trow);
                }
            });
        }else{
            var snd = {
                nametype:jq('#nametype').val(),
                editacctype:"yes",
                typeno:jq('#typeno').val()
            }
            jq.post('php/addnesettings.php',snd,function(some){
                var mines = JSON.parse(some);
                var tr = jq("#acctype-table tbody tr[rowid='"+mines.typeno+"']");
                tr.find('td:eq(1)').text(mines.nametype);
                
                tr.css({"background-color":"black","color":"white"});
            });
        }

        jq('#acctypemodal').modal('hide');
    });

    //Accident type ends here

    jq(document).on('click', '.acc-agent', function () {
        let tt = '';
        tt += "Edit accident agents";
        jq(document).find('.holdetails').html(tt);
    });

    jq(document).on('click', '.job-title', function () {
        let tt = '';
        tt += "Edit job titles";
        jq(document).find('.holdetails').html(tt);
    });


});