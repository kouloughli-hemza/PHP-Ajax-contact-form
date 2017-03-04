function _(id){ return document.getElementById(id); } // Saving as Function
    
function submitForm(){
    
    // Disable Button to avoid Multi sumbit at same time
	_("mybtn").disabled = true;
   
    // Loader When Button Submit Button is pressed 
    _("spinner").innerHTML = 'processing...<input style="display:none" class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised mdl-button--colored mdl-cell mdl-cell--8-col" id="mybtn" type="submit" value="Submit Form">';
    
    // Saving data to send to PHP page.You need to add New Elements HERE
	var formdata = new FormData();
    
	formdata.append( "name", _("name").value );// here is contact Full name
	formdata.append( "email", _("email").value );// Here is contact email
	formdata.append( "message", _("message").value );// Here is The Message value
    formdata.append( "subject", _("subject").value );// Here is The subject value
    formdata.append( "phone", _("phone").value );// Here is The subject value
    formdata.append( "uploadFile", _("uploadFile").value );// Here is The Upload value
    formdata.append( "g-recaptcha-response", _("g-recaptcha-response").value );// Here is The subject value
    //formdata.append( "input-name", _("input-name").value );// Here Your new element
    
    //You Need to add new elements here as  following->// formdata.append( "input-name", _("input-name").value );
    
    
    
	var ajax = new XMLHttpRequest();// Sending ajax Request
    
	ajax.open( "POST", "send.php" );// Calling The contact PHP page
    
	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4 && ajax.status == 200) {
			if(ajax.responseText == "sent"){
                //resut we get from PHP Sent successfully, Remove form body and place this success message
                _("spinner").innerHTML = '<span class="mdl-chip mdl-chip--contact"><span class="mdl-chip__contact mdl-color--teal mdl-color-text--white"><i class="contact-sent material-icons">send</i></span><span class="mdl-chip__text">Your Email is sent</span></span>';

                _("contact-errors").innerHTML = '';

                
			} else {
                //If message is Not successfully Sent  We show error message We get from the php page
				_("status").innerHTML = ajax.responseText;
                
                // If not successfully Submited We enbale Submit button again Form user
				_("mybtn").disabled = false;
                
                _("spinner").innerHTML = '<input class="mdl-button mdl-js-button mdl-js-ripple-effect mdl-button--raised mdl-button--colored mdl-cell mdl-cell--8-col" id="mybtn" type="submit" value="Submit Form">';
			}
		}
	}
	ajax.send( formdata );
}
