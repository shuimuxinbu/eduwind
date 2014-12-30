<?php foreach($posts as $post): ?>
<div class="posts" id="c<?php echo $post->id; ?>">

	<div class="author">
		<?php echo $post->userId; ?> says:
	</div>

	<div class="time">
		<?php echo date('F j, Y \a\t h:i a',$post->create_time); ?>
	</div>

	<div class="title">
	<?php echo CHtml::link(CHtml::encode($post->title), $post->getUrl()); ?>
		
	</div>

</div><!-- comment -->
<?php endforeach; ?>