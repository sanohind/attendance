<?php
class employee
{
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    public function storeData(
        $empId,
        $empNo,
        $fullName,
        $startDate,
        $endDate,
        $email,
        $positionId,
        $posCode,
        $posNameId,
        $empDept_posID,
        $empDept_posName
    ) {
        $sql = $this->db->prepare("INSERT INTO employee VALUES (
            ?,?,?,?,?,?,?,?,?,?,?
        )");

        try {
            $sql->execute([
                $empId,
                $empNo,
                $fullName,
                $startDate,
                $endDate,
                $email,
                $positionId,
                $posCode,
                $posNameId,
                $empDept_posID,
                $empDept_posName
            ]);

            return TRUE;
        } catch (Exception $e) {
            die();
            return $e->getMessage();
        }
    }

    public function getEmployee($empId = null)
    {
        if ($empId == NULL) {
            $sql = $this->db->prepare("select * from employee");
            try {
                $sql->execute();
            } catch (Exception $e) {
                die($e->getMessage());
            }
            return $sql->fetchAll(PDO::FETCH_OBJ);
        } else {
            $sql = $this->db->prepare("select * from employee where empId = ?");
            $sql->bindValue(1, $empId);
            try {
                $sql->execute();
            } catch (Exception $e) {
                die($e->getMessage());
            }
            return $sql->fetch(PDO::FETCH_OBJ);
        }
    }
}
