<?php
/**
 * The template for displaying the list of comments and the comment form.
 *
 * @package HelloElementor
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! post_type_supports( get_post_type(), 'comments' ) ) {
	return;
}

if ( ! have_comments() && ! comments_open() ) {
	return;
}

// Comment Reply Script.
if ( comments_open() && get_option( 'thread_comments' ) ) {
	wp_enqueue_script( 'comment-reply' );
}
?>
<section id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="title-comments">
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				printf( esc_html_x( 'One Response', 'comments title', 'hello-elementor' ) );
			} else {
				printf(
					/* translators: %s: Number of comments. */
					esc_html(
						_nx(
							'%s Response',
							'%s Responses',
							$comments_number,
							'comments title',
							'hello-elementor'
						)
					),
					esc_html( number_format_i18n( $comments_number ) )
				);
			}
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				[
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 42,
				]
			);
			?>
		</ol>

		<?php the_comments_navigation(); ?>

	<?php endif; ?>

<?php
$comment_args = [
    'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title">',
    'title_reply_after'  => '</h2>',
    'comment_field'      => '<textarea class="comment-textarea" name="comment" placeholder="متن نظر خود را وارد کنید..." required></textarea>',
    'class_submit'       => 'submit-btn',
];

// اگر یوزر لاگین نیست
if (!is_user_logged_in()) {
    $comment_args['fields'] = [
        'author' => '<div class="input-group">
                        <input id="author" name="author" type="text" placeholder="نام و نام خانوادگی" required />
                        <input id="email" name="email" type="email" placeholder="آدرس ایمیل" required />
                        <button name="submit" type="submit" id="submit" class="submit-btn">ارسال نظر</button>
                     </div>',
        'email' => ''
    ];
    // جلوگیری از دکمه دوم: دکمه پیش‌فرض وردپرس رو حذف کن
    $comment_args['submit_button'] = ''; 
} else {
    // برای کاربر لاگین، از دکمه پیش‌فرض استفاده کن
    $comment_args['submit_button'] = '<button name="submit" type="submit" id="submit" class="submit-btn">ارسال نظر</button>';
}

comment_form($comment_args);
?>



</section>
