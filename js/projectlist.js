$(document).ready(function () {
    var employers;

    $.post('php/projectlist.php', function (some) {
        //alert(some);
        var mines = JSON.parse(some);
        employers = mines.employers;

        for(s in mines.districts){
            $('#projdistrict').append("<option value='"+mines.districts[s].distcode+"'>"+mines.districts[s].distname+"</option>");
        }
    });

    $('#existemp').on('change', function () {
        if ($(this).val() == '') {
            $('#empid').val('');
            $('#uemail').val('');
            $('#emptel').val('');
            $('#seldis').val('');
            $('#projtable').empty();
        }
    });

    const myinput = document.querySelector('#existemp');
    const lookpanel = document.querySelector('#found');

    myinput.addEventListener('keyup', function () {
        const input = myinput.value;
        lookpanel.innerHTML = '';
        //$('#accide').val('');

        const suggestions = employers.filter(function (employer) {
            return employer.empname.toLowerCase().startsWith(input);
        });

        suggestions.forEach(function (suggested) {
            const div = document.createElement('div');
            div.innerHTML = suggested.empname;
            lookpanel.appendChild(div);
            div.addEventListener('click', function () {
                $('#empid').val(suggested.empid);
                myinput.value = suggested.empname;
                lookpanel.innerHTML = '';
                $('#uemail').val(suggested.uemail);
                $('#emptel').val(suggested.emptel);
                $('#seldis').val(suggested.distname);
                listprojects(suggested.empid);
            });

        });
        if (input == '')
            lookpanel.innerHTML = '';
    });

    function listprojects(empid) {
        $('#projtable').empty();
        $.post('php/projectlist.php', { project: empid }, function (some) {
            //alert(some);
            var mines = JSON.parse(some);
            if (mines.projects.length < 1)
                return false;
            var k = 1;
            var tab = '';
            tab = "<table id='proj'>";        
            // tab += "<thead><tr><th colspan='3'><button type='button' class='btn-success mybuts btnadd'>Add New Project</button></th><th colspan='6'></th></tr>";
            tab += "<thead><tr><th>#</th><th>Name</th><th>Owner</th><th>Nature</th><th>Type</th>";
            tab += "<th>District</th><th>Location</th><th>Cert No.</th><th>Action</th></tr></thead>";
            tab += "<tbody>";
            for (s in mines.projects) {
                tab += "<tr projid='" + mines.projects[s].projid + "'>";
                tab += "<td align='right'>" + k + "</td>";
                tab += "<td>" + mines.projects[s].projname + "</td>";
                tab += "<td>" + mines.projects[s].projowner + "</td>";
                tab += "<td>" + mines.projects[s].projnature + "</td>";
                tab += "<td>" + mines.projects[s].projtype + "</td>";
                tab += "<td distcode='" + mines.projects[s].projdistrict + "'>" + mines.projects[s].distname + "</td>";
                tab += "<td>" + mines.projects[s].projlocation + "</td>";
                tab += "<td>" + mines.projects[s].certno + "</td>";
                tab += "<td><div class='btn-group btn-group-xs' role='group'><button type='button' class='btn btn-success btn_edit mybuts' data-toggle='modal' data-target='#addmodal'>Edit</button><button type='button' class='btn mybuts mydels btn-danger'>Delete</button></div> </td>";

                tab += "</tr>";
                k += 1;
            }
            tab += "</tbody></table>";

            $(document).find('#projtable').html(tab);
        });
    }

    $(document).on('click','.mydels',function(){
        var projid = $(this).closest('tr').attr('projid');
        alert("You are deleting project "+projid);
    });

    $(document).on('click','.btn_edit',function(ev){
        ev.preventDefault();
        $('.myform')[0].reset();
        var myrow = $(this).closest('tr');
        $('#projid').val(myrow.attr('projid'));
        $('#projname').val(myrow.find('td:eq(1)').text());
        $('#projowner').val(myrow.find('td:eq(2)').text());
        $('#projnature').val(myrow.find('td:eq(3)').text());
        $('#projtype').val(myrow.find('td:eq(4)').text());
        $('#projdistrict').val(myrow.find('td:eq(5)').attr('distcode'));
        $('#projlocation').val(myrow.find('td:eq(6)').text());
        $('#certno').val(myrow.find('td:eq(7)').text());
        $('.modal_title').html('Editing Project');        
    });

    $(document).on('click','.btnadd',function(){
        if($('#empid').val() == ''){
            return false;
        }
        $('.myform')[0].reset();
    });

    $(document).on('submit', '.myform', function (ev) {

        ev.preventDefault();
        if ($('#empid').val() == '')
            return false;
        var snd;
        if ($('#projid').val() == '') {
            snd = {
                empid: $('#empid').val(),
                projname: $('#projname').val(),
                projnature: $('#projnature').val(),
                projtype: $('#projtype').val(),
                projdistrict: $('#projdistrict').val(),
                projlocation: $('#projlocation').val(),
                projowner: $('#projowner').val(),
                certno: $('#certno').val(),
                adding: "yes"
            }
        } else {
            snd = {
                empid: $('#empid').val(),
                projname: $('#projname').val(),
                projnature: $('#projnature').val(),
                projtype: $('#projtype').val(),
                projdistrict: $('#projdistrict').val(),
                projlocation: $('#projlocation').val(),
                projowner: $('#projowner').val(),
                certno: $('#certno').val(),
                projid: $('#projid').val(),
                editing: "yes"
            }
        }
        //document.write(JSON.stringify(snd));
        $('.myform')[0].reset();
        $('#addmodal').modal('hide');
        $.post('php/projectlist.php', snd, function (some) {
            listprojects($('#empid').val());
            alert("Project was added");
        });
    });
});