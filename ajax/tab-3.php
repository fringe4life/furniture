  <?php
      require_once "../classes/Furniture.php";
      
      
    ?>
  
  <div id="tabs-3" >
   <form action="searchItems.php" method="post">
    <label for="query">Search: </label>
        <input search type="text" name="query" placeholder="What are you looking for?"><br />
            
       
         <label for="amount">Price range:</label>
        <input type="text" name="amount" id="amount">    
            
          
    
   </form>
   
   <div id="slider-range">  </div>
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
