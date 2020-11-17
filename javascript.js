var modal = document.getElementById("UploadModal");

// Get the button that opens the modal
var btn = document.getElementById("UploadBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

var bool = false;

function redirect(){
	window.location="edit_inventory.php";
}

// When the user clicks on the button, open the modal
function btnOnclick(){
	modal.style.display = "block";
}

function uploadMenu(){
	var ftitle = document.getElementById("ftitle").value;
	var fdesc = document.getElementById("fdesc").value;
	var fprice = document.getElementById("fprice").value;
}

function myAjax(e)
{
	alert("Successfully Deleted!");
	$.ajax({
		type: "POST",
		url:'ajax.php',
		data:{id:e},
		success:function(html){
			
			location.reload();
		}
	});
}

// order Management
function deleteData(e){
	alert("Successfully Deleted!");
	var extract_orderid = e.substring(0, e.indexOf(":"));
	var extract_productid = e.substring(e.indexOf(":")+1);
	$.ajax({
		type: "POST",
		url:'ajax.php',
		data:{orderid:extract_orderid, productid:extract_productid},
		success:function(html){	
			location.reload();
		}
	});
}

// cart
function deleteCartData(e){
	alert("Successfully Deleted!");
	$.ajax({
		type: "POST",
		url:'ajax.php',
		data:{cart:e},
		success:function(html){			
			location.reload();
		}
	});
}

// order Management
//connect to the edit_order page from orderManagement
function editSortOrder(e){
	alert("Payment Status Updated.");
	var extract_orderid = e.substring(e.indexOf("-")+1, e.indexOf(":"));
	var extract_productid = e.substring(e.indexOf(":")+1);
	$.ajax({
		type: "POST",
		url:'ajax.php',
		data:{editorderid:extract_orderid, editproductid:extract_productid},
		success:function(html){
			
			location.reload();
		}
	});
}

/** Hide and show hidden order table **/
function showDetails(e){
	if(bool==false){
		var extract_hiddenId = e.substring(e.indexOf(":")+1);
		document.getElementById(extract_hiddenId).style.display="block";
		document.getElementById(e).innerHTML="Show Less";
		bool=true;
	}else{
		var extract_hiddenId = e.substring(e.indexOf(":")+1);
		document.getElementById(extract_hiddenId).style.display="none";
		document.getElementById(e).innerHTML="Show More";
		bool=false;
	}	
}




function edit_onclick(e)
{
	var edit_btn = document.getElementById(e);
	var done_id = 'd' + e;
	var done_btn = document.getElementById(done_id);
	
	var extract_id = e.substring(4);
	var fd_title = document.getElementById('fd_title'+ extract_id);
	var fd_title_content = document.getElementById('title_'+ extract_id);
	fd_title_content.innerHTML = "";
	fd_title.type = "text";
	fd_title.style.width = "100%";
	
	var fd_desc = document.getElementById('fd_desc'+ extract_id);
	
	var fd_price = document.getElementById('fd_price'+ extract_id);
	var fd_price_content = document.getElementById('price_'+ extract_id);
	
	fd_desc.readOnly = false;
	fd_desc.style.border = "1px solid black";
	
	fd_price_content.innerHTML = "";
	fd_price.type = "text";
	fd_price.style.width = "100%";
	
	var fd_initialPrice = document.getElementById('fd_iprice' + extract_id);
	var fd_initialPrice_content = document.getElementById('iprice_' + extract_id);
	
	fd_initialPrice_content.innerHTML = "";
	fd_initialPrice.type = "text";
	fd_initialPrice.style.width = "100%";
	
	var fd_stock = document.getElementById('fd_stock' + extract_id);
	var fd_stock_content = document.getElementById('stock_' + extract_id);
	
	fd_stock_content.innerHTML = "";
	fd_stock.type = "text";
	fd_stock.style.width = "100%";
	
	
	var handle = document.getElementsByClassName("fd_content");
	for(var i = 0;i < handle.length;i++){
		handle[i].style.width = "30%";
	}
	
	edit_btn.style.display = 'none';
	done_btn.style.visibility = 'visible';
	
}

function done_onclick(e)
{
	alert("Successfully Updated!");
	var done_btn = document.getElementById(e);
	var edit_id = e.substring(1);
	var edit_btn = document.getElementById(edit_id);
	
	var extract_id = e.substring(5);
	var fd_title = document.getElementById('fd_title'+ extract_id);
	var fd_title_content = document.getElementById('title_'+ extract_id);
	
	var fd_desc = document.getElementById('fd_desc'+ extract_id);
	
	var fd_price = document.getElementById('fd_price'+ extract_id);
	var fd_price_content = document.getElementById('price_'+ extract_id);
	
	var fd_initialPrice = document.getElementById("fd_iprice" + extract_id);
	var fd_initialPrice_content = document.getElementById("iprice_" + extract_id);
	
	var fd_stock = document.getElementById("fd_stock" + extract_id);
	var fd_stock_content = document.getElementById("stock_" + extract_id);
	
	
	fd_title_content.innerHTML = fd_title.value;
	fd_title.type = "hidden";
	
	fd_desc.readOnly = true;
	fd_desc.style.border = "hidden";
	
	fd_price_content.innerHTML = 'RM' + parseFloat(fd_price.value).toFixed(2);
	fd_price.type = "hidden";
	
	fd_initialPrice_content.innerHTML = 'RM' + parseFloat(fd_initialPrice.value).toFixed(2);
	fd_initialPrice.type = "hidden";
	
	fd_stock_content.innerHTML = fd_stock.value;
	fd_stock.type = "hidden";
	
	var handle = document.getElementsByClassName("fd_content");
	for(var i = 0;i < handle.length;i++){
		handle[i].style.width = "30%";
	}
	
	edit_btn.style.display = 'block';
	done_btn.style.visibility = 'hidden';
	
	$.ajax({
		type: "POST",
		url:'ajax.php',
		data:{title: fd_title.value, desc: fd_desc.value, price: fd_price.value, menuid: extract_id, initialPrice: fd_initialPrice.value, stock: fd_stock.value},
		success:function(html){
			location.reload();
		}
	});	
}

function menuFunction(e)
{
	var x = e.substr(11);
	
	$.ajax({
		type: "POST",
		url:'ajax.php',
		data:{product: x},
		success:function(html){
			window.location.href = "product-details.php";
		}
	});
}

function displayOnlineBanking(){
	document.getElementById("onlineBanking").style.display="block";
	document.getElementById("qrCode").style.display="none";
	document.getElementById("onDelivery").style.display="none";
}

function displayQrCode(){
	document.getElementById("onlineBanking").style.display="none";
	document.getElementById("qrCode").style.display="block";
	document.getElementById("onDelivery").style.display="none";
}


function displayOnDelivery(){
	document.getElementById("onlineBanking").style.display="none";
	document.getElementById("qrCode").style.display="none";
}

var loadFile = function(event){
	var image = document.getElementById('upload_img');
	var image_content = document.getElementById('upload_content');
	var browse = document.getElementById('myfile');
	image.src= URL.createObjectURL(event.target.files[0]);
	image.style.opacity = 1;
	image.style.width = "318px";
	image.style.height = "280px";
	image.style.marginLeft = "-15px";
	image.style.marginTop = "-25px";
	image_content.style.display = "none";
	browse.style.paddingTop = "20px";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
