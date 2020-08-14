<?php
    include_once( __DIR__ . "/layout/header.php");
?>

<div>
    <h1>DesignoCoin</h1>
</div>

<div class="img"></div>

<br class="space">

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
<br>
<br>

<?php include_once( __DIR__ . "/layout/footer.php");
