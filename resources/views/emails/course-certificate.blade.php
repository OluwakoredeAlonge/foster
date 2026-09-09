<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Certificate</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        h2 {
            color: #047857; /* emerald, matches the courses module */
        }
        p {
            line-height: 1.5;
        }
        .message-box {
            background-color: #f1f5f9;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
            white-space: pre-line;
        }
        .footer {
            font-size: 0.85rem;
            color: #6b7280;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Congratulations, {{ $studentName }}!</h2>

        <p>Your certificate for <strong>{{ $courseTitle }}</strong> is attached to this email.</p>

        @if($customMessage)
            <div class="message-box">
                {{ $customMessage }}
            </div>
        @endif

        <p>Thank you for learning with us.</p>

        <div class="footer">
            &copy; {{ date('Y') }} Fosterheirs. All rights reserved.
        </div>
    </div>
</body>
</html>
