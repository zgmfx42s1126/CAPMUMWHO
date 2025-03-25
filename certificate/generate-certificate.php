<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "certificates_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user details from database (Assume ID=1 for example)
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 1;
$sql = "SELECT first_name, last_name FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name);
$stmt->fetch();
$stmt->close();
$conn->close();

if (!$first_name || !$last_name) {
    die("User not found.");
}

// Load certificate template
$templatePath = "certificate.png"; // Ensure this file exists
if (!file_exists($templatePath)) {
    die("Error: Certificate template not found.");
}

$image = imagecreatefrompng($templatePath);

// Enable alpha blending and save full transparency
imagealphablending($image, true);
imagesavealpha($image, true);

$color = imagecolorallocate($image, 0, 0, 0); // Black text

// Define font and position


// Convert name to uppercase for emphasis
$text = strtoupper($first_name . " " . $last_name);
$font_size = 50;

// Calculate text width for centering
$bbox = imagettfbbox($font_size, 0, $font, $text);
$text_width = $bbox[2] - $bbox[0];
$image_width = imagesx($image);
$x = ($image_width - $text_width) / 2; // Centering the text

$y = 700; // Adjust this based on your template positioning

// Render the text onto the image
imagettftext($image, $font_size, 0, $x, $y, $color, $font, $text);

// Output the final image
header("Content-Type: image/png");
imagepng($image);
imagedestroy($image);
?>
