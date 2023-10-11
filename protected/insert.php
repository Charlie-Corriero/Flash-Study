<?php include 'top.php'; ?>

<main>

<?php
$dataIsGood = true;
$setName = "";
$setDescription = "";
$netId = "";
$totalTerms = 5;

function getPostData($field) {
    if (!isset($_POST[$field])) {
        $data = '"'; 
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
         for ($i = 1; $i < $totalTerms + 1; $i++) {
            ${'term' . $i . 'Text'} = getPostData('term' . $i . 'Text');
            ${'term' . $i . 'Definition'} = getPostData('term' . $i  . 'Definition');
        }
        $netId = getPostData("netId");

        if ($setName == "" ||
            $setDescription == "" ||
            $netId == "" ||
            $term1Text == "" ||
            $term2Text == "" ||
            $term3Text == "" ||
            $term4Text == "" ||
            $term5Text == "" ||
            $term1Definition == "" ||
            $term2Definition == "" ||
            $term3Definition == "" ||
            $term4Definition == "" ||
            $term5Definition == ""){
            print '<p>Please make sure you fill in all of the boxes.</p>';
            $dataIsGood = false;
        }

        if ($dataIsGood) {
             try {

                print "<p>This feature is currently disabled for viewing and security purposes. If the feature was enabled, a study set with the name, description, terms, and definitions provided would have been created.</p>";
            


                /*
                $sql = 'INSERT INTO tblUsers (fldNetId) VALUES (?)';
                $data = array($netId);
                $thisDataBaseWriter->insert($sql, $data);
                $userId = $thisDataBaseWriter->lastInsert();
                // Inserting set data
                $sql = 'INSERT INTO tblSets (pmkSetId,fpkUserId, fldSetName,fldSetDescription, fldSortOrder) VALUES (null,?,?,?,?)';
                $data = array($userId, $setName, $setDescription, 1);
                $thisDataBaseWriter->insert($sql,$data);
                $fpk = $thisDataBaseWriter->lastInsert();

                // Inserting term data
                for ($i = 1; $i < $totalTerms + 1; $i++) {
                    $sql = 'INSERT INTO tblTerms (pmkTermId,fpkSetId,fldTermName,fldTermDefinition,fldSortOrder)
                    VALUES (null,?,?,?,?);';
                    $data = array($fpk,${'term' . $i . 'Text'},${'term' . $i . 'Definition'},$i);
                    $thisDataBaseWriter->insert($sql,$data);  
                }*/

            } catch(PDOException $e) {
                print $e;
            } 
        } 
    }

print '<form action="#" method="post">' . PHP_EOL;
    print '<fieldset class="text">' . PHP_EOL;
    print '<p><strong>Please enter the name of the set on the left and the description on the right</strong></p>' . PHP_EOL;
        print '<p>' . PHP_EOL;
            print '<label>Set Name</label>' . PHP_EOL;
            print '<input type="text" name="setName" id="setName" maxlength="25" value="' . $setName . '">' . PHP_EOL;
        print '</p>' . PHP_EOL;
       print '<p>' . PHP_EOL;
            print '<label>Set Description</label>' . PHP_EOL;
            print '<input type="text" name="setDescription" id="setDescription" maxlength="200" value="' . $setDescription . '">' . PHP_EOL;
        print '</p>' . PHP_EOL;

        print '<p>' . PHP_EOL;
            print '<label>NetID</label>' . PHP_EOL;
            print '<input type="text" name="netId" id="netId" maxlength="10" value="' . $netId . '">' . PHP_EOL;
        print '</p>' . PHP_EOL;

        print '<p><strong>Please enter the term on the left and the definition on the right</strong></p>' . PHP_EOL;
        ?>
        
        <?php
        // Printing out the term and definition inputs
        for ($i = 1; $i < $totalTerms + 1; $i++) {
            print '<p class="term">' . PHP_EOL;
            print '<label>Term ' . $i . '</label>' . PHP_EOL;
            print '<input type="text" name="term' . $i . 'Text" id="term' . $i . 'Text" maxLength="25" value="' . ${'term' . $i . 'Text'} . '">' . PHP_EOL;
            print '</p>' . PHP_EOL;

            print '<p class="definition">' . PHP_EOL;
            print '<label>Definition ' . $i . '</label>' . PHP_EOL;
            print '<input type="text" name="term' . $i . 'Definition" id="term' . $i . 'Definition" maxLength="200" value="' . ${'term' . $i . 'Definition'} . '">' . PHP_EOL;
            print '</p>' . PHP_EOL;
        }
        print '</fieldset>' . PHP_EOL;
        print '<input type="submit" value="Insert">' . PHP_EOL;
    print '</form>'  . PHP_EOL;
    
        

 ?>
</main>
<?php
include 'footer.php';
?>