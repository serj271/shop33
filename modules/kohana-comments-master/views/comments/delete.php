<h2>Delete Comment</h2>
<p>
	Are you sure you want to delete this comment?
	This action cannot be undone.
</p>
<?php
	echo Form::open();
	echo Form::submit('yes', 'Yes');
	echo Form::submit('no', 'No');
	echo Form::close();
?>
