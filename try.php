<?php
    include('config.php');
?>
<html>
<head>
    <title>Fetch record using jQuery</title>
    <style type="text/css">
        #display {
            margin : 225px;
        }
    </style>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
    <script type="text/javascript">
    $('document').ready(function(){
        $('a').click(function(){
            var temp = $('a').attr('myval');
            $.post('fetch.php', {task_id:temp}, function(data){
            $('#display').html(data);
            });
        });
    });
    </script>
</head>
<body>
<?php
$query = mysqli_query($connection,"select * from task_info");
echo "<ul>";
while($row = mysqli_fetch_assoc($query)){
echo "<li><a href=\"javascript:return(0)\" myval=\"{$row['task_id']}\"><h3>{$row['duration']}</h3></a></li>";

}

echo "</ul>";

?>
<div id="display"></div>
</body>
</html>
<?php
mysqli_close($connection);
?>