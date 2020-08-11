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

<table>
    <tr>
        <th>Date</th>
        <th>Sender</th>
        <th>Receiver</th>
        <th>Amount</th>
        <th>Description</th>
    </tr>

    <?php
        foreach($transactions as $transaction) {
            echo '<tr>
                <td>' . (new DateTime($transaction['date']))->format('d-m-Y H:i:s') . '</td>
                <td>' . $transaction['sender'] . '</td>
                <td>' . $transaction['receiver'] . '</td>
                <td>' . $transaction['amount'] . '</td>
                <td>' . $transaction['description'] . '</td>
            </tr>';
        }
    ?>
</table>

<?php include_once( __DIR__ . "/layout/footer.php");
