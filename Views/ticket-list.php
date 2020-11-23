<?php
 require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="background-color: rgba(0, 0, 0, 0);">
  <main class="hoc container clear" style="background-color: rgba(0, 0, 0, 0);"> 
    <div class="content" style="background-color: rgba(0, 0, 0, 0);"> 
      <div class="scrollable">
      <h2> <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Your ticket <a href="#" style="font-size: 16px;"><?php echo $user->getUserName() ?></a></span></h2>
      <br>

      <div>
          <?php  if(isset($message)){ echo "<span style='color:red; font-weight: bold;' >". $message ."</span><br><br>";}?>
      </div>

        <table style="text-align:center;">
          <thead>
            <tr>
            <th style="width: 20%;">Cinema/Room</th>
            <th style="width: 25%;">Movie</th>
            <th style="width: 15%;" >Date</th>
            <th style="width: 15%;" >Hour</th>
            <th style="width: 15%;" >Ticket Value</th>
            <th style="width: 15%;" >Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
            <?php if(is_array($ticketList)){ foreach($ticketList as $ticket){?>
                <td> <?php echo $ticket->getScreening()->getRoom()->getCinema()->getName()."/".$ticket->getScreening()->getRoom()->getName() ; ?> </td>
                <td> <?php echo $ticket->getScreening()->getMovie()->getTitle(); ?> </td>
                <td> <?php echo $ticket->getScreening()->getDate_screening(); ?> </td>
                <td> <?php echo $ticket->getScreening()->getHour_screening(); ?> </td>
                <td> <?php echo $ticket->getScreening()->getRoom()->getTicketValue(); ?> </td>    
                 <td>
                <button type="submit" name="id_remove" class="btn" value="<?php  echo $ticket->getId_ticket() ;?>"style="font-size: 12px"> Remove </button>
                </td>        
            </tr> 
            <?php 
            }
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