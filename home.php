<!-- DFAULT HOMEPAGE -->

<?php

// Functions
include_once "functions/functions.php";
$pdo = databaseConnection();

?>

<!-- Header Template -->
<?= headerTemplate('HOME'); ?>

<!-- Homepage Navbar -->
<?= homepageNavbarTemplate(); ?>

<!-- Landing Page -->
<div id="landing_text">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="title">
                    <h1>Explore and discover <br> the right jobs for <br> you</h1>
                </div>
                <a href="#" class="signIn_link">Sign in with email</a>
            </div>

            <div class="col-md-6">
                <img src="images/image2.jpg" alt="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Suggested Job searches -->
<div id="suggested_job_searches">
    <div class="container">
        <div class="row">
            <div class="title">
                <h2>Find the right job vacancies in Kenya</h2>
            </div>
            <h5>Experience-based filtering</h5>
            <p>Find jobs that suite your experience level</p>

            <div class="row">
                <div class="col-md-4">
                    <h3>Senior Level</h3>
                    <!-- NUMBER OF ALL JOBS IN THE SENIOR LEVEL FROM THE DATABASE -->
                    <a href="#">Explore Jobs</a>
                </div>

                <div class="col-md-4">
                    <h3>Mid Level</h3>
                    <!-- NUMBER OF ALL JOBS IN THE MID LEVEL FROM THE DATABASE -->
                    <a href="#">Explore Jobs</a>
                </div>

                <div class="col-md-4">
                    <h3>Internship & Graduate</h3>
                    <!-- NUMBER OF ALL JOBS IN THE INTERNSHIP/GEADUATE FROM THE DATABASE -->
                    <a href="#">Explore Jobs</a>
                </div>
            </div>

            <div class="explore_all_jobs">
                <a href="#">Explore all jobs</a>
            </div>
        </div>
    </div>
</div>

<!-- Companies currently hiring -->
<div id="companies_currently_hiring">
    <div class="container">
        <div class="row">
            <div class="title">
                <h2>Companies currently hiring in Kenya</h2>
            </div>

            <!-- LIST OF ALL COMPANIES HIRING FROM THE DATABASE -->

            <div class="explore_all_jobs">
                <a href="#">View all companies hiring</a>
            </div>
        </div>
    </div>
</div>