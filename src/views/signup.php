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

<form action="/signup.php" method="post">
    <div>
        <label for="firstname">Firstname</label>
        <input type="text" name="firstname" id="firstname">
    </div>

    <br>

    <div>
        <label for="lastname">Lastname</label>
        <input type="text" name="lastname" id="lastname">
    </div>

    <br>

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
        <input type="submit" value="Sign up">
    </div>
</form>
<br>
<br>

<?php include_once( __DIR__ . "/layout/footer.php");
