<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My QR Code</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      text-align: center;
    }
    img.qr {
      width: 80vw; /* 80% ya screen width */
      max-width: 400px; /* Usizidi 400px kwenye desktop */
      margin-top: 60px;
    }
  </style>
</head>
<body>
<img class="qr" src="{{ asset('qrcodes/customer_' . $id . '.svg') }}" alt="QR Code">
</body>
</html>
