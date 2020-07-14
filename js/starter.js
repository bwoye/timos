$(document).ready(function(){    
    $.post('php/starter.php',function(some){
        mines = JSON.parse(some);
        console.log(mines);
    })
    // console.log(123);
});