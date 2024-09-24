<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? "Photographer Portfolio"; ?></title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/script.js" defer></script>

<style>
    /* Navbar */
    header {
        background-color: #2a80a8;
        padding: 20px 0;
        text-align: center;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 1000;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    nav {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 40px;
        flex-wrap: wrap;
    }

    nav a {
        color: white;
        font-size: 1.5rem;
        text-decoration: none;
        padding: 10px 15px;
        position: relative;
        transition: color 0.3s ease;
        font-weight: 600;
    }

    nav a:hover,
    nav a.active {
        color: #f7b731;
    }

    /* Underline effect */
    nav a::after {
        content: '';
        position: absolute;
        bottom: -5px;
        left: 0;
        width: 0;
        height: 3px;
        background-color: #f7b731;
        transition: width 0.4s ease, left 0.4s ease;
    }

    nav a:hover::after {
        width: 100%;
        left: 0;
    }

    nav a.active::after {
        width: 100%;
        left: 0;
    }

    /* Hamburger icon for mobile */
    .menu-icon {
        display: none;
        cursor: pointer;
    }

    .menu-icon div {
        width: 30px;
        height: 3px;
        background-color: white;
        margin: 5px 10px;
        transition: all 0.3s ease;
    }

    /* Hide the navigation on small screens */
    nav ul {
        list-style: none;
        display: flex;
        gap: 40px;
    }

    nav ul {
        display: flex;
        flex-direction: row;
        gap: 40px;
    }

    .menu-icon.active .line1 {
        transform: rotate(-45deg) translate(-5px, 6px);
    }

    .menu-icon.active .line2 {
        opacity: 0;
    }

    .menu-icon.active .line3 {
        transform: rotate(45deg) translate(-5px, -6px);
    }

    /* Responsive Adjustments for Smaller Screens */
    @media (max-width: 768px) {
        nav ul {
            flex-direction: column;
            display: none;
        }

        nav ul.active {
            display: flex;
        }

        .menu-icon {
            display: block;
        }

        nav {
            gap: 20px;
        }

        nav a {
            font-size: 1.2rem;
        }
    }
</style>

</head>
<body>
<header>
    <div class="menu-icon" id="menu-icon">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
    </div>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="about.php">About Me</a></li>
            <li><a href="gallery.php">Gallery</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
    </nav>
</header>

<script>
    // Toggle the mobile menu
    const menuIcon = document.getElementById('menu-icon');
    const navLinks = document.querySelector('nav ul');

    menuIcon.addEventListener('click', () => {
        navLinks.classList.toggle('active');
        menuIcon.classList.toggle('active');
    });
</script>
</body>
</html>
