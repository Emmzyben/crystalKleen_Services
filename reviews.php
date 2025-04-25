<?php
require "./database/db-config.php";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST["name"]);
    $rating = (int)$_POST["rating"];
    // $role =$conn->real_escape_string($_POST["role"]);
    $comment = $conn->real_escape_string($_POST["comment"]);

    if ( $name && $rating && $comment && $rating >= 1 && $rating <= 5) {
        $conn->query("INSERT INTO reviews (name, rating, comment) VALUES ('$name', $rating, '$comment')");
    }
}

// Fetch all reviews
$result = $conn->query("SELECT * FROM reviews ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reviews</title>
      <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="images/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://kit.fontawesome.com/f0fb58e769.js" crossorigin="anonymous"></script>
    <style>
 
        .contain {
            max-width: 90%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h3 {
            font-size: 2rem;
            margin-bottom: 20px;
        }

        p {
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .review-section {
            margin-bottom: 40px;
            max-height: 400px;
            overflow-y: auto;
        }

        .review {
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fafafa;
            border-left: 5px solid gold;
        }

        .review strong {
            display: block;
            font-size: 1.1rem;
            margin-bottom: 5px;
        }

        .stars {
            color: gold;
            font-size: 1.2rem;
        }

        .card {
            background-color: #ffffff;
            border: 1px solid #ccc;
            padding: 25px;
            margin-top: 30px;
            border-radius: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .star-input span {
            font-size: 1.5rem;
            cursor: pointer;
            color: gray;
        }

        .star-input span.selected {
            color: gold;
        }

        button {
            padding: 10px 20px;
            background-color: rgb(238, 234, 6);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background-color:gold;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .fadeIn {
            animation: fadeIn 1s ease-in-out;
        }
    </style>
</head>
<body>
<header>
        <div id="head1">
<img src="images/logo.png" alt="" id="img">
        </div>
        <div id="head2">
            <div class="head2">
                <ul >
                    <a href=""></a>
                                        <li><a href="index.html" >Home</a></li>
                                        <li><a href="about.html">About Us</a></li>
                    <li><a href="services.html">Services</a></li>
                    <li><a href="reviews.php" id="show">Reviews</a></li>
                    <li><a href="contact.html">Contact Us</a></li>
                    <li></li>
                 </ul>
            </div>

        </div>
        
    </header>
    <div id="side">
        <div id="underNav">
<img src="images/logo.png" alt="">        
        </div>

        <div onclick="openNav()">
         <div class="container" onclick="myFunction(this)" id="sideNav">
             <div class="bar1"></div>
             <div class="bar2"></div>
             <div class="bar3"></div>
           </div>
         </div>
       </div>

       <div id="mySidenav" class="sidenav">
        <div style="text-align: center;margin-bottom: 40px;">
          <img src="images/logo.png" alt="" id="img"> 
        </div>
        <a href="index.html">Home</a>
        
        <a href="about.html">About Us</a>
        <a href="services.html">Services</a>
        <a href="reviews.php">Reviews</a>
        <a href="contact.html">Contact Us</a>
         </div>
       
       
      </div>
      
<div class="contain">
    <div style="text-align:center;padding:30px">
       <h3 style="color: #25d366">See what our clients have to say about us!</h3>
    <p>At crystalKleen, we value the feedback of our community. Your reviews help us improve and provide the best experience possible. <br> Thank you for being a part of our journey!</p>
 
    </div>
    
    <div class="review-section">
        <?php while($row = $result->fetch_assoc()): ?>
        <div class="review">
            <strong><?php echo htmlspecialchars($row['name']); ?></strong>
            <strong><?php echo htmlspecialchars($row['role']); ?></strong>
            <div class="stars">
                <?php echo str_repeat("★", $row['rating']) . str_repeat("☆", 5 - $row['rating']); ?>
            </div>
            <p><?php echo nl2br(htmlspecialchars($row['comment'])); ?></p>
        </div>
        <?php endwhile; ?>
    </div>

    <div class="card">
        <h3>Please leave a Review</h3>
        <form method="POST" class="review-form" onsubmit="return validateForm()">
            <label>Name:</label><br>
            <input type="text" name="name" required class="form-control"><br>

        

            <label>Rating:</label><br>
            <div class="star-input" id="star-input">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                    <span data-value="<?php echo $i; ?>">&#9733;</span>
                <?php endfor; ?>
            </div>
            <input type="hidden" name="rating" id="rating-value" required><br><br>

            <label>Comment:</label><br>
            <textarea name="comment" rows="5" required class="form-control"></textarea><br>

            <button type="submit">Submit Review</button>
        </form>
    </div>
</div>

<script>
    const stars = document.querySelectorAll('#star-input span');
    const ratingInput = document.getElementById('rating-value');

    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            const rating = index + 1;
            ratingInput.value = rating;

            stars.forEach((s, i) => {
                s.classList.toggle('selected', i < rating);
            });
        });
    });

    function validateForm() {
        if (!ratingInput.value) {
            alert('Please select a rating.');
            return false;
        }
        return true;
    }
</script>

<footer>
  <div>
    <h3>USEFUL LINKS</h3>
    <ul id="ul">
      <li><a href="index.html">Home</a></li>
      <li><a href="about.html">About Us</a></li>
      <li><a href="services.html">Services</a></li>
      <li><a href="contact.html">Get a Quote</a></li>
    </ul>
    <h3>Our Socials</h3>
    <a style="font-size:25px;color:#ffc107;padding-right: 20px;" href="https://www.facebook.com/share/1DeXg3pNTD/?mibextid=wwXIfr" target="_blank"><i class="fa fa-facebook-f"></i></a>
    <a style="font-size:25px;color:#ffc107;padding-right: 20px;" href="https://www.instagram.com/crystalkleen.services?igsh=MXRnMHN6MnVzMGpnZg%3D%3D&utm_source=qr" target="_blank" ><i class="fa fa-instagram"></i></a>

  </div>
  <div>
    <h3>OUR SERVICES</h3>
    <ul id="ul">   
<li><a href="">Office & Commercial Cleaning</a></li>
<li><a href="">Home Cleaning</a></li>
<li><a href="">Airbnb/Short-Let Cleaning</a></li>
<li><a href="">Regular Cleaning</a></li>
<li><a href="">Deep Cleaning</a></li>
<li><a href="">End of Tenancy Cleaning</a></li>
<li><a href="">Window Cleaning</a></li>
<li><a href="">Upholstery & Carpet Cleaning</a></li>
<li><a href="">Post-Construction Cleaning</a></li>
<li><a href="">Move-In/Move-Out Cleaning</a></li>
<li><a href="">After-Party/Event Cleaning</a></li>
<li><a href="">Kitchen Deep Cleaning</a></li>
</ul>
  </div>

  <div>
    <h3>Crystal Kleen Services</h3>
   
    <p><i class="fa fa-phone" style="font-size:15px;color:#ffc107;padding-right: 10px;"></i><span>+44 7376 492639, +44 7585 144247</span>  </p>
    <p><a style="text-decoration: none;color: #f9f9f9;" href="mailto:info@crystalkleenservices.com"><i class="fa fa-envelope" style="font-size:15px;color:#ffc107;padding-right: 10px;"></i>info@crystalkleenservices.com</a></p>
    <p><a style="text-decoration: none;color: #f9f9f9;" href="mailto:enquiry@crystalkleenservices.com"><i class="fa fa-envelope" style="font-size:15px;color:#ffc107;padding-right: 10px;"></i>enquiry@crystalkleenservices.com</a></p>
<hr>

<h3>Office hours</h3>
<p  style="color: #ffc107;">Monday to Saturday</p>

<p>9:00 am to 6:00 pm</p>

<p  style="color: #ffc107;">Sunday</p>

<p>2:00 pm to 6:00 pm</p>
  </div>

  <div>
    <h3>Customers first
    </h3>
  <p>We at Crystal Kleen Services provide high-quality cleaning services to residents and business owners</p>  
<p>Our local cleaners are vetted and insured, trained to deal with any task – from carpet or domestic cleaning. Our simple booking process allows you to get a cleaner fast and easy. 
  </p>
  <img src="images/HH_T-footer_pic-300x68.png" alt="">
</div>

</footer>
<div style="background-color:#f9f9f9 ;padding: 20px;text-align: center;">
  © Copyright 2025 | Crystal Kleen Services | All Rights Reserved 
</div>
    <script src="script.js"></script>
    <button id="scrollToTopBtn" onclick="scrollToTop()">↑</button>
    <a href="https://wa.me/447376492639" target="_blank" id="whatsapp-icon-container">
      <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WhatsApp" />
      Chat with us
    </a>
</body>
</html>