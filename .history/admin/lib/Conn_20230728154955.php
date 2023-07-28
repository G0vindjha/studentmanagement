<?php
//Class Created
class Conn
{
    private $conn;
    //Constructor class created
    public function __construct()
    {
        try {

            $this->conn = new PDO("mysql:host=localhost;dbname=EmployeeModule", 'root', 'Govind@1990');
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    //Select Method
    public function select($table, $fields = "*", $join = "", $joinParam = '', $where = "", $whereParam = '', $groupbyFieldName = "", $orderFieldName = "", $order = "", $limit = "")
    {
        $sql = "SELECT $fields FROM $table";

        if (!empty($join) && !empty($joinParam)) {
            foreach ($joinParam as $tableName => $data) {
                foreach ($data as $field1 => $field2) {
                    $sql .= " $join $tableName ON $table.$field1 = $tableName.$field2";
                }
            }
        }
        if (!empty($where)) {
            $sql .= " WHERE $where";
        }
        if (!empty($groupbyFieldName)) {
            $sql .= " ORDER BY $orderFieldName $order";
        }
        if (!empty($order)) {
            $sql .= " ORDER BY $orderFieldName $order";
        }
        if (!empty($limit)) {
            $sql .= " LIMIT $limit";
        }
        $stmt = $this->conn->prepare($sql);
        foreach ($whereParam as $key => $value) {
            if ($value['type'] == 'INT') {
                $stmt->bindParam($key, $value['value'], PDO::PARAM_INT);
            } else {
                $stmt->bindParam($key, $value['value'], PDO::PARAM_STR);
            }
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    //Insert Method
    public function insert($table, $data)
    {
        $fields = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $table ($fields) VALUES ($values)";
        $stmt = $this->conn->prepare($sql);
        if ($stmt->execute($data) == true) {
            $emp_Id = $this->conn->lastInsertId();
            return $emp_Id;
        } else {
            return 'error';
        }
    }
    //Update Method
    public function update($table, $data, $where)
    {
        $set = "";
        foreach ($data as $key => $value) {
            $set .= "$key=:$key, ";
        }
        $set = rtrim($set, ", ");
        $sql = "UPDATE $table SET $set WHERE $where";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($data);
    }
    //Delete Method
    public function delete($table, $where, $whereParam)
    {
        $selectsql = "SELECT profile_Pic FROM $table WHERE $where";
        $selectstmt = $this->conn->prepare($selectsql);
        foreach ($whereParam as $key => $value) {
            if ($value['type'] == 'INT') {
                $selectstmt->bindParam($key, $value['value'], PDO::PARAM_INT);
            } else {
                $selectstmt->bindParam($key, $value['value'], PDO::PARAM_STR);
            }
        }
        $selectstmt->execute();
        $profile_Pic = ($selectstmt->fetchAll(PDO::FETCH_ASSOC)[0]['profile_Pic']);
        $imgpath = '/var/www/html/ops/public_html/PHPOPS/Day19/Assignments/Project1/admin/assets/img/upload/' . $value['value'] . '/' . $profile_Pic;
        $dirpath = '/var/www/html/ops/public_html/PHPOPS/Day19/Assignments/Project1/admin/assets/img/upload/' . $value['value'];
        $sql = "DELETE FROM $table WHERE $where";
        $stmt = $this->conn->prepare($sql);
        foreach ($whereParam as $key => $value) {
            if ($value['type'] == 'INT') {
                $stmt->bindParam($key, $value['value'], PDO::PARAM_INT);
            } else {
                $stmt->bindParam($key, $value['value'], PDO::PARAM_STR);
            }
        }
        if ($stmt->execute()) {
            if (unlink($imgpath)) {
                if (rmdir($dirpath)) {
                    echo "Data Deleted!!";
                } else {
                    echo "Folder is not deleted!!";
                }
            } else {
                echo "Image is not deleted!!";
            }
        } else {
            echo "Data is not Deleted!!";
        }
    }
}
