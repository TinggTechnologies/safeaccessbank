<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fingerprint Detection</title>
</head>
<body>
    <button id="detectFingerprintButton">Detect Fingerprint</button>
    <p id="status"></p>

    <script>
        document.getElementById('detectFingerprintButton').addEventListener('click', () => {
            if (!window.PublicKeyCredential) {
                document.getElementById('status').textContent = "WebAuthn is not supported in this browser.";
                return;
            }

            const publicKey = {
                challenge: new Uint8Array(32),
                rp: {
                    name: "Example Corp"
                },
                user: {
                    id: new Uint8Array(16),
                    name: "user@example.com",
                    displayName: "User Example"
                },
                pubKeyCredParams: [{
                    type: "public-key",
                    alg: -7 // ES256
                }],
                authenticatorSelection: {
                    authenticatorAttachment: "platform",
                    userVerification: "required"
                }
            };

            navigator.credentials.create({ publicKey })
                .then(credential => {
                    console.log('Fingerprint detected and used for registration.', credential);
                    document.getElementById('status').textContent = "Fingerprint detected and used for registration.";
                    
                    // Redirect to registered.php after 5 seconds
                    setTimeout(() => {
                        window.location.href = './user/user_profile.php';
                    }, 5000);
                })
                .catch(err => {
                    console.error('Error or fingerprint not detected', err);
                    document.getElementById('status').textContent = "Error or fingerprint not detected.";
                });
        });
    </script>
</body>
</html>
