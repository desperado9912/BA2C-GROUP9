<?php
session_start();

/* PROXY DESIGN PATTERN */

interface Auth {
    public function login($e, $p);
}

class RealAuth implements Auth {
    private $email = "admin@example.com";
    private $pass  = "12345";

    public function login($e, $p) {
        return ($e === $this->email && $p === $this->pass);
    }
}

class ProxyAuth implements Auth {
    private $real;

    public function __construct() { 
        $this->real = new RealAuth();
        $_SESSION["tries"] = $_SESSION["tries"] ?? 0;
    }

    public function login($e, $p) {
        if ($_SESSION["tries"] >= 3) return "blocked";

        if ($this->real->login($e, $p)) return "granted";

        $_SESSION["tries"]++;
        return "denied";
    }
}

/* ==== HANDLE SUBMIT ==== */
$result = null;
if ($_POST) {
    $auth = new ProxyAuth();
    $result = $auth->login($_POST["email"], $_POST["password"]);
}
?>
<!DOCTYPE html>
<html>
<head>
<style>
    body { background:#0a0f24; color:white; font-family:Arial; text-align:center; padding-top:60px; }
    .box { background:#11182e; padding:25px; width:300px; margin:auto; border-radius:10px; }
    input,button { width:90%; padding:10px; margin:6px 0; border:none; border-radius:5px; }
    button { background:#1e90ff; color:white; cursor:pointer; }
    .ok{color:#00ff7f;} .bad{color:#ff5050;} .block{color:#ffcc00;}
</style>
<title>Proxy Login</title>
</head>
<body>

<?php if (!$result): ?>
<div class="box">
    <h2>Login</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button>Login</button>
    </form>
    <p>Attempts: <?= $_SESSION["tries"] ?>/3</p>
</div>
<?php else: ?>
<div class="box">
    <?php 
        if ($result == "granted") echo "<h1 class='ok'>ACCESS GRANTED</h1>";
        if ($result == "denied") echo "<h1 class='bad'>ACCESS DENIED</h1>";
        if ($result == "blocked") echo "<h1 class='block'>SYSTEM BLOCKED</h1>";
    ?>
</div>
<?php endif; ?>

</body>
</html>
