<?php
    include_once( __DIR__ . "/layout/header.php");
?>

<div>
    <h1>DesignoCoin</h1>
</div>

<div class="img"></div>

<br class="space">

<?php if(isset($error)): ?>
    <div class="error" style="color: red;">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<?php if(isset($success)): ?>
    <div class="success">
        <?php echo $success; ?>
    </div>
<?php endif; ?>

<p>
    <b>Date:</b> <?php echo (new DateTime($transaction['date']))->format('d-m-Y H:i:s'); ?>
    <br />
    <b>Sender:</b> <?php echo $transaction['sender']; ?>
    <br />
    <b>Receiver:</b> <?php echo $transaction['receiver']; ?>
    <br />
    <b>Amount:</b> <?php echo $transaction['amount']; ?>
    <br />
    <b>Description:</b> <?php echo $transaction['description']; ?>
</p>

<?php 
 include_once(__DIR__ . "/layout/navbottom.php");
include_once( __DIR__ . "/layout/footer.php");
