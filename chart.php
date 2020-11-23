<!doctype html public "-//w3c//dtd html 3.2//en">
<html>

<head>
    <title>Bar Chart of Sales/profit</title>
    <style>


    </style>

    <!--    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
-->
</head>



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


<h2 style="text-align:center">Food Edge: Month-wise Profit vs Sales information for year: &nbsp;<?php echo $year; ?></h2>
<h4> Use the below list to filter by the year: </h4>

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

<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
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

<div id="control1"></div>
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
        /*
                var yearPicker = new google.visualization.ControlWrapper({
                    'controlType': 'CategoryFilter',
                    'containerId': 'control1',
                    'options': {
                        'filterColumnLabel': 'Month',
                        'ui': {
                            'labelStacking': 'vertical',
                            'allowTyping': false,
                            'allowMultiple': false,
                            'allowNone': false
                        }
                    },
                    'state': {
                        selectedValues: ['October']
                    }
                });
        */
        var chart = new google.charts.Bar(document.getElementById('chart_div'));
        chart.draw(data, options);
    }

</script>
</body>

</html>
