<?php
require 'vendor/autoload.php';

use WebAuthn\Server;
use WebAuthn\PublicKeyCredentialLoader;

$server = new Server('https://yourdomain.com', 'YourAppName');

// Retrieve challenge from session
$challenge = $_SESSION['challenge'];
$userID = 'uniqueUserID'; // Retrieve this from session or database

$loader = new PublicKeyCredentialLoader();
$credential = $loader->loadArray(json_decode(file_get_contents('php://input'), true));

$publicKeyCredentialSource = $server->processCreate(
    $challenge,
    $credential,
    $userID
);

// Save public key credential source to database
$mysqli = new mysqli("localhost", "username", "password", "yourdbname");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$stmt = $mysqli->prepare("INSERT INTO users (username, public_key, credential_id) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $publicKeyCredentialSource->getAttestationObject(), $publicKeyCredentialSource->getPublicKeyCredentialId());
$stmt->execute();

echo json_encode(['status' => 'Registration successful']);

$stmt->close();
$mysqli->close();
?>
