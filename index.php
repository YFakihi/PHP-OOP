
<?php
class Database {
    private $dbHost = 'localhost';
    private $dbUsername = 'root';
    private $dbPassword = '';
    private $dbName = 'poo_php';
    private $pdo;

    public function __construct() {
       
            $this->pdo = new PDO("mysql:host=$this->dbHost;dbname=$this->dbName", $this->dbUsername, $this->dbPassword);
           
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     
    }

    public function insertRecord($tableName, $data) {
        
            $columns = implode(',', array_keys($data));
            $placeholders = implode(',', array_fill(0, count($data), '?'));

            $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute(array_values($data));
            return true; 
  
    }
}


$database = new Database();
$dataToInsert = [
    'mame' => ' Fakihi',
];

$tableName = 'user';
$result = $database->insertRecord($tableName, $dataToInsert);

if ($result) {
    echo "user bien ajouter ";
} else {
    echo "syntax errore!!!!!!!!!!! ";
}
