var url = window.location.protocol + "//" + window.location.host + "/sico/" + "cob_actaconteo/subiradicional/" + $("#adicionales_form table").attr("id");
$( '#adicionales_form' ).parsley( 'destroy' );
$( '#adicionales_form' ).parsley();
$(".fileupload").change(function() {
	var archivo = $(this);
	$(archivo).parent().find('#progress .progress-bar').css(
            "width", "0%"
        );
	var formData = new FormData($('#adicionales_form')[0]);
	    $.ajax( {
	      url: url,
	      type: 'POST',
	      data: formData,
	      processData: false,
	      contentType: false,
	      success: function (data) {
	    	  if(data == "Tipo"){
	    		  alert("El tipo de imagen debe de ser jpg, png, bmp, o gif");
	    	  } else if(data == "Error"){
	    		  alert("Ocurrió un error la subir la imagen");
	    	  } else {
	    		  $(archivo).parent().find('#progress .progress-bar').css(
  	                "width", "100%"
  	            );
	    		  $(archivo).parent().find(".captura").html("Clic para ver");
	    		  $(archivo).parent().find("href").html(window.location.protocol + "//" + window.location.host + "/sico/files/adicionales/" + data);
  				  $(archivo).parent().find(".urlAdicional").val(data);
  		        }
	    	  }
	    });
});
