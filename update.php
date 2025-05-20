<?php
echo "Current Time: ".date('Y-m-d H:i:s');
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script>
        function fetchUpdatedData(){
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'update.php', true);

            xhr.onreadystatechange = function(){
                if (xhr.readyState === 4 && xhr.status === 200){
                    document.getElementById('content').innerHTML = xhr.responseText;}};xhr.send()}
                    setInterva;(fetchUpdatedData,2000)
        <script>
</head>
<body>
    <div id='content'>
    Loading...
</body>
</html>