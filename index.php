<form method="POST" action="process_payment.php">
    <input type="email" name="email" placeholder="Email Address" value="ofsajeeb@gmail.com" required>
    <input type="text" name="amount" placeholder="Amount (NGN)" value="5000" required>
    <input type="text" name="reference" value="<?php echo uniqid('txn_'); ?>">
    <button type="submit">Pay Now</button>
</form>
