<?php
session_start();
//call the FPDF library
require 'fpdf17/fpdf.php';
require 'Include/dtb.php';

$id = $_SESSION['orderID'];
$dis = $_SESSION['disAmount'];
$final = $_SESSION['total'];

$count = mt_rand(000001,999999);
//A4 width : 219mm
//default margin : 10mm each side
//writable horizontal : 219-(10*2)=189mm

//create pdf object
$pdf = new FPDF('P','mm','A4');
//add new page
$pdf->AddPage();

//set font to arial, bold, 14pt
$pdf->SetFont('Arial','B',14);

//Cell(width , height , text , border , end line , [align] )

$pdf->Cell(130 ,5,'FOOD EDGE GOURMET CATERING',0,0);
$pdf->Cell(59 ,5,'Receipt',0,1);//end of line

//set font to arial, regular, 12pt
$pdf->SetFont('Arial','',12);

$pdf->Cell(130 ,5,'No. 32 Ground Floor Tabuan Stutong Comm Centre,',0,0);
$pdf->Cell(59 ,5,'',0,1);//end of line

$pdf->Cell(130 ,5,'Jln Setia Raja, Kuching, Sarawak',0,0);
$pdf->Cell(25 ,5,'Date',0,0);
$pdf->Cell(34 ,5,'['.date('Y-m-d').']',0,1);//end of line

$pdf->Cell(130 ,5,'Phone [+6012-3456789]',0,0);
$pdf->Cell(25 ,5,'Receipt No #',0,0);
$pdf->Cell(34 ,5,'['.$count.']',0,1);//end of line

$pdf->Cell(130 ,5,'Email [foodedgegourmetcatering@gmail.com]',0,0);
$pdf->Cell(25 ,5,'User ID',0,0);
$pdf->Cell(34 ,5,'['.sprintf("%06s",$_SESSION['uid']).']',0,1);//end of line

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189 ,10,'',0,1);//end of line

//billing address
$pdf->Cell(100 ,5,'Bill to',0,1);//end of line

//add dummy cell at beginning of each line for indentation
$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,$_SESSION['username'],0,1);

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,$_SESSION['address'],0,1);

$pdf->Cell(10 ,5,'',0,0);
$pdf->Cell(90 ,5,$_SESSION['phoneno'],0,1);

//make a dummy empty cell as a vertical spacer
$pdf->Cell(189 ,10,'',0,1);//end of line

//invoice contents
$pdf->SetFont('Arial','B',12);

$pdf->Cell(8 ,5,'No',1,0);
$pdf->Cell(100 ,5,'Product',1,0);
$pdf->Cell(25 ,5,'Price (RM)',1,0);
$pdf->Cell(25 ,5,'Quantity',1,0);
$pdf->Cell(30 ,5,'Subtotal',1,1);//end of line

$pdf->SetFont('Arial','',12);

$count = 1;
$tempSum = 0;
$price = 0;
$total = 0;
//Numbers are right-aligned so we give 'R' after new line parameter
//display all information based on userID
	$sql = 'SELECT *
			FROM orderdb
			JOIN orderdetailsdb
			ON orderdb.orderID = orderdetailsdb.orderID
			JOIN productdb
			ON productdb.productID = orderdetailsdb.productID
			WHERE (orderdb.orderID = ?);';
	$stmt = mysqli_stmt_init($conn);
	if(!mysqli_stmt_prepare($stmt,$sql)){
		echo '<script type="text/javascript">
						alert("SQL statement Error.");
					</script>';
	}else{
		mysqli_stmt_bind_param($stmt, 'i', $id);
		mysqli_stmt_execute($stmt);
		$result = mysqli_stmt_get_result($stmt);
		$totalAmount = 0;
		while($row = mysqli_fetch_assoc($result)){
			$pdf->Cell(8 ,5,$count,1,0);
			$pdf->Cell(100 ,5,$row["name"],1,0);
			$pdf->Cell(25 ,5,$row["price"],1,0);
			$pdf->Cell(25 ,5,$row["quantity"],1,0);
			$pdf->Cell(30 ,5,$row["subtotal"],1,1,"R");
			$totalAmount = $row['totalAmount'];
			$count++;
		}
		
	}
//summary
$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(20 ,5,'Subtotal',0,0);
$pdf->Cell(8 ,5,'RM',1,0);
$pdf->Cell(30 ,5,$totalAmount,1,1,'R');//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(20 ,5,'Discount',0,0);
$pdf->Cell(8 ,5,'RM',1,0);
$pdf->Cell(30 ,5,$dis,1,1,'R');//end of line

$pdf->Cell(130 ,5,'',0,0);
$pdf->Cell(20 ,5,'Total',0,0);
$pdf->Cell(8 ,5,'RM',1,0);
$pdf->Cell(30 ,5,$final,1,1,'R');//end of line

//output the result
$pdf->Output('Receipt/receipt.pdf','F');
?>