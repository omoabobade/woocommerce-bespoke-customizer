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
$labels = $plugin->fetchLabels();
if(isset($_GET['item_id'])){
    $item_id= $_GET['item_id'];
    $categories = $plugin->fetchCategories($item_id);
}
if(isset($_GET['category_id'])){
    $category_id= $_GET['category_id']; 
   
}
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
<h1 class="wp-heading-inline">Items</h1>
<form name="selectorone" method="GET" >
    <input name="page" value="bespoke-customizer/admin/partials/bespoke-customizer-admin-display.php" type="hidden" />
    <select name="item_id" action="" onchange="selectorone.submit()">
        <option>Select an Item</option>
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
        <th scope="col" id="title" class="manage-column column-title column-primary sortable desc"><a href="#"><span>Title</span><span class="sorting-indicator"></span></a></th>
        <th scope="col" id="categories" class="manage-column column-categories">Categories</th>
        <th scope="col" id="tags" class="manage-column column-tags">Actions</th>
    </tr>
	</thead>

	<tbody id="the-list">
<?php foreach( $labels as $label){?>
		<tr id="post-1" class="iedit author-self level-0 post-1 type-post status-publish format-standard hentry category-uncategorized">
			<th scope="row" class="check-column">
			    <input id="cb-select-1" type="checkbox" name="post[]" value="1">
            </th>
            <td class="title column-title has-row-actions column-primary page-title" data-colname="Title">
                <strong><a class="row-title" href="#" aria-label="<?php echo $label->title ?>"><?php echo $label->title ?></a></strong>
            </td>
            <td class="categories column-categories" data-colname="Categories">
                <a href="edit.php?category_name=uncategorized"><?php echo $plugin->getCategoryById($label->category_id)->title ?></a>
            </td>	
            <td>
                <a href="?page=bespoke-customizer/admin/partials/labels.php&label_id='.$label->id.'">view</a>
            </td>
        </tr>
<?php } ?>
		</tbody>

	<tfoot>
        <tr>
            <td id="cb" class="manage-column column-cb check-column">
                <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                <input id="cb-select-all-1" type="checkbox">
            </td>
            <th scope="col" id="title" class="manage-column column-title column-primary sortable desc"><a href="#"><span>Title</span><span class="sorting-indicator"></span></a></th>
            <th scope="col" id="categories" class="manage-column column-categories">Categories</th>
            <th scope="col" id="tags" class="manage-column column-tags">Actions</th>
        </tr>
    </tfoot>
</table>
</form>

<div id="ajax-response"></div>
<br class="clear">
</div>
