<?php
return [
// Your API Key.
    $key = 'ghrOADvR3dnwdcIqeaGeo58ocwS4ExYK',

// The email you wish to validate.
//$email = 'noreply@ipqualityscore.com';

/*
* Set the maximum number of seconds to wait for a reply
* from an email service provider. If speed is not a concern
* or you want higher accuracy we recommend setting this in
* the 20 - 40 second range in some cases. Any results which
* experience a connection timeout will return the "timed_out"
* variable as true. Default value is 7 seconds.
*/
$timeout = 1,

/*
* If speed is your major concern set this to true,
* but results will be less accurate.
*/
$fast = 'false',

/*
* Adjusts abusive email patterns and detection rates
* higher levels may cause false-positives (0-2)
 * /*
 */
$abuse_strictness = 0,

];


/*
*- Example 1: We'd like to allow all valid email addresses.
*
* if($result['valid'] === true){
*		echo "Email is valid.";
* } else {
* 	echo "Email is NOT valid.";
* }
*/

/*
*- Example 2: We'd like to allow valid emails that haven't
*- been reported as abusive.
*
* if($result['valid'] === true && $result['recent_abuse'] === false){
*		echo "Email is valid.";
* } else {
* 	echo "Email is NOT valid.";
* }
*/

/*
*- Example 3: We'd like to allow valid emails or allow
*- emails that timed out, but passed other quality checks
*- and not allow emails reported as abusive
*- Note: Timeouts occur when the mail provider does not respond fast enough to verify the email inbox.
*
* if(
*		$result['recent_abuse'] === false &&
*		($result['valid'] === true || $result['timed_out'] === true && $result['disposable'] === false && $result['dns_valid'] === true)
*	){
*		echo "Email is valid.";
* } else {
* 	echo "Email is NOT valid.";
* }
*/

