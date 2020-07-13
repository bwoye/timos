$(document).ready(function(){
    $('#formpasschange').on('submit',function(ev){
        ev.preventDefsult();
        // if($('oldpass').val()=='' | $('newpass1').val() | $('oldpass').val()){
        //     alert("Fill in all fields");
        //     return false;
        // }
        alert("U have submitted form");
    });
});