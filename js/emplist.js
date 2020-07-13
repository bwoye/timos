// '.tbl-content' consumed little space for vertical scrollbar, scrollbar width depend on browser/os/platfrom. Here calculate the scollbar width .
// $(window).on("load resize ", function() {
//   var scrollWidth = $('.tbl-content').width() - $('.tbl-content table').width();
//   $('.tbl-header').css({'padding-right':scrollWidth});
// }).resize();


$(document).ready(function () {
  $.post('php/employers.php', function (some) {
    var mines = JSON.parse(some);
    alert(some);
    var k = 1;
    var tbl = '';
    tbl += "<table class='table table-hover table-bordered' id='employers'>";
    tbl += "<thead>"
    tbl += "<tr>";
    tbl += "<th>#</th><th>Name</th><th>Location</th><th>District</th><th>Phone</th><th>Email</th>"
    tbl += "</tr>";
    tbl += "</thead>";
    tbl += "<tbody>";
    for (s in mines.employers) {
      tbl += "<tr>";
      tbl += "<td align='right'>" + k + "</td>";
      tbl += "<td>" + mines.employers[s].empname + "</td>";
      tbl += "<td>" + mines.employers[s].phyadd + "</td>";
      tbl += "<td dcode='" + mines.employers[s].distcode + "'>" + mines.employers[s].distname + "</td>";
      tbl += "<td>" + mines.employers[s].emptel + "</td>";
      tbl += "<td>" + mines.employers[s].uemail + "</td>";
      tbl += "</tr>";
      k += 1;
    }
    tbl += "</tbody>";
    tbl += "</table>";

    $(document).find("#emplist").html(tbl);
  });
});

