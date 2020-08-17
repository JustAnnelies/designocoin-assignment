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
        <br>
        <br>
    </div>
<?php endif; ?>

<form action="/login.php" method="post">
    <div>
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
    </div>

    <br>

    <div>
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
    </div>

    <br>

    <div>
        <input type="submit" value="Login">
    </div>
</form>

<?php include_once( __DIR__ . "/layout/footer.php");
