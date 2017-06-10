<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport">
		<title>Grad 2018 Baby Photo</title>
		<link rel="shortcut icon" type="image/ico" href="images/baby.ico">

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script>window.jQuery || document.write('<script src="libraries/googleJQuery.js"><\/script>')</script>

		<link rel="stylesheet" href="gallery.css">
		<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	</head>
	<body ontouchstart>
		<div class="container-fluid" id="navigation">
			<div class="navbar-header">
				<button class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
					<i class="glyphicon glyphicon-menu-hamburger"></i>
				</button>
				<a href="index.php" id="site-name"><i class="glyphicon glyphicon-picture"></i> GRAD BABY PHOTO</a>
			</div>
			<div class="collapse navbar-collapse" id="myNavbar">
				<form class="navbar-form navbar-right"  method="post">
					<a href="form.php" class="btn btn-success" role="button" id="upload-button" <?php if ($isEditor) echo "style='display: none'"; ?>>Upload</a>

					<div class="input-group" id="search-bar">
						<input type="search" class="form-control" name="search" placeholder="Search" maxlength="50">
						<div class="input-group-btn"><button class="btn btn-default" type="submit" name="submit" value="submit" id="search-button"><i class="glyphicon glyphicon-search"></i></button></div>
					</div>

					<div class="btn-group">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-sort"></i> <span class="caret"></span></span>
						</button>
						<ul class="dropdown-menu">
							<li><a href="#" onclick="addToURL('sort', 'default');return false;"><i class="glyphicon glyphicon-sort-by-attributes"></i> Upload Date</a></li>
							<li><a href="#" onclick="addToURL('sort', 'firstName');return false;"><i class="glyphicon glyphicon-sort-by-alphabet"></i> First Name</a></li>
							<li><a href="#" onclick="addToURL('sort', 'lastName');return false;"><i class="glyphicon glyphicon-sort-by-alphabet"></i> Last Name</a></li>
						</ul>
					</div>

					
					<div class="btn-group" <?php if (!$isEditor) echo "style='display: none'"; ?>>
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="glyphicon glyphicon-eye-open"></i> <span class="caret"></span></span>
						</button>
						<ul class="dropdown-menu">
							<li><a href="#" onclick="addToURL('display', 'all');return false;"><i class="glyphicon glyphicon-globe"></i> Display All</a></li>
							<li><a href="#" onclick="addToURL('display', 'public');return false;"><i class="glyphicon glyphicon-user"></i> Display Public</a></li>
							<li><a href="#" onclick="addToURL('display', 'private');return false;"><i class="glyphicon glyphicon-lock"></i> Display Private</a></li>
						</ul>
					</div>
				</form>
			</div>
		</div>
		
		<div class="container-fluid" id="selection-navbar">
			<div class="navbar-header">
				<button class="navbar-toggle" data-toggle="collapse">
				</button>
				<span id="selection-header"><i class="glyphicon glyphicon-check"></i> <span class="selection-count"></span> SELECTED</span>
			</div>
			<div class="collapse navbar-collapse">
				<div class="navbar-right">
					<button type="button" class="btn btn-success selection-button" onclick="approveSelection()" <?php if ($view != "approval") echo "style='display: none'"; ?>><i class="glyphicon glyphicon-ok"></i> Approve (<span class="selection-count"></span>)</button>
					<button type="button" class="btn btn-danger selection-button" onclick="deleteSelection()" <?php if ($view != "approval") echo "style='display: none'"; ?>><i class="glyphicon glyphicon-remove"></i> Reject (<span class="selection-count"></span>)</button>
					<button type="button" class="btn btn-danger selection-button" onclick="deleteSelection()" <?php if ($view != "edit") echo "style='display: none'"; ?>><i class="glyphicon glyphicon-trash"></i> Delete Selected (<span class="selection-count"></span>)</button>
					<button type="button" class="btn btn-default selection-button-black" onclick="selectAll();">Select All</button>
					<button type="button" class="btn btn-default selection-button-black" onclick="deselectAll();">Deselect All</button>
				</div>
			</div>
		</div>

		<div id="lightbox-container">
			<div id="lightbox">
				<div id="lightbox-photo-container">
					<img src="#" id="lightbox-photo">
					<a href="#" download="#" id="download-button-lightbox" <?php if (!$isEditor) echo "style='display: none'"; ?>><i class="glyphicon glyphicon-download"></i></a>
					<i class="glyphicon glyphicon-remove" id="close-lightbox" onclick="closeLightbox()"></i>
					<i class="glyphicon glyphicon-chevron-left" id="left-lightbox" onclick="showPrevious()"></i>
					<i class="glyphicon glyphicon-chevron-right" id="right-lightbox" onclick="showNext()"></i>
				</div>
				<div id="lightbox-text"></div>
			</div>
		</div>

		<button onclick="topFunction()" id="back-to-top">
			<i class="glyphicon glyphicon-menu-up"></i>
		</button>

		<div class="container-fluid" style="margin-top: 100px; min-height: 800px;">