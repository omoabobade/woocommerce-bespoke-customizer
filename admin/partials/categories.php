<?php

$plugin = new Bespoke_Customizer();
$item_id = $_GET['item_id'];
$categories = [];
if($_POST){
    if($plugin->saveCategory()){
        echo "<h2 style='color:blue'>Category Saved</h2>";
    };
}
if($item_id){
    $categories = $plugin->getCategoriesByItemId($item_id);
}
$items = $plugin->fetchItems();
?>

<div class="wrap">
    <div style="width:30%; float:left;">
        <h1 class="wp-heading-inline">Add Category</h1>
        <form method="post">
            <p>
                <label>Item</label>
                <select name="item_id">
                    <option>Select an Item</option>
                    <?php 
                        foreach($items as $item){
                            $selected = ($item->id == $item_id)? "selected": "";
                            echo "<option ".$selected." value='".$item->id."'>".$item->title."</option>";
                        }
                    ?>
                </select>
            </p>
            <p>
                <label> Title </label> 
                <input name="title" style="width:100%"  />
            </p>
            <p>
                <label>Details</label>
                <textarea rows=10 cols=30 name="details"> </textarea>
            </p>
            <button type="submit">submit</button>
        </form>
    </div>
    <div style="width:60%;float:right;">
        <h1 class="wp-heading-inline">Categories List : <?php echo $plugin->getItemById($item_id)->title ?></h1>
            <table class="wp-list-table widefat fixed striped posts">
                <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                        <input id="cb-select-all-1" type="checkbox">
                    </td>
                    <th scope="col" id="title" class="manage-column column-title column-primary sortable desc"><a href="#"><span>Title</span><span class="sorting-indicator"></span></a></th>
                    <th>Item</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="the-list">
                    <?php 
                    foreach($categories as $category){
                    echo '<tr>
                            <th><input id="cb-select-all-1" type="checkbox"></th>
                            <td>'.$category->title.'</td>
                            <td>'.$plugin->getItemById($item_id)->title.'</td>
                            <td><a href="?page=bespoke-customizer/admin/partials/labels.php?category_id='.$category->id.'">view</a></td>
                        </tr>';
                    } 
                    ?>
                </tbody>
            </table>
    </div>
</div>