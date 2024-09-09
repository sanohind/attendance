<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Attendance Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
    const api_url = "https://dev.greatdayhr.com/api/";

    function getData() {
        fetch(api_url + "attendances/byPeriod?startDate=2024-09-01&endDate=2024-09-07", {
                mode: 'no-cors',
                //method: 'GET',
                headers: {
                    'Authorization': `eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VybmFtZSI6ImQyODcwYTkwLTJhYWItNDNhMC04NjY4LTI3MDMyZjliNWY0YyIsInN1YiI6IjMzMTI1IiwiY29kZW5hbWUiOiJHRFBSTzAwMDkiLCJpYXQiOjE3MjU2NzczNjksImV4cCI6MTcyNTc2Mzc2OX0.D1rB7KX_kU0Ud81F3vCZy5uh-WL54Ba0qQEClI9Zync`,
                    'Content-Type': 'application/json'
                }
            })
            .then(response => console.log(response))
            .catch(error => console.log(error));
    }


    $(document).ready(function() {
        getData();
    })
</script>