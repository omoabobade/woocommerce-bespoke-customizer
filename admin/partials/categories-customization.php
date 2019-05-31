<?php

$orderby = 'name';
$order = 'asc';
$hide_empty = false ;
$customizations = [];
$cat_args = array(
    'orderby'    => $orderby,
    'order'      => $order,
    'hide_empty' => $hide_empty,
);
 
$product_categories = get_terms( 'product_cat', $cat_args );
$plugin = new Bespoke_Customizer();
$items = $plugin->fetchItems();
if(isset($_GET['category'])){
    $catname = $_GET['name'];
    $catId = $_GET['category'];
    $customization = $plugin->fetchCustomizations($catId);
    //var_dump($customization[0]->customizations);
    $customizations = explode(",", $customization[0]->customizations);
    //var_dump($customization);
}

if(isset($_POST["save_customization"])){
     $response = $plugin->saveMapping();
}
?>

<div class="wrap">
    <div style="width:50%; float:left;">
        <h1 class="wp-heading-inline">Product Categories List</h1>
      <?php
        if( !empty($product_categories) ){ ?>
            <table class="wp-list-table widefat fixed striped posts">
            <thead>
            <tr>
                <th scope="col" id="title" class="manage-column column-title column-primary sortable desc"><a href="#"><span>Title</span><span class="sorting-indicator"></span></a></th>
                <th></th>
            </tr>
            </thead>
            <tbody id="the-list">
                <?php 
                foreach ($product_categories as $key => $category) {
                echo '<tr>
                        <td>'.$category->name.'</td>
                        <td><a href="?page=bespoke-customizer/admin/partials/categories-customization.php&category='.$category->term_id.'&name='.$category->name.'">View Customization</a></td>
                    </tr>';
                } 
                ?>
            </tbody>
        </table>
        <?php
        }
    ?>
    </div>
    <div style="width:40%;float:right;">
        <h1 class="wp-heading-inline">Select Customizations for : <?php echo $catname ?> </h1>
        <form method="post">
        <table class="wp-list-table widefat fixed striped posts">
                <thead>
                <tr>
                    <th id="cb" class="manage-column column-cb check-column">*</th>
                    <th scope="col" id="title" class="manage-column column-title column-primary sortable desc"><a href="#"><span>Title</span><span class="sorting-indicator"></span></a></th>
                </tr>
                </thead>
                <tbody id="the-list">
                    <?php 
                    foreach($items as $item){
                        $checked = "";
                       // var_dump($item->id, $customizations);
                        if( in_array($item->id, $customizations)){
                            $checked = "checked=true";
                        }
                    echo '<tr>
                            <td><input id="cb-select-all-1" name="customizations[]" '.$checked.' type="checkbox" value="'.$item->id.'"></td>
                            <td>'.$item->title.'</td>
                        </tr>';
                    } 
                    ?>
                </tbody>
            </table>
            <input name="save_customization" value="submit" type="submit" />
            </form>
    </div>
</div>