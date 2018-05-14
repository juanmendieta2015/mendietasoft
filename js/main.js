const ERROR_EMAIL 		= "Por favor verifique su E-mail, esta incorrecto.";
const ERROR_MESSAGE 	= "Ha ocurrido un error, su mensaje no se ha enviado. Por favor intente de nuevo.";
const SUCCESS_MESSAGE 	= "¡Gracias por escribirnos!. Pronto te contactaremos!. :)";
const ERROR_VALIDATION 	= "Ha ocurrido un error de validacion, por favor verifique sus datos.";
const ERROR_SERVIDOR 	= "No se ha podido establecer conexión con el servidor.";

var x;
x = $(document);
x.ready(inicializar);  

function inicializar()
{
	
	// Efecto Parallax
	$.stellar({
		horizontalScrolling: false,
		responsive: true
	});


	// Boton enviar
    var btnSend = $("#send");
    btnSend.click(send);


	// Animación de los Enlaces Anclas
	$("li a, a").click(function(e){				
		e.preventDefault();		//evitar el eventos del enlace normal
		var strAncla=$(this).attr('href'); //id del ancla
			$('body,html').stop(true,true).animate({				
				scrollTop: $(strAncla).offset().top
			},1000);
		
	});


	// Boton "Enviar Mensaje" habilitar/desahibilitar
	btnSend.prop('disabled', true);
	$('input,textarea').keyup(function() {
		if ( $('#name').val().length > 0 
			&& $('#email').val().length > 0  
			&& $('#telephone').val().length > 0 
			&& $('#message').val().length > 0 
		) {
		   btnSend.prop('disabled', false);
		} else{
		   btnSend.prop('disabled', true);
		}
	});	

	
	// Muestra/Oculta la Pregunta de Hora de Llamada
	$("#medio_contacto").change(function() {
	 	if ( $("#medio_contacto").val() == "Email" ) {
	 		$("#hora_llamada").hide();	 		
	 	} else {
	 		$("#hora_llamada").show();	 		
	 	}
	 });

}



// Invoca el servicio para enviar el email

function send()
{

    var name 			= $("#name").val();
    var email 			= $("#email").val();
    var telephone 		= $("#telephone").val();
    var message 		= $("#message").val();
    var medio_contacto 	= $("#medio_contacto").val();
    var hora_llamada 	= $("#hora_llamada").val();
    var tipo_producto 	= $("#tipo_producto").val();
    var rubro 			= $("#rubro").val();


    // Validacion de los datos del usuario

    if ( name == "" || telephone == "" || message == "" ) {
    	return;
    }

    if ( validateEmail(email) == false ) {

	    let response = '<div class="alert alert-danger alert-dismissible" role="alert">' + 
	    					'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
	    						'<span aria-hidden="true">&times;</span>' + 
	    					'</button>' +
	    					'<strong>Error! </strong>' + ERROR_EMAIL +
	    				'</div>';
	    $("#resultado").html(response);     	
    	return false;
    }

    $.ajax({
        async:true,
        type: "POST",
        dataType: "html",
        contentType: "application/x-www-form-urlencoded",
        url:"services/send_email.php",
        data:
        	"name=" + name + 
        	"&email=" + email + 
        	"&telephone=" + telephone +
        	"&message=" + message + 
        	"&medio_contacto=" + medio_contacto +
        	"&hora_llamada=" + hora_llamada + 
        	"&tipo_producto=" + tipo_producto + 
        	"&rubro=" + rubro, 
        beforeSend:inicioEnvio,
        success: llegada,
        error: problemas
    });



    // Limpia todos los campos de formulario
    document.getElementById("form_contact").reset();


    return false;
}  



// Preloader

function inicioEnvio()
{
    $("#loader").addClass("loader"); 
}      



// Muestra confirmacion/error al usuario      

function llegada(datos)
{

	switch(datos) {
	    
	    // 0: Error de envio de tipo interno, falla con SENGRID, servidor, etc.

	    case '0':
		    var response = '<div class="alert alert-danger alert-dismissible" role="alert">' +
		    					'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
		    						'<span aria-hidden="true">&times;</span>' +
		    					'</button>' +
		    					'<strong>Error! </strong>' + ERROR_MESSAGE +
		    				'</div>';

		    $("#resultado").html(response); 
	        break;


	    // 1: Envio satisfactorio

	    case '1':
		    var response = '<div class="alert alert-success alert-dismissible" role="alert">' +
		    					'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
		    						'<span aria-hidden="true">&times;</span>' +
		    					'</button>' +
		    					SUCCESS_MESSAGE +
		    				'</div>';

		    $("#resultado").html(response);
	        break;    


		// 2: Error de validacion, datos invalidos proporcionado por el usuario
	    
	    case '2':
		    var response = '<div class="alert alert-danger alert-dismissible" role="alert">' +
		    					'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
		    						'<span aria-hidden="true">&times;</span>' +
		    					'</button>' +
		    					'<strong>Error! </strong>' + ERROR_VALIDATION +
		    				'</div>';

		    $("#resultado").html(response);
	        break;

	}

	$("#loader").removeClass("loader");    

}

// Problemas estableciendo conexion con el servidor                   

function problemas()
{
    var response_success = '<div class="alert alert-danger alert-dismissible" role="alert"> ' +
    							'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
    								'<span aria-hidden="true">&times;</span>' +
    							'</button>' +
    							'<strong>Error! </strong>' + ERROR_SERVIDOR +
    						'</div>';
    $("#resultado").html(response_success)  
}            
 


function validateEmail(email) 
{
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}