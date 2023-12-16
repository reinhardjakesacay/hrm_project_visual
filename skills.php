<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <script
src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js">
</script>
    <title>Skill Proficiency</title>
</head>
<body>
    <!-- canvas chartjs -->
    <div class="col-md-6">
        <div class="card ">
            <div class="header">
                <h1 class="title">Skill Proficiency</h1>
                <p class="category">Skill</p>
            </div>

            <div class="content">
            <canvas id="skillProf"></canvas>
            </div>
        </div>
    </div>
    <!-- ------------------------------------------------------------ -->

    <?php

require('config/config.php');
require('config/db.php');


// ----------------------------------------------------------------------

$query1 = "SELECT skills.skill_type, count(skills_has_employees.employees_idemployees) as employee_skill
from skills
join skills_has_employees on skills.idskills = skills_has_employees.skills_idskills
group by skills.idskills
order by employee_skill desc";

$result1 = mysqli_query($conn, $query1);
if(mysqli_num_rows($result1) > 0){
    $order_count1 = array();
    $label_barchart1 = array();
    while ($row = mysqli_fetch_array($result1)){
        $order_count1[] = $row['employee_skill'];
        $label_barchart1[] = $row['skill_type'];
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
const skillProf = new Chart(
    document.getElementById('skillProf'),
    config4
);
// ----------------------------------------------------------------------
</script>

</body>
</html>