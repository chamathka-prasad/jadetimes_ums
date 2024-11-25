<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Under Maintenance</title>
    <style>
        /* Basic reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Full-page background styling */
        body, html {
            height: 100%;
            font-family: Arial, sans-serif;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('LogInBack.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }

        /* Dark overlay for better contrast */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.6); /* Adjust opacity as needed */
            z-index: 1;
        }

        /* Container for logo and message */
        .container {
            position: relative;
            text-align: center;
       justify-content: center;
       align-items: center;
            z-index: 2;
        }

        /* Logo styling */
        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }

        /* Maintenance message styling */
        h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        p {
            font-size: 1.2em;
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="darkLogo.png" alt="Jadetimes Logo" class="logo">
        <h1>We're Currently Under Maintenance</h1>
        <p>Our website is temporarily down for updates. We’ll be back shortly. Thank you for your patience!</p>
    </div>
</body>
</html>
