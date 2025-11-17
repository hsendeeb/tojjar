<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome to Tojjar</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f7f7f7;
      margin: 0;
      padding: 0;
    }
    .container {
      max-width: 600px;
      margin: 40px auto;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    h1 {
      color: #333333;
    }
    p {
      font-size: 16px;
      color: #555555;
    }
    .footer {
      margin-top: 30px;
      font-size: 14px;
      color: #999999;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Hi {{ $user->name }},</h1>
<p>Your account has been successfully verified. You're now a trusted member of Tojjar.</p>
<p>Feel free to post ads, connect with others, and enjoy full platform access.</p>
<p>Welcome aboard!</p>
    <div class="footer">
      &mdash; The Tojjar support Team<br>
      <a href="{{ env('APP_URL') }}">{{ env('APP_URL') }}</a>
    </div>
  </div>
</body>
</html>