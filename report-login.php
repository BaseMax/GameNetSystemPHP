<?php
require "_core.php";

if (isset($_POST["submit"], $_POST["password"])) {
    if ($_POST["password"] === "AliAliAliAliAkhtar$$") {
        $_SESSION["report"] = time();
        header("Location: report.php");
    } else {
        $error = "عبور اشتباه است!";
    }
}
?>
<title>سیستم گیم نت</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="style.css">

<a href="index.php">
    برگشت به اتاق فرمان
</a>
<br>

<center>
	<h1>ورود به حسابداری</h1>
    <?php if (isset($error)) { ?>
        <p>
            <?= $error ?>
        </p>
    <?php } ?>
</center>

<form action="" method="POST" style="display: flex; justify-content: center;flex-direction: column;">
    <b>رمز عبور</b>
    <input type="password" name="password">
    <br>

    <button name="submit">ورود</button>
</form>
