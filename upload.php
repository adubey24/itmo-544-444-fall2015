<?php
session_start();
include 'header.php';
?>
</p></p>
<?php
require 'vendor/autoload.php';
require 'resources/library/db.php';
if(isReadOnlyMode()) {
?>

<h3 center> Read Only Mode has been enabled. Photo uploads are temporarily disabled. You can still view the gallery. <br/>
Please click <a href="gallery.php">here</a> to navigate to the Gallery or use navigation menu to navigate to any other location</h3>

<?php
} else {
?>

<form enctype="multipart/form-data" action="result.php" method="POST">
	<div class="row">
		<div class="small-8 columns">
			<div class="small-3 columns">
				<label for="userfile">Select file to Upload</label>
			</div>
			<div class="small-9 columns">
				<input type="file" id="userfile" name="userfile" placeholder="Choose File" />
			</div>
		</div>	
	</div>
	<div class="row">
        <div class="small-3 columns">
            <input class="button tiny" type="submit" value="Upload File" />
        </div>
    </div>
</form>

<?php
}
include 'footer.php';
?>
