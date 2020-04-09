// Toastr alerts system
function toastrStatus( toastType, toastStatus){

    if ( typeof toastType !== 'undefined' ) {

        toastr.options = {
            "closeButton": true,
            "debug": false,
            "progressBar": true,
            "preventDuplicates": false,
            "positionClass": "toast-top-right",
            "onclick": null,
            "showDuration": "400",
            "hideDuration": "1000",
            "timeOut": "1800",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
          }

        if (toastType == "project") {

            if (toastStatus == "success") {
                toastr.success("Projekt został dodany pomyślnie");
            }
            else if(toastStatus == "deleted"){
                toastr.success("Projekt został usunięty pomyślnie");
            }
        }
        else if(toastType == "task"){

            if (toastStatus == "success") {
                toastr.success("Zadanie zostało dodane pomyślnie");
            }
            else if(toastStatus == "danger"){
                toastr.error("Pola Godziny muszą być wypełnione", "UWAGA!");
            }
        }  
    }   
}

// Function that set current time in Add Task modal.
function currentTime(id){

    var d = new Date();
    var hours = d.getHours();
    var minutes = d.getMinutes();
    
    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}

    var time = hours + ":" + minutes;
    document.getElementById("timeinput" + id).value=time;

}

// Function that switch on sweatalert and send data for project delete. 
function removeRow(id){
    console.log(id);
        swal({
            title: "Usunąć ten projekt?",
            text: "Zostanie usunięty projekt wraz z dodanymi zadaniami.",
            icon: "warning",
            buttons: ["Anuluj", "Usuń"],
            dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.post("../controllers/includes/deleteproject.php", {
                        id: id
                    }, function(){
                        location.reload();
                    });
                } else {
                    
                }
            });
};