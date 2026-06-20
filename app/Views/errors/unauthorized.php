<!DOCTYPE html>
<html>
<head>
    <title>403 - Forbidden</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            padding-top: 80px;
        }
        h1 {
            font-size: 50px;
            color: #dc3545;
        }
        p {
            font-size: 18px;
            color: #555;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: white;
            background: #007bff;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>

    <h1>403</h1>
    <p>You do not have permission to access this page.</p>

    <a href="<?= esc($backUrl) ?>"
       style="display:inline-block;
              margin-top:20px;
              padding:10px 20px;
              background:#007bff;
              color:white;
              text-decoration:none;
              border-radius:5px;">
        Go Back
    </a>

</body>
</html>