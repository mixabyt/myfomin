<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
</head>
<body>
    @foreach($transactions as $transaction)
        <div>

            {{$transaction->amount}}
        </div>


    @endforeach
</body>
</html>
