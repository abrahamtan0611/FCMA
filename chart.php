<!doctype html public "-//w3c//dtd html 3.2//en">
<html>

<head>
    <title>Bar Chart of Sales/profit</title>
    <style>


    </style>

</head>


<?Php
require 'Include/dtb.php';
    require 'Include/header.php';

if($stmt = $conn->query("SELECT MONTHNAME(deliveryDate), (totalAmount-totalOriPrice) AS Profit, totalAmount AS Sales FROM orderdb WHERE paymentStatus != 'pending' GROUP BY MONTH(deliveryDate)")){

  //echo "No of records : ".$stmt->num_rows."<br>";
$php_data_array = Array(); // create PHP array
  //echo "<table>
//<tr> <th>Month</th><th>Sale</th><th>Profit</th></tr>";
while ($row = $stmt->fetch_row()) {
  // echo "<tr><td>$row[0]</td><td>$row[1]</td><td>$row[2]</td></tr>";
   $php_data_array[] = $row; // Adding to array
   }
//echo "</table>";
}else{
echo $conn->error;
}
//print_r( $php_data_array);
// You can display the json_encode output here. 
//echo json_encode($php_data_array); 

// Transfor PHP array to JavaScript two dimensional array 
echo "<script>
        var my_2d = ".json_encode($php_data_array)."
</script>";
?>


<div id="chart_div"></div>
<br><br>




<script type="text/javascript">
    // Load the Visualization API and the corechart package.
    google.charts.load('current', {
        packages: ['corechart', 'bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Month');
        data.addColumn('number', 'Profit');
        data.addColumn('number', 'Sales');
        for (i = 0; i < my_2d.length; i++)
            data.addRow([my_2d[i][0], parseInt(my_2d[i][1]), parseInt(my_2d[i][2])]);
        var options = {
            title: 'Food Edge Sales Profit',
            hAxis: {
                title: 'Month',
                titleTextStyle: {
                    color: '#333'
                }
            },
            vAxis: {
                title: 'Amount',
                minValue: 0
            }
        };

        var chart = new google.charts.Bar(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

</script>
</body>

</html>
