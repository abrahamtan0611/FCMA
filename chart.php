<?Php
require 'Include/dtb.php';
require 'Include/header.php';
    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $year = $_POST['year'];
   // if (empty($year)) {
  //  $year = date("Y");
  //  } else {
 //   echo $year;
  //  }
    } else{
        $year = date("Y");
    }
 
    if($stmt = $conn->query("SELECT DATE_FORMAT(deliveryDate, '%M %Y'), (totalAmount-totalOriPrice) AS Profit, totalAmount AS Sales FROM orderdb WHERE (paymentStatus != 'pending' && YEAR(deliveryDate)= $year) GROUP BY YEAR(deliveryDate), MONTHNAME(deliveryDate) ORDER BY deliveryDate")) 
    {  
        
        

        
}else{
echo $conn->error;
}
    $php_data_array = Array(); 
while ($row = $stmt->fetch_row()) {
   $php_data_array[] = $row; 
   }


?>

<!--
<form method="post" action="<?php //echo $_SERVER['PHP_SELF'];?>">
    <input list="year" name="year">
    <datalist id="year">
        <option value="">Select Year</option>
        <option value="2016">2016</option>
        <option value="2017">2017</option>
        <option value="2018">2018</option>
        <option value="2019">2019</option>
        <option value="2020">2020</option>
    </datalist>
    <input type="submit">
</form>


-->
<section id="content">
<div class="replyFeedback-page" style="height:200%;">
<h3 class="feedback-h3">Food Edge: Month-wise Profit vs Sales information for year: &nbsp;<?php echo $year; ?></h3>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
	<h5> Use the below list to filter by the year: </h5>
    <?php
   $query = mysqli_query($conn, "SELECT DISTINCT YEAR(deliveryDate) AS year from orderDb");
   echo "<input type='search' name = 'year' list = 'year'/>";
    echo "<datalist id = 'year'>";
    while($row=mysqli_fetch_array($query))
{
    echo "<option>$row[year] </option>";
}
    echo"</datalist>";
?>
    <input type="submit">
</form>

<?php
    
echo "<script>
        var insights = ".json_encode($php_data_array)."
</script>";
?>

<div id="chart_div" style="height: 500px; position: relative; left:50%; transform: translateX(-50%);">div>
<br><br>
</div>
</section>


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
        for (i = 0; i < insights.length; i++)
            data.addRow([insights[i][0], parseInt(insights[i][1]), parseInt(insights[i][2])]);
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
</div>
<?php
	include_once "Include/footer.php"; 
?>