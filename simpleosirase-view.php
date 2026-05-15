<div class="oshirase">
	<?php if ( $info->title ) : ?>
		<?php echo '<' . esc_attr($info->title_tag) . '>' . esc_html($info->title) . '</' . esc_attr($info->title_tag) . '>'; ?>
	<?php endif; ?>

	<hr/>
	<?php foreach ( $info->items as $item ) : ?>
	<dl>
		<a href="<?php echo esc_url($item->url); ?>">
			<dt><?php echo esc_html($item->date); ?></dt>
			<dd>
				<?php if ( $item->newmark ) : ?>
				<span class="newmark">NEW!</span>
				<?php endif; ?>
				<?php echo esc_html($item->title); ?>
			</dd>
		</a>
	</dl>
	<hr/>
	<?php endforeach; ?>

	<?php if ( $info->pagination_enabled && $info->total_pages > 1 ) : ?>
	<nav class="oshirase-pagination">
		<?php if ( $info->current_page > 1 ) : ?>
			<a class="oshirase-prev" href="<?php echo esc_url( add_query_arg('sos_page', $info->current_page - 1, get_permalink()) ); ?>">&#8592; 前へ</a>
		<?php endif; ?>
		<span class="oshirase-page-info"><?php echo esc_html($info->current_page); ?> / <?php echo esc_html($info->total_pages); ?></span>
		<?php if ( $info->current_page < $info->total_pages ) : ?>
			<a class="oshirase-next" href="<?php echo esc_url( add_query_arg('sos_page', $info->current_page + 1, get_permalink()) ); ?>">次へ &#8594;</a>
		<?php endif; ?>
	</nav>
	<?php endif; ?>
</div>
