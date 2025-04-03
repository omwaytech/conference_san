<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SANCON-ASPA 2025 Registration Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }

        /* .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        } */
        h2 {
            font-size: 18px;
        }

        .bold {
            font-weight: bold;
        }

        .highlight {
            font-weight: bold;
            font-size: 20px;
        }

        .note {
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="container">
        <p>Dear {{ $data['name'] }},</p>
        <p>We are pleased to inform you that your registration for <span class="bold">SANCON-ASPA 2025</span> (Theme:
            <span class="note">Scaling New Heights in Pediatric Anesthesia and Beyond</span>) has been successfully
            completed.</p>
        <p>To collect your physical pass during the registration process, please <span class="bold">follow the
                alphabetical order</span> and <span class="bold">use your Registration ID</span> for quick reference.
        </p>
        <p>Your <span class="bold">Registration ID</span> is highlighted below for your convenience:</p>
        <p class="highlight">• Registration ID: {{ $data['registrationId'] }}</p>
        <p>Please ensure to have this email on hand when collecting your pass at the event. We appreciate your
            cooperation and look forward to welcoming you to SANCON-ASPA 2025.</p>
        <p>Should you have any further questions or need assistance, please don’t hesitate to contact us.</p>
        <p>Thank you and see you at the conference!</p>
        <p>Regards,</p>
        <p><span class="bold">SANCON ASPA 2025</span><br>Registration Committee</p>
    </div>
</body>

</html>
