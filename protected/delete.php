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

   if (isset($_GET["setId"])) {
    $set_id = getGetData("setId");
    //Line used to delete the set from the database, currently disabled
    // TODO: maybe switch this to just say which set wouldve been deleted. ie: The set 'set_name' would have been deleted
    //$thisDataBaseWriter->deleteSet($set_id);

    $sql='SELECT fldSetName, fldTermName, pmkTermId, fldSetName FROM tblSets JOIN tblTerms ON pmkSetId = fpkSetId WHERE pmkSetId = ?';
    $array = array($set_id);
    $data = $thisDataBaseReader->select($sql, $array);

    print "<p>This feature is currently disabled for viewing and security purposes. If the feature was enabled, the study set '" . $data[0]['fldSetName'] . "' and its corresponding definition would have been removed from the website/database.</p>";

   }


    $sql = 'SELECT pmkUserId, fldNetId, fldSetName, fldSetDescription, pmkSetId FROM tblUsers JOIN tblSets ON pmkUserId = fpkUserId';

    // execute the query
    //$data = $pdo->query($sql);
    $data = $thisDataBaseReader->select($sql);

    // iterate over the results and print them
    print '<br>';
    print '<table>';
    print '<tr>';
    print '<th>Net ID</th>';
    print '<th>Set Description</th>';
    print '<th>Action</th>';
    print '</tr>';
    //while ($dat = $data->fetch(PDO::FETCH_ASSOC)) {
    foreach ($data as $dat) {
        $set_id = $dat['pmkSetId'];
        $set_link = "update.php?set_id={$set_id}";
        print '<tr>';
        print "<td>" . $dat['fldNetId'] . '</td>';
        // Need to write delete function
        print "<td>" . $dat['fldSetDescription'] . '</td>';
        print '<td><a href="viewDelete.php?setId=' . $set_id . '" target="_parent">Delete Terms</a>
                   <a href="delete.php?setId=' . $set_id . '">Delete Set</a>
        </td>';
        print '</tr>';
    }
    print '</table>';
    ?>
</main>
<?php include 'footer.php'; ?>
