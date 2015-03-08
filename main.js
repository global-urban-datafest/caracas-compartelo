$(document).on("pageshow", "#registerPage", function() {


	$("#registerForm").validate({

		errorPlacement: function(error, element) {
			if (element.attr("name") === "favcolor") {
				error.insertAfter($("#favcolor").parent());
			} else {
				error.insertAfter(element);
			}
		}

	});

});