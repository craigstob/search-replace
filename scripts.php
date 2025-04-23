<?php
add_action('init', function () {
	$search = 'http:\/\/localhost\/clifton';
	$replace = 'https:\/\/clifton.localjungle.website';

	// Get ALL post types including built-in + custom + internal
	$post_types = get_post_types([], 'names');

	foreach ($post_types as $post_type) {
		$posts = get_posts([
			'post_type' => $post_type,
			'post_status' => 'any',
			'posts_per_page' => -1,
		]);

		foreach ($posts as $post) {
			if (strpos($post->post_content, $search) !== false) {
				$new_content = str_replace($search, $replace, $post->post_content);

				wp_update_post([
					'ID' => $post->ID,
					'post_content' => $new_content,
				]);

				error_log("Updated {$post_type} ID: {$post->ID}");
			}
		}
	}
});
