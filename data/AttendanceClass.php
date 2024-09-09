<?php
class Attendance
{
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    public function storeData(
        $attendId,
        $empId,
        $shiftdailyCode,
        $shiftstarttime,
        $shiftendtime,
        $attendCode,
        $starttime,
        $endtime,
        $actualIn,
        $actualOut,
        $dayType,
        $totalOt,
        $totalOtindex,
        $overtimeCode,
        $actualworkmnt,
        $actualLti,
        $actualEao,
        $geolocStart,
        $geolocEnd,
        $empNo,
        $spvNo,
        $spvId
    ) {
        $sql = $this->db->prepare("INSERT INTO attendance VALUES (
            ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
        )");
        try {
            $sql->execute([
                $attendId,
                $empId,
                $shiftdailyCode,
                $shiftstarttime,
                $shiftendtime,
                $attendCode,
                $starttime,
                $endtime,
                $actualIn,
                $actualOut,
                $dayType,
                $totalOt,
                $totalOtindex,
                $overtimeCode,
                $actualworkmnt,
                $actualLti,
                $actualEao,
                $geolocStart,
                $geolocEnd,
                $empNo,
                $spvNo,
                $spvId
            ]);

            return TRUE;
        } catch (Exception $e) {
            die();
            return $e->getMessage();
        }
    }

    public function getAttendanceById($id)
    {
        $sql = $this->db->prepare("select * from attendance where attendId = ?");
        $sql->bindValue(1, $id);
        try {
            $sql->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $sql->fetch(PDO::FETCH_OBJ);
    }

    public function updateData($starttime, $endtime, $actualIn, $actualOut, $totalOt, $totalOtindex, $geolocStart, $geolocEnd, $attendId)
    {
        $sql = $this->db->prepare("update attendance set
            starttime = ?,
            endtime = ?,
            actualIn = ?,
            actualOut = ?,
            totalOt = ?,
            totalOtindex = ?,
            geolocStart = ?,
            geolocEnd = ?
            where attendId = ?");
        try {
            $sql->execute([$starttime, $endtime, $actualIn, $actualOut, $totalOt, $totalOtindex, $geolocStart, $geolocEnd, $attendId]);
            return TRUE;
        } catch (Exception $e) {
            return die($e->getMessage());
        }
    }

    public function getTotalOtbyPerson()
    {
        $sql = $this->db->prepare("select empid,empName,sum(totalOtindex) 'sum_ot' 
                FROM greatday.data_attendance
                where month(shiftstarttime) = ?
                and empsection not in ('Security','Office Boy','Driver')
                group by empId,empName
                order by 3 desc
                limit 20;");
        $sql->bindValue(1, 9);
        try {
            $sql->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTotalOtbySection()
    {
        $sql = $this->db->prepare("select empsection,sum(totalOtindex) 'sum_ot' 
            FROM greatday.data_attendance
            where month(shiftstarttime) = ?
            group by empsection
            order by 2 desc
            limit 10;");
        $sql->bindValue(1, 9);
        try {
            $sql->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
        return $sql->fetchAll(PDO::FETCH_OBJ);
    }
}
