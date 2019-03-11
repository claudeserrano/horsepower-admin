$(document).ready(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
	$(".generate").click(function(event){
        const form = event.currentTarget.value;
        var data = {
            form : form
        };
        $.ajax({
            type: "GET",
            url: window.location.href + "/getForm",
            data: data,
            cache: false,
            success: function(response)
            {
                console.log(response);
                var link=document.createElement('a');
                link.href=window.location.href + "/download/" + response;
                link.click();
            },
            error: function (XMLHttpRequest, status, error) 
            {
                alert('Error: ' + error + ', Status: ' + status);
            }
        });
    });
    
})