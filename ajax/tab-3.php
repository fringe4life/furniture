  <?php
      require_once "../classes/Furniture.php";
      
      
    ?>
  
  <div id="tabs-3" >
    
    <div id="itemSearch">
        <form action="ajax/tab-3.php" method="get">
            <label for="query">Search: </label>
            <input  type="text" name="query" id="query" placeholder="What are you looking for?"><br style="border:0;" />
            
            <input type="range" min=500, max=1400, value=700, id="min"><input id="minLabel" >:700</input>
            <input type="range" min=500, max=1400, value=900, id="max"><input id="maxLabel" >:900</input>
            <div class="center">
                <input type="submit" value="search" >
            </div>
        </form>
    </div>
   
   
    <div id="workFlex">
        <section class="right padding-left" id = "gallery2">
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
</div>