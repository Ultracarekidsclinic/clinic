<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {

   
    $patientName = htmlspecialchars(trim($_POST['patientName']));
    $mobileNumber = htmlspecialchars(trim($_POST['mobileNumber']));
    $age = htmlspecialchars(trim($_POST['age']));
    $email = htmlspecialchars(trim($_POST['email']));

    
    $clinicNumber = "919958826779"; // NOTE: Indian numbers need a '91' prefix for international format

   
    $patientMessage = "Dear " . $patientName . ", your appointment at UltraCare Diagnostics & Kids Clinic is confirmed. We look forward to seeing you!";

    
    $clinicMessage = "New Appointment Booking!\n" .
                     "Patient Name: " . $patientName . "\n" .
                     "Mobile: " . $mobileNumber . "\n" .
                     "Age: " . $age . "\n" .
                     "Email: " . $email;

    // --- SMS Sending Logic (Placeholder) ---
    // You MUST replace this with your actual SMS API integration code.
    // The code below is a conceptual example and won't work without a real API.

    // 1. You'll need an SMS API key or credentials
    $apiKey = "YOUR_SMS_API_KEY"; // Replace with your actual API key
    $senderId = "ULTRACARE"; // Replace with your sender ID (often provided by the service)

    // 2. The API endpoint URL provided by your service
    $api_url = "https://your-sms-api-provider.com/send"; // Replace with the actual URL

    // Function to send an SMS using cURL
    function sendSMS($to, $message, $url, $apiKey, $senderId) {
        // Prepare data for the API request
        $data = array(
            'apikey' => $apiKey,
            'senderid' => $senderId,
            'number' => $to,
            'message' => urlencode($message)
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    // Attempt to send messages
    $patientSent = sendSMS($mobileNumber, $patientMessage, $api_url, $apiKey, $senderId);
    $clinicSent = sendSMS($clinicNumber, $clinicMessage, $api_url, $apiKey, $senderId);

    // --- End SMS Sending Logic ---

    // Simple success/failure response
    if ($patientSent !== false && $clinicSent !== false) {
        echo "<script>alert('Your appointment has been booked! A confirmation message has been sent to your mobile.'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Failed to book appointment. Please try again later.'); window.location.href='index.html';</script>";
    }

} else {
    // If someone tries to access this script directly without submitting the form
    header("Location: index.html");
    exit();
}
?>
