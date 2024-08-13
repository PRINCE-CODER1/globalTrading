<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Stock Aging Notification Email</title>
</head>
<body>
    <p>Hello,</p>

    <p>The product "{{ $product->product_name }}" is now {{ $ageDays }} days old.</p>
    <p>Please review the stock and take necessary actions.</p>

    <p>Thank you!</p>
</body>
</html>