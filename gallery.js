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
	
	document.getElementById("download-button-lightbox").href = "uploads/" + image;
	
	document.getElementById("download-button-lightbox").download = firstName + " " + lastName;
	
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

	// prepare image name for ajax request
	var selected = [src];
	
	// use ajax to call delete image function
	$.ajax({
		url: "approve.php",
		data: { src: selected },
		type: "GET",
		success: function(data){
			document.location.reload(true);
		} // success
	}); // ajax
} // approveImage

// delete image button
function deleteImage (src) {
	
	// delete confirmation
	if (confirm("Permanently Delete Image?") == false) return;

	// prepare image name for ajax request
	var selected = [src];

	// use ajax to call delete image function
	$.ajax({
		url: "delete.php",
		data: { src: selected },
		type: "GET",
		success: function(data){
			document.location.reload(true);
		} // success
	}); // ajax
} // deleteImage

// select all
function selectAll(){

	// check all checkboxes
	var checkArray = document.getElementsByClassName("check");
	for (var i = 0; i < checkArray.length; i++) checkArray[i].checked = true;

	// update selection number
	selected();
} // selectAll

// deselect all
function deselectAll(){

	// hide selection navbar
	document.getElementById("selection-navbar").style.display = "none";

	// uncheck all checkboxes
	var checkArray = document.getElementsByClassName("check");
	for (var i = 0; i < checkArray.length; i++) checkArray[i].checked = false;
} // deselectAll

// determines if the user checked on checkboxes or not 
function selected(){
	var checkArray = document.getElementsByClassName("check");
	var displayBar = document.getElementById("selection-navbar");
	var displayedNumbers = document.getElementsByClassName("selection-count");
	var counter = 0; // number of selection

	// find number of selection
	for (var i = 0; i < checkArray.length; i++) if (checkArray[i].checked) counter++;

	// display number of selection
	if (counter != 0) {
		for (var i = 0; i < displayedNumbers.length; i++) displayedNumbers [i].innerHTML = counter;
		displayBar.style.display = "block";
	} else displayBar.style.display = "none";
} // modified

// approve multiple images at once
function approveSelection() {
	
	// load selected image names into array
	var checkArray = document.getElementsByClassName("check");
	var selected = [];
	for (var i = 0; i < checkArray.length; i++) if(checkArray[i].checked) selected.push(checkArray[i].value);
	
	// use ajax to call delete image function
	$.ajax({
		url: "approve.php",
		data: { src: selected },
		type: "GET",
		success: function(data) {
			document.location.reload(true);
		} // success
	}); // ajax
} // approveSelection

// delete multiple images at once
function deleteSelection(){

	// load selected image names into array
	var checkArray = document.getElementsByClassName("check");
	var selected = [];
	for (var i = 0; i < checkArray.length; i++) if(checkArray[i].checked) selected.push(checkArray[i].value);

	// delete confirmation
	if (confirm("Permanently Delete All "+ selected.length +" Images?") == false) return;
	
	// use ajax to call delete image function
	$.ajax({
		url: "delete.php",
		data: { src: selected },
		type: "GET",
		success: function(data) {
			document.location.reload(true);
		} // success
	}); // ajax
} // deleteSelection

// allows user to edit info of the edit box
function editInfo(original) {
	var edit = document.getElementsByClassName(original);
	var buttonGroup = document.getElementsByClassName("btn-group btn-group-justified");
	var saveButton = document.getElementsByClassName("btn btn-success btn-block");
	var editorGrid = document.getElementsByClassName("editor-grid");
	var checkBox = document.getElementsByClassName("check");
	
	// enable current input fields
	for (var i = 0; i < edit.length; i++) edit[i].disabled = false;
	
	// disable other grids
	for (var i = 0; i < editorGrid.length; i++){
		if (editorGrid[i].getAttribute("value") != original){
			editorGrid[i].style.pointerEvents = "none"; 
			editorGrid[i].style.opacity = "0.5";
		} else checkBox[i].disabled = true;	
	} // for
	
	// show save button 
	for (var i = 0; i < buttonGroup.length; i++){
		if (buttonGroup[i].getAttribute("value") == original){
			buttonGroup[i].style.display = "none";
			saveButton[i].style.display = "block";
		} // if
	} // for

} // editInfo

// enable other girds and hide save button
function save(original) {

	// get edited info
	var newFirstName = document.getElementById(original + "-firstName").value;
	var newLastName = document.getElementById(original + "-lastName").value;
	var newDescription = document.getElementById(original + "-description").value;
	var newTags = document.getElementById(original + "-tags").value;

	// use ajax to modify json
	$.ajax({
		url: "modify.php",
		data: {
			target: original,
			firstName: newFirstName,
			lastName: newLastName,
			description: newDescription,
			tags: newTags
		},
		type: "GET",
		success: function(data) {
			document.location.reload(true);
		} // success
	}); // ajax
} // save