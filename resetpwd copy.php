<?php
include('header&footer/header_co.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['email'])) {
    $email = $_GET['email'];
?>
    <body>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <h1 class="text-center mt-5">Verification Token</h1>
                    <form action="verify_token_page.php" method="post">
                        <input type="hidden" name="email" value="<?php echo $email; ?>">
                        <div class="mb-3">
                            <input type="text" name="token" placeholder="Enter the verification token" required class="form-control">
                        </div>
                        <div class="mb-3 animate__animated animate__fadeInUp" style="animation-delay: 1.6s; animation-duration: 1s;">
                            <center><button type="submit" class="btn btn-primary btn-lg" onmouseover="this.style.color='white'" onmouseout="this.style.color=''" style="font-size: 20px;">Validate</button></center>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
<?php
} else {
    // Handle the case where the email parameter is missing
    // Redirect or display an error message
    header("Location: index.php");
    exit();
}
?>
