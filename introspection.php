<?php
include 'header.php';
?>
<form enctype="multipart/form-data" action="backupdb.php" method="POST">
	<div class="row">
		<div class="large-6 columns">
			<div class="large-4 columns">
				<label for="dbBackup">Click here to backup the database</label>
			</div>
		</div>	
	</div>
    
    <div class="row">
        <div class="small-3 columns">
            <input class="button tiny" id="dbBackup" type="submit" value="Backup Database" />
        </div>
    </div>
</form>
</p></p></p>
<form enctype="multipart/form-data" action="togglereadonlymode.php" method="POST">
	<div class="row">
		<div class="large-6 columns">
			<div class="large-4 columns">
				<label for="readonly">Click here to toggle Read Only Mode</label>
			</div>
		</div>	
	</div>
    
    <div class="row">
        <div class="small-3 columns">
            <input class="button tiny" id="readonly" type="submit" value="Toggle Mode" />
        </div>
    </div>
</form>
<?php
include 'footer.php';
?>
