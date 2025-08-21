<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $phone = $_POST['phone'];

    // Random OTP generate
    $otp = rand(100000, 999999);

    // SMSlenz API
    $url = "https://smslenz.lk/api/sms/send";
    $data = [
        "uid" => "578", // 👉 SMSlenz UID
        "to" => $phone,
        "message" => "Your OTP code is: $otp"
    ];

    $options = [
        "http" => [
            "header"  => "Content-Type: application/json\r\n" .
                         "Authorization: Bearer ffa49e48-ef51-4f6e-ab4f-f9a44fcd1008\r\n", // 👉 SMSlenz API Key
            "method"  => "POST",
            "content" => json_encode($data)
        ]
    ];

    $context  = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);

    if ($result) {
        echo json_encode(["status" => "success", "otp" => $otp]);
    } else {
        echo json_encode(["status" => "fail"]);
    }
}
?>
