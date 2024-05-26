<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ID Card</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: Arial, sans-serif;
        }
        .id-card {
            max-width: 300px;
            margin: 0 auto;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .id-card__header {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .id-card__content {
            padding: 20px;
        }
        .id-card__content img {
            max-width: 100%;
            height: auto;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .id-card__content h2 {
            margin-bottom: 5px;
            font-size: 20px;
            font-weight: bold;
        }
        .id-card__content p {
            margin-bottom: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="id-card">
        <div class="id-card__header">
            ID Card
        </div>
        <div class="id-card__content">
            <img src="{{ asset('storage/fotos' . $atlet->foto) }}" alt="Foto Diri">
            <h2>{{ $atlet->nama }}</h2>
            <p>Gender: {{ $atlet->jk == 'l' ? 'Laki-laki' : 'Perempuan' }}</p>
            <p>Berat Badan: {{ $atlet->bb }} kg</p>
        </div>
    </div>
</body>
</html>
