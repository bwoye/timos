</head>

<body>
    <header>
        <nav>
            <div class="main-wrapper">
                <ul>
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="blogs.html">Blog</a>
                    </li>
                    <?php
                     if (isset($_SESSION['userid'])) {
                    echo '<li>
                        <a href="viewblogs.html">View Blogs</a>
                    </li> ';
                     } ?>
                </ul>
                <div class="nav-login">
                    <?php
                    if (isset($_SESSION['userid'])) {
                        echo '<form action="php/logout.php" method="POST">
<button name="submit" type="submit">Log out</button>
</form>';
                    } else {
                        echo '<form action="php/login.php" method="POST">
                        <select id="mytypes" name="mytypes"><option value="factory">Factory Reporter</option><option value="office">Labour office</option></select>
<input type="text" name="userid" placeholder="userid">
<input type="password" name="kpass" placeholder="password">
<button name="submit" type="submit">Login</button>
</form>';
                        //<a href="signup.php">Sign up</a>';
                    }
                    ?>
                </div>
            </div>
        </nav>
    </header>
    <?php
    if (isset($_SESSION['userid'])) {
        echo '<section class="menu-container">
        <div class="main-wrapper">
            <div class="menus">
                <ul>                   
                    <li><a>Employer Details</a>
                        <ul>                        
                            <li><a href="employerlist.php">View List</a></li>
                            <li><a href="projectlist.php">Projects</a></li>
                        </ul>
                    </li>
                    <li><a>Report Accident</a>
                        <ul>
                            <li><a href="accidentreport.php">New Report</a></li>
                            <li><a href="editaccident.php">Edit Accident</a></li>
                            <li><a>Report </a></li>
                        </ul>
                    </li>                   
                    <li><a>Administration</a>
                        <ul>
                            <li><a href="addnewsettings.php">Settings</a></li>
                            <li><a>Manage users</a></li>                       
                            <li><a href="changepass.php">Change password</a></li>
                            <li><a>Add user</a></li>                    
                        </ul>
                    </li> 
                    <li><a>Contact</a>
                        <ul>
                            <li><a>Telephone</a></li>
                            <li><a>Email</a></li>
                            <li><a>map</a></li>
                        </ul>
                    </li>                  
                </ul>
            </div>
        </div>
    </section>';
    }
    ?>