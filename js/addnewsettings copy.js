$(document).ready(function () {
    $(document).on('click', '.btn_dists', function () {
        $.post('php/district.php', function (some) {
            var mines = JSON.parse(some);
            var tab = '';
            var k = 1;
            tab += "<table id='distable' class='table table-border table-hover'>";
            tab += "<thead><tr><button type='button' class='btn btn-success mybuts newdist' data-toggle='modal' data-target='#distmodal'>Add District</button></tr>";
            tab += "<tr><th>#</th><th>Name</th><th>action</th></tr></thead>";
            tab += "<tbody>";
            for (s in mines.districts) {
                tab += "<tr distcode='" + mines.districts[s].distcode + "'>";
                tab += "<td align='right'>" + k + "</td>";
                tab += "<td>" + mines.districts[s].distname + "</td>";
                tab += "<td><div class='btn-group btn-group-xs' role='group'><button type='button' class='btn btn-primary btn_editdist mybuts' data-toggle='modal' data-target='#distmodal'>Edit</button><button type='button' class='btn btn-danger btn_deldist mybuts'>Delete</button</div></td>";
                tab += "</tr>";
                k += 1;
            }
            tab += "</tbody></table>";
            $(document).find('#dists').html(tab);

            hideme('#mydistricts'); ///.show();
        })
    });

    // $(document).on('click','.btn_counties',function(){
    //     hideme('#mycounties');
    // });

    $(document).on('click', '.btn_editdist', function () {
        $('#district_form')[0].reset();
        $('.modal_title').html("Edit district");
        //$('#addmodal').modal('hide');
        var myrow = $(this).closest('tr');
        $('#distcode').val(myrow.attr('distcode'));
        $('#distname').val(myrow.find('td:eq(1)').text());
    });

    $(document).on("click", '.newdist', function () {
        $('.modal_title').html("New district");
        $('#distcode').val('');
        $('#district_form')[0].reset();
    });

    $('#subcounty_form').on('submit', function (ev) {
        ev.preventDefault();
        //alert("submitting subcounty");
        var snd;

        if ($('#code').val() == '') {
            snd = {
                name: $('#cname').val(),
                distcode: $('#subdistcode').val(),
                adding: "yes",
                subcounty: "yes",
                addsubcounty: "yes"
            }
        } else {
            snd = {
                name: $('#cname').val(),
                distcode: $('#subdistcode').val(),
                editing: "yes",
                subcounty: "yes",
                editing: "yes",
                code: $('#code').val()
            }
            $.post('php/addnewsettings.php', snd, function (some) {
                var ele = $("tr[code='" + snd['code'] + "']");
                ele.find('td:eq(1)').text(snd['name']);
                ele.css({ 'background-color': 'blue', 'color': 'white' });
            });
            $('#subcounty_form')[0].reset();
            $('#subcountymodal').modal('hide');
            $('#code').val();
            return false;

        }

        //document.write(JSON.stringify(snd));
        $('#subcounty_form')[0].reset();
        $('#subcountymodal').modal('hide');
        $('#code').val();
        $.post('php/addnewsettings.php', snd, function (some) {
            var mines = JSON.parse(some);
            alert(some);
            var nrow = $(document).find('#subcount tbody tr').eq(0);
            var tbl = '';
            tbl += "<tr code='" + mines.code + "'>";
            tbl += "<td align='right'></td>";
            tbl += "<td>" + mines.name + "</td>";
            tbl += "<td><div class='btn-group btn-group-xs' role='group'><button type='button' class='btn btn-primary btn_editcounty mybuts' data-toggle='modal' data-target='#subcountymodal'>Edit</button><button type='button' class='btn btn-danger btn_county mybuts'>Delete</button</div></td>"
            tbl += '</tr>';

            tbl.css({ 'background-color': 'black', 'color': 'white' });

            if ($('#subcount tbody tr').length < 1) {
                $('#subcount tbody').append(tbl);
            } else {
                nrow.before(tbl);
            }

            var tt = 0;

            $.each($('#subcount tbody tr').find('td:eq(0)'), function () {
                tt += 1;
                $(this).text(tt);

            });
        });
    });

    $(document).on('click', '.btn_county', function () {
        var myrow = $(this).closest('tr');
        snd = {
            subcounty: "yes",
            delete: myrow.attr('code')
        }

        $.post('php/addnewsettings.php', snd, function () {
            myrow.remove();
        });
    });

    $('#district_form').on('submit', function (ev) {
        event.preventDefault();
        var snd
        if ($('#distcode').val() == '') {
            snd = {
                distname: $('#distname').val(),
                adding: "yes",
                Region: "no"
            }

            $.post('php/district.php', snd, function (some) {
                var mines = JSON.parse(some);
                var tab = '';
                tab += "<tr distcode='" + mines.distcode + "'>";
                tab += "<td align='right'>0</td>";
                tab += "<td>" + mines.distname + "</td>";
                tab += "<td><div class='btn-group btn-group-xs' role='group'><button type='button' class='btn btn-primary btn_editdist mybuts' data-toggle='modal' data-target='#distmodal'>Edit</button><button type='button' class='btn btn-danger btn_deldist mybuts'>Delete</button</div></td>";
                tab += "</tr>";

                if ($('#distable tbody tr').length < 1) {
                    $('#distable tbody').append(tab);
                } else {
                    nrow = $('#distable tbody tr').eq(0);
                    nrow.before(tab);
                }
                tab.css({ 'background-color': 'black', 'color': 'white' });

                tt = 0;
                $.each($('#distable tbody tr').find('td:eq(0)'), function () {
                    tt += 1;
                    $(this).text(tt);
                });
            });
        } else {
            snd = {
                distcode: $('#distcode').val(),
                distname: $('#distname').val(),
                editing: "yes",
                Region: "no"
            }
            $.post('php/district.php', snd, function (some) {
                var mines = JSON.parse(some);
                if (mines.error)
                    return false;
                var ele = $("tr[distcode='" + snd['distcode'] + "']");
                ele.find('td:eq(1)').text(snd['distname']);
                ele.css({ 'background-color': 'black', 'color': 'white' });
            });
        }
        //document.write(JSON.stringify(snd));

        $('#distmodal').modal('hide');
        $("#district_form")[0].reset();
    });

    $(document).on('click', '.btn_subcounties', function () {

        $.post('php/addnewsettings.php', { subcounty: "yes" }, function (some) {
            var mines = JSON.parse(some);
            $('#ddist').empty();
            $('#ddist').append("<option value='k' disabled selected>Select district</option>");
            for (s in mines.districts) {
                $('#ddist').append("<option value='" + mines.districts[s].distcode + "'>" + mines.districts[s].distname + "</option>");
            }
        });
        hideme('#div_subcounties');
    });

    $('#ddist').on('change', function () {
        $('#subdistcode').val($(this).val());
        var snd = {
            pagecounty: $(this).val()
        }
        $.post('php/addnewsettings.php', snd, function (some) {
            var mines = JSON.parse(some);
            var tab = '';
            var k = 1;
            tab = "<table class='table table-border table-hover' id='subcount'>";
            tab += "<thead><tr><th><button type='button' class='btn btn-success mybuts newcount' data-toggle='modal' data-target='#subcountymodal'>Add Subcounty</button></th></tr>"
            tab += "<tr><th>#</th><th>Name</th><th>Action</th></tr></thead>";
            tab += "<tbody>";
            for (s in mines.subcounties) {
                tab += "<tr code='" + mines.subcounties[s].code + "'>";
                tab += "<td align='right'>" + k + "</td>";
                tab += "<td>" + mines.subcounties[s].name + "</td>";
                tab += "<td><div class='btn-group btn-group-xs' role='group'><button type='button' class='btn btn-primary btn_editcounty mybuts' data-toggle='modal' data-target='#subcountymodal'>Edit</button><button type='button' class='btn btn-danger btn_county mybuts'>Delete</button</div></td>"
                tab += '</tr>';
                k += 1;
            }

            tab += "</tbody></table>";
            $(document).find('#subcounts').html(tab);
        })
    });

    $(document).on('click', '.btn_editcounty', function (ev) {
        ev.preventDefault();
        var myrow = $(this).closest('tr');
        $('#cname').val(myrow.find('td:eq(1)').text());
        $('#code').val(myrow.attr('code'));
 
    });

    $("#body_form").on('submit', function (ev) {
        ev.preventDefault();
        var snd;
        if ($('#bno').val() == '') {
            snd = {
                binjure: "yes",
                addinjure: "yes",
                injtype: $('#injtype').val()
            }

            $.post('php/addnewsettings.php', snd, function (some) {
                var mines = JSON.parse(some);
                nrow = $('#bins tbody tr').eq(0);

                var tab = '';
                tab += "<tr bparts='" + mines.bno + "'>";
                tab += "<td align='right'>0</td>";
                tab += "<td>" + mines.injtype + "</td>";
                tab += "<td><div class='btn-group btn-group-xs' role='group'><button type='button' class='btn btn-primary btn_partedit mybuts' data-toggle='modal' data-target='#partsmodal'>Edit</button><button type='button' class='btn btn-danger btn_partdelete mybuts'>Delete</button</div></td>";
                tab += "</tr>";

                if ($('#bins tbody tr').length < 1) {
                    $('#bins tbody').append(tab);
                } else {
                    nrow.before(tab);
                }
                tt = 0;
                $.each($('#bins tbody tr').find('td:eq(0)'), function () {
                    tt += 1;
                    $(this).val(tt);
                });
            });
        } else {
            snd = {
                binjure: "yes",
                bedit: "yes",
                injtype: $('#injtype').val(),
                bno: $('#bno').val()
            }

            $.post('php/addnewsettings.php', snd, function () {
                ele = $("tr[bparts ='" + snd['bno'] + "']");
                ele.find('td:eq(1)').text(snd['injtype']);
                ele.css({ 'background-color': 'blue', 'color': 'white' });
            });
        }

        $('#partsmodal').modal('hide');
        $('#body_form')[0].reset();
    });

    $(document).on('click', '.btn_addparts', function () {
        $('#bno').val('');
        $('#body_form')[0].reset();
        $('.modal_title').html("Add body part");
    });

    $('.newcount').on('click', function () {
        $('#subcounty_form')[0].reset();
        $('#code').val('');
        $(".modal_title").html("Add subcounty");
    });

    $(document).on('click', '.btn_parts', function () {
        hideme('#mybodyparts');
        $.post('php/addnewsettings.php', { binjure: "yes" }, function (some) {
            var mines = JSON.parse(some);
            //alert(some);
            var tab = '';
            var k = 1;
            tab += "<table class='table table-border table hover' id='bins'>";
            tab += "<thead><tr><th><button type='button' class='btn btn-success btn_addparts mybuts' data-toggle='modal' data-target='#partsmodal'>Add Body Part</button></th></tr>";
            tab += "<tr><th>#</th><th>Name</th><th>action</th></tr></thead>";
            tab += "<tbody>";
            for (s in mines.bparts) {
                tab += "<tr bparts='" + mines.bparts[s].bno + "'>";
                tab += "<td align='right'>" + k + "</td>";
                tab += '<td>' + mines.bparts[s].injtype + "</td>";
                tab += "<td><div class='btn-group btn-group-xs' role='group'><button type='button' class='btn btn-primary btn_partedit mybuts' data-toggle='modal' data-target='#partsmodal'>Edit</button><button type='button' class='btn btn-danger btn_partdelete mybuts'>Delete</button></div></td>";
                tab += "</tr>";
                k += 1;
            }
            tab += "</tbody></table>";
            $('#mparts').html(tab);
        });
    });

    $(document).on('click', '.btn_partedit', function () {
        $('#body_form')[0].reset();
        $('.modal_title').html("Edit Body part");
        $('#bno').val($(this).closest('tr').attr('bparts'));
        $('#injtype').val($(this).closest('tr').find('td:eq(1)').text());
    });

    function hideme(me) {
        $(me).siblings().hide();
        $(me).show();
    }
});