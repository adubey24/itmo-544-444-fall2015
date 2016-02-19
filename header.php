<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>IIT Cloud Gallery</title>
        <link rel="stylesheet" href="/resources/css/foundation.css" />
        <link rel="stylesheet" href="/resources/css/foundation-mobile.css" />
        <script src="/resources/js/vendor/modernizr.js"></script>
		<script src="/resources/js/vendor/jquery.js"></script>
		<script src="/resources/js/foundation/foundation.js"></script>
		<script src="/resources/js/foundation/foundation.topbar.js"></script>
    </head>
    <body>
        <nav class="top-bar" data-topbar role="navigation">
            <ul class="title-area">
                <li class="name">
                    <h1><a href="logon.php">Cloud Gallery</a></h1>
                </li>
                <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
                <li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
            </ul>

            <section class="top-bar-section">
                <!-- Right Nav Section -->
                <ul class="right">
                    
                        <li class="has-dropdown">
                            <a href="#">Admin Actions</a>
                            <ul class="dropdown">
                               <li><a href="introspection.php">Introspection</a></li>
                            </ul>
                        </li>
                    
                    
                        <li class="has-dropdown">
                            <a href="#">My Account</a>
                            <ul class="dropdown">
                                <li><a href="account.php" >Account Details</a></li>
								<li><a href="gallery.php" >My Gallery</a></li>
                                <li><a href="upload.php" >Upload a file</a></li>
                            </ul>
                        </li>
                    
                    <li class="active"><a href="javascript:formSubmit()">Logout</a></li>
                </ul>

<?php
$email = $_SESSION["email"];
$uname = $_SESSION["uname"];
?>				
                <!-- Left Nav Section -->
                <ul class="left">
                    <li><a href="#">Welcome <?php echo $uname; ?>!!</a></li>
                </ul>

            </section>
        </nav>     

        <form action="logout.php" method="post" id="logoutForm">
            <input type="hidden" 
                   name="email"
                   value="<?php echo $email; ?>" />
        </form>

        <script>
            function formSubmit() {
                document.getElementById("logoutForm").submit();
            }
        </script>
