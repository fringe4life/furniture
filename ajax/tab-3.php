  <?php
      require_once "../classes/Furniture.php";
    ?>
  
  <div id="tabs-3" >
   
  <section class="right width-50 padding-left" id = "gallery2">
    <ul id="galleryList2">
  <?php
  
  if (request_is_get()){
  $furniture = new Furniture();
  echo $furniture->getFurniture();
  }
  ?>
  </ul>
    </section>
    <section class="left width-50" id = "gallery1">
         <ul id="galleryList1">
  <?php
  if (request_is_get()){
  $furniture = new Furniture();
  echo $furniture->getFurniture();
  }
  ?>
  </ul>
    </section>
  </div>
