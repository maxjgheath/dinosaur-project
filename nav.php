<nav>
    <a class="navLink <?php
    if ($path_parts['filename'] == 'index') {
        print 'activePage';
    }
    ?>" href="index.php">Home</a>
    <a class="navLink <?php
    if ($path_parts['filename'] == 'triceratops') {
        print 'activePage';
    }
    ?>" href="triceratops.php">Triceratops</a>
    <a class="navLink <?php
    if ($path_parts['filename'] == 'trex') {
        print 'activePage';
    } 
    ?>" href="trex.php">Tyrannosaurus Rex</a>
    <a class="navLink <?php
    if ($path_parts['filename'] == 'form') {
        print 'activePage';
    }
    ?>" href="form.php">Dinosaur Survey</a>
    <a class="navLink <?php
    if ($path_parts['filename'] == 'data') {
        print 'activePage';
    }
    ?>" href="data.php">Survey Results</a>
</nav>