<?php

$plugin = new Bespoke_Customizer();
$item_id = $_GET['item_id'];
$categories = [];
if($_POST){
    if($plugin->saveLabel()){
        echo "<h2 style='color:blue'>Label Saved</h2>";
    };
}
if($item_id){
    $categories = $plugin->getCategoriesByItemId($item_id);
}
if($_GET['label_delete_id']){
    $plugin->deleteLabel($_GET['label_delete_id']);
}
$items = $plugin->fetchItems();
$labels = $plugin->fetchLabels();
?>

<div class="wrap">
    <div style="width:30%; float:left;">
        <h1 class="wp-heading-inline">Add Category</h1>
        <form method="get" name="item_selector">
            <p>
                <label>Item</label>
                <select name="item_id" onchange="item_selector.submit()">
                    <option>Select Item</option>
                    <?php 
                        foreach($items as $item){
                            $selected = ($item->id == $item_id)? "selected": "";
                            echo "<option ".$selected." value='".$item->id."'>".$item->title."</option>";
                        }
                    ?>
                </select>
            </p>
            <input type="hidden" name="page" value="bespoke-customizer/admin/partials/labels.php" />
        </form>
        <form method="post" enctype="multipart/form-data">
            <p>
                <label>Category</label>
                <select name="category_id">
                    <option>Select Category</option>
                    <?php 
                        foreach($categories as $category){
                            $selected = ($category->id == $category_id)? "selected": "";
                            echo "<option ".$selected." value='".$category->id."'>".$category->title."</option>";
                        }
                    ?>
                </select>
            </p>
            <p>
                <label> Title </label> 
                <input name="title" style="width:100%"  />
            </p>
            <p>
                <label>Price</label>
                <input name="price" style="width:100%"  />
            </p>
            <p>
                <label>Upload Picture</label>
                <input name="picture" style="width:100%"  type="file" />
            </p>
            <button type="submit">submit</button>
        </form>
    </div>
    <div style="width:60%;float:right;">
        <h1 class="wp-heading-inline">Label List </h1>
            <table class="wp-list-table widefat fixed striped posts">
                <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                        <input id="cb-select-all-1" type="checkbox">
                    </td>
                    <th scope="col" id="title" class="manage-column column-title column-primary sortable desc"><a href="#"><span>Title</span><span class="sorting-indicator"></span></a></th>
                    <th>Category</th>
                    <th></th><th></th>
                </tr>
                </thead>
                <tbody id="the-list">
                    <?php 
                    foreach($labels as $label){
                    echo '<tr>
                            <th><input id="cb-select-all-1" type="checkbox"></th>
                            <td>'.$label->title.'</td>
                            <td>'.$plugin->getCategoryById($label->category_id)->title.'</td>
                            <td><a href="?page=bespoke-customizer/admin/partials/labels.php&label_id='.$label->id.'">view</a></td>
                            <td><a href="?page=bespoke-customizer/admin/partials/labels.php&label_delete_id='.$label->id.'">delete</a></td>
                        </tr>';
                    } 
                    ?>
                </tbody>
            </table>
    </div>
</div>