<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            color: #333333;
            margin-bottom: 10px;
        }
        p {
            color: #666666;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<h1>{{ $title }}</h1>
<h3>Date: {{ $date }}</h3>
<h3>Location: {{ $location }}</h3>
<p>{{ $description }}</p>
</body>
</html>
