<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include('/config.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

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
        }

        h1 {
            text-align: center;
            color: #2a80a8;
            margin-bottom: 20px;
        }

        /* Admin Action Button Container */
        .admin-actions {
            display: flex;
            justify-content: center;
            gap: 15px; /* Adds space between buttons */
            margin-bottom: 30px;
        }

        .cta-button {
            display: inline-block;
            padding: 15px 30px;
            background-color: #2a80a8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 1.1rem;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .cta-button:hover {
            background-color: #1c6a97;
            transform: translateY(-3px); /* Lift button on hover */
        }

        /* Admin Gallery Section */
        .admin-gallery {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .admin-gallery h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            color: #2a80a8;
        }

        /* Admin Item Layout */
        .admin-item {
            background-color: white;
            padding: 20px;
            margin: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .admin-item:hover {
            transform: translateY(-5px); /* Hover effect */
        }

        .admin-item img {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .admin-item h3 {
            margin: 10px 0;
            font-size: 1.5rem;
            color: #333;
        }

        /* Edit and Delete Button Styling */
        .edit-btn, .delete-btn {
            display: inline-block;
            padding: 8px 15px;
            margin: 5px;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
        }

        .edit-btn {
            background-color: #f7b731;
        }

        .delete-btn {
            background-color: #e74c3c;
        }

        .edit-btn:hover {
            background-color: #d4a22b;
        }

        .delete-btn:hover {
            background-color: #c0392b;
        }

        /* Grid layout for gallery items */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        /* Media Queries for Responsive Design */
        @media (max-width: 768px) {
            .cta-button {
                font-size: 1rem;
                padding: 10px 20px;
            }

            .admin-item h3 {
                font-size: 1.2rem;
            }

            .edit-btn, .delete-btn {
                font-size: 0.9rem;
                padding: 7px 12px;
            }
        }
    </style>
</head>
<body>

    <h1>Welcome to the Admin Dashboard</h1>

    <!-- Admin Action Buttons -->
    <div class="admin-actions">
        <a href="upload_photo.php" class="cta-button">Upload New Photo</a>
        <a href="logout.php" class="cta-button">Logout</a>
    </div>

    <!-- Gallery Management Section -->
<section class="admin-gallery">
    <h2>Manage Gallery</h2>

    <div class="gallery-grid">
        <?php
        // Include the database connection
        include('./config.php');

        // Fetch gallery items ordered by id (or another column)
        $sql = "SELECT * FROM gallery ORDER BY id DESC"; // Using 'id' for ordering
        $result = $conn->query($sql);

        // Check if there are any results
        if ($result->num_rows > 0) {
            // Loop through each row and display the gallery item
            while ($row = $result->fetch_assoc()) {
                echo "<div class='admin-item'>";
                echo "<img src='../images/" . $row['image_path'] . "' alt='" . $row['title'] . "'>";
                echo "<h3>" . $row['title'] . "</h3>";
                echo "<a href='edit_photo.php?id=" . $row['id'] . "' class='edit-btn'>Edit</a>";
                echo "<a href='delete_photo.php?id=" . $row['id'] . "' class='delete-btn' onclick=\"return confirm('Are you sure you want to delete this photo?');\">Delete</a>";
                echo "</div>";
            }
        } else {
            // No photos available message
            echo "<p>No photos available.</p>";
        }
        ?>
    </div>
</section>


</body>
</html>
