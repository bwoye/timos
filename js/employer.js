// '.tbl-content' consumed little space for vertical scrollbar, scrollbar width depend on browser/os/platfrom. Here calculate the scollbar width .
// $(window).on("load resize ", function() {
//   var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
//   $('.tbl-header').css({'padding-right':scrollWidth});
// }).resize();


$(document).ready(function () {
  $.post('php/employers.php', function (some) {
    var mines = JSON.parse(some);
    for (vk in mines.districts) {
      $('#distcode').append("<option value='" + mines.districts[vk].distcode + "'>" + mines.districts[vk].distname + "</option>");
      //$('#district1').append("<option value='"+mines.terms[kk].code+"'>"+mines.terms[kk].district+"</option>");
    }
    var k = 1;
    var tbl = '';
    tbl += "<table class='table table-hover table-bordered' id='employers'>";
    tbl += "<thead>"
    tbl += "<tr><td colspan='3'><input type='text' placeholder='Search' id='msearch' /></td><td colspan='4'><button type='button' class='btn btn-success btn_add mybuts' data-toggle='modal' data-target='#addmodal'>Add New Employer</button></td>"
    tbl += "<tr>";
    tbl += "<th>#</th><th>Name</th><th>Location</th><th>District</th><th>Phone</th><th>Email</th><th>Options</th>"
    tbl += "</tr>";
    tbl += "</thead>";
    tbl += "<tbody>";
    for (s in mines.employers) {
      tbl += "<tr empid='" + mines.employers[s].empid + "'>";
      tbl += "<td align='right'>" + k + "</td>";
      tbl += "<td>" + mines.employers[s].empname + "</td>";
      tbl += "<td>" + mines.employers[s].phyadd + "</td>";
      tbl += "<td dcode='" + mines.employers[s].distcode + "'>" + mines.employers[s].distname + "</td>";
      tbl += "<td>" + mines.employers[s].emptel + "</td>";
      tbl += "<td>" + mines.employers[s].uemail + "</td>";
      tbl += "<td><div class='btn-group btn-group-xs' role='group'><button type='button' class='btn btn-success btn_save mybuts' data-toggle='modal' data-target='#addmodal'>Edit</button><button type='button' class='btn mybuts mydels btn-danger'>Delete</button></div> </td>";
      tbl += "</tr>";
      k += 1;
    }
    tbl += "</tbody>";
    tbl += "</table>";

    $(document).find("#emplist").html(tbl);
  });

  $(document).on('click', '.btn_save', function (ev) {
    $('#insert_form')[0].reset();
    ev.preventDefault();
    $(document).find(".modal_title").html("Edit Employer Details");
    var myrow = $(this).closest('tr');

    $('#empid').val(myrow.attr('empid'));
    $('#empname').val(myrow.find('td:eq(1)').text());
    $('#phyadd').val(myrow.find('td:eq(2)').text());
    $('#distcode').val(myrow.find('td:eq(3)').attr('dcode'));
    $('#emptel').val(myrow.find('td:eq(4)').text());
    $('#uemail').val(myrow.find('td:eq(5)').text());
  });

  $('#insert_form').on('submit', function (ev) {
    ev.preventDefault();

    if ($('#empid').val() == '') {
      //alert("added a record for now");
      var snd = {
        phyadd: $('#phyadd').val(),
        adding: 'yes',
        distcode: $('#distcode').val(),
        empname: $('#empname').val(),
        emptel: $('#emptel').val(),
        uemail: $('#uemail').val()
      }
      // document.write(JSON.stringify(snd));
      // return;
      $.post('php/employers.php', snd, function (some) {
        var mines = JSON.parse(some);
        //alert(some);
        var nrow = $(document).find('#employers tbody tr').eq(0);
        tbl = '';
        tbl += "<tr empid='" + mines.newrec.empid + "' style='background-color:black;color:white;'>";
        tbl += "<td align='right'>" + mines.newrec.many + "</td>";
        tbl += "<td>" + mines.newrec.empname + "</td>";
        tbl += "<td>" + mines.newrec.phyadd + "</td>";
        tbl += "<td dcode='" + mines.newrec.distcode + "'>" + mines.newrec.distname + "</td>";
        tbl += "<td>" + mines.newrec.emptel + "</td>";
        tbl += "<td>" + mines.newrec.uemail + "</td>";
        tbl += "<td><div class='btn-group btn-group-xs' role='group'><button type='button' class='btn btn-success btn_save mybuts' data-toggle='modal' data-target='#addmodal'>Edit</button><button type='button' class='btn mybuts mydels btn-danger'>Delete</button></div> </td>";
        tbl += "</tr>";

        nrow.before(tbl);
      });
    } else {
      var snd = {
        empid: $('#empid').val(),
        phyadd: $('#phyadd').val(),
        distcode: $('#distcode').val(),
        empname: $('#empname').val(),
        emptel: $('#emptel').val(),
        uemail: $('#uemail').val()
      }

      $.post('php/employers.php', snd, function (some) {

        var mines = JSON.parse(some);

        var ele = $("tr[empid='" + mines.editRec.empid + "']");

        ele.find('td:eq(1)').text(mines.editRec.empname);
        ele.find('td:eq(2)').text(mines.editRec.phyadd);
        ele.find('td:eq(3)').text(mines.editRec.distname);
        ele.find('td:eq(3)').attr('dcode', mines.editRec.distcode);
        ele.find('td:eq(4)').text(mines.editRec.emptel);
        ele.find('td:eq(5)').text(mines.editRec.uemail);
        ele.css({ 'background-color': 'blue', 'color': 'white' });
      });
    }
    $('#insert_form')[0].reset();
    $('#addmodal').modal('hide');
  });

  $(document).on('click', '.bnt_add', function (ev) {

    ev.preventDefault();

    $('#empid').val('');

  });

  $(document).on('click', '.mydels', function (ev) {
    ev.preventDefault();
    var dels = $(this).closest('tr').attr('empid');

    mynum = $(this).closest('tr')
    var snd = {
      deleting: dels,
    }
    $(this).closest('tr').remove();
    $.post('php/employers.php', snd, function () { });
    var fm = 0;
    $('#employers tbody tr').each(function () {
      fm += 1;
      $(this).find('td:eq(0)').text(fm);
    });
  });


  $(document).on('keyup', '#msearch', function () {
    var value = $(this).val().toLowerCase().trim();

    var numrows = $("#employers tbody tr").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      return $(this).css('display') !== 'none';
    });

    if ($('#msearch').val() == '')
      $('#found').val('');
    else
      $('#found').val("Filtered " + numrows.length + " record(s)");

    //var numrows =  $(this) $(this).css('display') !== 'none'; 
  });
});

