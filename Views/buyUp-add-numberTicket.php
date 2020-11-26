<?php
require_once('nav-bar.php');
?>
<div class="wrapper row4 diseño" style="background-color: rgba(0, 0, 0, 0);">
  <main class="hoc container clear" style="background-color: rgba(0, 0, 0, 0);">
    <div class="content" style="background-color: rgba(0, 0, 0, 0);">
      <div class="scrollable">
        <h2> <span style="background-color: rgba(115, 64, 70, 0.9); padding: 10px">Buying Tickets</span></h2>
        <form action="<?php echo FRONT_ROOT . "Ticket/PayTickets"  ?>" method="post" style="padding: 2rem !important;">
          <table style="max-width: 60%">
            <thead>
              <th colspan="3">
                Movie: <?php echo $screening->getMovie()->getTitle(); ?>
              </th>

            </thead>
            <tbody align="center">

              <tr>
                <td>
                  Duration: <?php echo $screening->getMovie()->getDuration(); ?>
                </td>
                <td>
                  Cinema: <?php echo $screening->getRoom()->getCinema()->getName(); ?>
                </td>
                <td>
                  Room: <?php echo $screening->getRoom()->getName(); ?>
                </td>
              </tr>
              <tr>
                <td>
                  Date: <?php echo $screening->getDate_screening() ?>
                </td>
                <td>
                  Hour: <?php echo $screening->getHour_screening() ?>
                </td>
                <td>
                  Quantity: <input type="number" name="number" min="1" max="15" size="30" placeholder="1" style="display: inline-flex;" required>
                </td>
              </tr>
              <tr>
                <td colspan="3">
                  <input id="id_screening" name="id_screening" type="hidden" value="<?php echo $screening->getId_screening() ?>">
                  <input type="submit" class="btn" value="Pay Tickets">
                </td>
              </tr>

            </tbody>
        </form>
        </table>
        <!-- / main body -->
        <div class="clear"></div>
  </main>
</div>