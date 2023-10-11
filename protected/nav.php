<nav>
    <!-- lead to update -->
    <a class="<?php
    if (PATH_PARTS['filename'] == 'view' ){
        print 'activePage';
    }
    ?>" href="view.php">Update</a>
    
    <!-- lead to insert -->
    <a class="<?php
    if (PATH_PARTS['filename'] == 'insert' ){
        print 'activePage';
    }
    ?>" href="insert.php">Insert</a>

    <!-- lead to delete -->
    <a class="<?php
    if (PATH_PARTS['filename'] == 'delete' ){
        print 'activePage';
    }
    ?>" href="delete.php">Delete</a>

    <!-- lead to main site index -->
    <a class="<?php
    if (PATH_PARTS['filename'] == 'main-index' ){
        print 'activePage';
    }
    ?>" href="../index.php">Home Page</a>
</nav>
