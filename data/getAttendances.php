<?php
//date_default_timezone_set('Etc/GMT');
include 'AttendanceClass.php';
include 'connection.php';
include 'cekToken.php';
$dateFrom = date('Y-m-d', strtotime("-3 days"));
$dateTo = date('Y-m-d', strtotime("+1 days"));

$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, 'https://dev.greatdayhr.com/api/attendances/byPeriod?startDate='.$dateFrom.'&endDate='.$dateTo);
curl_setopt($ch, CURLOPT_URL, 'https://dev.greatdayhr.com/api/attendances/byPeriod?startDate=2024-09-06&endDate=2024-09-10');
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Authorization:Bearer '.$token
));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
$data = json_decode($result);
curl_close($ch);


$attn = new Attendance($db);
$new = 0;
$update = 0;
echo "total data ". count($data->data) ." row <br/>";
foreach ($data->data as $row) {

    $checkExist = $attn->getAttendanceById($row->attendId);
    // if($checkExist != NULL){
    //     echo $row->attendId." sudah ada <br/>";
    // }else{
    //     echo $row->attendId." belum ada <br/>";
    // }
    if ($checkExist != NULL) {
        $update = $attn->updateData(
            $row->starttime,
            $row->endtime,
            $row->actualIn,
            $row->actualOut,
            $row->totalOt,
            $row->totalOtindex,
            $row->geolocStart,
            $row->geolocEnd,
            $row->attendId
        );

        //if ($update == TRUE) {
            $update++;
        //}

    } else {
        $save = $attn->storeData(
            $row->attendId,
            $row->empId,
            $row->shiftdailyCode,
            $row->shiftstarttime,
            $row->shiftendtime,
            $row->attendCode,
            $row->starttime,
            $row->endtime,
            $row->actualIn,
            $row->actualOut,
            $row->daytype,
            $row->totalOt,
            $row->totalOtindex,
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

        //if ($save == TRUE){
            $new++;
        //}
    }
}
echo "data baru = ".$new." row, <br/> data update = ". $update ." row.";
