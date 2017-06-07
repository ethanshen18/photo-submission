$(window).on("load resize", function(e){

	// make sure toggle text is correct on window resize
	setTimeout(changeToggleText, 350);

	// update lightbox width and height
	setLightboxSize($(window).width(), $(window).height());

	// adjust search bar size on window resize
	if (window.matchMedia('(max-width: 767px)').matches) $("#search-bar").css("width", "auto");
	else $("#search-bar").css("width", "120px");

	// image grid equal height
	if (!window.matchMedia('(max-width: 767px)').matches) {
		$(".approval-info").height("auto");
		var heights = $(".approval-info").map(function() {return $(this).height();}).get(),
		maxHeight = Math.max.apply(null, heights);
		$(".approval-info").height(maxHeight);
	} else $(".approval-info").height("auto");

	// change edit view button alignment
	if (!window.matchMedia('(max-width: 767px)').matches) {
		document.getElementsByClassName("btn-group btn-group-justified").className = "btn-group-vertical";
	} else {
		document.getElementsByClassName("btn-group-vertical").className = "btn-group btn-group-justified";
	}
}); // window on resize

// recalculate lightbox size on photo change
$("#lightbox-photo").on('load', function () {
	$(function(){setLightboxSize($(window).width(), $(window).height());});
}); // on photo change

// set back to top button visibility on scroll
window.onscroll = function() {backToTopVisibility()};

// update navbar toggle icon
$(document).click(function() {

	// change to close button
	if ($("#search-button").is(":visible")) $(".navbar-toggle").html("<i class='glyphicon glyphicon-remove'></i>");

	// change to default button
	setTimeout(changeToggleText, 350);
}); // window on click

// change search bar size on focus
$(".form-control").focus(function() {
	if (window.matchMedia('(max-width: 767px)').matches) $("#search-bar").css("width", "auto");
	else $("#search-bar").css("width", "200px");
}); $(".form-control").focusout(function() {
	if (window.matchMedia('(max-width: 767px)').matches) $("#search-bar").css("width", "auto");
	else $("#search-bar").css("width", "120px");
});

// add new get array variable to url
function addToURL(key, value) {
	key = encodeURI(key); value = encodeURI(value);
	var kvp = document.location.search.substr(1).split("&");
	var i = kvp.length; 
	var x;

	// format url
	while (i--) {
		x = kvp[i].split("=");
		if (x [0] == key) {
			x [1] = value;
			kvp [i] = x.join("=");
			break;
		} // if
	} // while

	// join keys and values together
	if (i < 0) kvp[kvp.length] = [key, value].join("=");

	// reload page
	document.location.search = kvp.join("&"); 
} // addToURL

// change navbar toggle icon when user expands it
function changeToggleText() {

	// change to default button
	if (!$("#search-button").is(":visible")) $(".navbar-toggle").html("<i class='glyphicon glyphicon-menu-hamburger'></i>");
} // changeToggleText

// display lightbox
function showLightbox(image, firstName, lastName, description) {

	// display but hide lightbox
	document.getElementById("lightbox-container").style.display = "block";
	document.getElementById("lightbox-container").style.opacity = 0;
	document.getElementById("lightbox-container").style.filter = "alpha(opacity=0)";

	// change image source
	document.getElementById("lightbox-photo").src = "uploads/" + image;

	// upload photo caption
	document.getElementById("lightbox-text").innerHTML = "<b style='font-size: 20px; line-height: 50px;'>" + firstName + " " + lastName + "</b><br>" + description;

	// set lightbox size and reveal lightbox
	$(function(){
		setLightboxSize($(window).width(), $(window).height());
		$("#lightbox-container").animate({opacity: 1}, 200);
	});
} // showLightbox

// close lightbox
function closeLightbox() {

	// hide lightbox
	document.getElementById("lightbox-container").style.display = "none";

	// remove lightbox image
	document.getElementById("lightbox-photo").src = "#";
} // closeLightbox

// calculate lightbox size
function setLightboxSize(width, height) {
	var lightbox = document.getElementById("lightbox");
	var photoContainer = document.getElementById("lightbox-photo-container");
	var caption = document.getElementById("lightbox-text");
	var photo = document.getElementById("lightbox-photo");
	var previous = document.getElementById("left-lightbox");
	var next = document.getElementById("right-lightbox");

	// calculate container size
	lightbox.style.width = width * 0.9 + "px";
	lightbox.style.height = height * 0.8 + "px";

	// center container on screen
	lightbox.style.marginLeft = (width - lightbox.offsetWidth) * 0.5 + "px";
	lightbox.style.marginTop = (height - lightbox.offsetHeight) * 0.5 + "px";

	// calculate photo size
	photoContainer.style.height = lightbox.offsetHeight - caption.offsetHeight + "px";

	// positioning previous & next buttons
	previous.style.left = 20 + "px";
	next.style.right = 20 + "px";
	previous.style.top = photoContainer.offsetHeight * 0.5 - 15 + "px";
	next.style.top = photoContainer.offsetHeight * 0.5 - 15 + "px";
} // setLightboxSize

// previous button in lightbox
function showPrevious() {

	// current gallery as json array
	var json = JSON.parse(document.getElementById("current-array").innerHTML);

	// go through jason array
	for (var i = 1; i < json.length; i++) {

		// display previous image
		if (json [i].fileToUpload == document.getElementById("lightbox-photo").src.replace(/^.*[\\\/]/, '')) {
			document.getElementById("lightbox-photo").src = "uploads/" + json [i - 1].fileToUpload;
			document.getElementById("lightbox-text").innerHTML = "<b style='font-size: 20px; line-height: 50px;'>" + json [i - 1].firstName + " " + json [i - 1].lastName + "</b><br>" + json [i - 1].description;
			return;
		} // if
	} // for
	//}); // json
} // showPrevious

// next button in lightbox
function showNext() {

	// current gallery as json array
	var json = JSON.parse(document.getElementById("current-array").innerHTML);

	// go through jason array
	for (var i = 0; i < json.length - 1; i++) {

		// display next image
		if (json [i].fileToUpload == document.getElementById("lightbox-photo").src.replace(/^.*[\\\/]/, '')) {
			document.getElementById("lightbox-photo").src = "uploads/" + json [i + 1].fileToUpload;
			document.getElementById("lightbox-text").innerHTML = "<b style='font-size: 20px; line-height: 50px;'>" + json [i + 1].firstName + " " + json [i + 1].lastName + "</b><br>" + json [i + 1].description;
			return;
		} // if
	} // for
} // showNext

// back to top animation
function topFunction() {
	$(document.body).animate({scrollTop: 0}, 500);
} // topFunction

// set back to top button visibility on scroll
function backToTopVisibility() {
	if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200)
		document.getElementById("back-to-top").style.display = "block";
	else document.getElementById("back-to-top").style.display = "none";
} // backToTopVisibility

// approve image button
function approveImage (src) {
	
	// use ajax to call delete image function
	$.ajax({
		url: "approveImage.php",
		data: { src: src },
		type: "GET",
		success: function(data){
			document.location.reload(true);
		} // success
	}); // ajax
} // approveImage

// delete image button
function deleteImage (src) {
	
	// delete confirmation
	if (confirm("Permanently Delete Image(s)?") == false) return;

	// use ajax to call delete image function
	$.ajax({
		url: "deleteImage.php",
		data: { src: src },
		type: "GET",
		success: function(data){
			document.location.reload(true);
		} // success
	}); // ajax
} // deleteImage

// approve multiple images at once
function approveSelection () {
	
	var checkArray = document.getElementsByClassName("check");
	var source = document.getElementsByName("checkBox");
	var array = new Array (checkArray.length);
	
	for (var i = 0; i < checkArray.length; i++){
		if(checkArray[i].checked){	
			for (var j = 0; j < array.length; j++){
				array[j] = source[i].value;
				alert(array[j]);
				break;
			} // for
		} // if
	} // for
	
	// use ajax to call delete image function
	$.ajax({
		url: "approveSelection.php",
		data: { src: array },
		type: "GET",
		success: function(data){
			document.location.reload(true);
			alert("hey!");
		} // success
	}); // ajax
} // approveSelection

// delete multiple images at once
function deleteSelection (){
	
	// delete confirmation
	if (confirm("Permanently Delete?") == false) return;
	
	var checkArray = document.getElementsByClassName("check");
	var source = document.getElementsByName("checkBox");
	var array = new Array (checkArray.length);
	
	for (var i = 0; i < checkArray.length; i++){
		if(checkArray[i].checked){	
			for (var j = 0; j < array.length; j++){
				array[j] = source[i].value;
				alert(array[j]);
				break;
			} // for
		} // if
	} // for
	
	// use ajax to call delete image unction
	$.ajax({
		url: "deleteSelection.php",
		data: { src: array },
		type: "GET",
		success: function(data){
			document.location.reload(true);
			alert("HOIIIIIII");
		} // success
	}); // ajax
} // deleteSelection

// deselect all
function closeNav(){
	document.getElementById("selection-navbar").style.display = "none";

	/////////deselect all

} // closeNav

// determines if the user checked on checkboxes or not 
function selected(){
	var isChecked = document.getElementsByClassName("check");
	var displayBar = document.getElementById("selection-navbar");
	
	for (var i = 0; i < isChecked.length; i++){
		if (isChecked[i].checked){
			displayBar.style.display = "block";
			break;
		} else displayBar.style.display = "none";
	} // for
} // modified