<!-- Database -->
<?php
 class DataBase {
    const DB_DEBUG = true;
    public $pdo;
    public function __construct($dataBaseUser, $dataBaseName) {
        $this->pdo = null;
        $dsn = 'mysql:host=webdb.uvm.edu;dbname=' . $dataBaseName;
        $DataBasePassword = '';
        require 'pass.php';
        switch(substr($dataBaseUser, -3)) {
        case 'ter':
            $dataBasePassword = $writer;
            break;
        case 'der':
            $dataBasePassword = $reader;
            break;
        }
        try{
            $this->pdo = new PDO($dsn, $dataBaseUser, $dataBasePassword);
                if(!$this->pdo){
                    if(self::DB_DEBUG){
                        print PHP_EOL . '<!-- NOT Connected -->'. PHP_EOL;
                        $this->$pdo = 0;
                    }
                } else {
                    if (self::DB_DEBUG){
                        print PHP_EOL . '<!-- Connected -->' . PHP_EOL;
                    }
                }
        } catch(PDOException $e){
                $error_message = $e->getMessage();
                    if (self:: DB_DEBUG){
                        print '<!-- Error connecting : ' . $error_message . '-
        ->' . PHP_EOL;
                    }
        }
        return $this->pdo;
    }

    public function select($query, $values = ''){
        $statement = $this->pdo->prepare($query);
        if(is_array($values)){
            $statement->execute($values);
        } else {
            $statement->execute();
        }
        $recordSet = $statement->fetchAll(PDO::FETCH_ASSOC);
        $statement->closeCursor();
        return $recordSet;
    }

    public function displaySQL($sqlStatement, $values = '') {
        $sqlText = $sqlStatement;
        foreach ($values as $value) {
            $pos = strpos($sqlText, '?');
            if ($pos !== false) {
                $sqlText = substr_replace($sqlText, '"' . $value . '"', $pos, strlen('?'));
            }
        }
        return $sqlText;
    }

    public function insert($query, $values = ''){
        $statement = $this->pdo->prepare($query);
        $inserted = false;
        if (is_array($values)) {
            $inserted = $statement->execute($values);
        }
        $statement->closeCursor();
        return $inserted;
    }

    public function lastInsert() {
        $primaryKey = -1;
        $query = 'SELECT LAST_INSERT_ID()';
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $recordSet = $statement->fetchAll();
        $statement->closeCursor();

        if ($recordSet) {
            $primaryKey = $recordSet[0]['LAST_INSERT_ID()'];
        }
        return $primaryKey;
    }

    public function deleteSet($setId) {
        $sql = 'DELETE FROM tblSets WHERE pmkSetId = ' . $setId;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $sql = 'DELETE FROM tblTerms WHERE fpkSetId = ' . $setId;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();

        $statement->closeCursor();
    }

    // Currently deletes all terms, need to make it only delete one
    public function deleteTerm($setId, $termId) {
        $sql = 'DELETE FROM tblTerms WHERE fpkSetId = ' . $setId . ' AND pmkTermId = ' . $termId;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $statement->closeCursor();
    }

    public function update($query, $values = '') {
        $statement = $this->pdo->prepare($query);
        $updated = false;
        if (is_array($values)) {
            $updated = $statement->execute($values);
        }
        $statement->closeCursor();
        return $updated;
    }
    
}
?>
<!-- end class -->
