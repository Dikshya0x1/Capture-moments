<?php 
$page_title = "Gallery";
include 'config.php'; 
include 'templates/header.php'; 

// Check if limit is set in the URL, otherwise use default limit
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 8; // Default is 8, 9 for iPads
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$category = isset($_GET['category']) ? $_GET['category'] : '';

// Start for pagination
$start = ($page - 1) * $limit;

// Category filter query
if ($category) {
    $sql = "SELECT * FROM gallery WHERE category = '$category' ORDER BY created_at DESC LIMIT $start, $limit";
    $total_sql = "SELECT COUNT(id) FROM gallery WHERE category = '$category'";
} else {
    $sql = "SELECT * FROM gallery ORDER BY created_at DESC LIMIT $start, $limit";
    $total_sql = "SELECT COUNT(id) FROM gallery";
}

$result = $conn->query($sql);
$total_result = $conn->query($total_sql);
$total_images = $total_result->fetch_row()[0];
$total_pages = ceil($total_images / $limit);

// Fetch distinct categories for filtering
$categories_sql = "SELECT DISTINCT category FROM gallery";
$categories_result = $conn->query($categories_sql);
?>


<section class="gallery">
    <h1>My Photo Gallery</h1>

    <!-- Category Filter -->
    <div class="category-filter">
        <a href="gallery.php" class="<?php echo (!$category) ? 'active-category' : ''; ?>">All</a>
        <?php while ($cat_row = $categories_result->fetch_assoc()): ?>
            <a href="gallery.php?category=<?php echo $cat_row['category']; ?>" class="<?php echo ($category == $cat_row['category']) ? 'active-category' : ''; ?>">
                <?php echo ucfirst($cat_row['category'] ?? 'Uncategorized'); ?>
            </a>
        <?php endwhile; ?>
    </div>

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
            <p>No photos available for this category.</p>
        <?php endif; ?>
    </div>

    <!-- Pagination Links -->
    <div class="pagination">
        <!-- Previous Button -->
        <?php if ($page > 1): ?>
            <a href="gallery.php?page=<?php echo $page - 1; ?>&category=<?php echo $category; ?>">Previous</a>
        <?php endif; ?>

        <!-- Page Numbers -->
        <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
            <a href="gallery.php?page=<?php echo $i; ?>&category=<?php echo $category; ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>"><?php echo $i; ?></a>
        <?php endfor; ?>

        <!-- Next Button -->
        <?php if ($page < $total_pages): ?>
            <a href="gallery.php?page=<?php echo $page + 1; ?>&category=<?php echo $category; ?>">Next</a>
        <?php endif; ?>
    </div>
</section>

<?php include 'templates/footer.php'; ?>

<!-- CSS Section -->
<style>
    /* General Styles */
    .gallery {
        max-width: 1200px;
        margin: 0 auto;
        padding: 5px;
        text-align: center;
    }

    .gallery h1 {
        margin-bottom: 30px;
        font-size: 2.5rem;
        color: #2a80a8;
    }

    .category-filter {
        margin-bottom: 20px;
        text-align: center;
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
    }

    .category-filter a {
        margin: 0 10px;
        padding: 8px 15px;
        background-color: #2a80a8;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .category-filter a:hover {
        background-color: #1c6a97;
    }

    .category-filter a.active-category {
        background-color: #1c6a97;
        pointer-events: none;
    }

    /* Grid Layout */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); /* Default for large screens */
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
        height: auto;
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
        background: rgba(0, 0, 0, 0.7);
        color: white;
        opacity: 0;
        transition: opacity 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 10px;
        border-radius: 10px;
        text-align: center;
    }

    .gallery-item:hover .overlay {
        opacity: 1;
    }

    /* Pagination Styles */
    .pagination {
        margin-top: 15px;
        margin-bottom: 80px;
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

    /* Responsive Styles */
    @media (max-width: 1024px) {
        .gallery-grid {
            grid-template-columns: repeat(3, 1fr); /* 3 images per row for iPads */
        }
    }

    @media (max-width: 768px) {
        .gallery h1 {
            font-size: 2rem;
        }

        .gallery-grid {
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); /* Adjust for smaller screens */
        }

        .category-filter a {
            margin: 5px; 
            padding: 8px 12px;
            font-size: 0.9rem;
        }

        .pagination {
            margin-bottom: 90px; 
        }

        .pagination a {
            padding: 5px 10px;
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .gallery h1 {
            font-size: 1.75rem;
        }

        .gallery-grid {
            grid-template-columns: 1fr; /* 1 image per row for mobile */
        }

        .category-filter a {
            margin: 5px;
            padding: 8px 10px;
            font-size: 0.85rem;
        }

        .pagination {
            margin-bottom: 80px;
        }

        .pagination a {
            padding: 4px 8px;
            font-size: 0.9rem;
        }
    }
</style>


<script>
    // Check screen size and update the limit if it's an iPad-sized screen
    document.addEventListener("DOMContentLoaded", function() {
        var screenWidth = window.innerWidth;

        // Check if the screen size is between 768px and 1024px (iPad)
        if (screenWidth >= 768 && screenWidth <= 1024) {
            // Append limit=9 to the URL if not already present
            var url = new URL(window.location.href);
            var searchParams = new URLSearchParams(url.search);
            
            if (!searchParams.has('limit')) {
                searchParams.set('limit', '9'); // Set the limit to 9 for iPads
                url.search = searchParams.toString();
                window.location.href = url.toString(); // Reload the page with the new limit
            }
        }
    });
</script>
