$.ajax({
    beforeSend: function(request) {
        request.setRequestHeader("Authorization", 'Bearer ');
    },
    dataType: "json",
    url: "http://hearts2020.com/api/user/bpm/last",
    error: function (xhr, ajaxOptions, thrownError) {
        heart.playbackRate = 0;
        toastr.warning('Error'  , thrownError  , { "progressBar": true });
    },
    success: function(json) {
    current = JSON.stringify(json);
    if(!$.isEmptyObject(json)){
        rate = json.bpm/100;
        if(dataARR.length > 0){
            if(dataARR.length > 0 && dataARR[dataARR.length - 1].created_at != json.created_at){
                dataARR.push(json);
            }
        }
        else{
            dataARR.push(json);
        }
    }

    }
}).done(function(results) {
        console.log("done : " + dataARR);
});