jq = $.noConflict();
jq(document).ready(function(){
    jq.post('php/official.php',function(some){
        let mines = JSON.parse(some);
        let dists = mines.districts;
        //Populate the distirct combo
        jq('#dist-list').append("<option value='0' disabled selected>Select district</option>");

        for(j in dists){
            jq('#dist-list').append("<option value='"+dists[j].distcode+"'>"+dists[j].distname+"</option>"); 
        }
    });

    jq(document).on('change','#dist-list',function(){
        let lookup = jq(this).val();
        jq.post('php/officialdetails.php',{lookup:lookup},function(some){
            let mines = JSON.parse(some);
            console.log(mines);
        });
    });
});