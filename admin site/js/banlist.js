if (typeof secKey === 'undefined'){
    secKey = "";
}

if (typeof ipbans === 'undefined'){
    ipbans = []
}
if (typeof guidbans === 'undefined'){
    guidbans = [];
}

var numBansPerIteration = 100;
var maxIterations = 0;
var currentOverallIteration = 0;
var currentIteration = 0;
var currentArray = "ip";

function getBanData(){
    maxIterations = ( (Math.ceil(ipbans.length/numBansPerIteration) + Math.ceil(guidbans.length/numBansPerIteration)) ) + 1;

    var bans = ipbans.slice( 0 , numBansPerIteration );
    callPlayerInfo(bans);
}


function callPlayerInfo(banlist){
    $.ajax({
        cache: false,
        data: {secKey: secKey, bans: banlist, banType: currentArray},
        error: processFail,
        success: processSuccess,
        timeout: 600000,
        type: 'POST',
        url: 'server/ajax/banlist.php'
    });
}


function processSuccess(){
    // Progressbar display
    currentOverallIteration += 1;
    var percent = (currentOverallIteration/maxIterations)*100;
    $(".progress .progress-bar").css("width", percent+"%" );
    $(".progress .progress-bar span").html( Math.round(percent)+"%");


    //Success so increment
    currentIteration += 1;
    
    // Now send off next request. We don't get much back cause it's all stored serverside then written to file
    if (currentArray == "ip"){
        if ((currentIteration*numBansPerIteration) > ipbans.length){
            // Done all the IP bans, start on guid
            currentIteration = 0;
            currentArray = "guid";
            var bans = guidbans.slice( 0 , numBansPerIteration );
            callPlayerInfo(bans);
        } else {
            var bans = ipbans.slice( (currentIteration*numBansPerIteration) , ((currentIteration*numBansPerIteration)+numBansPerIteration) );
            callPlayerInfo(bans);
        }
    } else if (currentArray == "guid") {
        if ((currentIteration*numBansPerIteration) > guidbans.length){
            // Done all the GUID bans, we are done
            currentArray = "done";
            var bans = [];
            callPlayerInfo(bans);
        } else {
            var bans = guidbans.slice( (currentIteration*numBansPerIteration) , ((currentIteration*numBansPerIteration)+numBansPerIteration) );
            callPlayerInfo(bans);
        }
    } else {
        $("#banlistAlertField").html("Finished! The page should now reload after 10 seconds. If it does not, please refresh the page manually.<br />If you find the page reloading continuosly, please contact the webmaster.");
        setTimeout(window.location.reload(), 10000);
    }
}


function processFail(){

}