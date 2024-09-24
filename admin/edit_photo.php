<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include('../config.php');

if (isset($_GET['id'])) {
    $photo_id = escape($_GET['id']);
    
    // Fetch the current photo details
    $sql = "SELECT * FROM gallery WHERE id='$photo_id'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $photo = $result->fetch_assoc();
    } else {
        echo "Photo not found!";
        exit();
    }
}

// Update the photo
if (isset($_POST['update'])) {
    $title = escape($_POST['title']);
    $description = escape($_POST['description']);
    $category = escape($_POST['category']); // Fetch new category
    $photo_id = escape($_POST['id']);
    
    // Check if a new image has been uploaded
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target = "../uploads/" . basename($image);
        
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            // Update with new image
            $sql = "UPDATE gallery SET title='$title', description='$description', category='$category', image_path='$target' WHERE id='$photo_id'";
        } else {
            echo "Failed to upload new image.";
            exit();
        }
    } else {
        // Update without changing the image
        $sql = "UPDATE gallery SET title='$title', description='$description', category='$category' WHERE id='$photo_id'";
    }
    
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php?success=1");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Photo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #2a80a8;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        input[type="text"], textarea, input[type="file"], select {
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }
        textarea {
            resize: vertical;
            height: 100px;
        }
        img {
            display: block;
            margin-bottom: 20px;
            max-width: 150px;
            border-radius: 5px;
        }
        .form-container p {
            margin-bottom: 10px;
            font-weight: bold;
        }
        button {
            background-color: #2a80a8;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #1f6690;
        }
        @media (max-width: 600px) {
            .form-container {
                margin: 20px;
                padding: 20px;
            }
            button {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Edit Photo</h2>
    <form method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $photo['id']; ?>">
        <input type="text" name="title" value="<?php echo $photo['title']; ?>" required>
        <textarea name="description" required><?php echo $photo['description']; ?></textarea>
        
        <!-- Display current image -->
        <img src="../<?php echo $photo['image_path']; ?>" alt="Current Image">
        
        <p>Change Image (optional):</p>
        <input type="file" name="image">

        <!-- Category Dropdown (with pre-selected category) -->
        <p>Category:</p>
        <select name="category" required>
            <option value="Nature" <?php if($photo['category'] == 'Nature') echo 'selected'; ?>>Nature</option>
            <option value="Wedding" <?php if($photo['category'] == 'Wedding') echo 'selected'; ?>>Wedding</option>
            <option value="Portraits" <?php if($photo['category'] == 'Portraits') echo 'selected'; ?>>Portraits</option>
            <option value="Fashion" <?php if($photo['category'] == 'Fashion') echo 'selected'; ?>>Fashion</option>
            <option value="Events" <?php if($photo['category'] == 'Events') echo 'selected'; ?>>Events</option>
            <option value="Other" <?php if($photo['category'] == 'Other') echo 'selected'; ?>>Other</option>
        </select>

        <button type="submit" name="update">Update Photo</button>
    </form>
</div>

</body>
</html>
