<?php

$token ='eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImQyODcwYTkwLTJhYWItNDNhMC04NjY4LTI3MDMyZjliNWY0YyIsInN1YiI6IjMzMTI1IiwiY29kZW5hbWUiOiJHRFBSTzAwMDkiLCJpYXQiOjE3MjU4NDAwOTMsImV4cCI6MTcyNTkyNjQ5M30.ZK_9muofVjg0cpLsmIfndyWRsKJiMsR62uXL7IxL5mM';

$config = array(
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'dbname' => 'greatday'
  
  );

$db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] , $config['username'] , $config['password']);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);