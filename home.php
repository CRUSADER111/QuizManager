<?php
// Include navbar file
//require_once 'navbar.php';

// Set Session Variables
$action = $page =  '';

// Initialize the session
session_start();


// if($_SERVER["REQUEST_METHOD"] == "POST"){
    
//     if (!empty(trim($_POST['action']))) {
//         $action = $_POST['action'];
//         $_SESSION['page'] = $action;
//         include 'viewquizzes.php';
//     }
// }

// If session variable is not set or empty it will redirect to login page
// if(!isset($_SESSION['username']) || empty($_SESSION['username'])){
//   header("location: login.php");
//   exit;
//}
?>
 
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/home.css">
    
    <!-- Font Awesome JS -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>

    <!-- Favicon -->
    <link rel="icon" href="QMicon.ico">

    <title>Home - SQ</title>
  </head>
  <body>
    <div class="wrapper">
        <!-- Sidebar  -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>WebbiSkools Quiz Manager</h3>
                <strong>WS QM</strong>
            </div>

            <ul class="list-unstyled components">
                <li class="active">
                    <a href="#home" id="listItem" class="sidebarItem">
                        <i class="fas fa-home"></i>
                        Home
                    </a>
                </li>
                <!-- If session variable is set and not empty it will display list item -->
                <?php if(isset($_SESSION['username']) && !empty($_SESSION['username'])): ?>
                <li>
                    <a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">
                        <i class="fas fa-copy"></i>
                        Quiz Manager
                    </a>
                </li>
                <li>
                    <ul class="collapse list-unstyled" id="pageSubmenu">
                        <li>
                            <a href="#viewQuizzes" class="sidebarItem">
                                <i></i>
                                View Quizzes
                            </a>
                        </li>
                        <?php if($_SESSION['permissionlevel'] == "Edit"): ?>
                        <li>
                            <a href="#editQuizzes" class="sidebarItem">
                                <i></i>
                                Edit Quizzes
                            </a>
                        </li>
                        <?php endif; ?> 
                    </ul>
                </li>
                <?php endif; ?>                
                <li>
                    <a href="#about" class="sidebarItem">
                        <i class="fas fa-briefcase"></i>
                        About
                    </a>
                </li>
                <!-- <li>
                    <a href="#">
                        <i class="fas fa-image"></i>
                        Portfolio
                    </a>
                </li>
                <li>
                    <a href="#">
                        <i class="fas fa-question"></i>
                        FAQ
                    </a>
                </li> -->
                <li>
                    <a href="#contact" class="sidebarItem">
                        <i class="fas fa-paper-plane"></i>
                        Contact
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Page Content  -->
        <div id="content">
            <!-- Modal -->
            <div class="modal fade" id="confirmAction" tabindex="-1" role="dialog" aria-labelledby="Confrim Action" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Are you sure?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <?php if(isset($_SESSION['quiz']) && !empty($_SESSION['quiz'])): ?>
                    Delete quiz: <?php echo $_SESSION['quiz']; ?>
                    <?php else: ?>
                    No quiz selected
                    <?php endif; ?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger">Confirm</button>
                  </div>
                </div>
              </div>
            </div>
            <!-- Horizontal Navbar -->
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <button type="button" id="sidebarCollapse" class="navbar-btn">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                    <button class="btn btn-account d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                        <span>Account</span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ml-auto" align="right">
                            <?php if(isset($_SESSION['username']) && !empty($_SESSION['username'])): ?>
                                <li class="nav-item">
                                    <a class="nav-link">Hi, <b><?php echo htmlspecialchars($_SESSION['username']); ?></b>. Welcome to our site.</a>
                                </li>
                                <li class="nav-item">
                                    <a href="logout.php" class="btn btn-danger"><i class="fas fa-sign-out-alt"></i> Logout</a>
                                </li>
                            <?php else: ?>
                                <li class="nav-item">
                                    <a class="nav-link">Welcome, please login.</a>
                                </li>
                                <li class="nav-item">
                                    <a href="login.php" class="btn btn-success"><i class="fas fa-sign-in-alt"></i> Login</a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </nav>
            <div id="navbaraction">
                <h2>WebbiSkools Quiz Manager</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
            </div>
            <div id="quiztable">
                <h2>Please select a quiz above</h2>
            </div>
        </div>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script> -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

    <!-- Custom Script -->
    <script src="js/queries.js"></script>
  </body>
</html>