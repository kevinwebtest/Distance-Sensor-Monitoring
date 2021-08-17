<!DOCTYPE html>
<html>
<head>
<title>Ultrasonic Sensor</title>
<meta http-equiv="refresh" content="5">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<style>
.container{
  width:90%;
  padding-right:15px;
  padding-left:15px;
  margin-right:auto;
  margin-left:auto;  
}
table {
  border-collapse: collapse;
  width: 80%;
  color: #0b62a4;
  font-family: monospace;
  font-size: 22px;
  text-align: left;
  margin-left: auto;
  margin-right: auto;
}
th {
  background-color: #0b62a4;
  color: white;
}
tr:nth-child(even) {background-color: #f2f2f2}
</style>
</head>
<body>
<h1 style="text-align: center; font-family: monospace;">Ultrasonic Sensor Monitoring</h1>
<div class="container">
<table>
<tr>
<th>No</th>
<th>Distance</th>
<th>Time</th>
</tr>
<?php
  $conn = mysqli_connect("localhost", "id17043007_smsultrasonic", "dE)qQfwdP2/h4xs", "id17043007_sms_ultrasonic");
  // Check connection
  $i = 1;
  if ($conn->connect_error)
  {
      die("Connection failed: " . $conn->connect_error);
  }
  $sql = "SELECT distance, datetime FROM hcsr04 dt ORDER BY dt.datetime DESC LIMIT 10";
  $result = $conn->query($sql);
  if ($result->num_rows > 0)
  {
      // output data of each row
      while ($row = $result->fetch_assoc())
      {
          echo "<tr><td>" . $i . "</td><td>" . $row["distance"] . "</td><td>" . $row["datetime"] . "</td></tr>";
          $i++;
      }
      echo "</table>";
  }
  else
  {
      echo "0 results";
  }
  $conn->close();
?>
</table>
</div>
<n>
<?php
  $connect = mysqli_connect("localhost", "id17043007_smsultrasonic", "dE)qQfwdP2/h4xs", "id17043007_sms_ultrasonic");
  $query = "SELECT*FROM hcsr04 dt ORDER BY dt.datetime DESC LIMIT 20";
  $new_result = mysqli_query($connect, $query);
  $chart_data = '';
  while($row = mysqli_fetch_array($new_result))
  {
      $chart_data .= "{datetime:'".$row["datetime"]."', distance:".$row["distance"]."}, ";
  }
  $chart_data = substr($chart_data, 0, -2);
?>
<div class="container">
<div id="chart"></div>
</div>
</body>
</html>
<script>
    Morris.Line({
        element: 'chart',
        data: [<?php echo $chart_data; ?>],
        xkey:'datetime',
        ykeys:['distance'],
        labels:['distance'],
    });
</script>