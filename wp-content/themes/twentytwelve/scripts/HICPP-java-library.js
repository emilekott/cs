// check the standard contact form

function checkHICPPForm()
{
	var incompleteForm = false;

	var frm_fname = document.getElementById('fname');
	var frm_lname = document.getElementById('lname');
	var frm_country = document.getElementById('country');
	var frm_source = document.getElementById('SourceFind');
	var frm_email = document.getElementById('email');
	var frm_phone = document.getElementById('phone');
	var frm_company = document.getElementById('company');
	
	
	if(frm_fname.value == "" || frm_fname.value == " " ||
		frm_lname.value == "" || frm_lname.value == " " ||
		frm_country.value == "" ||
		frm_source == "" || frm_source == "  " || frm_source == "Select" ||
		frm_email.value == "" ||
		frm_company.value == "" ||
		frm_phone.value == "" || frm_phone.value == " ")
			incompleteForm = true;

	if(incompleteForm)
		alert("Please fill out the required areas of the form");
    else
	{
		var emmailAddress = $("#email").val();
		var emailDomain = emmailAddress.match(/@\w+/)+" ";

		if(validateEmail(emmailAddress))
		{
			if(badEmailList.match(emailDomain) )
			{
				alert("Please provide an appropriate corporate email address");
				incompleteForm = true;
			}
		}
		else
		{
			alert("Please provide a valid email address");
            incompleteForm = true;
		}
    }

	return !incompleteForm;
}

//Check the feedback form. Currently differs from HICPP because no secondary source (where did you find us)

function checkFeedbackForm()
{
	var incompleteForm = false;

	var frm_fname = document.getElementById('fname');
	var frm_lname = document.getElementById('lname');
	var frm_country = document.getElementById('country');
	var frm_email = document.getElementById('email');
	var frm_phone = document.getElementById('phone');
	var frm_company = document.getElementById('company');
	
	
	if(frm_fname.value == "" || frm_fname.value == " " ||
		frm_lname.value == "" || frm_lname.value == " " ||
		frm_country.value == "" ||
		frm_email.value == "" ||
		frm_company.value == "" ||
		frm_phone.value == "" || frm_phone.value == " ")
			incompleteForm = true;

	if(incompleteForm)
		alert("Please fill out the required areas of the form");
    else
	{
		var emmailAddress = $("#email").val();
		var emailDomain = emmailAddress.match(/@\w+/)+" ";

		if(validateEmail(emmailAddress))
		{
			if(badEmailList.match(emailDomain) )
			{
				alert("Please provide an appropriate corporate email address");
				incompleteForm = true;
			}
		}
		else
		{
			alert("Please provide a valid email address");
            incompleteForm = true;
		}
    }

	return !incompleteForm;
}



// Function to count and trim text inputs where they have a max length

function formTextCounter(field,cntfield,maxlimit) {
if (field.value.length > maxlimit) //trim the input
field.value = field.value.substring(0, maxlimit);
// otherwise, update 'characters left' counter
else
cntfield.value = maxlimit - field.value.length;
}


var badEmailList = "";
badEmailList += " ";
var requestType;

// Check basic contents of email address (an @, a dot, etc)

function validateEmail(address)
{
	var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	if(reg.test(address) == false)
		return false;
	else
		return true;
}

