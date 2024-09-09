<?php
include 'connection.php';
include 'AttendanceClass.php';

$attn = new Attendance($db);

$otPerson = $attn->getTotalOtbyPerson();
$otSection = $attn->getTotalOtbySection();

$data = [
    "otPerson" => $otPerson,
    "otSection" => $otSection
];

echo json_encode($data);