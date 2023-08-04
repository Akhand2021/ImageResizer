<!DOCTYPE html>
<html>

<head>
    <title>Image Upload</title>
</head>

<body>
    <form action="{{ route('image.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="image">Choose an image:</label>
        <input type="file" name="image" id="image">
        <button type="submit">Upload</button>
        @if ($errors->has('image'))
            <div style="color: red">{{ $errors->first('image') }}</div>
        @endif
    </form>
</body>

</html>
