// asking alerts
function myalert_danger(data) {
    $(' <div id="myModal_alert_d" class="modal " role="dialog" data-backdrop="static" data-keyboard="false"> <div class="modal-dialog modal-md">  <div class="modal-content"> <div class="modal-header" style ="background:#c43831; color:#fafafa;"> <h4 class="modal-title"> ' + data + ' </h4> </div> <div class="modal-body" style="text-align:right;"> <button type="button" class="btn btn-success d35343_btn"  data-dismiss="modal">OK</button>  <button type="button" class="btn btn-danger d64534_btn"  data-dismiss="modal">Cancel</button>  </div> </div> </div> ').insertAfter("body");
    $('#myModal_alert_d').modal('show');
}

function myalert_warning(data) {
     $(' <div id="myModal_alert_w" class="modal " role="dialog" data-backdrop="static" data-keyboard="false"> <div class="modal-dialog modal-md">  <div class="modal-content"> <div class="modal-header" style ="background:#cf871d; color:#fafafa;">  <h4 class="modal-title"> ' + data + ' </h4> </div> <div class="modal-body" style="text-align:right;"> <button type="button" class="btn btn-success w35343_btn"  data-dismiss="modal">OK</button>  <button type="button" class="btn btn-danger w64534_btn"  data-dismiss="modal">Cancel</button>  </div> </div> </div> ').insertAfter("body");
    $('#myModal_alert_w').modal('show');
}

function myalert_success(data) {
     $(' <div id="myModal_alert_s" class="modal " role="dialog" data-backdrop="static" data-keyboard="false"> <div class="modal-dialog modal-md">  <div class="modal-content"> <div class="modal-header" style ="background:#26b543; color:#fafafa;"> <h4 class="modal-title"> ' + data + ' </h4> </div> <div class="modal-body" style="text-align:right;"> <button type="button" class="btn btn-success s35343_btn"  data-dismiss="modal">OK</button>  <button type="button" class="btn btn-danger s64534_btn"  data-dismiss="modal">Cancel</button>  </div> </div> </div> ').insertAfter("body");
    $('#myModal_alert_s').modal('show');
}

function myalert_void(data) {
    $(' <div id="myModal_alert_v" class="modal " role="dialog" data-backdrop="static" data-keyboard="false"> <div class="modal-dialog modal-md">  <div class="modal-content"> <div class="modal-header" style ="background:#1f1e1c; color:#fafafa;">  <h4 class="modal-title"> ' + data + ' </h4> </div> <div class="modal-body" style="text-align:right;"> <button type="button" class="btn btn-success v35343_btn"  data-dismiss="modal">OK</button>  <button type="button" class="btn btn-danger v64534_btn"  data-dismiss="modal">Cancel</button>  </div> </div> </div> ').insertAfter("body");
    $('#myModal_alert_v').modal('show');
}
// usage
// My alert!
// myalert_warning("Are you sure you want to edit " + title + "?");
// $(".s35343_btn").click(function() {
//     // ---------

// });
// $(".s64534_btn").click(function() {
//     setTimeout(function() {
//         $('#myModal_alert_w').remove();
//         $('.modal-backdrop').remove();
//     }, 0);
// });

function myalert_danger_af(data,redirection) {
    $('<div id="myModal_alert1" class="modal " role="dialog" data-backdrop="static" data-keyboard="false"  > <div class="modal-dialog modal-md">  <div class="modal-content" style="background:none; font-size:23px !important; font-family:verdana; margin-top:45%;"> <div class="alert alert-danger"> ' + data + '</div>  </div> </div> ').insertAfter("body");
    $('#myModal_alert1').modal({
        backdrop: false,
    });
    setTimeout(function() {
        $('#myModal_alert1').modal('hide');
        if(redirection  !=  "nothing"){
            location.replace(redirection);
        }
    }, 1900);

   
}

function myalert_success_af(data,redirection) {
    $('<div id="myModal_alert1" class="modal" role="dialog" data-backdrop="static" data-keyboard="false"  > <div class="modal-dialog modal-md">  <div class="modal-content" style="background:none; font-size:23px; font-family:verdana; margin-top:45%;"> <div class="alert alert-success"> ' + data + '</div>  </div> </div> ').insertAfter("body");
    $('#myModal_alert1').modal('show');


      $('#myModal_alert1').modal({
        backdrop: false,
    });
    setTimeout(function() {
        $('#myModal_alert1').modal('hide');
        if(redirection != "nothing"){
            location.replace(redirection);
        }
        // $('#myModal_alert1').remove()
    }, 1900);

}

function myalert_warning_af(data,redirection) {
    $('<div id="myModal_alert1" class="modal " role="dialog" data-backdrop="static" data-keyboard="false"  > <div class="modal-dialog modal-md">  <div class="modal-content" style="background:none; font-size:23px; font-family:verdana; margin-top:45%;"> <div class="alert alert-warning"> ' + data + '</div>  </div> </div> ').insertAfter("body");

    $('#myModal_alert1').modal('show');

       $('#myModal_alert1').modal({
        backdrop: false,
    });
    setTimeout(function() {
        $('#myModal_alert1').modal('hide');
         if(redirection  !=  "nothing"){
            location.replace(redirection);
        }
    }, 1900);

}

function myalert_void_af(data,redirection) {
    $('<div id="myModal_alert1" class="modal " role="dialog" data-backdrop="static" data-keyboard="false"  > <div class="modal-dialog modal-md">  <div class="modal-content" style="background:none; font-size:23px; font-family:verdana; margin-top:45%;"> <div class="alert alert-danger"> ' + data + '</div>  </div> </div> ').insertAfter("body");
    $('#myModal_alert1').modal('show');

       $('#myModal_alert1').modal({
        backdrop: false,
    });
    setTimeout(function() {
        $('#myModal_alert1').modal('hide');
         if(redirection  !=  "nothing"){
            location.replace(redirection);
        }
    }, 1900);

}
// myalert_void_af(data)
// $('#myModal_alert1').remove()

function myreload() {
    setTimeout(function() {
        location.replace(window.location.pathname + window.location.search)
    }, 2500);
}