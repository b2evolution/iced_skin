<?php
/**
 * This is the main/default page template for the "custom" skin.
 *
 * This skin only uses one single template which includes most of its features.
 * It will also rely on default includes for specific dispays (like the comment form).
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://manual.b2evolution.net/Skins_2.0}
 *
 * The main page template is used to display the blog when no specific page template is available
 * to handle the request (based on $disp).
 *
 *
 * @version $Id: index.main.php,v 1.1 2008/04/15 17:52:15 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

if( version_compare( $app_version, '2.4.1' ) < 0 )
{
	die( 'This skin is designed for b2evolution 2.4.1 and above. Please <a href="http://b2evolution.net/downloads/index.html">upgrade your b2evolution</a>.' );
}

// This is the main template; it may be used to display very different things.
// Do inits depending on current $disp:
skin_init( $disp );


// -------------------------- HTML HEADER INCLUDED HERE --------------------------
skin_include( '_html_header.inc.php' );
// Note: You can customize the default HTML header by copying the generic
// /skins/_html_header.inc.php file into the current skin folder.
// -------------------------------- END OF HEADER --------------------------------
?>
<!--[if IE]><link rel="stylesheet" type="text/css" href="ie.css" /><![endif]-->
<div align="center">
<div id="skinwrap">
<div id="wrap">
	<div id="topnav">	
	<?php if ( true /* change to false to hide the blog list */ ) { ?>
				<?php
				  // START OF BLOG LIST
				  skin_widget( array(
						'widget' => 'colls_list_public',
						'block_start' => '',
						'block_end' => '',
						'block_display_title' => false,
						'list_start' => '<ul>',
						'list_end' => '</ul>',
						'item_start' => '<li>',
						'item_end' => '</li>',
						'item_selected_start' => '<span class="selected">',
						'item_selected_end' => '</span>',
					  ) );
				?>
				<?php } ?>
             		<?php
			// Display container and contents:
			skin_container( NT_('Page Top'), array(
					// The following params will be used as defaults for widgets included in this container:
					'block_start' => '<div class="$wi_class$">',
					'block_end' => '</div>',
					'block_display_title' => false,
					'list_start' => '<ul>',
					'list_end' => '</ul>',
					'item_start' => '<li>',
					'item_end' => '</li>',
				) );
		?>
    </div>
	<div id="header">
    	<div id="title">
	       <?php
				// ------------------------- "Header" CONTAINER EMBEDDED HERE --------------------------
				// Display container and contents:
				skin_container( NT_('Header'), array(
						// The following params will be used as defaults for widgets included in this container:
						'block_start'       => '<div class="description">',
						'block_end'         => '</div>',
						'block_title_start' => '<h1>',
						'block_title_end'   => '</h1>',
					) );
				// ----------------------------- END OF "Header" CONTAINER -----------------------------
			?>
        </div>
        <div id="topsearch">
	  <?php 
	  skin_widget( array(
		// CODE for the widget:
		'widget' => 'coll_search_form',
		// Optional display params
		'block_start' => '',
		'block_end' => '',
		'block_display_title' => false,
		'disp_search_options' => 0,
		'search_class' => 'extended_search_form',
		'use_search_disp' => 0,
	) );
	?>
        </div>
        <div id="pagenav">
          <ul>
                  <?php
					// ------------------------- "Menu" CONTAINER EMBEDDED HERE --------------------------
					// Display container and contents:
					// Note: this container is designed to be a single <ul> list
					skin_container( NT_('Menu'), array(
							// The following params will be used as defaults for widgets included in this container:
							'block_start'         => '',
							'block_end'           => '',
							'block_display_title' => false,
							'list_start'          => '',
							'list_end'            => '',
							'item_start'          => '<li>',
							'item_end'            => '</li>',
						) );
					// ----------------------------- END OF "Menu" CONTAINER -----------------------------
				?>
          </ul>
        </div>
    </div><!-- end of header -->
    <div id="main">
<?php
// ------------------------- SIDEBAR INCLUDED HERE --------------------------
skin_include( '_sidebar.inc.php' );
// Note: You can customize the default BODY footer by copying the
// _body_footer.inc.php file into the current skin folder.
// ----------------------------- END OF SIDEBAR -----------------------------
?>
    <div id="content">
      <?php
	// ------------------------- MESSAGES GENERATED FROM ACTIONS -------------------------
	messages( array(
			'block_start' => '<div class="action_messages">',
			'block_end'   => '</div>',
		) );
	// --------------------------------- END OF MESSAGES ---------------------------------
	?>


	
	<?php	// ---------------------------------- START OF POSTS --------------------------------------
		// Display message if no post:
		display_if_empty();

		while( $Item = & mainlist_get_item() )
		{	// For each blog post, do everything below up to the closing curly brace "}"
		?>



			<div id="<?php $Item->anchor_id() ?>" lang="<?php $Item->lang() ?>">
			<div class="post">
			<?php
				$Item->locale_temp_switch(); // Temporarily switch to post locale (useful for multilingual blogs)
			?>
		<div class="date">
        <?php
		$Item->issue_time( array(
		'time_format' => 'j',
		) );
		?>

        <div>
			<?php
			$Item->issue_time( array(
			'time_format' => 'M',
			) );
			?>
        </div>
		</div>
        <div class="entry">
        <h1><a href="<?php $Item->permanent_url() ?>" title="<?php echo T_('Permanent link to full entry') ?>"></a>
				<?php $Item->title(); ?>
			</h1>

			
				<?php
					// ---------------------- POST CONTENT INCLUDED HERE ----------------------
					skin_include( '_item_content.inc.php' );
					// Note: You can customize the default item feedback by copying the generic
					// /skins/_item_feedback.inc.php file into the current skin folder.
					// -------------------------- END OF POST CONTENT -------------------------
				?>
            

				<div class="postmetadata">
				<?php
					$Item->issue_time( array(
							'before'      => /* TRANS: time */ T_('Posted at '),
						) );
				?>
				<?php
					$Item->categories( array(
						'before'          => ' '.T_('and is filed under').' ',
						'after'           => '.',
						'include_main'    => true,
						'include_other'   => true,
						'include_external'=> true,
						'link_categories' => true,
					) );
				?>

				<?php
					// List all tags attached to this post:
					$Item->tags( array(
							'before' =>         ' '.T_('Tags').': ',
							'after' =>          ' ',
							'separator' =>      ', ',
						) );
				?>

				<!-- You can follow any responses to this entry through the RSS feed. -->
				<?php
					$Item->edit_link( array( // Link to backoffice for editing
							'before'    => '',
							'after'     => '',
						) );
				?>
				</div>

 </div>
<img src="images/spacer.gif" alt="free b2evolution skin" width="600" height="1" />			
			<?php
				// ------------------ FEEDBACK (COMMENTS/TRACKBACKS) INCLUDED HERE ------------------
				skin_include( '_item_feedback.inc.php', array(
						'before_section_title' => '<h4>',
						'after_section_title'  => '</h4>',
					) );
				// Note: You can customize the default item feedback by copying the generic
				// /skins/_item_feedback.inc.php file into the current skin folder.
				// ---------------------- END OF FEEDBACK (COMMENTS/TRACKBACKS) ---------------------
			?></div></div>

			<?php
				locale_restore_previous();	// Restore previous locale (Blog locale)
			?>

			

	<?php } // --------------------------------- END OF POSTS ----------------------------------- ?>


	<?php
		// -------------- MAIN CONTENT TEMPLATE INCLUDED HERE (Based on $disp) --------------
		skin_include( '$disp$', array(
				'disp_posts'  => '',		// We already handled this case above
				'disp_single' => '',		// We already handled this case above
				'disp_page'   => '',		// We already handled this case above
			) );
		// Note: you can customize any of the sub templates included here by
		// copying the matching php file into your skin directory.
		// ------------------------- END OF MAIN CONTENT TEMPLATE ---------------------------
	?>


	
	<div align="center">
		<?php
			// -------------------- PREV/NEXT PAGE LINKS (POST LIST MODE) --------------------
			mainlist_page_links( array(
					'block_start' => '<p class="center">',
					'block_end' => '</p>',
					'links_format' => '$prev$ :: $next$',
   				'prev_text' => '&lt;&lt; '.T_('Previous'),
   				'next_text' => T_('Next').' &gt;&gt;',
				) );
			// ------------------------- END OF PREV/NEXT PAGE LINKS -------------------------
		?>
	</div>
    </div><img src="images/spacer.gif" alt="free blog themes" height="1" width="900" />
    </div>
<?php
// ------------------------- BODY FOOTER INCLUDED HERE --------------------------
skin_include( '_body_footer.inc.php' );
// Note: You can customize the default BODY footer by copying the
// _body_footer.inc.php file into the current skin folder.
// ------------------------------- END OF FOOTER --------------------------------
?>
<?php

	$Hit->log();	// log the hit on this page

	debug_info(); // output debug info if requested

?>
    
</div><!-- end of wrap --></div>
</div>
</div><!-- end of center -->
</body>
</html>
