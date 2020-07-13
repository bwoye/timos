jq = $.noConflict();

let employers = [];
let districts = [];
let projects = [];
let accreport = [];
let scounts = [];


function xmlhtpp() {
    return new XMLHttpRequest();
}

xhr = xmlhtpp();

xhr.open("POST", 'php/employers.php', false);
xhr.setRequestHeader("Content-Type", "application/json");
xhr.onload = function () {
    if (xhr.status == 200) {
        let mines = JSON.parse(this.responseText);
        employers = mines.employers;
        districts = mines.districts;
    }
};
xhr.send();

//fill the project distrits
districts.forEach(m => {
    let pp = document.getElementById('projdistrict');
    let c = document.createElement('option');
    let p = document.getElementById('idistcode');
    let d = document.createElement('option');
    c.value = m.distcode;
    c.textContent = m.distname;
    d.value = m.distcode;
    d.textContent = m.distname;
    pp.append(c);
    p.append(d);
});


const myemps = document.querySelector('#empdrop');
const myempdiv = document.querySelector('.suggestions');

myemps.addEventListener('keyup', showthem);

function showthem() {
    const inputs = myemps.value.toLowerCase();
    myempdiv.innerHTML = '';
    //myempdiv.setAttribute("z-index",10);

    const msuggest = employers.filter(employer => {
        return employer.empname.toLowerCase().startsWith(inputs);
    });

    msuggest.forEach(function (m) {
        const div = document.createElement('div');
        div.append(m.empname);
        myempdiv.append(div);
        div.addEventListener('click', function () {
            document.getElementById('edistcode').value = m.distname;
            document.getElementById('empdrop').value = m.empname;
            document.getElementById('phyadd').value = m.phyadd;
            document.getElementById('uemail').value = m.uemail;
            document.getElementById('emptel').value = m.emptel;
            document.getElementById('empid').value = m.empid;
            getProjects();
            myempdiv.innerHTML = '';
        });
    });

    if (inputs == '')
        myempdiv.innerHTML = '';
}


function getProjects() {
    var snd = { idpro: document.getElementById('empid').value };
    jq.post('php/accidentcode.php', snd, function (some) {
        var mines = JSON.parse(some);
        projects = mines.injured;
        //console.log(projects);
    });

    const myproject = document.querySelector('.projname');
    myproject.addEventListener('keyup', populateExisiting);

}

function populateExisiting() {
    //.log(projects);
    const myproject = document.querySelector('.projname');
    const mypdiv = document.querySelector('.projsuggest');
    const inputs = myproject.value.toLowerCase();
    mypdiv.innerHTML = '';

    const myfinds = projects.filter(m => m.projname.toLowerCase().startsWith(inputs));

    myfinds.forEach(hh => {
        var div = document.createElement('div');
        mypdiv.append(div);
        div.append(hh.projname);
        //alert(hh.projname);
        div.addEventListener('click', function () {
            jq('#projname').val(hh.projname);
            jq('#projnature').val(hh.projnature);
            jq('#projtype').val(hh.projtype);
            jq('#projowner').val(hh.projowner);
            jq('#siteaddress').val(hh.projlocation);
            jq('#projdistrict').val(hh.projdistrict);
            jq('#certno').val(hh.certno);
            jq('#projid').val(hh.projid);
            mypdiv.innerHTML = '';

            //accregister();
        });
    });

    if (inputs == '')
        mypdiv.innerHTML = '';
}

jq(document).ready(function () {
    jq.post('php/accidentcode.php', function (some) {
        var mines = JSON.parse(some);
        jobs = mines.jobs;
        scounts = mines.scounts;
        var accplaces = mines.accplaces;
        var what = mines.doingwhat;
        var accty = mines.acctypes;

        var aag = mines.accagent;
        var inj = mines.injnature;
        var bparts = mines.bparts;

        var coos = mines.country;

        jq('#race').append("<option value='0' disabled selected>Select country</option>");

        for (s in coos) {
            jq('#race').append("<option value='" + coos[s].idno + "'>" + coos[s].namex + "</option>");
        }

        jq('#bodyinjury').append("<option value='0' disabled selected >Injured body part</option>");

        for (s in bparts) {
            jq('#bodyinjury').append("<option value='" + bparts[s].bno + "'>" + bparts[s].injtype + "</option>");
        }

        jq('#accinjuries').append("<option value='0' disabled selected >Accident injuries</option>");

        for (s in inj) {
            jq('#accinjuries').append("<option value='" + inj[s].injnature + "'>" + inj[s].nature + "</option>");
        }

        jq('#accagent').append("<option value='0' disabled selected >Accident Agent</option>");

        for (s in aag) {
            jq('#accagent').append("<option value='" + aag[s].agentid + "'>" + aag[s].agentname + "</option>");
        }

        jq('#acctype').append("<option value='0' disabled selected >Accident type</option>");

        for (s in accty) {
            jq('#acctype').append("<option value='" + accty[s].typeno + "'>" + accty[s].nametype + "</option>");

        }
        jq('#doingwhat').append("<option value='0' selected disabled>Select Action</option>");

        for (s in what) {
            jq('#doingwhat').append("<option value='" + what[s].what + "'>" + what[s].actions + "</option>");
        }
        //console.log(jobs);
        jq('#jobtitle').append("<option value='0' disabled selected >Select Jobtitle</option>");

        for (s in jobs) {
            jq('#jobtitle').append("<option value='" + jobs[s].jobid + "'>" + jobs[s].description + "</option>");
        }

        jq('#accplace').append("<option value='0' disabled selected>Place of Accident</option>");

        for (s in accplaces) {
            jq('#accplace').append("<option value='" + accplaces[s].accplace + "'>" + accplaces[s].place + "</option>");
        }
    });


    jq('#idistcode').on('change', function () {
        var kk = jq(this).val();
        const mk = scounts.filter(m => m.distcode == kk);

        jq('#saza').empty();
        jq("#saza").append("<option value='0' selected disabled>Select Subcounty</option>");

        for (s in mk) {
            jq("#saza").append("<option value='" + mk[s].code + "'>" + mk[s].name + "</option>");
        }
    })
    jq(document).on('submit', '#empdetails', function (ev) {
        event.preventDefault();

        //alert("form submitted");

        //Adding new Record
        var snd = {
            projid: jq('#projid').val(),
            injpname: jq('#injpname').val(),
            accdate: jq('#accdate').val(),
            acctime: jq('#acctime').val(),
            natid: jq('#natid').val(),
            nextofkin: jq('#nextofkin').val(),
            kinphone: jq('#kinphone').val(),
            race: jq('race').val(),
            injempadd: jq('#injempadd').val(),
            gender: jq('#gender').val(),
            empage: jq('empage').val(),
            jobtitle: jq('#jobtitle').val(),
            distcode: jq('distcode').val(),
            saza: jq('#saza').val(),
            village: jq('#village').val(),
            acctype: jq('#acctype').val(),
            accagent: jq('#accagent').val(),
            accresult: jq('#accresult').val(),
            hospital: jq('#hospital').val(),
            workno: jq('#workno').val(),
            accinjuries: jq("#accinjuries").val(),
            bodyinjury: jq("#bodyinjury").val(),
            accplace: jq("#accplace").val(),
            accdescription: jq("#accdescription").val(),
            doingwhat: jq("#doingwhat").val(),
            monthly: jq("#monthly").val(),
            wdaily: jq("#wdaily").val(),
            wweekly: jq("#wweekly").val(),
            adding: "yes",
            empid: jq('#empid').val()
        };

        console.log(JSON.stringify(snd));

        jq.post('php/accidentcode.php', snd, function (some) {
            var mines = JSON.parse(some);
            alert(mines.errmsg);
        });
    })
    var myaccidents = [];


    jq(document).on('click', '#recedit', function (ev) {
        ev.preventDefault();
        jq.post('php/accidentcode.php', { projid: jq('#projid').val() }, function (some) {
            var mines = JSON.parse(some);
            myaccidents = mines.projacc;
            var mk = mines.scounts;
            for (s in scounts)
                if (myaccidents) {
                    const mhead = document.querySelector('.myhead');
                    mhead.innerHTML = '';
                    mhead.innerHTML = `<span class='closeBtn'>&times;</span>`;
                    jq('.mymodal').show();

                    myaccidents.forEach(m => {
                        div = document.createElement('div');
                        div.append(m.injpname);
                        mhead.append(div);
                        div.addEventListener('click', () => {
                            jq('#saza').empty();
                            jq("#saza").append("<option value='0' selected disabled>Select Subcounty</option>");
                            console.log(m.saza);
                            const vv = mk.filter(c => c.distcode == m.distcode);
                            vv.forEach(y => {
                                jq("#saza").append("<option value='" + y.code + "'>" + y.name + "</option>");
                            });

                            jq('#projid').val(m.projid);
                            jq('#injpname').val(m.injpname);
                            var starting = new Date(m.accdate).toISOString().substr(0, 10);
                            document.querySelector('#accdate').value = starting;
                            //jq('#accdate').val(m.accdate);
                            jq('#acctime').val(m.acctime);
                            jq('#natid').val(m.natid);
                            jq('#nextofkin').val(m.nextofkin);
                            jq('#kinphone').val(m.kinphone);
                            jq('race').val(m.race);
                            jq('#injempadd').val(m.injempadd);
                            jq('#genser').val(m.gender);
                            jq('empage').val(m.empage);
                            jq('#jobtitle').val(m.jobtitle);
                            jq('#idistcode').val(m.distcode);
                            jq('#saza').val(m.saza);
                            jq('#village').val(m.village);
                            jq('#acctype').val(m.acctype);
                            jq('#accagent').val(m.accagent);
                            jq('#accresult').val(m.accresult);
                            jq('#hospital').val(m.hospital);
                            jq('#workno').val(m.workno);
                            jq("#accinjuries").val(m.accinjuries);
                            jq("#bodyinjury").val(m.bodyinjury);
                            jq("#accplace").val(m.accplace);
                            jq("#accdescription").val(m.accdescription);
                            jq("#doingwhat").val(m.doingwhat);
                            jq("#monthly").val(m.monthly);
                            jq("#wdaily").val(m.wdaily);
                            jq("#wweekly").val(m.wweekly);
                            jq('#accid').val(m.accid);
                            jq('#empid').val(m.empid);
                            jq('.mymodal').hide();
                        });
                    });

                } else {
                    alert("no record");
                }
        })
    });

    jq(document).on('click', '.closeBtn', function (ev) {
        ev.preventDefault();
        jq('.mymodal').hide();
        jq('#injpname').val('');
        jq('#accdate').val();
        jq('#acctime').val();
        jq('#natid').val('');
        jq('#nextofkin').val('');
        jq('#kinphone').val('');
        jq('race').val(0);
        jq('#injempadd').val('');
        jq('#genser').val(0);
        jq('empage').val(0);
        jq('#jobtitle').val(0);
        jq('distcode').val(0);
        jq('#saza').val(0);
        jq('#village').val('');
        jq('#acctype').val(0);
        jq('#accagent').val(0);
        jq('#accresult').val('');
        jq('#hospital').val('');
        jq('#workno').val(0);
        jq("#accinjuries").val(0);
        jq("#bodyinjury").val(0);
        jq("#accplace").val(0);
        jq("#accdescription").val('');
        jq("#doingwhat").val(0);
        jq("#monthly").val(0);
        jq("#wdaily").val(0);
        jq("#wweekly").val(0);
        jq('#accid').val('');
        jq('#empid').val('');
    })
});