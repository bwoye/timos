jq = $.noConflict();
jq(document).ready(function(){
    jq('#blog-form').on('submit',function(ev){
        ev.preventDefault();
        var snd = {
            emailadd:jq('#emailadd').val(),
            phone:jq('#phone').val(),
            fulname:jq('#fulname').val(),
            employer:jq('#employer').val(),
            accplace:jq('#accplace').val(),
            emailadd:jq('#emailadd').val(),
            description:jq('#description').val(),
            dateaccident:jq('#datereported').val(),
            adding:"yes"
        };

        jq.post('php/blogs.php',snd,function(some){
            var mines = JSON.parse(some);
        });
    })
});