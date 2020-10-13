<?php


require_once("config/config.php");

$bedrijfsid = $_SESSION['bedrijfs_id'];

$sql = "SELECT AVG(Antwoord) as mean,survey_id FROM vragenlijst where bedrijfs_id = $bedrijfsid group by survey_id";
$result = mysqli_query($con,$sql);
while ($fetch = mysqli_fetch_assoc($result)) {
    
    $mean_surveys[$fetch['survey_id']] = $fetch['mean']; 
}


$sql = "SELECT id,surveyname FROM surveys where bedrijfs_id = $bedrijfsid";
$result = mysqli_query($con,$sql);
while ($fetch = mysqli_fetch_assoc($result)) {
    if(array_key_exists($fetch['id'],$mean_surveys)){
        $value = $mean_surveys[$fetch['id']];
    }else{
        $value = 0;
    }
    $barchart_data[$fetch['surveyname']] = $value; 
}

foreach($barchart_data as $key=>$value){
    $label[] = $key;
    $data[] = $value;
}



?>
<html>
    <head>
<?php include "assets/lib/libraries_head.php";?>
<link href="css/styles.css" rel="stylesheet" />
</head>
<body>
<div class="col-lg-6">
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-chart-bar mr-1"></i>
            Bar Chart Example With Data
        </div>
        <div class="card-body"><canvas id="surveyBarChart" width="100%" height="50"></canvas></div>
        <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script>
    
// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#292b2c';

// Bar Chart Example
var ctx = document.getElementById("surveyBarChart");
var myLineChart = new Chart(ctx, {
  type: 'horizontalBar',
  data: {
    labels: <?php echo json_encode($label); ?>,
    datasets: [{
      label: "Mean Score",
      backgroundColor: "rgba(2,117,216,1)",
      borderColor: "rgba(2,117,216,1)",
      data: <?php echo json_encode($data); ?>,
    }],
  },
  options: {
    scales: {
      yAxes: [{
        gridLines: {
          display: false
        },
      }],
      xAxes: [{
        ticks: {
          min: 0,
          max: 5,
          maxTicksLimit: 20
        },
        gridLines: {
          display: true
        }
      }],
    },
    legend: {
      display: false
    }
  }
});
</script>
</body>

</html>