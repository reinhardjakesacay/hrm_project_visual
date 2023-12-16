<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script
src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js">
</script>
    <title>Job Position</title>
</head>
<body>
    <!-- canvas chartjs -->
    <div class="col-md-6">
        <div class="card ">
            <div class="header">
                <h1 class="title">Job Position</h1>
                <p class="category">Job</p>
            </div>

            <div class="content">
            <canvas id="jobPos"></canvas>
            </div>
        </div>
    </div>
    <!-- ------------------------------------------------------------ -->

    <?php

require('config/config.php');
require('config/db.php');


// ----------------------------------------------------------------------

$query1 = "select job_positions.job_category, count(service_records.job_positions_idjob_positions) as job_count
from job_positions 
join service_records on job_positions.idjob_positions = service_records.job_positions_idjob_positions
group by job_positions.idjob_positions
order by job_count desc";

$result1 = mysqli_query($conn, $query1);
if(mysqli_num_rows($result1) > 0){
    $order_count1 = array();
    $label_barchart1 = array();
    while ($row = mysqli_fetch_array($result1)){
        $order_count1[] = $row['job_count'];
        $label_barchart1[] = $row['job_category'];
    }
    mysqli_free_result($result1);
}else{
    echo "No records matching your query were found.";
}

?>

<script>

// <!-- setup block --> -------------------------------------------------
const label_barchart1 = <?php echo json_encode($label_barchart1); ?>;
const order_count1 = <?php echo json_encode($order_count1); ?>;

const data4 ={

labels: label_barchart1,
    datasets: [{
        label: 'Number of Employee',
        data: order_count1,
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
}]
};
// <!-- config block -->
const config4 = {
    type: 'bar',
    data: data4,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
};
// <!-- render block -->
const jobPos = new Chart(
    document.getElementById('jobPos'),
    config4
);
// ----------------------------------------------------------------------
</script>

</body>
</html>