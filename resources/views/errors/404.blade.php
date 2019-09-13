<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="{{ secure_asset('css/main-style.css') }}" />
  <!-- <link rel="short icon" type="image/png" sizes="16x16" href="{{ secure_asset('img/lucid-logo.svg') }}"> -->
  <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
  <link rel="manifest" href="favicon/site.webmanifest">
  <link rel="mask-icon" href="favicon/safari-pinned-tab.svg" color="#b805fc">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff">
  <title>Are you lost?</title>
  <style>
    body{
      text-align: center;
    }
    .container {
      margin-top: 6vh
    }
    img{
      width: 300px;
      margin-top: 0.7rem;
    }
    a{
      color: #ffffff;
      background: var(--secondary-color);
      padding: 1rem 0.7rem;
      display: inline-block;
      text-decoration: none;
    }
    @media screen and (max-width: 425px){
      img{
        width: 250px;
      }
    }
  </style>
</head>
<body>
    <main class="container">
      <h2>Something's not right</h2>
      <img src="{{ secure_asset('img/404-space-ship.svg') }}" alt="space ship image">
      <p>It seems the aliens have taken this page..</p>
      <a href="javascript: history.go(-1)">Click this button to return home</a>
    </main>
</body>
</html>