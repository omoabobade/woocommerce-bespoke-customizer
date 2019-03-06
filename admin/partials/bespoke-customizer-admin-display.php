<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Bespoke_Customizer
 * @subpackage Bespoke_Customizer/admin/partials
 */
//require_once "../class-bespoke-customizer-admin.php";
$plugin = new Bespoke_Customizer();
$items = $plugin->fetchItems();
$item_id= $_GET['item_id'];
$category_id= $_GET['category_id']; 
if($category_id){
    $labels = $plugin->fetchLabels($category_id);
}
if($item_id){
    $categories = $plugin->fetchCategories($item_id);
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
<h1 class="wp-heading-inline">Items</h1>
<form name="selectorone" method="GET" >
    <input name="page" value="bespoke-customizer/admin/partials/bespoke-customizer-admin-display.php" type="hidden" />
    <select name="item_id" action="" onchange="selectorone.submit()">
        <option>Select an Item</option>
        <option value="1">New</option>
        <?php 
        foreach($items as $item){
            $selected = ($item->id == $item_id)? "selected": "";
            echo "<option "+$selected+" value="+$item->id+">"+ $item->title+"</option>";
        } 
        ?>
    </select>
    <a href="?page=bespoke-customizer/admin/partials/items.php" class="page-title-action">Add New </a>
    <select name="category_id" action="" onchange="selectorone.submit()">
        <option>Select a Category</option>
        <option value="1">New</option>
        <?php 
        foreach($categories as $category){
            $selected = ($category->id == $category_id)? "selected": "";
            echo "<option "+$selected+" value="+$category->id+">"+ $category->title+"</option>";
        } 
        ?>
    </select>
    <hr class="wp-header-end">
</form>


<h2 class="screen-reader-text">Filter posts list</h2><ul class="subsubsub">
	<li class="all"><a href="edit.php?post_type=post" class="current" aria-current="page">All <span class="count">(1)</span></a> |</li>
	<li class="publish"><a href="edit.php?post_status=publish&amp;post_type=post">Published <span class="count">(1)</span></a></li>
</ul>
<form id="posts-filter" method="get">



<input type="hidden" id="_wpnonce" name="_wpnonce" value="84fdbad147"><input type="hidden" name="_wp_http_referer" value="/wordpress/wp-admin/edit.php">	
<div class="tablenav top">
		<br class="clear">
</div>
<h2 class="screen-reader-text">Posts list</h2>
<table class="wp-list-table widefat fixed striped posts">
	<thead>
	<tr>
		<td id="cb" class="manage-column column-cb check-column">
            <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
            <input id="cb-select-all-1" type="checkbox">
        </td>
        <th scope="col" id="title" class="manage-column column-title column-primary sortable desc"><a href="http://localhost/wordpress/wp-admin/edit.php?orderby=title&amp;order=asc"><span>Title</span><span class="sorting-indicator"></span></a></th>
        <th scope="col" id="author" class="manage-column column-author">Author</th>
        <th scope="col" id="categories" class="manage-column column-categories">Categories</th>
        <th scope="col" id="tags" class="manage-column column-tags">Tags</th>
        <th scope="col" id="comments" class="manage-column column-comments num sortable desc"><a href="http://localhost/wordpress/wp-admin/edit.php?orderby=comment_count&amp;order=asc"><span><span class="vers comment-grey-bubble" title="Comments"><span class="screen-reader-text">Comments</span></span></span><span class="sorting-indicator"></span></a></th>
        <th scope="col" id="date" class="manage-column column-date sortable asc"><a href="http://localhost/wordpress/wp-admin/edit.php?orderby=date&amp;order=desc"><span>Date</span><span class="sorting-indicator"></span></a></th>	
    </tr>
	</thead>

	<tbody id="the-list">
		<tr id="post-1" class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
			<th scope="row" class="check-column">			
                <label class="screen-reader-text" for="cb-select-1">Select Hello world!</label>
			<input id="cb-select-1" type="checkbox" name="post[]" value="1">
			<div class="locked-indicator">
				<span class="locked-indicator-icon" aria-hidden="true"></span>
				<span class="screen-reader-text">“Hello world!” is locked</span>
			</div>
            </th>
            <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
                <div class="locked-info"><span class="locked-avatar"></span> <span class="locked-text"></span></div>
                <strong><a class="row-title" href="http://localhost/wordpress/wp-admin/post.php?post=1&amp;action=edit" aria-label="“Hello world!” (Edit)">Hello world!</a></strong>
                <div class="row-actions">
                    <span class="edit"><a href="http://localhost/wordpress/wp-admin/post.php?post=1&amp;action=edit" aria-label="Edit “Hello world!”">Edit</a> | </span>
                    <span class="inline hide-if-no-js"><a href="#" class="editinline" aria-label="Quick edit “Hello world!” inline">Quick&nbsp;Edit</a> | </span>
                    <span class="trash"><a href="http://localhost/wordpress/wp-admin/post.php?post=1&amp;action=trash&amp;_wpnonce=9f305425a0" class="submitdelete" aria-label="Move “Hello world!” to the Trash">Trash</a> | </span>
                    <span class="view"><a href="http://localhost/wordpress/index.php/2018/12/03/hello-world/" rel="bookmark" aria-label="View “Hello world!”">View</a></span>
                </div>
                <button type="button" class="toggle-row"><span class="screen-reader-text">Show more details</span></button>
            </td>
            <td class="author column-author" data-colname="Author">
                <a href="edit.php?post_type=post&amp;author=1">admin</a>
            </td>
            <td class="categories column-categories" data-colname="Categories">
                <a href="edit.php?category_name=uncategorized">Uncategorized</a>
            </td>
            <td class="tags column-tags" data-colname="Tags">
                <span aria-hidden="true">—</span><span class="screen-reader-text">No tags</span>
            </td>
            <td class="comments column-comments" data-colname="Comments">		
                <div class="post-com-count-wrapper">
                    <a href="http://localhost/wordpress/wp-admin/edit-comments.php?p=1&amp;comment_status=approved" class="post-com-count post-com-count-approved"><span class="comment-count-approved" aria-hidden="true">1</span><span class="screen-reader-text">1 comment</span></a><span class="post-com-count post-com-count-pending post-com-count-no-pending"><span class="comment-count comment-count-no-pending" aria-hidden="true">0</span><span class="screen-reader-text">No pending comments</span></span>		
                </div>
            </td>
            <td class="date column-date" data-colname="Date">
                Published<br><abbr title="2018/12/03 8:23:21 pm">2018/12/03</abbr>
            </td>		
        </tr>
		</tbody>

	<tfoot>
	<tr>
		<td class="manage-column column-cb check-column"><label class="screen-reader-text" for="cb-select-all-2">Select All</label><input id="cb-select-all-2" type="checkbox"></td><th scope="col" class="manage-column column-title column-primary sortable desc"><a href="http://localhost/wordpress/wp-admin/edit.php?orderby=title&amp;order=asc"><span>Title</span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-author">Author</th><th scope="col" class="manage-column column-categories">Categories</th><th scope="col" class="manage-column column-tags">Tags</th><th scope="col" class="manage-column column-comments num sortable desc"><a href="http://localhost/wordpress/wp-admin/edit.php?orderby=comment_count&amp;order=asc"><span><span class="vers comment-grey-bubble" title="Comments"><span class="screen-reader-text">Comments</span></span></span><span class="sorting-indicator"></span></a></th><th scope="col" class="manage-column column-date sortable asc"><a href="http://localhost/wordpress/wp-admin/edit.php?orderby=date&amp;order=desc"><span>Date</span><span class="sorting-indicator"></span></a></th>	</tr>
	</tfoot>
</table>
</form>

<div id="ajax-response"></div>
<br class="clear">
</div>
