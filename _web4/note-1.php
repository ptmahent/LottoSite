<?php
require_once("../../../libraries/ValidForm/class.validform.php");

	$objForm = new ValidForm("superRegistrationForm","Welcome to our imaginary website. Please register to access all the good stuff.");
	
	//*** Add a paragraph and header above the paragraph
	$objForm->addParagraph("Oh, and by the way.. I wanted to add some extra text here.", "Forgot something.");
	
	$objForm->addFieldset("Personal details");
	
	$objGender = $objForm->addField("gender", "Gender", VFORM_RADIO_LIST,
		array(
			"required" => true
		),
		array(
			"required" => "You must select your gender!"
		),
		array(
			"tip" => "If you're not sure, select 'both'.",
			"class" => "vf__inline-select"
		)
	);
		//*** addField($label, $value, $checked = false);
		$objGender->addField("Male", "male");
		$objGender->addField("Female", "female");
		$objGender->addField("Both", "not-sure-yet");
	
	$objForm->addField("name","Name",VFORM_STRING,
		array(
			"required" => true,
			"maxLength" => 60
		),
		array(
			"required" => "You forgot your name?",
			"maxLength" => "Your name is too long. Maximum of %s characters allowed."
		)
	);

	$objForm->addField("last-name","Last name",VFORM_STRING,
		array(
			"required" => true,
			"maxLength" => 60
		),
		array(
			"required" => "You forgot your last name?",
			"maxLength" => "Your last name is too long. Maximum of %s characters allowed."
		)
	);
	
	//*** We don't want to add 60 addField methods, so let's use
	//*** some meta info instead.
	$objForm->addField("age","Age",VFORM_SELECT_LIST,
		array(
			"required" => true
		),
		array(
			"required" => "Please select an age."
		),
		array(
			"start" => 10,
			"end" => 70
		)
	);
	
	//*** Special e-mail address validation
	$objForm->addField("email1","1st e-mail address", VFORM_EMAIL,
		array(
			"required" => true
		),
		array(
			"required" => "You'll have to fill in at least one e-mail address",
			"type" => "This is not a valid e-mail address!"
		),
		array(
			"tip" => "This will also be your username"
		)
	);
	$objForm->addField("email2","2nd e-mail address", VFORM_EMAIL,
		array(
			"required" => false
		),
		array(
			"type" => "This is not a valid e-mail address!"
		),
		array(
			"tip" => "Just in case.."
		)
	);
	
	//*** There is also built-in support for password fields
	$objForm->addField("password1","Password", VFORM_PASSWORD,
		array(
			"required" => true
		),
		array(
			"type" => "This is not a valid e-mail address!",
			"required" => "Please fill in a password"
		)
	);
	$objForm->addField("password2","Repeat password", VFORM_PASSWORD,
		array(
			"required" => true
		),
		array(
			"type" => "This is not a valid e-mail address!",
			"required" => "Please retype your password"
		)
	);
	
	//*** Let's insert a file upload field as well.
	$objForm->addField("avatar", "Your avatar", VFORM_FILE,
		array(
			"required" => false
		)
	);
	
	
	//*** Now we want to know all the users' addresses.
	$objForm->addFieldset("Addresses");
	
	//*** Let's start by asking their home address by default
	$objHome = $objForm->addArea("Home address", false, "home-address");
		$objStreet = $objHome->addMultiField("Street, Number");
		$objStreet->addField("home-street", VFORM_STRING,
			array(
				"required" => true
			),
			array(
				"required" => "Please fill in your streetname.",
				"type" => "Only letters and numbers allowed"
			)
		);
		$objStreet->addField("home-number", VFORM_INTEGER,
			array(
				"required" => true
			),
			array(
				"required" => "This field is required.",
				"type" => "Only numbers are allowed."
			)
		);
	$objHome->addField("home-zip-postal", "Zip / Postal Code", VFORM_STRING,
		array(
			"required" => true
		),
		array(
			"required" => "Please fill in your streetname.",
			"type" => "Only letters and numbers allowed"
		)
	);
	$objHome->addField("home-city", "City", VFORM_STRING,
		array(
			"required" => true
		),
		array(
			"required" => "Please fill in your streetname.",
			"type" => "Only letters and numbers allowed"
		)
	);
	
	$objCountry = $objHome->addField("home-country","Country",VFORM_SELECT_LIST,
		array("required"=>true),
		array("required"=>"Select your country")
	);
		$objCountry->addField("Select your country","");
		$objCountry->addField("United States","US");
		$objCountry->addField("Netherlands","NL");
		$objCountry->addField("Madagascar","MA");
	
	//*** Optional delivery address data
	$objHome = $objForm->addArea("Delivery address", true, "delivery-address", false);
		$objStreet = $objHome->addMultiField("Street, Number");
		$objStreet->addField("delivery-street", VFORM_STRING,
			array(
				"required" => true
			),
			array(
				"required" => "Please fill in your streetname.",
				"type" => "Only letters and numbers allowed"
			)
		);
		$objStreet->addField("delivery-number", VFORM_INTEGER,
			array(
				"required" => true
			),
			array(
				"required" => "This field is required.",
				"type" => "Only numbers are allowed."
			)
		);
	$objHome->addField("delivery-zip-postal", "Zip / Postal Code", VFORM_STRING,
		array(
			"required" => true
		),
		array(
			"required" => "Please fill in your streetname.",
			"type" => "Only letters and numbers allowed"
		)
	);
	$objHome->addField("delivery-city", "City", VFORM_STRING,
		array(
			"required" => true
		),
		array(
			"required" => "Please fill in your streetname.",
			"type" => "Only letters and numbers allowed"
		)
	);
	
	$objCountry = $objHome->addField("delivery-country","Country",VFORM_SELECT_LIST,
		array("required"=>true),
		array("required"=>"Select your country")
	);
		$objCountry->addField("Select your country","");
		$objCountry->addField("United States","US");
		$objCountry->addField("Netherlands","NL");
		$objCountry->addField("Madagascar","MA");
	
		
	
	
	$objForm->addParagraph("If you want to be registered as a company, please fill in the next fields as wel.", "Are you a company?");
	
	$objCompany = $objForm->addArea("I am a company", true, "company", false);
		$objCompany->addField("company-name", "Company Name", VFORM_STRING,
			array(
				"required" => true
			),
			array(
				"required" => "You must provide your company name."
			)
		);
		$objCompany->addField("function", "Title / Function", VFORM_STRING);
		$objCountry = $objCompany->addField("country", "Country", VFORM_SELECT_LIST,
			array(
				"required" => true
			),
			array(
				"required" => "Please select the country where your company is located."
			)
		);
			$objCountry->addField("Select a country","");
			$objCountry->addField("Netherlands", "NL");
			$objCountry->addField("Other","Other");
		$objCompany->addField("chamber-of-commerce", "Chamber of Commerce (KvK) number", VFORM_INTEGER,
			array(
				"required" => false,
				"maxLenght" => 8,
				"minLength" => 8
			),
			array(
				"type" => "Only numbers are allowed.",
				"maxLenght" => "A Chamber of Commerce number is max. %s numbers long.",
				"minLength" => "A Chamber of Commerce number is min. %s numbers long."
			),
			array(
				"tip" => "For Dutch companies only."
			)
		);
		
		//*** A VFORM_CUSTOM field uses a custom regular expression
		//*** for field validation, server- and clientside. 
		$objCompany->addField("tax-number", "Tax number", VFORM_CUSTOM,
			array(
				"required" => false,
				//*** This is a custom regular expression 
				//*** for a Dutch tax number. 
				"validation" => '/(NL)(\\d{9})(B)(\\d{2})*$/i',
				"minLength" => 14,
				"maxLength" => 14
			),
			array(
				"type" => "This is not a valid Tax number.",
				"minLength" => "A Tax number is at least %s characters long.",
				"maxLength" => "A Tax number has a maximum of %s characters.",
				"hint" => "This value is just a hint. Insert your Tax number or remove the hint value."
			),
			array(
				//*** A hint value is displayed inside the input field
				//*** and is not allowed to be submitted.
				"hint" => "NL123456789B12",
				"tip" => "For Dutch companies only."
			)
		);
		
	/* 	
	 * As soon as the client side validation is done, alert the user
	 * that we will continue validating serverside. This uses the
	 * validate() function from the javascript ValidForm class.
	 * 
	 * Ofcourse you can always add a custom javascript function like
	 * an AJAX request.
	 */
	$objForm->addJSEvent("submit","function(){ if(objForm.validate()){ alert('Client side validation is done. We now continue to validate the data serverside.');} }");


	//*** Setting the main alert.
	$objForm->setMainAlert("One or more errors occurred. Check the marked fields and try again.");
	
	//*** As this method already states, it sets the submit button's label.
	$objForm->setSubmitLabel("Send");
	
	//*** Handling the form data.
	if($objForm->isSubmitted() && $objForm->isValid()){
		$strOutput = "<p>Thank you for submitting the form. However, we didn't save any data because this is just an example page.</p>
					<p><a href=\"http://www.validformbuilder.org/tutorials.html\">Go back to the tutorials page</a> or <a href=\"http://validform.stylr.nl/tutorial-3/note-1.php\">retry this form</a></p>";
	}
	else {
		$strOutput = $objForm->toHtml();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xml:lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>ValidForm Builder: Tutorial 3 - The fully featured registration form >> Note 1</title>

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE8" />

<link type="text/css" rel="stylesheet" href="/css/default.css" />
<link type="text/css" rel="stylesheet" href="/css/validform.css" />
<!--<link type="text/css" rel="stylesheet" href="/css/validform-custom.css" />-->

<script type="text/javascript" src="/libraries/jquery.js"></script>
<script type="text/javascript" src="/libraries/validform.js"></script>

</head>
<body>
<div id="wrapper">
	<h1>ValidForm Builder: Tutorial 3 - The fully featured registration form >> Note 1</h1>
	<!-- The ValidForm Builder generated code starts here -->
	<?php echo $strOutput; ?>
	<!-- The ValidForm Builder generated code ends here -->
</div>
</body>
</html>