<?Php
session_start();
require 'Include/dtb.php';
require 'Include/header.php';
    
  
 //$year = 2020;
//(paymentStatus != 'pending' && YEAR(deliveryDate) = $year)
//$year = datalistvalue
    if($stmt = $conn->query("SELECT DATE_FORMAT(deliveryDate, '%M %Y'), (totalAmount-totalOriPrice) AS Profit, totalAmount AS Sales FROM orderdb WHERE (paymentStatus != 'pending') GROUP BY YEAR(deliveryDate), MONTHNAME(deliveryDate) ORDER BY deliveryDate")){
  

	$php_data_array = Array(); // create PHP array

		while ($row = $stmt->fetch_row()) {
		   $php_data_array[] = $row; // Adding to array
		}

	}else{
		echo $conn->error;
	}
	echo'
	<div id="content">
	<div>
	<input type ="date" name = "from_date" id = "from_date"/>
	&nbsp;
	<input type ="date" name = "to_date" id = "to_date"/>

	</div>
	<br>
	';
    

?>
<select name="year" class="form-control" id="year">
    <option value="">Select Year</option>
    <option value="2016">2016</option>
    <option value="2017">2017</option>
    <option value="2018">2018</option>
    <option value="2019">2019</option>
    <option value="2020">2020</option>
    <?php
	foreach($stmt as $row)
	{
		echo '<option value="'.$row[$year].'">'.$row[$year].'</option>';
	}
	?>
</select>
<button type="submit" name="submit" id="submit"onClick="myFunction();">Filter</button>
<br>
<?php
    
    //SELECT GETDATE() 'Today', FORMAT(deliveryDate,'MMMM') 'Month Name'
    
    //SELECT RIGHT(CONVERT(VARCHAR(8), deliveryDate, 3), 5) AS [MM/YY]
    
    // FORMAT(deliveryDate,'MMyy')
    
    // mysql> SELECT DATE_FORMAT('2009-10-04 22:23:00', '%W %M %Y');
    //outputs  -> 'Sunday October 2009'


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
<script>
    $(document).ready(function() {

        $('#year').change(function() {
            var year = $(this).val();
            if (year != '') {
                load_monthwise_data(year, 'Month Wise Profit Data For');
            }
        });

    });

</script>
</div>
</div>
<?php
include_once "Include/footer.php"; 
?>

