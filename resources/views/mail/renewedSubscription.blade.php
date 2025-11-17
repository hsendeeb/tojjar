<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome to Tojjar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
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
    <p> Your <strong>premium plan has been renewed successfully </strong>.</p>
    <p>The premium plan will be valid until <mark>{{ date_format($user->subscription->last()?->ends_at,'d/m/Y') }}!</mark></p>
   <div class="text-center"><a href="{{ route('profile.index',$user->id) }}" class="btn btn-primary w-100 mx-auto">Go to profile</a></div>
    <div class="footer">
      
      &mdash; The Tojjar support Team<br>
      <a href="{{ env('APP_URL') }}">{{ env('APP_URL') }}</a>
    </div>
  </div>
</body>
</html>