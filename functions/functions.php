<?php

// Database Connection
function databaseConnection()
{

    // Database credentials
    $DATABASE_HOST = "localhost";
    $DATABASE_USER = "root";
    $DATABASE_PASSWORD = "";
    $DATABASE_NAME = "job_recommender_system";

    // Try to connect
    try {
        return new PDO("mysql:host=" . $DATABASE_HOST . ";dbname=" . $DATABASE_NAME . ";charset=utf8", $DATABASE_USER, $DATABASE_PASSWORD);
    } catch (PDOException $e) {
        exit("Connection to the database failed: " . $e->getMessage());
    }
}

// Header Template
function headerTemplate($title)
{
    $element = "
        <!DOCTYPE html>
        <html lang=\"en\">
        <head>
        <title>$title</title>
        <meta charset=\"utf-8\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <meta name=\"keywords\" content=\"PHP, HTML5, MySQL,Javascript\">
        <meta name=\"description\" content=\"This is an online job recommender system\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <link rel=\"stylesheet\" type=\"text/css\" href=\"./css/styles.css\">
        </head> 
    ";
    echo $element;
}

// Homepage Navbar
function homepageNavbarTemplate()
{
    $element = "
    <nav class=\"navbar navbar-expand-lg bg-body-tertiary\">
            <div class=\"container-fluid\">
                <a href=\"index.php?page=home\" class=\"navbar-brand\">Nyalik JRS</a>
                <button class=\"navbar-toggler\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                    <span class=\"navbar-toggler-icon\"></span>
                </button>
             <div class=\"collapse navbar-collapse justify-content-end\" id=\"navbarSupportedContent\">
                <ul class=\"navbar-nav\">
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"index.php?page=jobs/explore_all_jobs\">Jobs</a>
                    </li>
                    <li class=\"nav-item\">
                        
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"index.php?page=users/user_register_step1\">Create Account</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"index.php?page=users/user_login\">Sign In</a>
                    </li>
                     <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"index.php?page=admin/admin_login\">Admin Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    ";
    echo $element;
}

// Account Login/Register navbar
function login_navbarTemplate()
{
    $element = " 
          <nav class=\"navbar navbar-expand-lg login_navbar\">
            <div class=\"container-fluid\">
                <a href=\"index.php?page=home\" class=\"navbar-brand mx-auto\">Nyalik JRS</a>
                <button class=\"navbar-toggler\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                    <span class=\"navbar-toggler-icon\"></span>
                </button>
        </div>
    </nav>
    ";
    echo $element;
}

// Admin Navbar Template
function adminNavbarTemplate()
{
    $element = "
        <nav class=\"navbar navbar-expand-lg bg-body-tertiary\">
            <div class=\"container-fluid\">
                <a href=\"index.php?page=admin/admin_dashboard\" class=\"navbar-brand\">NYALIK JRS</a>
                <button class=\"navbar-toggler\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#navbarSupportedContent\" aria-controls=\"navbarSupportedContent\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
                    <span class=\"navbar-toggler-icon\"></span>
                </button>
             <div class=\"collapse navbar-collapse justify-content-end\" id=\"navbarSupportedContent\">
                <ul class=\"navbar-nav\">
                    <li class=\"nav-item\">
                        <a class=\"nav-link active\" aria-current=\"page\" href=\"index.php?page=admin/admin_dashboard\">Dashboard</a>
                    </li>
                    <li class=\"nav-item dropdown\" style=\"display: none\">
                        <a class=\"nav-link dropdown-toggle\" href=\"#\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                             Account
                        </a>
                        <ul class=\"dropdown-menu\">
                            <li><a class=\"dropdown-item\" href=\"index.php?page=admin/account\">Profile</a></li>
                            <li><a class=\"dropdown-item\" href=\"index.php?page=admin/logout\">Logout</a></li>
                        </ul>
                </li>
                <li class=\"nav-item\" style=\"display: none\">
                    <a class=\"nav-link\">Logout</a>
                </li>
                <li class=\"nav-item\">
                    <a href=\"index.php?page=admin/admin_logout\" class=\"nav-link\">Sign Out</a>
                </list>
                </ul>
            </div>
        </div>
    </nav>

    ";
    echo $element;
}
