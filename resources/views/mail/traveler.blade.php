<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333333;
        }

        p {
            color: #666666;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 3px;
        }
    </style>
    <title>Traveler Request Confirmation Message</title>
</head>
<body>
    <div class="container">
        <h1>Confirmation: Your Traveler Request has been Approved</h1>
        <p>Dear {{$traveler->user->name }},</p>
        <p>We are delighted to inform you that your travel request has been approved!</p>
        <a href="{{ route('traveler.dashboard') }}" class="button">Visit Your dashboard</a>
        <p>Please review the provided information, and if you have any questions or need further assistance, feel free to reach out to our dedicated travel coordinator at {{ $anyBringrSettings->service_email }}</p>
        <p>Thank you for your commitment to excellence. We look forward to your participation in the E-commerce traveler system and wish you a productive and rewarding experience.</p>
        <p>Safe traveling with Anybringr!</p>
        <p>Best regards,<br>AnyBringr</p>
    </div>
</body>
</html>
