<?php

$plugin = new Bespoke_Customizer();
if($_POST){
    if($plugin->saveItem()){
        echo "<h2 style='color:blue'>Item Saved</h2>";
    };
}
$items = $plugin->fetchItems();
?>

<div class="wrap">
    <div style="width:30%; float:left;">
        <h1 class="wp-heading-inline">Add Items</h1>
        <form method="post">
            <p>
                <label > Title </label> 
                <input name="title" style="width:100%"  />
            </p>
            <button type="submit">submit</button>
        </form>
    </div>
    <div style="width:60%;float:right;">
        <h1 class="wp-heading-inline">Items List</h1>
            <table class="wp-list-table widefat fixed striped posts">
                <thead>
                <tr>
                    <td id="cb" class="manage-column column-cb check-column">
                        <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                        <input id="cb-select-all-1" type="checkbox">
                    </td>
                    <th scope="col" id="title" class="manage-column column-title column-primary sortable desc"><a href="#"><span>Title</span><span class="sorting-indicator"></span></a></th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="the-list">
                    <?php 
                    foreach($items as $item){
                    echo '<tr>
                            <th><input id="cb-select-all-1" type="checkbox"></th>
                            <td>'.$item->title.'</td>
                            <td><a href="?page=bespoke-customizer/admin/partials/categories.php&item_id='.$item->id.'">view</a></td>
                        </tr>';
                    } 
                    ?>
                </tbody>
            </table>
    </div>
</div>