<?php
// Read the variables sent via POST from the API gateway
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HTML Page with PHP</title>
</head>
<body>
    <h1>Welcome to my PHP-enabled HTML page</h1>
    
    <p>The current date and time is:</p>
    <?php
// Read the variables sent via POST from our API gateway
$sessionId   = $_POST["sessionId"];
$serviceCode = $_POST["serviceCode"];
$phoneNumber = $_POST["phoneNumber"];
$text = $_POST["text"];

if ($text == "") {
    // This is the first request. Note how we start the response with CON, CON needs user input
    $response  = "CON What would you want to check \n";
    $response .= "1. My Account Number \n";
    $response .= "2. My phone number";

} else if ($text == "1") {
    // Business logic for first level response
    $response = "CON Choose account information you want to view \n";
    $response .= "1. Account Number \n";
    $response .= "2. Account Balance";

} else if ($text == "2") {
    // Business logic for first level response
    // This is a terminal request. Note how we start the response with END, END doesn't need user input
    $response = "END Your phone number is ".$phoneNumber;

} else if($text == "1*1") { 
    // This is a second level response where the user selected 1 in the first instance
    $accountNumber  = "ACC1001";

    // This is a terminal request. Note how we start the response with END
    $response = "END Your account number is ".$accountNumber;

} else if ($text = "1*2"){
    // This is a second level response where user selected 1 in the first instance
    $balance = "KES 15,000";

    // terminal request starting with END
    $response = "END Your balance is ".$balance;
}

// Echo the response back to the API. The response depends on the statement that is fullfilled in each instance
header('Content-type: text/plain');
echo $response;

?>

    
    <p>This is regular HTML content after the PHP section.</p>
</body>
</html>




