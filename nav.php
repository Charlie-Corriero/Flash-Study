<nav>

    <a class="<?php
    if (PATH_PARTS['filename'] == 'create' ){
        print 'activePage';
    }
    ?>" href="create.php">Create</a>
    
    <!-- lead to view page of created sets -->
    <a class="<?php
    if (PATH_PARTS['filename'] == 'view' ){
        print 'activePage';
    }
    ?>" href="view.php">View</a>

        <!-- admin.php -->
        <a class="<?php
    if (PATH_PARTS['filename'] == 'admin' ){
        print 'activePage';
    }
    ?>" href="protected/index.php">Admin</a>

    <!-- lead to main site index -->
    <a class="<?php
    if (PATH_PARTS['filename'] == 'index' ){
        print 'activePage';
    }
    ?>" href="index.php">Home Page</a>

    <!-- lead to about us page -->
    <a class="<?php
    if (PATH_PARTS['filename'] == 'ss' ){
        print 'activePage';
    }
    ?>" href="ss.php">About Us</a>

</nav>
