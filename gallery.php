<?php 
$page_title = "Gallery";
include 'config.php'; 
include 'templates/header.php'; 

$limit = 8; // Number of images per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch images from the gallery table
$sql = "SELECT * FROM gallery ORDER BY created_at DESC LIMIT $start, $limit";
$result = $conn->query($sql);

$total_sql = "SELECT COUNT(id) FROM gallery";
$total_result = $conn->query($total_sql);
$total_images = $total_result->fetch_row()[0];
$total_pages = ceil($total_images / $limit);
?>

<section class="gallery">
    <h1>My Photo Gallery</h1>
    <div class="gallery-grid">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="gallery-item">
                    <img src="images/<?php echo $row['image_path']; ?>" alt="<?php echo $row['title']; ?>">
                    <div class="overlay">
                        <h3><?php echo $row['title']; ?></h3>
                        <p><?php echo $row['description']; ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No photos available.</p>
        <?php endif; ?>
    </div>

    <!-- Pagination Links -->
    <div class="pagination">
        <!-- Previous Button -->
        <?php if ($page > 1): ?>
            <a href="gallery.php?page=<?php echo $page - 1; ?>">Previous</a>
        <?php endif; ?>

        <!-- Page Numbers -->
        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
            <a href="gallery.php?page=<?php echo $i; ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <!-- Next Button -->
        <?php if ($page < $total_pages): ?>
            <a href="gallery.php?page=<?php echo $page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
</section>

<?php include 'templates/footer.php'; ?>


<!-- CSS Section -->
<style>
    /* Gallery Styles */
    .gallery {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        text-align: center;
    }

    .gallery h1 {
        margin-bottom: 30px;
        font-size: 2.5rem;
        color: #2a80a8;
    }

    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Use 250px as min width for images */
        gap: 20px;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .gallery-item img {
        width: 100%;
        height: auto; /* Let height be automatic to maintain aspect ratio */
        object-fit: cover;
        border-radius: 10px;
        display: block;
    }

    .gallery-item:hover {
        transform: scale(1.05);
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7); /* Slightly lighter for better visibility */
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 10px; /* Less padding for better text fitting */
        border-radius: 10px;
        text-align: center; /* Center the text */
    }

    .gallery-item:hover .overlay {
        opacity: 1;
    }

    /* Pagination Styles */
    .pagination {
        margin-top: 15px;
        margin-bottom: 60px;
        display: flex;
        justify-content: center; 
        flex-wrap: wrap;
        align-items: center; 
    }

    .pagination a {
        margin: 0 5px;
        padding: 5px 15px;
        background-color: #2a80a8;
        color: white;
        border-radius: 5px;
        text-decoration: none;
        transition: background-color 0.3s ease;
        font-size: 1.1rem;
    }

    .pagination a:hover {
        background-color: #1c6a97;
    }

    .pagination a.active {
        background-color: #1c6a97;
        pointer-events: none;
    }

    /* Style for Previous and Next buttons */
    .pagination a:first-child, .pagination a:last-child {
        font-weight: bold;
    }

    .pagination a:first-child:hover, .pagination a:last-child:hover {
        background-color: #145a7c;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .gallery h1 {
            font-size: 2rem; 
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); 
        }

        .pagination {
            margin-top: 10px;
            margin-bottom: 60px;
        }

        .pagination a {
            margin: 0 5px;
            padding: 5px 15px;
            background-color: #2a80a8;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-size: 1.1rem;
        }
    }

    @media (max-width: 768px) {
        .gallery h1 {
            font-size: 1.75rem;
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); 
        }

        .pagination {
            margin-top: 10px;
            margin-bottom: 40px;
        }

        .pagination a {
            margin: 0 5px;
            padding: 5px 15px;
            background-color: #2a80a8;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-size: 1.1rem;
        }
    }

    @media (max-width: 576px) {
        .gallery h1 {
            font-size: 1.5rem; 
        }

        .overlay {
            padding: 2px; 
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        }

        .pagination {
            margin-top: 10px;
            margin-bottom: 90px;
        }

        .pagination a {
            margin: 0 5px;
            padding: 5px 15px;
            background-color: #2a80a8;
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-size: 1.1rem;
        }
    }
</style>
