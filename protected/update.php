<?php include 'top.php'; ?>

<main>

<?php
$dataIsGood = true;
$setName = "";
$setDescription = "";
$netId = "";
$totalTerms = 5;

$set_id = isset($_GET['set_id']) ? $_GET['set_id'] : null;
$sql='SELECT fldNetId, fldSetName, fldSetDescription, fldTermName, fldTermDefinition, pmkUserId, pmkTermId FROM tblSets JOIN tblTerms ON pmkSetId = fpkSetId JOIN tblUsers ON pmkUserId = fpkUserId WHERE pmkSetId = ?';
$data = $thisDataBaseReader->select($sql, array($set_id));


function getPostData($field) {
    if (!isset($_POST[$field])) {
        $data = ''; 
    } else {
        $data = trim($_POST[$field]);
        $data = htmlspecialchars($data);
    }
    return $data;
}


 if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dataIsGood = true;
        $setName = getPostData("setName");
        $setDescription = getPostData("setDescription");

        // Trying to use a loop to create variables
        // https://stackoverflow.com/questions/17135192/php-how-can-i-create-variable-names-within-a-loop
        for ($i = 0; $i < count($data); $i++) {
            ${'term' . ($i+1) . 'Text'} = getPostData('term' . ($i+1) . 'Text');
            ${'term' . ($i+1) . 'Definition'} = getPostData('term' . ($i+1)  . 'Definition');
        }
        $netId = getPostData("netId");

        if ($setName == ''){
            $dataIsGood = false;
        }

        if ($dataIsGood) {
            
        
            
            try {
                print "<p>This feature is currently disabled for viewing and security purposes. If the feature was enabled, a study set would have been updated to contain the provided new name, description, term(s), or definition(s)</p>";
                
                // Updating the set name
                if ($data[0]['fldSetName'] != $setName) {
                    $sql = 'UPDATE tblSets SET fldSetName = ? WHERE pmkSetId = ?';
                    $thisDataBaseWriter->update($sql, array($setName, $set_id));
                }
        
                // Updating the set description
                if ($data[0]['fldSetDescription'] != $setDescription) {
                    $sql = 'UPDATE tblSets SET fldSetDescription = ? WHERE pmkSetId = ?';
                    $thisDataBaseWriter->update($sql, array($setDescription, $set_id));
                }
        
                for ($i = 0; $i < $totalTerms; $i++) {
                    $termId = $data[$i]['pmkTermId'];
                
                    $newTermName = "";
                    $newTermDefinition = "";
                    
                    $newTermName = getPostData('term' . ($i+1) . 'Text');
                    $oldTermName = $data[$i]['fldTermName'];
                    $newTermName = ${'term' . ($i+1) . 'Text'};
                
                    if ($oldTermName != $newTermName) {
                        $sql = 'UPDATE tblTerms SET fldTermName = ? WHERE fpkSetId = ? AND pmkTermId = ?';
                        $result = $thisDataBaseWriter->update($sql, array($newTermName, $set_id, $termId));
                    }
                
                    // Updating the term definition
                    $oldTermDefinition = $data[$i]['fldTermDefinition'];
                    $newTermDefinition = ${'term' . ($i+1) . 'Definition'};
                    if ($oldTermDefinition != $newTermDefinition) {
                        $sql = 'UPDATE tblTerms SET fldTermDefinition = ? WHERE fpkSetId = ? AND pmkTermId = ?';
                        $thisDataBaseWriter->update($sql, array($newTermDefinition, $set_id, $termId));
                    }
                }
            } catch(PDOException $e) {
                print $e;
            }
        }        
    } 
?>

<?php
print '<form action="#" method="post">' . PHP_EOL;
    print '<fieldset class="text">' . PHP_EOL;
    print '<p><strong>Please enter the name of the set on the left and the description on the right</strong></p>' . PHP_EOL;
        print '<p>' . PHP_EOL;
            print '<label>Set Name</label>' . PHP_EOL;
            print '<input type="text" name="setName" id="setName" maxlength="25" value="' . $data[0]['fldSetName'] . '">' . PHP_EOL;
        print '</p>' . PHP_EOL;
       print '<p>' . PHP_EOL;
            print '<label>Set Description</label>' . PHP_EOL;
            print '<input type="text" name="setDescription" id="setDescription" maxlength="200" value="' . $data[0]['fldSetDescription']  . '">' . PHP_EOL;
        print '</p>' . PHP_EOL;

        print '<p>' . PHP_EOL;
            print '<label>NetID</label>' . PHP_EOL;
            print '<input type="text" name="netId" id="netId" maxlength="10" value="' . $data[0]['fldNetId']  . '">' . PHP_EOL;
        print '</p>' . PHP_EOL;

        print '<p><strong>Please enter the term on the left and the definition on the right</strong></p>' . PHP_EOL;
        ?>
        
        <?php
        // Printing out the term and definition inputs
        for ($i = 0; $i < count($data); $i++) {
            print '<p class="term">Term ' . ($i+1) . '</p>' . PHP_EOL;
            print '<p>' . PHP_EOL;
            print '<label>Term Name:</label>' . PHP_EOL;
                print '<input type="text" name="term' . ($i+1) . 'Text" id="term' . ($i+1) . 'Text" maxlength="50" value="' . $data[$i]['fldTermName'] . '">' . PHP_EOL;
            print '</p>' . PHP_EOL;
            print '<p>' . PHP_EOL;
                print '<label>Term Definition:</label>' . PHP_EOL;
                print '<input type="text" name="term' . ($i+1) . 'Definition" id="term' . ($i+1) . 'Definition" maxLength="200" value="' . $data[$i]['fldTermDefinition'] . '">';
                //print '<textarea name="term' . ($i+1) . 'Definition" id="term' . ($i+1) . 'Definition">' . $data[$i]['fldTermDefinition'] . '</textarea>' . PHP_EOL;
            print '</p>' . PHP_EOL;
        }
        ?>

    </fieldset>
    <input type="submit" value="Update">
</form>
</main>
<?php
include 'footer.php';
?>
