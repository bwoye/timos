jq = $.noConflict();
jq(document).ready(function(){
    jq.post('php/blogs.php',{viewing:"yes"},function(some){
        var mines = JSON.parse(some);
        var tt= '';
        mines.forEach(j => {
            tt += `<div class='particulars'>
            <span>Name ${j.fulname}</span><span> Tel: ${j.phone}</span>
            <span>Email :${j.emailadd}</span><span>Place of Accident : ${j.accplace}</span>
            </div>
            <div class='accdets'>
            <span class='emps'>${j.employer}</span>
            <span>Date reported ; ${j.datereported}</span>
            <span class='description'>${j.description}</span>
            </div><div class='mydeletes'>
            <span>${j.dateaccident}</span><span><button class='btndel'>Delete blog</button>
            <input type='hidden' value='${j.idno}' id='idno'></div>`
        })

        jq(document).find('.container').append(tt);
    });

    jq(document).on('click','.btndel',function(){
        jq(this).hide();
        jq.post('php/blogs.php',{idelete:jq('#idno').val()},function(){
            
        });
    });
});