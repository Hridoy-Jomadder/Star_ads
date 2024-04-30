<?php
session_start();
// Include the necessary files
include_once("classes/connect.php");
include_once("classes/database.php");
include_once("classes/database2.php");
include_once("classes/login.php");

// Instantiate Login class with database connection
$login = new Login($conn);

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Check if email and role are set in the session
if (isset($_SESSION['email']) && isset($_SESSION['role'])) {
    // Retrieve email and role from session
    $email = $_SESSION['email'];
    $role = $_SESSION['role'];

    // Authenticate the user using the provided credentials
    $user = $login->authenticate($email, $password, $role);

    // Check if authentication was successful
    if ($user) {
        // Set the user information in the session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect to the index page
        header("Location: index.php");
        exit();
    } else {
        // Authentication failed, handle the error
        $error_message = "Invalid email, password, or role.";
    }
} else {
    // Email and role are not set in the session, handle the error
    $error_message = "Email and role are required.";
}

// Function to get all ads from the database
function getAds() {
    global $conn; // Assuming $conn is your database connection variable
    $ads = array(); // Initialize an empty array to store ads

    // Query to select all ads from the database
    $sql = "SELECT * FROM ads";
    $result = mysqli_query($conn, $sql);

    // Check if query was successful
    if ($result) {
        // Loop through each row in the result set
        while ($row = mysqli_fetch_assoc($result)) {
            // Add each ad to the $ads array
            $ads[] = $row;
        }
        // Free result set
        mysqli_free_result($result);
    } else {
        // Query failed
        echo "Error: " . mysqli_error($conn);
    }

    // Return the array of ads
    return $ads;
}

// Get ads from the database
$ads = getAds();

// Check if the user is a Star Member (you need to define how to identify Star Members)
// if ($_SESSION['role'] !== 'star_member') {
//     // Redirect to a page indicating unauthorized access
//     header("Location: unauthorized.php");
//     exit();
// }

// Check if 'status' key exists in each ad array
foreach ($ads as &$ad) {
    // If 'status' key doesn't exist, set it to a default value or handle accordingly
    if (!isset($ad['status'])) {
        $ad['status'] = 'Unknown'; // Set a default status
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Star Ads - Web Design Agency & Advertisement</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border position-relative text-primary" style="width: 6rem; height: 6rem;" role="status"></div>
        <i class="fa fa-laptop-code fa-2x text-primary position-absolute top-50 start-50 translate-middle"></i>
    </div>
    <!-- Spinner End -->


    <!-- Topbar Start -->
    <div class="container-fluid bg-light px-0 wow fadeIn" data-wow-delay="0.1s">
        <div class="row gx-0 align-items-center d-none d-lg-flex">
            <div class="col-lg-6 px-5 text-start">
                <ol class="breadcrumb mb-0">
                    
                    <li class="breadcrumb-item"><a class="small text-secondary" href="#">Career</a></li>
                    <li class="breadcrumb-item"><a class="small text-secondary" href="#">Terms</a></li>
                    <li class="breadcrumb-item"><a class="small text-secondary" href="#">Privacy</a></li>
                </ol>
            </div>
            <div class="col-lg-6 px-5 text-end">
                <small>Follow us:</small>
                <div class="h-100 d-inline-flex align-items-center">
                    <a class="btn-square text-primary border-end rounded-0" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn-square text-primary border-end rounded-0" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn-square text-primary border-end rounded-0" href=""><i class="fab fa-linkedin-in"></i></a>
                    <a class="btn-square text-primary pe-0" href=""><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Brand & Contact Start -->
    <div class="container-fluid py-4 px-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="row align-items-center top-bar">
            <div class="col-lg-4 col-md-12 text-center text-lg-start">
                <a href="" class="navbar-brand m-0 p-0">
                    <h1 class="fw-bold text-primary m-0"><i class="fa fa-laptop-code me-3"></i>Star Ads</h1>
                    <!-- <img src="img/logo.png" alt="Logo"> -->
                </a>
            </div>
            <div class="col-lg-8 col-md-7 d-none d-lg-block">
                <div class="row">
                    <div class="col-4">
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="flex-shrink-0 btn-lg-square border rounded-circle">
                                <i class="far fa-clock text-primary"></i>
                            </div>
                            <div class="ps-3">
                                <p class="mb-2">Opening Hour</p>
                                <h6 class="mb-0">Mon - Fri, 8:00 - 9:00</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex align-items-center justify-content-end">
                            <div class="flex-shrink-0 btn-lg-square border rounded-circle">
                                <i class="far fa-envelope text-primary"></i>
                            </div>
                            <div class="ps-3">
                                <p class="mb-2">Email Us</p>
                                <h6 class="mb-0">info@example.com</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Brand & Contact End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-primary navbar-dark sticky-top py-lg-0 px-lg-5 wow fadeIn" data-wow-delay="0.1s">
        <a href="#" class="navbar-brand ms-3 d-lg-none">MENU</a>
        <button type="button" class="navbar-toggler me-3" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav me-auto p-3 p-lg-0">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="about.php" class="nav-item nav-link">About Us</a>
                <a href="service.php" class="nav-item nav-link">Services</a>
                <a href="project.php" class="nav-item nav-link active">Projects</a>
                <div class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                    <div class="dropdown-menu border-0 rounded-0 rounded-bottom m-0">
                        <a href="feature.php" class="dropdown-item">Features</a>
                        <a href="team.php" class="dropdown-item">Our Team</a>
                        <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                        <a href="404.php" class="dropdown-item">404 Page</a>
                    </div>
                </div>
                <a href="contact.php" class="nav-item nav-link">Contact Us</a>
            </div>
            
        </div>
    </nav>
    <!-- Navbar End -->


    <!-- Page Header Start -->
    <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container text-center py-5">
            <h1 class="display-4 text-white animated slideInDown mb-3">Projects</h1>
            <nav aria-label="breadcrumb animated slideInDown">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a class="text-white" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="text-white" href="#">Pages</a></li>
                    <li class="breadcrumb-item text-primary active" aria-current="page">Projects</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header End -->

    <div class="container">
    <h1>Ad Management Dashboard</h1>
    <div class="table-responsive">
        <table class="table text-start align-middle table-bordered table-hover mb-0">
            <thead>
                <tr class="text-dark">
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Image</th>
                    <th scope="col">Date</th>
                    <th scope="col">Budget</th>
                    <th scope="col">Duration</th>
                    <th scope="col" colspan="2">Star Member<br> Action</th>
                    <th scope="col">Personal or<br> Company Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ads as $ad): ?>
                    <tr>
                        <td><?php echo $ad['title']; ?></td>
                        <td><?php echo $ad['description']; ?></td>
                        <td><img src="<?php echo $ad['image']; ?>" alt="Ad Image" style="max-width: 100px;"></td>
                        <td><?php echo $ad['date']; ?></td>
                        <td><?php echo $ad['budget']; ?></td>
                        <td><?php echo $ad['duration']; ?></td>
                        <td>
                            <form action="edit_ad.php" method="post">
                                <input type="hidden" name="ad_id" value="<?php echo $ad['id']; ?>">
                                <button type="submit">Edit</button>
                            </form>
                        </td>
                        <td>
                            <form action="manage_ads.php" method="post" onsubmit="return confirm('Are you sure you want to delete this ad?');">
                                <input type="hidden" name="ad_id" value="<?php echo $ad['id']; ?>">
                                <button type="submit" name="action" value="delete">Delete</button>
                            </form>
                        </td>
                        <td>
                        <form action="manage_ads.php" method="post">
                            <input type="hidden" name="ad_id" value="<?php echo $ad['id']; ?>">
                            <button type="submit" name="action" value="delete">Confirm</button>
                        </form>
                    </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<br>
    <div class="container">
    <h1>Add to Ads</h1>
    <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Image</th>
                        <th scope="col">Date</th>
                        <th scope="col">Budget</th>
                        <th scope="col">Duration</th>
                    </tr>
                </thead>
                <tbody>

            <?php foreach ($ads as $ad): ?>
                <tr>
                    <td><?php echo $ad['id']; ?></td>
                    <td><?php echo $ad['title']; ?></td>
                    <td><?php echo $ad['description']; ?></td>
                    <td><img src="<?php echo $ad['image']; ?>" alt="Ad Image" style="max-width: 100px;"></td>
                        <td><?php echo $ad['date']; ?></td>
                        <td><?php echo $ad['budget']; ?></td>
                        <td><?php echo $ad['duration']; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<div class="container">
    <h1>Bill</h1>
    <div class="table-responsive">
        <table class="table text-start align-middle table-bordered table-hover mb-0">
            <thead>
                <tr class="text-dark">
                    <th scope="col">ID</th>
                    <th scope="col">Budget</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ads as $ad): ?>
                    <tr>
                        <td><?php echo $ad['id']; ?></td>
                        <td><?php echo $ad['budget']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <!-- Total Row -->
            <tfoot>
                <tr class="text-dark">
                    <th scope="row" colspan="1">Total</th>
                    <td>
                        <?php
                        $totalBudget = 0;
                        foreach ($ads as $ad) {
                            $totalBudget += $ad['budget'];
                        }
                        echo $totalBudget;
                        ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

 <div class="container">
    <h1>Personal or Company Management Dashboard</h1>
    <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Status</th>
                        <th scope="col">Image</th>
                        <th scope="col">Date</th>
                        <th scope="col">Click</th>
                        <th scope="col">View Website</th>
                        <th scope="col">Sell</th>
                        <th scope="col">Budget</th>
                        <th scope="col">Duration</th>
                        <th scope="col" colspan="2">Action</th>
                    </tr>
                </thead>
                <tbody>

            <?php foreach ($ads as $ad): ?>
                <tr>
                    <td><?php echo $ad['title']; ?></td>
                    <td><?php echo $ad['description']; ?></td>
                    
                    <td><?php echo $ad['status']; ?></td>
                    
                    </td>
                    <td>
                        
                    </td>
                    <td>
                    
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                        <form action="edit_ad.php" method="post">
                            <input type="hidden" name="ad_id" value="<?php echo $ad['id']; ?>">
                            <button type="submit">Edit</button>
                        </form>
                    </td>
                    <td>
                        <form action="manage_ads.php" method="post">
                            <input type="hidden" name="ad_id" value="<?php echo $ad['id']; ?>">
                            <button type="submit" name="action" value="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
    <!-- <div class="performance">
        <h2>Performance Metrics</h2>
        <canvas id="adPerformanceChart" width="400" height="200"></canvas>
    </div> -->
</div>


<div class="container">
    <h1>Personal or Company Management Dashboard</h1>
    <div class="filters mb-3">
        <label for="status">Status:</label>
        <select id="status">
            <option value="">All</option>
            <option value="active">Active</option>
            <option value="paused">Paused</option>
            <option value="expired">Expired</option>
        </select>
        <label for="dateRange">Date Range:</label>
        <input type="date" id="startDate">
        <input type="date" id="endDate">
        <button id="filterBtn">Filter</button>
    </div>
    <div class="table-responsive">
        <table class="table text-start align-middle table-bordered table-hover mb-0">
            <thead>
                <tr class="text-dark">
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Status</th>
                    <th scope="col">Image</th>
                    <th scope="col">Date</th>
                    <th scope="col">Click</th>
                    <th scope="col">View Website</th>
                    <th scope="col">Sell</th>
                    <th scope="col">Budget</th>
                    <th scope="col">Duration</th>
                    <th scope="col" colspan="2">Action</th>
                </tr>
            </thead>
            <tbody id="adList">
                <!-- Ad list will be populated dynamically -->
            </tbody>
        </table>
    </div>
    <!-- <div class="performance">
        <h2>Performance Metrics</h2>
        <canvas id="adPerformanceChart" width="400" height="200"></canvas>
    </div> -->
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sample ad data (replace with actual data fetched from backend)
    const ads = [
        { title: "Ad 1", description: "Description for Ad 1", status: "active", date: "2024-04-29", clicks: 100, budget: 500 },
        { title: "Ad 2", description: "Description for Ad 2", status: "paused", date: "2024-04-28", clicks: 50, budget: 300 },
        // Add more ad data here...
    ];

    // Function to render ads based on filter criteria
    function renderAds() {
        const statusFilter = document.getElementById('status').value;
        const startDate = document.getElementById('startDate').value;
        const endDate = document.getElementById('endDate').value;

        // Filter ads based on status
        let filteredAds = ads;
        if (statusFilter) {
            filteredAds = filteredAds.filter(ad => ad.status === statusFilter);
        }

        // Filter ads based on date range
        if (startDate && endDate) {
            filteredAds = filteredAds.filter(ad => ad.date >= startDate && ad.date <= endDate);
        }

        // Render filtered ads
        const adList = document.getElementById('adList');
        adList.innerHTML = '';
        filteredAds.forEach(ad => {
            const row = `
                <tr>
                    <td>${ad.title}</td>
                    <td>${ad.description}</td>
                    <td>${ad.status}</td>
                    <td>Image</td>
                    <td>${ad.date}</td>
                    <td>${ad.clicks}</td>
                    <td>View Website</td>
                    <td>Sell</td>
                    <td>${ad.budget}</td>
                    <td>Duration</td>
                    <td>
                        <form action="edit_ad.php" method="post">
                            <input type="hidden" name="ad_id" value="${ad.id}">
                            <button type="submit">Edit</button>
                        </form>
                    </td>
                    <td>
                        <form action="manage_ads.php" method="post">
                            <input type="hidden" name="ad_id" value="${ad.id}">
                            <button type="submit" name="action" value="delete">Delete</button>
                        </form>
                    </td>
                </tr>
            `;
            adList.innerHTML += row;
        });
    }

    // Function to render ad performance chart
    function renderPerformanceChart() {
        const adPerformanceChart = document.getElementById('adPerformanceChart');
        new Chart(adPerformanceChart, {
            type: 'bar',
            data: {
                labels: ['Ad 1', 'Ad 2'], // Add ad titles dynamically
                datasets: [{
                    label: 'Clicks',
                    data: [100, 50], // Add clicks data dynamically
                    backgroundColor: ['#36a2eb', '#ff6384'], // Customize colors
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }

    // Initial rendering
    renderAds();
    renderPerformanceChart();

    // Event listener for filter button click
    document.getElementById('filterBtn').addEventListener('click', () => {
        renderAds();
    });
</script>

    <!-- Ads Start -->
    <div class="container-xxl py-5">
        <div class="container">
            <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
                <h6 class="section-title bg-white text-center text-primary px-3">Our Projects</h6>
                <h1 class="display-6 mb-4">Learn More About Our Complete Projects</h1>
            </div>
            <div class="owl-carousel project-carousel wow fadeInUp" data-wow-delay="0.1s">
                <div class="project-item border rounded h-100 p-4" data-dot="01">
                    <div class="position-relative mb-4">
                        <img class="img-fluid rounded" src="img/project-1.jpg" alt="">
                        <a href="img/project-1.jpg" data-lightbox="project"><i class="fa fa-eye fa-2x"></i></a>
                    </div>
                    <h6>UI / UX Design</h6>
                    <span>Digital agency website design and development</span>
                </div>
                <div class="project-item border rounded h-100 p-4" data-dot="02">
                    <div class="position-relative mb-4">
                        <img class="img-fluid rounded" src="img/project-2.jpg" alt="">
                        <a href="img/project-2.jpg" data-lightbox="project"><i class="fa fa-eye fa-2x"></i></a>
                    </div>
                    <h6>UI / UX Design</h6>
                    <span>Digital agency website design and development</span>
                </div>
                <div class="project-item border rounded h-100 p-4" data-dot="03">
                    <div class="position-relative mb-4">
                        <img class="img-fluid rounded" src="img/project-3.jpg" alt="">
                        <a href="img/project-2.jpg" data-lightbox="project"><i class="fa fa-eye fa-2x"></i></a>
                    </div>
                    <h6>UI / UX Design</h6>
                    <span>Digital agency website design and development</span>
                </div>
                <div class="project-item border rounded h-100 p-4" data-dot="04">
                    <div class="position-relative mb-4">
                        <img class="img-fluid rounded" src="img/project-4.jpg" alt="">
                        <a href="img/project-4.jpg" data-lightbox="project"><i class="fa fa-eye fa-2x"></i></a>
                    </div>
                    <h6>UI / UX Design</h6>
                    <span>Digital agency website design and development</span>
                </div>
                <div class="project-item border rounded h-100 p-4" data-dot="05">
                    <div class="position-relative mb-4">
                        <img class="img-fluid rounded" src="img/project-5.jpg" alt="">
                        <a href="img/project-5.jpg" data-lightbox="project"><i class="fa fa-eye fa-2x"></i></a>
                    </div>
                    <h6>UI / UX Design</h6>
                    <span>Digital agency website design and development</span>
                </div>
                <div class="project-item border rounded h-100 p-4" data-dot="06">
                    <div class="position-relative mb-4">
                        <img class="img-fluid rounded" src="img/project-6.jpg" alt="">
                        <a href="img/project-6.jpg" data-lightbox="project"><i class="fa fa-eye fa-2x"></i></a>
                    </div>
                    <h6>UI / UX Design</h6>
                    <span>Digital agency website design and development</span>
                </div>
                <div class="project-item border rounded h-100 p-4" data-dot="07">
                    <div class="position-relative mb-4">
                        <img class="img-fluid rounded" src="img/project-7.jpg" alt="">
                        <a href="img/project-7.jpg" data-lightbox="project"><i class="fa fa-eye fa-2x"></i></a>
                    </div>
                    <h6>UI / UX Design</h6>
                    <span>Digital agency website design and development</span>
                </div>
                <div class="project-item border rounded h-100 p-4" data-dot="08">
                    <div class="position-relative mb-4">
                        <img class="img-fluid rounded" src="img/project-8.jpg" alt="">
                        <a href="img/project-8.jpg" data-lightbox="project"><i class="fa fa-eye fa-2x"></i></a>
                    </div>
                    <h6>UI / UX Design</h6>
                    <span>Digital agency website design and development</span>
                </div>
                <div class="project-item border rounded h-100 p-4" data-dot="09">
                    <div class="position-relative mb-4">
                        <img class="img-fluid rounded" src="img/project-9.jpg" alt="">
                        <a href="img/project-9.jpg" data-lightbox="project"><i class="fa fa-eye fa-2x"></i></a>
                    </div>
                    <h6>UI / UX Design</h6>
                    <span>Digital agency website design and development</span>
                </div>
                <div class="project-item border rounded h-100 p-4" data-dot="10">
                    <div class="position-relative mb-4">
                        <img class="img-fluid rounded" src="img/project-10.jpg" alt="">
                        <a href="img/project-10.jpg" data-lightbox="project"><i class="fa fa-eye fa-2x"></i></a>
                    </div>
                    <h6>UI / UX Design</h6>
                    <span>Digital agency website design and development</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Ads End -->



    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-body footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
        <div class="container py-5">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Address</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-3"></i>+012 345 67890</p>
                    <p class="mb-2"><i class="fa fa-envelope me-3"></i>info@example.com</p>
                    <div class="d-flex pt-2">
                        <a class="btn btn-square btn-outline-secondary rounded-circle me-1" href=""><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-square btn-outline-secondary rounded-circle me-1" href=""><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-square btn-outline-secondary rounded-circle me-1" href=""><i class="fab fa-youtube"></i></a>
                        <a class="btn btn-square btn-outline-secondary rounded-circle me-0" href=""><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Quick Links</h5>
                    <a class="btn btn-link" href="">About Us</a>
                    <a class="btn btn-link" href="">Contact Us</a>
                    <a class="btn btn-link" href="">Our Services</a>
                    <a class="btn btn-link" href="">Terms & Condition</a>
                    <a class="btn btn-link" href="">Support</a>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Gallery</h5>
                    <div class="row g-2">
                        <div class="col-4">
                            <img class="img-fluid rounded" src="img/project-1.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid rounded" src="img/project-2.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid rounded" src="img/project-3.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid rounded" src="img/project-4.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid rounded" src="img/project-5.jpg" alt="Image">
                        </div>
                        <div class="col-4">
                            <img class="img-fluid rounded" src="img/project-6.jpg" alt="Image">
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5 class="text-light mb-4">Newsletter</h5>
                    <p>Dolor amet sit justo amet elitr clita ipsum elitr est.</p>
                    <div class="position-relative mx-auto" style="max-width: 400px;">
                        <input class="form-control bg-transparent border-secondary w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                        <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; <a href="#">Star Ads</a>, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                        Designed By <a href="">Star</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary btn-lg-square rounded-circle back-to-top"><i class="bi bi-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/lightbox/js/lightbox.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

<!-- add me -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    // Get data for the chart
    var activeAdsCount = <?php echo $activeAdsCount; ?>;
    var pausedAdsCount = <?php echo $pausedAdsCount; ?>;

    // Create a new Chart instance
    var ctx = document.getElementById('adPerformanceChart').getContext('2d');
    var adPerformanceChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Active Ads', 'Paused Ads'],
            datasets: [{
                label: 'Ad Performance',
                data: [activeAdsCount, pausedAdsCount],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.5)', // Blue color for active ads
                    'rgba(255, 99, 132, 0.5)'  // Red color for paused ads
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>



</body>

</html>