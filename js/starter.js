$(document).ready(function(){    
    $.post('php/starter.php',function(some){
        // alert(some);
        mines = JSON.parse(some);
        console.log(mines);
    })
    // console.log(123);
});