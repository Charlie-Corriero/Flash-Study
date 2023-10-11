<?php include 'top.php'; ?>

<main>

<?php
$dataIsGood = true;
$setName = "";
$setDescription = "";
$netId = "";
$totalTerms = 5;
$email = "";
if (isset($_POST['hidSubmitted'])) {
    $submitted = $_POST['hidSubmitted'];
} else {
    $submitted = false;
}

function getPostData($field) {
    if (!isset($_POST[$field])) {
        $data = '"'; 
    } else {
        $data = trim($_POST[$field]);
        $data = htmlspecialchars($data);
    }
    return $data;
}
if ($submitted){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $dataIsGood = true;
        $setName = getPostData("setName");
        $setDescription = getPostData("setDescription");
        $email = getPostData("email");

        // https://stackoverflow.com/questions/17135192/php-how-can-i-create-variable-names-within-a-loop
         for ($i = 1; $i < $totalTerms + 1; $i++) {
            ${'term' . $i . 'Text'} = getPostData('term' . $i . 'Text');
            ${'term' . $i . 'Definition'} = getPostData('term' . $i  . 'Definition');
        }
        $netId = getPostData("netId");
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);



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
            $term5Definition == "" ||
            $email == ""){
            print '<p>Please make sure you fill in all of the boxes.</p>';
            $dataIsGood = false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            print '<p> Your email address appears to be incorrect.</p>';
            $dataIsGood = false;
        }

        if ($dataIsGood) {
            
             try {
                $sql = 'INSERT INTO tblUsers (fldNetId, fldEmail) VALUES (?,?)';
                $data = array($netId, $email);
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
                }

            } catch(PDOException $e) {
                print $e;
            } 


            //Email the user
            mail($to, $subject, $mailMessage, $headers);
            $to = $email;
            $from = 'Flash Study Team <ccorrier@uvm.edu>';
            $subject = 'New set created!';

            $mailMessage = '<html><body>';
            $mailMessage .= '<h1><strong>Thank you!</strong></h1>';
            $mailMessage .= '<p style="font: 14pt serif;">Thank you for creating the study set \'' . $setName . '\'!';
            $mailMessage .= 'Your set had been added to our site and can be viewed here: ';
            $mailMessage .= '<a href="https://ccorrier.w3.uvm.edu/flash-study/set.php?set_id=' . $fpk . '">' . $setName . '</a>';
            $mailMessage .= '</body></html>';

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=utf-8\r\n";
            $headers .= "From: " . $from . "\r\n";

            $mailSent = mail($to, $subject, $mailMessage, $headers);
            if ($mailSent) {
                print "<p>A link to your set has been sent to your provided email.</p>";
                print $mailMessage;
            }

            print '<h1>Successfully created the set!</h1>';
            print '<a href="create.php" target="_parent"><button>Create a new set</button></a>';
            print '<a href="view.php" target="_parent"><button>View other sets</button></a>';
            print '<a href="index.php" target="_parent"><button>Return to the home page</button></a>';
        } else {

        print '<form action="#" method="post">' . PHP_EOL;
    print '<fieldset class="text">' . PHP_EOL;
    print '<p class="txthead><strong>Please enter the name of the set on the left and the description on the right</strong> (Note: you will be sent  an email when you click create)</p>' . PHP_EOL;
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

        print '<p>' . PHP_EOL;
            print '<label>Email</label>' . PHP_EOL;
            print '<input type="text" name="email" id="email" maxlength="50" value="' . $email . '">' . PHP_EOL;
        print '</p>' . PHP_EOL;

        print '<p class="txthead"><strong>Please enter the term on the left and the definition on the right</strong></p>' . PHP_EOL;
 
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
    print '<input type="submit" value="Create">' . PHP_EOL;
    print '<input type="hidden" name="hidSubmitted" value="true">' . PHP_EOL;
print '</form>' . PHP_EOL;
    }
    } 

} else {


print '<form action="#" method="post">' . PHP_EOL;
    print '<fieldset class="text">' . PHP_EOL;
    print '<p class="txthead"><strong>Please enter the name of the set on the left and the description on the right</strong> (Note: you will be sent  an email when you click create)</p>' . PHP_EOL;
        print '<p class="phead">' . PHP_EOL;
            print '<label>Study Set Name</label>' . PHP_EOL;
            print '<input type="text" name="setName" id="setName" maxlength="25">' . PHP_EOL;
        print '</p>' . PHP_EOL;
       print '<p class="phead">' . PHP_EOL;
            print '<label>Study Set Description</label>' . PHP_EOL;
            print '<input type="text" name="setDescription" id="setDescription" maxlength="200">' . PHP_EOL;
        print '</p>' . PHP_EOL;

        print '<p class="phead">' . PHP_EOL;
            print '<label>NetID</label>' . PHP_EOL;
            print '<input type="text" name="netId" id="netId" maxlength="10">' . PHP_EOL;
        print '</p>' . PHP_EOL;

        print '<p class="phead">' . PHP_EOL;
            print '<label>Email</label>' . PHP_EOL;
            print '<input type="text" name="email" id="email" maxlength="50">' . PHP_EOL;
        print '</p>' . PHP_EOL;

        print '<p class="txthead"><strong>Please enter the term on the left and the definition on the right</strong></p>' . PHP_EOL;
 
        // Printing out the term and definition inputs
        for ($i = 1; $i < $totalTerms + 1; $i++) {
            print '<p class="term">' . PHP_EOL;
            print '<label>Term ' . $i . '</label>' . PHP_EOL;
            print '<input type="text" name="term' . $i . 'Text" id="term' . $i . 'Text" maxLength="25">' . PHP_EOL;
            print '</p>' . PHP_EOL;

            print '<p class="definition">' . PHP_EOL;
            print '<label>Definition ' . $i . '</label>' . PHP_EOL;
            print '<input type="text" name="term' . $i . 'Definition" id="term' . $i . 'Definition" maxLength="200">' . PHP_EOL;
            print '</p>' . PHP_EOL;
        }
        
    print '</fieldset>' . PHP_EOL;
    print '<input type="submit" value="Create">' . PHP_EOL;
    print '<input type="hidden" name="hidSubmitted" value="true">' . PHP_EOL;
print '</form>' . PHP_EOL;
    }
?>
</main>
<?php
include 'footer.php';
?>