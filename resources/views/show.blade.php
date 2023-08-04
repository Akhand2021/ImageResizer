<!DOCTYPE html>
<html>
<head>
    <title>Show Images</title>
</head>
<body>
    <h1>Original Image</h1>
    @if (session('success'))
    <div class="success-message">{{ session('success') }}</div>
@endif
    <img src="{{ $originalImagePath }}" alt="Original Image">

    <h1>Resized Image</h1>
    <img src="{{ $resizedImagePath }}" alt="Resized Image">
</body>
</html>
