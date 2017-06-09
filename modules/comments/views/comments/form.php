<h2><?php echo $legend ?></h2>
<?php echo Form::open() ?> 

<?php echo isset($errors['name']) ? '<p class="error">'.$errors['name'].'</p>' : ''; ?> 
<p>
	<?php echo $comment->labels('name') ?> 
	
</p>

<?php echo isset($errors['email']) ? '<p class="error">'.$errors['email'].'</p>' : ''; ?> 
<p>
	<?php echo $comment->labels('email') ?> 
	
</p>

<?php echo isset($errors['url']) ? '<p class="error">'.$errors['url'].'</p>' : ''; ?> 
<p>
	<?php echo $comment->labels('url') ?> 
	
</p>


<p class="submit">
	<?php echo Form::submit('submit', $submit) ?> 
</p>
<?php echo Form::close() ?> 
