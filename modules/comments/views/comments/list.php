<h2><?php echo $legend ?></h2>

<?php # echo $pagination ?> 

<?php foreach ($comments as $comment): ?>
<dl>
	<dt>Name:</dt>
	<dd><?php echo $comment->name ?></dd>
	<dt>Email:</dt>
	<dd><?php echo $comment->email ?></dd>
	<dt>URL:</dt>
	<dd><?php echo $comment->url ?></dd>
	<dt>Date:</dt>
	<dd><?php  echo $comment->date ?></dd>
	<dt>Text:</dt>
	<dd><?php echo $comment->text ?></dd>
</dl>
<?php endforeach ?>

<?php  #echo $pagination ?> 
