<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Me</title>
    <style>
        .contact {
            background-color: #ffffff;
            padding: 10px 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 80px;
        }

        .contact h2 {
            margin-bottom: 20px;
            font-size: 2.5rem;
            color: #2a80a8;
            text-transform: uppercase;
        }

        .contact p {
            margin-bottom: 20px;
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.8;
        }

        /* Contact Form Styling */
        form {
            max-width: 100%;
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        form label {
            font-size: 1.1rem;
            color: #444;
            display: block;
            margin-bottom: 8px;
            text-align: left;
        }

        form input[type="text"],
        form input[type="email"],
        form textarea {
            width: 100%;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            font-size: 1rem;
            background-color: #f9f9f9;
            transition: border-color 0.3s;
        }

        form input[type="text"]:focus,
        form input[type="email"]:focus,
        form textarea:focus {
            border-color: #2a80a8;
        }

        form textarea {
            resize: none;
        }

        /* Submit Button Styling */
        form button {
            background-color: #2a80a8;
            color: white;
            padding: 15px 30px;
            border-radius: 50px;
            border: none;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            text-transform: uppercase;
        }

        form button:hover {
            background-color: #f7b731;
            transform: scale(1.05);
        }

        /* Success Popup Styling */
        #success-popup {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            z-index: 1000;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .contact {
                padding: 40px 20px;
            }

            .contact h2 {
                font-size: 2rem;
            }

            .contact p {
                font-size: 1rem;
            }

            form {
                padding: 30px;
            }

            form button {
                width: 100%;
                padding: 15px;
            }
        }
    </style>
</head>
<body>

    <?php 
    // Include database connection
    include 'config.php';

    // Initialize an empty message to display later
    $msg = '';

    // Check if the form has been submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and get the form data
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $message = mysqli_real_escape_string($conn, $_POST['message']);

        // Prepare the SQL query
        $sql = "INSERT INTO contact (name, email, message) VALUES ('$name', '$email', '$message')";

        // Execute the query and check if the data is inserted
        if ($conn->query($sql) === TRUE) {
            // Set the success message
            $msg = "Thank you! Your message has been sent successfully. We will get back to you shortly.";
            echo "<script>showSuccessPopup();</script>";
        } else {
            // Set the error message if something went wrong
            $msg = "Error: " . $sql . "<br>" . $conn->error;
        }

        // Close the database connection
        $conn->close();
    }
    ?>

    <?php 
        $page_title = "Contact Me";
        include 'templates/header.php'; 
    ?>

    <div id="success-popup">
        <?php echo $msg; ?>
    </div>

    <section class="contact">
        <h2>Get in Touch</h2>
        <p>If you have any questions or would like to work together, please fill out the form below.</p>

        <?php if ($msg != '' && strpos($msg, 'Error') === false): ?>
            <script>
                // Function to show the success popup and auto-hide after 1 second
                function showSuccessPopup() {
                    var popup = document.getElementById("success-popup");
                    popup.style.display = "block";

                    // Hide after 1 second (1000 milliseconds)
                    setTimeout(function () {
                        popup.style.display = "none";
                    }, 5000);
                }

                // Call the function to show popup on form submit
                showSuccessPopup();
            </script>
        <?php endif; ?>

        <form action="contact.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="message">Message:</label>
            <textarea id="message" name="message" required></textarea>

            <button type="submit">Send Message</button>
        </form>
    </section>

    <?php include 'templates/footer.php'; ?>
</body>
</html>
