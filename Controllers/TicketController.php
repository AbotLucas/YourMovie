<?php
    namespace Controllers;

    use Models\Ticket as Ticket;
    use DAO\TicketBdDAO as TicketBdDAO;
    use DAO\ScreeningBdDAO as ScreeningBdDAO;
    use DAO\UserBdDAO as UserBdDAO;
    use Models\User as User;
    use PDOException;

    class TicketController
    {       
        
        private $ticketBdDAO;

        public function __construct() {
            
            $this->ticketBdDAO = new TicketBdDAO();
        }
          
        public function ShowListTicketView($message ="", $user){

            $this->ticketBdDAO = new TicketBdDAO();

            $ticketList = $this->ticketBdDAO->GetTicketFromUser($user->getUserId());

            require_once(VIEWS_PATH."ticket-list.php");   
        }

        public function ShowLoginTicketView($message =""){

            if(!isset($_SESSION["loginUser"])){
            
                require_once(VIEWS_PATH."signup.php");
            }
               
         }

         public function ShowbuyUpaddlistView($id_ticket){

            #if(!isset($_SESSION["loginUser"])){

                require_once(VIEWS_PATH."buyUp-add-numberTicket.php");
           # }
        }

        public function AddTicket($id_screening,  User $user) {

            
            $screening = ScreeningBdDAO::MapearScreening($id_screening);
           
            $newTicket = new Ticket($screening,$user);
        
            $this->TicketBdDAO = new TicketBdDAO();
            $result = $this->TicketBdDAO->SaveTicketInBd($newTicket);

            return $result;

        }



        public function removerTicketAndPay($id_ticket){

            if(isset($_POST['id_remove'])){

             $this->RemoveTicketFromDB($id_ticket);

            }elseif($_POST['id_pay']){

                $message ="";

                $this->ShowbuyUpaddlistView($id_ticket);
            }
        }

        public function GetTicket($id_screening) {
           
            if(isset($_SESSION["loginUser"])){
            $userName = $_SESSION['loginUser']->getUserName();
            
            $userDao = new UserBdDAO();

            $user = $userDao->GetByUserName($userName);

            if(is_array($user)) {
                $user = $user[0];
            } 
            
            if(!empty($user)){

                $result = $this->AddTicket($id_screening, $user);

                if($result != 1) {

                    $message = "Ticket added FAIL!";
                }
                else {
                    $message = "Ticket added Succesfully";
                }

                $this->ShowListTicketView($message, $user);
            
            }

        }else{
            $message ="debe loguearse";
           $this-> ShowLoginTicketView($message);
        }
            
        }

        public function RemoveTicketFromDB($id_ticket)
        {   
            
            try{
                $user = $_SESSION['loginUser'];
                $this->ticketBdDAO = new TicketBdDAO();

            $result = $this->ticketBdDAO->DeleteTicketInDB($id_ticket);
            
             if($result == 1) {
                $message = "Ticket Deleted Succefully!";
               $this->ShowListTicketView($message ,$user);
            }
            else
            {
                $message = "ERROR: Failed in ticket delete, reintente";
                $this->ShowListTicketView($message ,$user);
            }
        } catch (PDOException $ex){

            $message = $ex->getMessage();
            
            if(Functions::contains_substr($message,"has associated buy up cannot be deleted !!")) {
                $message = "has associated buy up cannot be deleted !!";

                $this->ShowListTicketView($message ,$user);
            }
        }
    }

       
   }
   ?>