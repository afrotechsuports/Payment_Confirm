<?php
// Handle form submission
$fullname = $email = $phone = $message = "";
$upload_status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : "";
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : "";
    $phone = isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : "";

    // Handle file upload
    if (isset($_FILES['screenshot']) && $_FILES['screenshot']['error'] == UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . basename($_FILES['screenshot']['name']);
        
        // Create uploads directory if it doesn't exist
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['screenshot']['tmp_name'], $upload_file)) {
            $upload_status = "Screenshot uploaded successfully! 📸";
        } else {
            $upload_status = "Failed to upload screenshot. 😔";
        }
    }

    if ($fullname && $email && $phone) {
        $message = "Payment confirmation received!<br>Full Name: $fullname<br>Email: $email<br>Phone: $phone";
    } else {
        $message = "Please fill in all fields. ⚠️";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Your Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            text-align: center;
            color: #2c3e50;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="email"], input[type="tel"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .bank-option {
            background-color: #fff;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .copy-btn {
            padding: 5px 10px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .copy-btn:hover {
            background-color: #2980b9;
        }
        .upload-btn, .support-btn {
            display: block;
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: center;
        }
        .upload-btn:hover {
            background-color: #219653;
        }
        .support-btn {
            background-color: #e67e22;
        }
        .support-btn:hover {
            background-color: #d35400;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            background-color: #ecf0f1;
        }
    </style>
</head>
<body>
    <h1>Confirm Your Payment 💸</h1>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fullname">Your Full Name 👤</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>" placeholder="Enter your full name" required>
        </div>

        <div class="form-group">
            <label for="email">Your Email 📧</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" placeholder="Enter your email" required>
        </div>

        <div class="form-group">
            <label for="phone">Phone Number 📞</label>
            <input type="tel" id="phone" name="phone" value="<?php echo $phone; ?>" placeholder="Enter your phone number" required>
        </div>

        <h3>Bank Details 🏦</h3>
        <div class="bank-option">
            <div>
                <strong>Commercial Bank of Ethiopia</strong><br>
                Name: Asefa Mezgebu<br>
                Account No: 100023033324
            </div>
            <button type="button" class="copy-btn" onclick="copyToClipboard('100023033324')">Copy 📋</button>
        </div>

        <div class="bank-option">
            <div>
                <strong>Bank of Abyssinia</strong><br>
                Name: Asefa Mezgebu<br>
                Account No: 96332933
            </div>
            <button type="button" class="copy-btn" onclick="copyToClipboard('96332933')">Copy 📋</button>
        </div>

        <div class="bank-option">
            <div>
                <strong>Zemen Bank</strong><br>
                Name: Asefa Mezgebu<br>
                Account No: 12044302209
            </div>
            <button type="button" class="copy-btn" onclick="copyToClipboard('12044302209')">Copy 📋</button>
        </div>

        <div class="form-group">
            <label for="screenshot">Upload Screenshot 📸</label>
            <input type="file" id="screenshot" name="screenshot" accept="image/*">
        </div>

        <button type="submit" class="upload-btn">Submit Confirmation ✅</button>
    </form>

    <button class="support-btn" onclick="alert('Contact us at support@example.com or call +251-XXX-XXX-XXXX')">Customer Support ☎️</button>

    <?php if ($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>
    <?php if ($upload_status): ?>
        <div class="message"><?php echo $upload_status; ?></div>
    <?php endif; ?>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Account number copied to clipboard! ✅');
            }).catch(err => {
                console.error('Failed to copy: ', err);
            });
        }
    </script>
</body>
</html>
