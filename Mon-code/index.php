<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(blue, 10%, pink);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
        }

        h1 {
            color: #de1212;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
<body>
    <?php include 'header.php'; ?>

    <form action="upload.php" method="post" enctype="multipart/form-data" class="form-container">

      <!-- Body -->
        <div class="form-body">
            <label for="profile_pic" class="form-label">Choose a file:</label>
            <input type="file" name="profile_pic" id="profile_pic" accept=".pdf, .jpg, .jpeg, .png" class="upload-input">
            <br>
            <input type="submit" value="Submit" class="upload-button">
        </div>

    </form>
</body>
</html>
</body>
</html>
