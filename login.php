<?php
/*
// Outcommented as 'merser.dk' is not an encrypted sever!
if(!$_SERVER['HTTPS']) {
  header("Location: https://merser.dk/Stine".$filename);
  exit();
}
*/
session_save_path("../../stine_sessions");
ini_set('session.gc_maxlifetime', 3600);    // 1 hour
ini_set('session.gc_probability', 5);       // 5%
session_set_cookie_params(0);               // Delete cookien if browser closes
session_start();
error_reporting(0);


function  checklogin() {
    // DATABASE CONNECT
    include('../../.PDO.inc');
    $pdo = new PDO('mysql:host=mysql2.unoeuro.com;dbname=merser_dk_db', $db_usr, $pwd);

    if ($user_id = $_SESSION['user_id']) {
        return 1;
    } else {
        if (isset($_POST['password'])) {
            $sql = sprintf("select * from t_users where usr='%s' and pwd='%s'", 'stine', $_POST['password']);
            $res = $pdo->query($sql)->fetch();
            if ($res) {
                $_SESSION['user_id'] = $site_usr;
                return 1;
            }
        }
    }

print <<<EOF
<br>
<form method="post" name="login">
<center><table>
<tr><td><input type="password" id="pwd" name="password" placeholder="Skriv adgangskode" style="text-align:center;"></td></tr>
<tr><td align="right"><input type="submit" value="Login"></td></tr>
</table></center>
</form>
EOF;
return 0;
}

?>
