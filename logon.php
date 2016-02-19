<?php
include 'header.php';
?>
</p></p>
<form enctype="multipart/form-data" action="createsession.php" method="POST">
	<div class="row">
		<div class="small-8 columns">
			<div class="small-3 columns">
				<label for="username">User Id*</label>
			</div>
			<div class="small-9 columns">
				<input type="text" id="username" name="username" placeholder="Enter Your User Name" />
			</div>
		</div>	
	</div>
    <div class="row">
		<div class="small-8 columns">
			<div class="small-3 columns">
				<label for="useremail">Email*</label>
			</div>
			<div class="small-9 columns">
				<input type="text" id="useremail" name="useremail" placeholder="Enter Your Email Address" />
			</div>
		</div>
	</div>
    <div class="row">
		<div class="small-8 columns">
			<div class="small-3 columns">
				<label for="phone">Phone*</label>
			</div>
			<div class="small-9 columns">
				<input type="text" id="phone" name="phone" placeholder="Enter Your Phone Number" />
			</div>
		</div>
    </div>
    <div class="row">
        <div class="small-3 columns">
            <input class="button" type="submit" value="Logon" />
        </div>
    </div>
</form>
<?php
include 'footer.php';
?>
