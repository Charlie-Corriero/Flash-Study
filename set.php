<?php include 'top.php'; ?>
<main>
    <?php
    
    $set_id = $_GET['set_id'];
    $sql='SELECT fldSetName, fldSetDescription, fldTermName, fldTermDefinition FROM tblSets JOIN tblTerms ON pmkSetId = fpkSetId WHERE pmkSetId = ?';
    $data = $thisDataBaseReader->select($sql, array($set_id));
    
    print '<p><strong>Study set name:</strong> ' . $data[0]['fldSetName'] . '</p>';
    print '<p><u>Study set Description</u>: ' . $data[0]['fldSetDescription'] . '</p>';
    print '<table>';
    print '<tr>';
    print '<th>Term Name</th>';
    print '<th>Term Definition</th>';
    print '</tr>';
    foreach ($data as $row) {
        print '<tr>';
        print '<td>' . $row['fldTermName'] . '</td>';
        print '<td>' . $row['fldTermDefinition'] . '</td>';
        print '</tr>';
    }
    print '</table>';
    ?>
</main>
<?php include 'footer.php'; ?>
