<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $ip = $_SERVER["REMOTE_ADDR"];
    $email = $_POST["email"];
    $file = "email_list.txt";

    // Check if the IP address has exceeded the maximum allowed attempts
    $maxAttempts = 3;
    $ipAttempts = countEmailAttempts($ip);
    if ($ipAttempts >= $maxAttempts) {
        echo "Maximum attempts exceeded. Please try again later.";
        exit();
    }

    // Validate the email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit();
    }

    // Write the email to the file
    if (!empty($email)) {
        $handle = fopen($file, "a");
        if ($handle) {
            fwrite($handle, $email . PHP_EOL);
            fclose($handle);
            header("Location: email_subscribe.html?success=Subscription%20successful");
            incrementEmailAttempts($ip);
        } else {
            echo "<script>alert('很遗憾出现了点故障，未成功订阅。')</script>";
        }
    } else {
        echo "<script>alert('请输入有效的邮箱地址！')</script>";
    }
} else {
    echo "<script>alert('无效请求')</script>";
}

/**
 * Count the number of email attempts made by the given IP address.
 * @param string $ip The IP address
 * @return int The number of attempts
 */
function countEmailAttempts($ip) {
    $attemptsFile = "email_attempts.txt";
    $attempts = [];

    if (file_exists($attemptsFile)) {
        $attempts = unserialize(file_get_contents($attemptsFile));
    }

    if (isset($attempts[$ip])) {
        return $attempts[$ip];
    }

    return 0;
}

/**
 * Increment the number of email attempts made by the given IP address.
 * @param string $ip The IP address
 */
function incrementEmailAttempts($ip) {
    $attemptsFile = "email_attempts.txt";
    $attempts = [];

    if (file_exists($attemptsFile)) {
        $attempts = unserialize(file_get_contents($attemptsFile));
    }

    $attempts[$ip] = isset($attempts[$ip]) ? $attempts[$ip] + 1 : 1;
    file_put_contents($attemptsFile, serialize($attempts));
}
?>
