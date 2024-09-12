<?php
date_default_timezone_set('Etc/GMT');
include 'AttendanceClass.php';
include 'connection.php';
include 'cekToken.php';
$dateFrom = date('Y-m-d', strtotime("-3 days"));
$dateTo = date('Y-m-d', strtotime("+2 days"));

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://dev.greatdayhr.com/api/attendances/byPeriod?startDate=' . $dateFrom . '&endDate=' . $dateTo);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization:Bearer ' . $token
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$data = json_decode($result);
curl_close($ch);

$attn = new Attendance($db);
$new = 0;
$old = 0;
echo "total data dari tanggal " . $dateFrom . " sampai tangal " . $dateTo . " = " . count($data->data) . " row <br/>";
foreach ($data->data as $row) {

    $checkExist = $attn->getAttendanceById($row->attendId);
    //print_r($checkExist);
    //echo "<br/>";

    if ($checkExist != NULL) {
        $update = $attn->updateData(
            date("Y-m-d H:i:s", strtotime('$row->starttime')),
            date("Y-m-d H:i:s", strtotime('$row->endttime')),
            intval($row->actualIn),
            intval($row->actualOut),
            intval($row->totalOt),
            intval($row->totalOtindex),
            $row->geolocStart,
            $row->geolocEnd,
            $row->attendId
        );

        if ($update == 1) {
            echo $row->attendId . " berhasil update ";
        }else{
            echo $row->attendId . " gagal update ";
        }
        $old++;
    } else {
        $save = $attn->storeData(
            $row->attendId,
            $row->empId,
            $row->shiftdailyCode,
            date("Y-m-d H:i:s", strtotime('$row->shiftstarttime')),
            date("Y-m-d H:i:s", strtotime('$row->shiftendttime')),
            $row->attendCode,
            date("Y-m-d H:i:s", strtotime('$row->starttime')),
            date("Y-m-d H:i:s", strtotime('$row->endttime')),
            intval($row->actualIn),
            intval($row->actualOut),
            $row->daytype,
            intval($row->totalOt),
            intval($row->totalOtindex),
            $row->overtimeCode,
            $row->actualworkmnt,
            $row->actualLti,
            $row->actualEao,
            $row->geolocStart,
            $row->geolocEnd,
            $row->empNo,
            $row->spvNo,
            $row->spvId
        );

        //if ($save == 1){
        $new++;
        //}
    }
}
echo "data baru = " . $new . " row, <br/> data update = " . $old . " row.";
