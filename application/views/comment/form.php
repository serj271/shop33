<h2><?php echo $legend ?></h2>
<?php echo Form::open('comment', array('method'=>'POST')) ?> 

<?php echo isset($errors['name']) ? '<p class="error">'.$errors['name'].'</p>' : ''; ?> 
<p>
	<?php echo $comment->label('name') ?> 
	<?php echo $comment->input('name') ?> 
</p>

<?php echo isset($errors['email']) ? '<p class="error">'.$errors['email'].'</p>' : ''; ?> 
<p>
	<?php echo $comment->label('email') ?> 
	<?php echo $comment->input('email') ?> 
</p>

<?php echo isset($errors['url']) ? '<p class="error">'.$errors['url'].'</p>' : ''; ?> 
<p>
	<?php echo $comment->label('url') ?> 
	<?php echo $comment->input('url') ?> 
</p>

<?php echo isset($errors['state']) ? '<p class="error">'.$errors['state'].'</p>' : ''; ?> 
<p>
	<?php echo $comment->label('state') ?> 
	<?php echo $comment->input('state') ?> 
</p>

<?php echo isset($errors['text']) ? '<p class="error">'.$errors['text'].'</p>' : ''; ?> 
<p>
	<?php echo $comment->label('text') ?> 
	<?php echo $comment->input('text') ?> 
</p>

<?php echo Form::hidden('token',Security::token()); ?>

<p class="submit">
	<?php echo Form::submit('submit', $submit) ?> 
</p>
<?php echo Form::close() ?> 
