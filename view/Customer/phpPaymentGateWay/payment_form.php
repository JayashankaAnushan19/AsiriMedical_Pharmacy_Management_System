<?php 

$_SESSION['OrderID'] = 256;
$_SESSION['Total'] = 25;

 ?>

<html>
<head>
    <title>Secure Acceptance - Payment Form Example</title>
    <link rel="stylesheet" type="text/css" href="payment.css"/>
    <script type="text/javascript" src="jquery-1.7.min.js"></script>
</head>
<body>
<form id="payment_form" action="payment_confirmation.php" method="post">
    <input type="hidden" name="access_key" value="645eaa0866f13e6db4db4ac07d1052e3">
    <input type="hidden" name="profile_id" value="EC28C876-BF71-4683-8601-7437754145FA">
    <input type="hidden" name="transaction_uuid" value="<?php echo uniqid() ?>">
    <input type="hidden" name="signed_field_names" value="access_key,profile_id,transaction_uuid,signed_field_names,unsigned_field_names,signed_date_time,locale,transaction_type,reference_number,amount,currency">
    <input type="hidden" name="unsigned_field_names">
    <input type="hidden" name="signed_date_time" value="<?php echo gmdate("Y-m-d\TH:i:s\Z"); ?>">
    <input type="hidden" name="locale" value="en">
    <fieldset>
        <legend>Payment Details</legend>
        <div id="paymentDetailsSection" class="section">
            <span>Transaction_type:</span><input type="text" name="transaction_type" size="25" value="authorization" hidden>
            <label>authorization</label>
            <br/>
            <span>Reference_number:</span><input type="text" name="reference_number" value="<?php echo (!empty($_SESSION['OrderID'])) ? $_SESSION['OrderID'] : ''; ?>" size="25" hidden>
            <label><?php echo (!empty($_SESSION['OrderID'])) ? $_SESSION['OrderID'] : ''; ?></label>
            <br/>
            <span>Amount:</span><input type="text" name="amount" size="25" value="<?php echo (!empty($_SESSION['Total'])) ? $_SESSION['Total'] : ''; ?>" hidden>
            <label><?php echo (!empty($_SESSION['Total'])) ? $_SESSION['Total'] : ''; ?></label>
            <br/>
            <span>Currency:</span><input type="text" name="currency" size="25" value="USD" hidden>
            <label>USD</label>
            <br/>
        </div>
    </fieldset>
    <input type="submit" id="submit" name="submit" value="Submit"/>
    <script type="text/javascript" src="payment_form.js"></script>
</form>
</body>
</html>
