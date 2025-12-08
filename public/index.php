<?php
// router.php
print_r($_SERVER["REQUEST_URI"]);
if (preg_match('/\.(?:png|jpg|jpeg|gif)$/', $_SERVER["REQUEST_URI"])) {
    return false;    // serve o recurso requisitado sem modificação.
} else {
    echo "<p>Welcome to PHP</p>";
}
?>