var modal = document.getElementById("UploadModal");

// Get the button that opens the modal
var btn = document.getElementById("UploadBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

//Bool value to show hidden order table
var bool=false;

function redirect(){
	window.location="edit_inventory.php";
}

function redirectAltPage(){
	window.location="order_alt.php";
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
	$.ajax({
		type: "POST",
		url:'ajax.php',
		data:{id:e},
		success:function(html){
			alert(html);
			location.reload();
		}
	});
}


function deleteData(e){
	var extract_orderid = e.substring(0, e.indexOf(":"));
	var extract_productid = e.substring(e.indexOf(":")+1);
	$.ajax({
		type: "POST",
		url:'ajax.php',
		data:{orderid:extract_orderid, productid:extract_productid},
		success:function(html){
			alert(html);
			location.reload();
		}
	});
}

//connect to the edit_order page from orderManagement
function editSortOrder(e){
	alert("Succesfully Added");
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

function editOrder(e){
	// Get the modal
	var modal = document.getElementById("myModal");

	// Get the button that opens the modal
	var btn = document.getElementById("myBtn");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks the button, open the modal 
	btn.onclick = function() {
	  modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
	  modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
	  if (event.target == modal) {
		modal.style.display = "none";
	  }
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
	var fd_desc_content = document.getElementById('desc_'+ extract_id);
	
	var fd_price = document.getElementById('fd_price'+ extract_id);
	var fd_price_content = document.getElementById('price_'+ extract_id);
	
	
	fd_desc_content.innerHTML = "";
	fd_desc.type = "text";
	fd_desc.style.width = "100%";
	
	fd_price_content.innerHTML = "";
	fd_price.type = "text";
	fd_price.style.width = "100%";
	
	var handle = document.getElementsByClassName("fd_content");
	for(var i = 0;i < handle.length;i++){
		handle[i].style.width = "30%";
	}
	
	edit_btn.style.display = 'none';
	done_btn.style.visibility = 'visible';
	
}

function done_onclick(e)
{
	var done_btn = document.getElementById(e);
	var edit_id = e.substring(1);
	var edit_btn = document.getElementById(edit_id);
	
	var extract_id = e.substring(5);
	var fd_title = document.getElementById('fd_title'+ extract_id);
	var fd_title_content = document.getElementById('title_'+ extract_id);
	
	var fd_desc = document.getElementById('fd_desc'+ extract_id);
	var fd_desc_content = document.getElementById('desc_'+ extract_id);
	
	var fd_price = document.getElementById('fd_price'+ extract_id);
	var fd_price_content = document.getElementById('price_'+ extract_id);
	
	fd_title_content.innerHTML = fd_title.value;
	fd_title.type = "hidden";
	
	fd_desc_content.innerHTML = fd_desc.value;
	fd_desc.type = "hidden";
	
	fd_price_content.innerHTML = 'RM' + parseFloat(fd_price.value).toFixed(2);
	fd_price.type = "hidden";
	
	var handle = document.getElementsByClassName("fd_content");
	for(var i = 0;i < handle.length;i++){
		handle[i].style.width = "30%";
	}
	
	edit_btn.style.display = 'block';
	done_btn.style.visibility = 'hidden';
	
	$.ajax({
		type: "POST",
		url:'ajax.php',
		data:{title: fd_title.value, desc: fd_desc.value, price: fd_price.value, menuid: extract_id},
		success:function(html){
			alert(html);
			location.reload();
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
	document.getElementById("onDelivery").style.display="block";
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

var loadFile = function(event){
	var image = document.getElementById('upload_img');
	var image_content = document.getElementById('upload_content');
	var browse = document.getElementById('myfile');
	image.src= URL.createObjectURL(event.target.files[0]);
	image.style.opacity = 1;
	image.style.width = "318px";
	image.style.height = "175px";
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
