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
    
echo'
<div>
<input type ="date" name = "from_date" id = "from_date"/>
&nbsp;
<input type ="date" name = "to_date" id = "to_date"/>

</div>
';
    
    //SELECT GETDATE() 'Today', FORMAT(deliveryDate,'MMMM') 'Month Name'
    
    //SELECT RIGHT(CONVERT(VARCHAR(8), deliveryDate, 3), 5) AS [MM/YY]
    
    // FORMAT(deliveryDate,'MMyy')
    
    // mysql> SELECT DATE_FORMAT('2009-10-04 22:23:00', '%W %M %Y');
    //outputs  -> 'Sunday October 2009'

if($stmt = $conn->query("SELECT DATE_FORMAT(deliveryDate, '%M %Y'), (totalAmount-totalOriPrice) AS Profit, totalAmount AS Sales FROM orderdb WHERE paymentStatus != 'pending' GROUP BY YEAR(deliveryDate), MONTHNAME(deliveryDate) ORDER BY deliveryDate")){

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


<div id="chart_div">

</div>
<br><br>
<!--
<div id = "date">
 <form method='post' action=''>
     Start Date <input type='text' class='dateFilter' name='fromDate' value='<?php if(isset($_POST['fromDate'])) echo $_POST['fromDate']; ?>'>
 
     End Date <input type='text' class='dateFilter' name='endDate' value='<?php if(isset($_POST['endDate'])) echo $_POST['endDate']; ?>'>

     <input type='submit' name='but_search' value='Search'>
   </form>
</div>

-->




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
