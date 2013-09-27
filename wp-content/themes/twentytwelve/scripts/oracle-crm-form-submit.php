<?php
//open connection
$ch = curl_init();

//email vars
$address = "marketing@programmingresearch.com";
$subject = "PRQA Form Error";
$problem = "http://www.programmingresearch.com/error_docs/sorry-there-has-been-a-problem/";

//if there is no data then just exit with error
if ($_POST['fname']=="" AND $_POST['company']=="") {
	header('Location: ' . $problem);
	exit();
	}

//set up EUI and email to be lower case
$externalIdentifier = substr(stripslashes($_POST['email']), 0, 30);
$externalIdentifier = strtolower($externalIdentifier);
$emailLowerCase = substr(stripslashes($_POST['email']),0,100);
$emailLowerCase = strtolower($emailLowerCase);

//set the url, number of POST vars, POST data
curl_setopt($ch, CURLOPT_URL, 'https://secure-ausomxeea.crmondemand.com/Services/Integration?command=login');
curl_setopt($ch, CURLOPT_HTTPHEADER, array('UserName: pruk/bpi.support', 'Password: bpiondemand1'));
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // allow redirects
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // return into a variable
curl_setopt($ch, CURLOPT_HEADER, true);

## Below two option will enable the HTTPS option.
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

//execute post
$data = curl_exec($ch);
// Check for curl errors
if ($error = curl_error($ch)) {
    exit();
}
//close connection
curl_close($ch);
$sessionid = substr($data, (strpos($data, "Set-Cookie:") + 23), (strpos($data, ";") - strpos($data, "Set-Cookie:") - 23));

//now submit appropriate fields depending upon which form was used
$formUsed = $_POST['source'];

switch ($formUsed) {
case "Trial - Second Stage":
		try {
			$lead = new SoapClient("wsdl/Lead.wsdl", array('trace' => 1));
			$lead->__setCookie("JSESSIONID", $sessionid);
			$lead->response_timeout = 600;
			$result = $lead->LeadInsertOrUpdate(
					array(
						'ListOfLead' => array(
							'Lead' => array(
								stWeb_Source => $_POST['source'],
								stEmail_Message => $_POST['user_email_msg'],
								stAdmin_Email_Address => $_POST['admin_email_addr'],
								stRedirect => $_POST['redir'],
								LeadFirstName => substr(stripslashes($_POST['fname']),0,50), //limit to 50 chars
								LeadLastName => substr(stripslashes($_POST['lname']),0,50), //limit to 50
								JobTitle => substr($_POST['title'],0,75), //limit to 75
								Company => substr($_POST['company'],0,100), //limit to 100
								bS101 => $_POST['s101'],
								bOther_PRQA_Product => $_POST['OtherPRQAProduct'],
								stVersion => $_POST['Version'],
								stOS_Version => $_POST['OSVersion'],
								plTime_to_purchase => $_POST['TimeToPurchase'],
								plSize_of_Development_Team => $_POST['SizeOfDevelopmentTeam'],
								StreetAddress => substr(stripslashes($_POST['Address']),0,200), //limit to 200
								City => substr($_POST['City'],0,50), //limit to 50
								County => substr($_POST['StateProvince'],0,30), //limit to 30
								ZipCode => substr($_POST['ZipPostCode'],0,50), //limit to 50
								Country => stripslashes($_POST['country']),
								PrimaryPhone => substr($_POST['phone'],0,40),//limit to 40
								stPhone_Number => substr($_POST['phone'],0,40),//limit to 40
								LeadEmail => $emailLowerCase, //limit to 100 lower case
								ExternalSystemId => $externalIdentifier, //limit to 30 lower case
								bQAC => $_POST['qac'],
								bQAC_1 => $_POST['qacpp'],
								bMISRA_C => $_POST['m2cm'],
								bQAVerify => $_POST['mis'],
								bMISRA_C_1 => $_POST['mcpp'],
								bJSF => $_POST['jcm'],
								bhicpp => $_POST['hicpp'],
								bVCAST => $_POST['vcast'],
								dInstallation_Date => $_POST['Install_Date'], //does this need to be reformatted?
								stHost_ID => substr(stripslashes($_POST['CustHostID']),0,40), //limit 40
								plEvaluation_Platform => $_POST['Evaluation_Platform'],
								plEvaluation_Platform_Version => $_POST['Evaluation_Platform_Version'],
								stCompiler => substr($_POST['Compiler'],0,40), //limit to 40
								stCompiler_Version => substr($_POST['CompilerVersion'],0,40), //limit to 40
								stBuild => substr($_POST['Build'],0,40), //limit to 40
								ltThird_party_libraries_used => substr($_POST['ThirdPartyLib'],0,255), //limit 255
								bRemote_desktop => $_POST['RemoteDesktop'],
								bDistributed_environment => $_POST['DistributedEnvironment'],
								IndexedBoolean0 => $_POST['VirtualisedEnvironment'],
								ltCoding_standards_used => substr(stripslashes($_POST['CodingStandardsUsed']),0,255), //limit 255
								stCompiler_2 => $_POST['Compiler2'],
								plVCS => $_POST['VCS'],
								lt3_Reasons => substr(stripslashes($_POST['Eval_Criteria']),0,255),  //limit 255
								Source => 'PRQA Website',
								plSecondary_Source => $_POST['source'],
								plTertiary_Source => $_POST['SourceFind'],
								CampaignExternalSystemId => $_POST['campaignID'],
								dSource_Date => date("m/d/Y"),
								IndexedLongText0 => $_POST['redir'],
								plNext_Step => "Call",
								ReassignLeadOwner => "Y",
								IndexedNumber0 => 1
							),
						),
					)
			);
			header('Location: ' . $_POST['redir']);
			}
		catch (SoapFault $e) {
			$email = email_content($_POST, $e);
			$sent = mail($address, $subject, $email);
			if ($sent){
				header('Location: ' . $_POST['redir']); //user does not need to know about soap error
			}
			else{
				//then soap and email has failed - send user to error page
				header('Location: '.$problem);
			}
			}
		break;

case "Contact Us":
		try {
			$lead = new SoapClient("wsdl/Lead.wsdl", array('trace' => 1));
			$lead->__setCookie("JSESSIONID", $sessionid);
			$lead->response_timeout = 600;
			$result = $lead->LeadInsertOrUpdate(
					array(
						'ListOfLead' => array(
							'Lead' => array(
								stWeb_Source => $_POST['source'],
								stEmail_Message => $_POST['user_email_msg'],
								stAdmin_Email_Address => $_POST['admin_email_addr'],
								stRedirect => $_POST['redir'],
								LeadFirstName => substr(stripslashes($_POST['fname']),0,50), //limit to 50 chars
								LeadLastName => substr(stripslashes($_POST['lname']),0,50), //limit to 50
								JobTitle => substr($_POST['title'],0,75), //limit to 75
								Company => substr($_POST['company'],0,100), //limit to 100
								Description => substr(stripslashes($_POST['comments']),0,2000),
								Country => stripslashes($_POST['country']),
								PrimaryPhone => substr($_POST['phone'],0,40),//limit to 40
								stPhone_Number => substr($_POST['phone'],0,40),//limit to 40
								LeadEmail => $emailLowerCase, //limit to 100
								ExternalSystemId => $externalIdentifier,
								Source => 'PRQA Website',
								plSecondary_Source => $_POST['source'],
								plTertiary_Source => $_POST['SourceFind'],
								CampaignExternalSystemId => $_POST['campaignID'],
								dSource_Date => date("m/d/Y"),
								IndexedLongText0 => $_POST['redir'],
								plNext_Step => "Call",
								ReassignLeadOwner => "Y",
								IndexedNumber0 => 1
							),
						),
					)
			);
			header('Location: ' . $_POST['redir']);
		}

		catch (SoapFault $e) {
			$email = email_content($_POST, $e);
			$sent = mail($address, $subject, $email);
			if ($sent){
				header('Location: ' . $_POST['redir']); //user does not need to know about soap error
			}
			else{
				//then soap and email has failed - send user to error page
				header('Location: '.$problem);
			}
			}
		break;

case "Trial":
	try {
    $lead = new SoapClient("wsdl/Lead.wsdl", array('trace' => 1));
    $lead->__setCookie("JSESSIONID", $sessionid);
    $lead->response_timeout = 600;
    $result = $lead->LeadInsertOrUpdate(
            array(
                'ListOfLead' => array(
                    'Lead' => array(
                        stWeb_Source => $_POST['source'],
                        stEmail_Message => $_POST['user_email_msg'],
                        stAdmin_Email_Address => $_POST['admin_email_addr'],
                        stRedirect => $_POST['redir'],
                        LeadFirstName => substr(stripslashes($_POST['fname']),0,50), //limit to 50 chars
                        LeadLastName => substr(stripslashes($_POST['lname']),0,50), //limit to 50
                        JobTitle => substr($_POST['title'],0,75), //limit to 75
                        Company => substr($_POST['company'],0,100), //limit to 100
                        bS101 => $_POST['s101'],
                        bOther_PRQA_Product => $_POST['OtherPRQAProduct'],
                        Description => substr(stripslashes($_POST['comments']),0,2000),
                        plTime_to_purchase => $_POST['TimeToPurchase'],
                        plSize_of_Development_Team => $_POST['SizeOfDevelopmentTeam'],
                        Country => stripslashes($_POST['country']),
                        PrimaryPhone => substr($_POST['phone'],0,40),//limit to 40
						stPhone_Number => substr($_POST['phone'],0,40),//limit to 40
                        LeadEmail => $emailLowerCase, //limit to 100
                        ExternalSystemId => $externalIdentifier,
                        bQAC => $_POST['qac'],
                        bQAC_1 => $_POST['qacpp'],
                        bMISRA_C => $_POST['m2cm'],
                        bQAVerify => $_POST['mis'],
                        bMISRA_C_1 => $_POST['mcpp'],
                        bJSF => $_POST['jcm'],
                        bhicpp => $_POST['hicpp'],
                        bVCAST => $_POST['vcast'],
                        Source => 'PRQA Website',
                        plSecondary_Source => $_POST['source'],
                        plTertiary_Source => $_POST['SourceFind'],
                        CampaignExternalSystemId => $_POST['campaignID'],
                        dSource_Date => date("m/d/Y"),
                        IndexedLongText0 => $_POST['redir'],
                        plNext_Step => "Call",
						ReassignLeadOwner => "Y",
						IndexedNumber0 => 1
                    ),
                ),
            )
    );
    header('Location: ' . $_POST['redir']);
	}
	catch (SoapFault $e) {
		$email = email_content($_POST, $e);
		$sent = mail($address, $subject, $email);
		if ($sent){
			header('Location: ' . $_POST['redir']); //user does not need to know about soap error
		}
		else{
			//then soap and email has failed - send user to error page
			header('Location: '.$problem);
		}
		}	
	break;
	
case "Newsletter":
	try {
    $lead = new SoapClient("wsdl/Lead.wsdl", array('trace' => 1));
    $lead->__setCookie("JSESSIONID", $sessionid);
    $lead->response_timeout = 600;
    $result = $lead->LeadInsertOrUpdate(
            array(
                'ListOfLead' => array(
                    'Lead' => array(
                        stWeb_Source => $_POST['source'],
                        stEmail_Message => $_POST['user_email_msg'],
                        stAdmin_Email_Address => $_POST['admin_email_addr'],
                        stRedirect => $_POST['redir'],
                        LeadFirstName => substr(stripslashes($_POST['fname']),0,50), //limit to 50 chars
                        LeadLastName => substr(stripslashes($_POST['lname']),0,50), //limit to 50
                        JobTitle => substr($_POST['title'],0,75), //limit to 75
                        Company => substr($_POST['company'],0,100), //limit to 100
                        Country => stripslashes($_POST['country']),
                        LeadEmail => $emailLowerCase, //limit to 100
                        ExternalSystemId => $externalIdentifier,
                        Source => 'PRQA Website',
                        plSecondary_Source => $_POST['source'],
                        CampaignExternalSystemId => $_POST['campaignID'],
                        dSource_Date => date("m/d/Y"),
                        IndexedLongText0 => $_POST['redir'],
                        plNext_Step => "Call",
						ReassignLeadOwner => "Y",
						IndexedNumber0 => 1
                    ),
                ),
            )
    );
    header('Location: ' . $_POST['redir']);
	}
	catch (SoapFault $e) {
		$email = email_content($_POST, $e);
		$sent = mail($address, $subject, $email);
		if ($sent){
			header('Location: ' . $_POST['redir']); //user does not need to know about soap error
		}
		else{
			//then soap and email has failed - send user to error page
			header('Location: '.$problem);
		}
		}	
	break;

case "Whitepaper":
		try {
			$lead = new SoapClient("wsdl/Lead.wsdl", array('trace' => 1));
			$lead->__setCookie("JSESSIONID", $sessionid);
			$lead->response_timeout = 600;
			$result = $lead->LeadInsertOrUpdate(
					array(
						'ListOfLead' => array(
							'Lead' => array(
								stWeb_Source => $_POST['source'],
								stEmail_Message => $_POST['user_email_msg'],
								stAdmin_Email_Address => $_POST['admin_email_addr'],
								stRedirect => $_POST['redir'],
								LeadFirstName => substr(stripslashes($_POST['fname']),0,50), //limit to 50 chars
								LeadLastName => substr(stripslashes($_POST['lname']),0,50), //limit to 50
								JobTitle => substr($_POST['title'],0,75), //limit to 75
								Company => substr($_POST['company'],0,100), //limit to 100
								Country => stripslashes($_POST['country']),
								PrimaryPhone => substr($_POST['phone'],0,40),//limit to 40
								stPhone_Number => substr($_POST['phone'],0,40),//limit to 40
								LeadEmail => $emailLowerCase, //limit to 100
								ExternalSystemId => $externalIdentifier,
								Source => 'PRQA Website',
								plSecondary_Source => $_POST['source'],
								plTertiary_Source => $_POST['SourceFind'],
								CampaignExternalSystemId => $_POST['campaignID'],
								dSource_Date => date("m/d/Y"),
								bWhite_Paper_1 => $_POST['WhitePaper1'],
								bWhite_Paper_2 => $_POST['WhitePaper2'],
								bWhite_Paper_3 => $_POST['WhitePaper3'],
								bWhite_Paper_4 => $_POST['WhitePaper4'],
								bWhite_Paper_5 => $_POST['WhitePaper5'],
								bWhite_Paper_6 => $_POST['WhitePaper6'],
								bWhite_Paper_7 => $_POST['WhitePaper7'],
								bWhite_Paper_8 => $_POST['WhitePaper8'],
								bWhite_Paper_9 => $_POST['WhitePaper9'],
								bWhite_Paper_10 => $_POST['WhitePaper10'],
								bWhite_Paper_11 => $_POST['WhitePaper11'],
								bWhite_Paper_12 => $_POST['WhitePaper12'],
								bWhite_Paper_13 => $_POST['WhitePaper13'],
								bWhite_Paper_14 => $_POST['WhitePaper14'],
								bWhite_Paper_15 => $_POST['WhitePaper15'],
								bWhite_Paper_16 => $_POST['WhitePaper16'],
								bWhite_Paper_17 => $_POST['WhitePaper17'],
								bWhite_Paper_18 => $_POST['WhitePaper18'],
								bWhite_Paper_19 => $_POST['WhitePaper19'],
								bWhite_Paper_20 => $_POST['WhitePaper20'],
								IndexedLongText0 => $_POST['redir'],
								plNext_Step => "Call",
								ReassignLeadOwner => "Y",
								IndexedNumber0 => 1
							),
						),
					)
			);
			header('Location: ' . $_POST['redir']);
		}

		catch (SoapFault $e) {
			$email = email_content($_POST, $e);
			$sent = mail($address, $subject, $email);
			if ($sent){
				header('Location: ' . $_POST['redir']); //user does not need to know about soap error
			}
			else{
				//then soap and email has failed - send user to error page
				header('Location: '.$problem);
			}
			}
		break;

default:    //HICPP or HICPP Japanese
		try {
			$lead = new SoapClient("wsdl/Lead.wsdl", array('trace' => 1));
			$lead->__setCookie("JSESSIONID", $sessionid);
			$lead->response_timeout = 600;
			$result = $lead->LeadInsertOrUpdate(
					array(
						'ListOfLead' => array(
							'Lead' => array(
								stWeb_Source => $_POST['source'],
								stEmail_Message => $_POST['user_email_msg'],
								stAdmin_Email_Address => $_POST['admin_email_addr'],
								stRedirect => $_POST['redir'],
								LeadFirstName => substr(stripslashes($_POST['fname']),0,50), //limit to 50 chars
								LeadLastName => substr(stripslashes($_POST['lname']),0,50), //limit to 50
								JobTitle => substr($_POST['title'],0,75), //limit to 75
								Company => substr($_POST['company'],0,100), //limit to 100
								Country => stripslashes($_POST['country']),
								PrimaryPhone => substr($_POST['phone'],0,40),//limit to 40
								stPhone_Number => substr($_POST['phone'],0,40),//limit to 40
								LeadEmail => $emailLowerCase, //limit to 100
								ExternalSystemId => $externalIdentifier,
								Source => 'PRQA Website',
								plSecondary_Source => $_POST['source'],
								plTertiary_Source => $_POST['SourceFind'],
								CampaignExternalSystemId => $_POST['campaignID'],
								dSource_Date => date("m/d/Y"),
								IndexedLongText0 => $_POST['redir'],
								plNext_Step => "Call",
								ReassignLeadOwner => "Y",
								IndexedNumber0 => 1
							),
						),
					)
			);
			header('Location: ' . $_POST['redir']);
		}

		catch (SoapFault $e) {
			$email = email_content($_POST, $e);
			$sent = mail($address, $subject, $email);
			if ($sent){
				header('Location: ' . $_POST['redir']); //user does not need to know about soap error
			}
			else{
				//then soap and email has failed - send user to error page
				header('Location: '.$problem);
			}
			}
		break;
}



function email_content($array, $error) {
    $output = "There was an error submitting a form to CRM.\n\n\nForm Data:\n\n";
    foreach ($array as $key => $item) {
        $output.= $key . ": " . $item . "\n";
    }

    $output.= "\n\nSOAP Error:\n" . $error;

    return $output;
}
?>
