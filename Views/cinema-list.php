<?php
 require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="background-color: rgba(0, 0, 0, 0);">
  <main class="hoc container clear" style="background-color: rgba(0, 0, 0, 0);"> 
    <div class="content" style="background-color: rgba(0, 0, 0, 0);"> 
      <div class="scrollable">
      <h2> <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Cinemas List</span></h2>
      <br>
      <form action="<?php echo FRONT_ROOT."Cinema/modifyANDremover"?> " method="post">
        <table style="text-align:center;">
          <thead>
            <tr>
           
            <th style="width: 20%;">Name</th>
            <th style="width: 20%;">Adress</th>
            <th style="width: 30%;" > Action</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($cinemaList as $Cinema)
          {
               ?>
            <tr>
                <td> <?php echo $Cinema->GetName(); ?> </td>
                <td> <?php echo $Cinema->GetAddress(); ?> </td>
                           
                <td>
                <button type="submit" name="id_remove" class="btn" value="<?php echo $Cinema->GetId_Cinema() ?>"style="font-size: 12px"> Remove </button>
                <button type="submit" name="id_modify" class="btn" value="<?php echo $Cinema->GetId_Cinema() ?>"style="font-size: 12px"> modify </button>
                <button type="submit" name="" class="btn" value="Show Functions"style="margin-left: 10px, font-size: 8px"> Show Functions </button>
                </td>
                
            </tr> 
          <?php 
        }
         ?>                
        </tbody></form>
        </table> 
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>
</div>