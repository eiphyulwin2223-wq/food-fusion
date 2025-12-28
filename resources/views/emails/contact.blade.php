<!DOCTYPE html>
<html>
<head>
    <title>Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 15px;
            border-bottom: 3px solid #0d6efd;
            margin-bottom: 20px;
        }
        .content {
            padding: 15px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #6c757d;
            text-align: center;
        }
        .field {
            margin-bottom: 15px;
        }
        .field-label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .field-value {
            padding: 5px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>New Contact Form Submission</h2>
    </div>

    <div class="content">
        <div class="field">
            <div class="field-label">Name:</div>
            <div class="field-value">{{ $data['name'] }}</div>
        </div>

        <div class="field">
            <div class="field-label">Email:</div>
            <div class="field-value">{{ $data['email'] }}</div>
        </div>

        <div class="field">
            <div class="field-label">Subject:</div>
            <div class="field-value">{{ $data['subject'] }}</div>
        </div>

        <div class="field">
            <div class="field-label">Message:</div>
            <div class="field-value">{{ $data['message'] }}</div>
        </div>
    </div>

    <div class="footer">
        <p>This email was sent from the contact form on Food Fusion website.</p>
    </div>
</body>
</html>
