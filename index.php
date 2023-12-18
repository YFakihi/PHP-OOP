
<?php
require_once "./config.php";
class Database extends DatabaseConnection {

    public function insertRecord($tableName, $data) {
           
            $conn=$this->getConnection();
            $columns = implode(',', array_keys($data));
            $placeholders = implode(',', array_fill(0, count($data), '?'));

            $sql = "INSERT INTO $tableName ($columns) VALUES ($placeholders)";
            $stmt =   $conn->prepare($sql);

            $stmt->execute(array_values($data));
            return true; 
    }


    public function updateRecord($tableName, $data, $id) {
        try {
           
            $conn=$this->getConnection();
            $args = array();
            foreach ($data as $key => $value) {
                $args[] = "$key = ?";
            }
    
            $sql = "UPDATE $tableName SET " . implode(',', $args) . " WHERE id = ?";
            $stmt = $conn->prepare($sql);
    
            if (!$stmt) {
                // throw new Exception("Error in prepared statement: " . $this->pdo->errorInfo());
            }
            // Bind parameters to the prepared statement
            $params = array_merge(array_values($data), [$id]);
            $stmt->execute($params);
            return true; // Successful update
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false; // Failed update
            // Handle the error in a better way, such as logging or throwing an exception.
        }
    }


    public function deleteRecord($tableName, $id) {
       
          $conn=$this->getConnection();
            $sql = "DELETE FROM $tableName WHERE id = ?";
            $stmt = $conn->prepare($sql);
    
            if (!$stmt) {
                // throw new Exception("Error in prepared statement: " . $this->pdo->errorInfo());
            }
    
            $stmt->execute([$id]);
    
            // Check if any rows were affected by the deletion
            $rowCount = $stmt->rowCount();
    
            if ($rowCount > 0) {
                return true; // Successful deletion
            } else {
                return false; 
            }  
    }    
    
}


// Usage example:
// Instantiate the DatabaseHandler class
$database = new Database('localhost', 'poo_php', 'root', '');

// // Example of updating a record
// $updateData = array(
//     'mame' => 'ggg',
    
//     // Add other columns and their updated values
// );
// $recordIdToUpdate = 1; // Set the ID of the record to update

// $updateResult = $database->updateRecord('user', $updateData, $recordIdToUpdate);
// if ($updateResult) {
//     echo "Record updated successfully!";
// } else {
//     echo "Failed to update record.";
// }

// Example of deleting a record



//  $database = new Database();
// $dataToUpdate = [
//     'mame' => 'Mohammed',
//     // Add other fields to update
// ];

// $tableName = 'user';
// $recordID = 3; // ID of the record you want to update

// $result = $database->updateRecord($tableName, $dataToUpdate, $recordID);

// if ($result) {
//     echo "Record updated successfully!";
// } else {
//     echo "Failed to update record.";
// }




// $database = new Database();
// $dataToInsert = [
//     'mame' => ' Fakihi',
// ];

// $tableName = 'user';
// $result = $database->insertRecord($tableName, $dataToInsert);

// if ($result) {
//     echo "user bien ajouter ";
// } else {
//     echo "syntax errore!!!!!!!!!!! ";
// }


$tableName = 'user'; // Replace 'users' with your table name
$recordIdToDelete = 3; // Replace '1' with the ID of the record you want to delete

$result = $database->deleteRecord($tableName, $recordIdToDelete);

if ($result) {
    echo "Record deleted successfully!";
} else {
    echo "Failed to delete record.";
}
