<?php defined('SYSPATH') or die('No direct access allowed.'); ?>

	<div class="control-group">
		<label class="control-label" for="<?php echo $field; ?>_field">
<?php
			echo __($labels[ $field ]), '&nbsp;:&nbsp;';
?>
		</label>
		<div class="controls">
			<span id="<?php echo $field; ?>" class="plaintext">
<?php 
			if ( ! empty($user['link'])) {
				echo HTML::anchor($user['link'], $user['name'], array(
					'target' => '_blank',
				));
			} else {
				echo $user['name'];
			}
?>
			</span>
		</div>
	</div>