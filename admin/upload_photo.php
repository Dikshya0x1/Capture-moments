<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include('../config.php');

if (isset($_POST['upload'])) {
    $title = escape($_POST['title']);
    $description = escape($_POST['description']);
    
    // File upload
    $image = $_FILES['image']['name'];
    $target = "../images/" . basename($image);
    
    // Check if file was uploaded without errors
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // Use prepared statement to avoid SQL injection
            $stmt = $conn->prepare("INSERT INTO gallery (title, description, image_path) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $description, $target);

            if ($stmt->execute()) {
                header("Location: dashboard.php?success=1");
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Failed to upload image.";
        }
    } else {
        echo "Error uploading file: " . $_FILES['image']['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload New Photo</title>

    <style>
        /* Basic Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8;
            color: #333;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Card Layout for Form */
        .upload-form {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }

        .upload-form h2 {
            color: #2a80a8;
            margin-bottom: 20px;
            font-size: 2rem;
        }

        .upload-form input,
        .upload-form textarea {
            width: 100%;
            padding: 20px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .upload-form input[type="file"] {
            padding: 5px;
            font-size: 0.9rem;
        }

        /* Styling the Button */
        .upload-form button {
            background-color: #2a80a8;
            color: white;
            padding: 15px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .upload-form button:hover {
            background-color: #1c6a97;
            transform: translateY(-3px); /* Slight lift on hover */
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .upload-form {
                padding: 20px;
            }

            .upload-form h2 {
                font-size: 1.8rem;
            }

            .upload-form input,
            .upload-form textarea {
                font-size: 0.95rem;
            }

            .upload-form button {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>

    <form method="post" enctype="multipart/form-data" class="upload-form">
        <h2>Upload New Photo</h2>
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description" required></textarea>
        <input type="file" name="image" required>
        <button type="submit" name="upload">Upload Photo</button>
    </form>

</body>
</html>
