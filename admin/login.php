<?php

require_once("../config.php");
require_once(SRC_DIR . "bobblog.php");

$bb = new BobBlog();
$loginSuccess = false;

if (isset($_POST["username"])) {
    $loginName = $_POST['username'];
    $magicWord = $_POST['password'];
    try {
        $con = new PDO("mysql:host=". DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "SELECT * FROM userbase WHERE username = '$loginName'";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll();

        $username_exists = false;
        $lockout_minutes = 5;
        $login_fail_max = 5;
        $login_fail_count = 0;
        $timestamp = date("Y-m-d H:i:s");

        if (sizeof($data) == 1) {
            $userid = $data[0]['userid'];
            $username_exists = true;
            if ($data[0]['is_locked'] == 1) {
                $lock_start_timestamp = $data[0]['lock_start_timestamp'];
                if ($lock_start_timestamp != NULL) {
                    $dif = (strtotime($timestamp) - strtotime($lock_start_timestamp));
                    if ($dif > $lockout_minutes * 60) {
                        $login_fail_count = 0;
                        $sql = "UPDATE userbase
                        SET is_locked = 0, login_fail_count = 0, lock_start_timestamp = NULL
                        WHERE userid = $userid";
                        $stmt = $con->prepare($sql);
                        $stmt->execute();
                    }
                }
            } else {
                $login_fail_count = $data[0]['login_fail_count'];
            }
        }

        if ($username_exists) {
            $sql = "SELECT * FROM userbase WHERE username = '$loginName' AND magicword = '$magicWord' LIMIT 1";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $data = $stmt->fetchAll();
            
            if (sizeof($data) == 1) {
                if ($data[0]["is_locked"] == 0) {
                    $sql = "UPDATE userbase
                    SET login_fail_count = 0
                    WHERE userid = $userid";
                    $stmt = $con->prepare($sql);
                    $stmt->execute();

                    // Login Successful
                    $_SESSION["userID"] = $data[0]["username"];
                    $_SESSION["userEmail"] = $data[0]["email"];
                    $_SESSION["userType"] = $data[0]["type"];
                    $_SESSION["userRole"] = $data[0]["role"];
                    header("Location: " . LOGIN_SUCCESS_URL);
                } else {
                    // Account is locked. Increment failed login count
                    $sql = "UPDATE userbase
                        SET login_fail_count = login_fail_count + 1
                        WHERE username = '$loginName'";
                    $stmt = $con->prepare($sql);
                    $stmt->execute();
                    echo "<pre>Account is locked.</pre>";
                }
            } else {
                // Not Successful. Increment failed login count
                $will_be_locked = ($login_fail_count == $login_fail_max - 1);
                $timestamp = date("Y-m-d H:i:s");
                if ($will_be_locked) {
                    $sql = "UPDATE userbase 
                    SET login_fail_count = login_fail_count + 1, is_locked = 1, lock_start_timestamp = '$timestamp'
                    WHERE userid = $userid";
                } else {
                    $sql = "UPDATE userbase 
                    SET login_fail_count = login_fail_count + 1
                    WHERE userid = $userid";
                }
                $stmt = $con->prepare($sql);
                $stmt->execute();
                
                if ($will_be_locked) {
                    echo "<pre>Account is locked.</pre>";
                } else {
                    $attempts_remaining = ($login_fail_max - ($login_fail_count + 1));
                    if ($attempts_remaining > 0) {
                        echo "<pre>Incorrect username or password.</pre>";
                        if ($attempts_remaining <= 3) {
                            echo "<pre>Attempts remaining: " . ($login_fail_max - ($login_fail_count + 1)) . "</pre>";
                        }
                    }
                }
            }
        } else {
            echo "<pre>Incorrect username or password.</pre>";
        }
    } catch (PDOException $e) {
        echo "Fail: " . $e->getMessage();
    }
}

$bb->addHeadScript(array("src" => "https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"));
$bb->addHeadScript(array("src" => "https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"));

$bb->addHeadStyle(array("href" => "https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css"));
$bb->addHeadStyle(array("href" => "https://fonts.googleapis.com/css?family=Lato"));
$bb->addHeadStyle(array("href" => "https://fonts.googleapis.com/css?family=Droid+Sans|Lato"));
$bb->addHeadStyle(array("href" => ASSETS_URL . "/css/font-awesome.min.css"));
$bb->addHeadStyle(array("href" => ASSETS_URL . "/css/core.css"));

// prepare all variables, then load the template
include(TEMPLATE_DIR . 'login.html');
