
$(document).ready(function() {
	$('#registration_form').validate({
		rules: {
			fname: 'required',
		    lname: 'required',
		    email: {
		    	required: true,
      	    	email: true,
			},
		    password: {
	 	        required: true,
		        minlength: 8,
			},
			gender: 'required',
		},
		messages: {
		    fname: 'This field is required!',
		    lname: 'This field is required!',
		    email: 'Enter a valid email!',
		    password: {
		    	minlength: 'Password must be at least 8 characters long!'
		    },
		    gender: 'Select atleast one'
		}
	});

	$('#login_form').validate({
		rules: {
		    email: {
		    	required: true,
	     	    email: true,
			},
			password: {
			    required: true,
			    minlength: 8,
			}
		},

		messages: {
			  
			email: 'Enter a valid email!',
			password: {
		    	minlength: 'Password must be at least 8 characters long!'
			}
		}
	});

	
	$('#add_cat').validate({
		rules: {
			category_name: 'required',
		},

		messages: {
		    category_name: 'This field is required!',
		}
	});
	$('#add_role').validate({
		rules: {
			role: 'required',
		},

		messages: {
		    role: 'This field is required!',
		}
	});
	$('#add_subcategory').validate({
		rules: {
			subcategory_name: 'required',
		},

		messages: {
		    subcategory_name: 'This field is required!',
		}
	});
	$('#add_product').validate({
		rules: {
			product_name: 'required',
			description: 'required',
			price: 'required',
			quantity: 'required'
		},

		messages: {
		    subcategory_name: 'This field is required!',
			product_name: 'This field is required!',
			description: 'This field is required!',
			price: 'This field is required!',
			quantity: 'This field is required!'
		}
	});
	$('add_paymenttype').validate({
		rules: {
			paymenttype: 'required',
			description: 'required',
		},

		messages: {
			description: 'This field is required!',
			paymenttype: 'This field is required!',
		}
	})

	
});
