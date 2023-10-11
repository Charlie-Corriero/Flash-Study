<?php include 'top.php'; ?>
<main>
    <?php
    function getGetData($field) {
        if (!isset($_GET[$field])) {
            $data = '"'; 
        } else {
                $data = trim($_GET[$field]);
                $data = htmlspecialchars($data);
            }
            return $data;
    }
    if (isset($_GET["setId"]) and isset($_GET["termId"])) {
        $set_id = getGetData("setId");
        $term_id = getGetData("termId");
        //Line used to delete the set from the database, currently disabled
        #$thisDataBaseWriter->deleteTerm($set_id,$term_id);

        $sql='SELECT fldSetName, fldTermName, pmkTermId FROM tblSets JOIN tblTerms ON pmkSetId = fpkSetId WHERE pmkSetId = ? AND pmkTermId = ?';
        $array = array($set_id,$term_id);
        $data = $thisDataBaseReader->select($sql, $array);

        print "<p>This feature is currently disabled for viewing and security purposes. If the feature was enabled, the term '" . $data[0]['fldTermName'] . "' and its corresponding definition would have been removed from the website/database.</p>";
    }

    $set_id = $_GET['setId'];
    $sql='SELECT fldSetName, fldSetDescription, fldTermName, fldTermDefinition, pmkTermId FROM tblSets JOIN tblTerms ON pmkSetId = fpkSetId WHERE pmkSetId = ?';
    $array = array($set_id);
    $data = $thisDataBaseReader->select($sql, $array);
    
    print '<h3>' . $data[0]['fldSetName'] . '</h3>' . PHP_EOL;
    print '<p>' . $data[0]['fldSetDescription'] . '</p>' . PHP_EOL;
    print '<table>' . PHP_EOL;
    print '<tr>' . PHP_EOL;
    print '<th>Term Name</th>' . PHP_EOL;
    print '<th>Term Definition</th>' . PHP_EOL;
    print '<th>Action</th>' . PHP_EOL;
    print '</tr>' . PHP_EOL;
    foreach ($data as $row) {
        print '<tr>';
        print '<td>' . $row['fldTermName'] . '</td>' . PHP_EOL;
        print '<td>' . $row['fldTermDefinition'] . '</td>' . PHP_EOL;
        print '<td><a href="viewDelete.php?setId=' . $set_id . '&termId=' . $row['pmkTermId'] . '">Delete Term</a></td>' . PHP_EOL;
        print '</tr>' . PHP_EOL;
    }
    print '</table>' . PHP_EOL;
    ?>
</main>
<?php include 'footer.php'; ?>
