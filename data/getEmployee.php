<?php
include 'employeeClass.php';
include 'connection.php';
$url = "https://dev.greatdayhr.com/api/employees";
$data = [
    "page" => 0,
    "limit" => 100,
    "query" => "",
    "empId" => "",
    "empNo" => "",
    "orgUnit" => ""
];

//echo json_encode($data);
$ch = curl_init($url);
//attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

//set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization:Bearer '.$token));

//return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//execute the POST request
$result = curl_exec($ch);

//close cURL resource
curl_close($ch);

//var_dump($result);

//echo "<br/>";

$res = json_decode($result);
// $res2 = get_object_vars($res);
// print_r($res2);

//echo "<br/><p>";
//print_r($res->data[0]->empCompany->empPosition->empDept);

$emp = new Employee($db);
foreach ( $res->data as $row ){
    $save = $emp->storeData(
        $row->empCompany->empId,
        $row->empCompany->empNo,
        $row->fullName,
        $row->empCompany->startDate,
        $row->empCompany->endDate,
        $row->email,
        $row->empCompany->empPosition->positionId,
        $row->empCompany->empPosition->posCode,
        $row->empCompany->empPosition->posNameId,
        $row->empCompany->empPosition->empDept->positionId,
        $row->empCompany->empPosition->empDept->posNameEn
    );
     if($save == TRUE){
        echo "data tersimpan <br/>";
     }
}