<?php
 
//Global $wpdb;

// Load WP
require('/home/user/public_html/wp-load.php');

// Check MYSQL
/*if (!function_exists('mysql_init') && !extension_loaded('mysql')) {
    echo 'SQL extention Not Recognized';
} else {
    echo 'SQL extention OK';
}
*/

// Create A Connection
$dbhost = 
$dbuser = 
$dbpass =
$db = 

//MYSQLI VARIATION
//$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $db);
//if ($mysqli->connect_errno) {
//    die("Connection failed: " . $conn->connect_error);
//}

// Find Black Bayside Hats
$black_hats = $wpdb->get_results('SELECT * 
                               FROM wp_rmproductmanagement_order_details 
                               WHERE order_id IN (SELECT order_id FROM wp_rmproductmanagement_orders WHERE user_id = THE_ID) 
                               AND product_id = 381
                               AND color_id = 7
                               AND DAY(created_at) = DAY(NOW() - INTERVAL 1 DAY)');
// Get Current Balance
$get_user_balance = $wpdb->get_results('SELECT * 
                               FROM wp_transactions 
                               WHERE id IN (SELECT MAX(id) 
                               FROM wp_transactions  
                               WHERE userid = THE_ID)');
// How Many Hats
echo ("How many hats:") , PHP_EOL;
$numhats = count($black_hats);

// Echo The Results
//print_r($black_hats);
//print_r($get_user_balance);
echo ($numhats) , PHP_EOL;

//UPDATE wp_users SET balance = ($amount!!) WHERE user_id = THE_ID

// If There Are Hats Today Insert a Refund (not including shipping)For Each One
if ($numhats > 0) {
    $i = 0;
    foreach ($black_hats as $black_hat) {
        foreach($get_user_balance as $user_balance){
                $balance = $user_balance->balance;
                        }
        $userid = 107250; //The user id 
        $payeremail = 'ANY@gmail.com';
        $amount = $black_hat->cost;
        $transactionid = "Refund";
        $balance = $balance + $amount;
        $type = 5; //refund type
        $timestamp = time(now);
        $note = "Refund For Hat(s)";
        $payment_method = "string";
        $audit_user_id = 1;// admin user

        $wpdb->insert("wp_transactions", array(
                        userid=>$userid,
                        payeremail=>$payeremail,
                        amount=>$amount,
                        transactionid=>$transactionid,
                        balance=>$balance,
                        type=>$type,
                        timestamp=>$timestamp,
                        note=>$note,
                        payment_method=>$payment_method,
                        audit_user_id=>$audit_user_id
        ));


        $updateSQL = "UPDATE wp_users SET balance = $balance where ID = 107250";

        if(mysql_query($updateSQL)){
                echo 'User balance updated to ' . $balance;
        }

        echo ("Hats Inserted") , PHP_EOL;
    }
}
else
{
    if ($numhats == 0) {
    echo ("No Hats Today") , PHP_EOL;
   }
}
echo ("DONE!!!") , PHP_EOL;
?>
