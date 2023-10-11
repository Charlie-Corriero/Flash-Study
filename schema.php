<?php
include 'top.php';
?>
<!DOCTYPE html>
<main>

    <p>CREATE TABLE tblUsers (
    pmkUserId int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    fldNetId varchar(11) NOT NULL,
    fldEmail varchar(50) DEFAULT NULL
    );</p>
    
    <p>CREATE TABLE tblSets (
    pmkSetId int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    fpkUserId varchar(11) NOT NULL,
    fldSetName varchar(25) NOT NULL,
    fldSetDescription varchar(200) NOT NULL,
    fldSortOrder int(11) NOT NULL
        );</p>
    
    <p>CREATE TABLE tblTerms (
    pmkTermId int(11) PRIMARY KEY NOT NULL AUTO_INCREMENT,
    fpkSetId int(11) NOT NULL,
    fldTermName varchar(25) NOT NULL,
    fldTermDefinition varchar(200) NOT NULL,
    fldSortOrder int(11) NOT NULL
        );</p>
  
</main>
<?php
include 'footer.php';
?>
</html>
