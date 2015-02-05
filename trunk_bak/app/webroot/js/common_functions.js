/* function to remove white spaces from string or text */
function removeSpaces(string1) {
	if(string1 != '') {
		var val = string1.split(' ');
		val = val.join('')
		return val;
	}
}
/* end of function */


function validateEmail(email) { 
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,3}))$/;
    return re.test(email);
}
