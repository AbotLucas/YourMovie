<?php
 require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="background-color: rgba(0, 0, 0, 0);">
  <main class="hoc container clear" style="background-color: rgba(0, 0, 0, 0);"> 
    <div class="content" style="background-color: rgba(0, 0, 0, 0);"> 
      <div class="scrollable">
      <h2> <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Cinemas List</span></h2>
      <br>
      <form action="<?php echo FRONT_ROOT."Cinema/button"?> " method="post">

      <div id="btnImportant" class="" style="position: absolute; right: 15%; top: 21%; color:black;">  

       </div>

        <table style="text-align:center;">
          <thead>
            <tr>
            <?php if ($message) { echo "<h3>" . $message . "</h3><br>";} ?>
            <th style="width: 20%;">Name</th>
            <th style="width: 20%;">Adress</th>
            <th style="width: 30%;" >Action</th>
            </tr>
            <td style="background-color: #1a1c20;">
            <span style="color: yellow; padding: 2px; font-weight: bold"><a href="<?php echo FRONT_ROOT."Cinema/ShowAddCinemaView" ?>">+Add</a></span>
          </td>
          <td style="background-color: #1a1c20">
            - - - -
          </td>
          <td style="background-color: #1a1c20"> 
            - - - - 
          </td>
          </thead>
          <tbody>
          <?php if(is_array($cinemaList)) {foreach($cinemaList as $Cinema)
          {
               ?>
            <tr>
                <td> <a href="<?php echo FRONT_ROOT . "Room/ShowRoomListCinemas/" . "?id_cinema=" . $Cinema->getId_Cinema();?>"><?php echo $Cinema->GetName(); ?></a> </td>
                <td> <?php echo $Cinema->GetAddress(); ?> </td>         
                <td>
                <?php if($_SESSION["loginUser"]->getRole()==1){ ?>
                <button type="submit" name="id_remove" class="btn" value="<?php echo $Cinema->GetId_Cinema() ?>"style="font-size: 12px"> Remove </button>
                <button type="submit" name="id_modify" class="btn" value="<?php echo $Cinema->GetId_Cinema() ?>"style="font-size: 12px"> Modify </button>
                <button type="submit" name="add_room" class="btn" value="<?php echo $Cinema->GetId_Cinema() ?>"style="font-size: 12px"> Add Room </button>
                <?php } ?>
                <button type="submit" name="show_rooms" class="btn" value="<?php echo $Cinema->GetId_Cinema() ?>"style="font-size: 12px"> Show Rooms </button>
                </td>  
            </tr> 
          <?php 
        }}
         ?>                
        </tbody></form>
        <tfoot>
          
        </tfoot>
        </table> 
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
</div>