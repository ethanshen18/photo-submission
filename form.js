document.getElementById('fileToUpload').onchange = function () {
	document.getElementById('upload-button').innerHTML = this.value.replace(/^.*[\\\/]/, '');
	document.getElementById('upload-button').style = "background-color: white; color: #4BC970";
};