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

<form action="/transfer.php" method="post">
    <div>
        <label for="receiver">Receiver</label>
        <select name="receiver" id="receiver">
            <?php
                foreach ($users as $user) {
                    echo '<option value="' . $user['id'] . '">' . $user['firstname'] . '</option>';
                }
            ?>
        </select>
    </div>

    <br>

    <div>
        <label for="amount">Amount</label>
        <input type="text" name="amount" id="amount">
    </div>

    <br>

    <div>
        <label for="description">Description</label>
        <input type="text" name="description" id="description">
    </div>

    <br>

    <div>
        <input type="submit" value="Transfer">
    </div>
</form>

<?php include_once( __DIR__ . "/layout/footer.php");
