<?php include 'top.php'; ?>
<main>
    <h3>View</h3>

    <?php
    $sql = 'SELECT fldNetId, pmkUserId, fldSetName, fldSetDescription, pmkSetId FROM tblUsers JOIN tblSets ON pmkUserId = fpkUserId';

    // execute the query
    //$data = $pdo->query($sql);
    $data = $thisDataBaseReader->select($sql);

    // iterate over the results and print them
    print '<br>';
    print '<table>';
    print '<tr>';
    print '<th>Net ID</th>';
    print '<th>Set Name</th>';
    print '<th>Set Description</th>';
    print '</tr>';

    foreach ($data as $dat) {
        $set_id = $dat['pmkSetId'];
        $set_link = "set.php?set_id={$set_id}";
        print '<tr>';
        print "<td>" . $dat['fldNetId'] . '</td>';
        print "<td><a href='{$set_link}'>" . $dat['fldSetName'] . '</a></td>';
        print "<td>" . $dat['fldSetDescription'] . '</td>';
        print '</tr>';
    }
    print '</table>';
    ?>
</main>
<?php include 'footer.php'; ?>
