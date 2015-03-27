  <?php
      require_once "../classes/Furniture.php";
  ?>
  
  <div id="tabs-3" >
    
    <div id="itemSearch">
        <form method="get">
            <label for="query">Search: </label>
            <input  type="text" name="query" id="query" placeholder="What are you looking for?"><br style="border:0;" />
            
            <input type="range" min=500, max=1400, value=700, id="min" name="min"><p id="minLabel">:700</p>
            <input type="range" min=500, max=1400, value=900, id="max" name="max"><p id="maxLabel">:900</p>
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
                    $response = $furniture->getFurniture("right");
                    echo $response;
                }
            ?>
            </ul>
        </section>
        <section class="left width-50" id = "gallery1">
            <ul id="galleryList1">
            <?php
                if (request_is_get()){
                    $furniture = new Furniture();
                    $response = $furniture->getFurniture("left");
                    echo $response;
                }
            ?>
            </ul>
        </section>
    </div>
</div>