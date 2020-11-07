<?php
    namespace Controllers;

    use Models\Room as Room;
    use DAO\RoomBdDAO as RoomBdDAO;
    use Controllers\CinemaController as CinemaController;
    use DAO\CinemaBdDAO as CinemaBdDAO;
use PDOException;

class RoomController
    {       
        
        private $roomBdDAO;

        public function __construct() {
            
            $this->roomBdDAO = new RoomBdDAO();
        }

        public function ShowRoomListCinemas($id_cinema) {
            $this->ShowListRoomView(" ", $id_cinema);
        }

        public function ShowListRoomView($message="", $id_cinema)
        {   
            $this->roomBdDAO = new RoomBdDAO();
            $cinema = CinemaBdDAO::MapearCinema($id_cinema);

            
            $roomList = $this->roomBdDAO->GetRoomsFromCinema($id_cinema);
            
            if(!isset($_SESSION["loginUser"])){
                $message = "Upps, needs to be logged! ;)";
                require_once(VIEWS_PATH."login.php");
            }
            else {
                if(!is_array($roomList)) {
                    
                }
                require_once(VIEWS_PATH."room-list.php");
            }
        }
       
        public function Addroom($name, $capacity , $ticketValue, $id_cinema)
        {   
            $newRoom = new Room($name, $capacity, $ticketValue,CinemaBdDao::MapearCinema($id_cinema));
            $newShowListCinema = new CinemaController();

                try{
                    $result = $this->roomBdDAO->SaveRoomInBd($newRoom);
                    if($result == 1) {
                        $message = "Room added succesfully!";
                        $this->ShowListRoomView($message, $id_cinema);
                     }
                    else
                    {
                        $message = "ERROR: System error, reintente";
                        $newShowListCinema->ShowListCinemaView($message);
                    }
                } catch (PDOException $ex){
                    $message = $ex->getMessage();
                    if(Functions::contains_substr($message, "Duplicate entry")) {
                        $message = "Alguno de los datos ingresados ya existe en la BD. Reintente.";
                        $newShowListCinema->ShowListCinemaView($message);
                    }
                }
            
        }  
        
        public function RemoveRoomFromDB($id_cinema, $id_room)
        {   
            $result = $this->roomBdDAO->DeleteRoomInDB($id_room);

            if($result == 1) {
                $message = "Room Deleted Succefully!";
                $this->ShowListRoomView($message, $id_cinema); 
            }
            else
            {
                $message = "ERROR: Failed in room delete, reintente";
                $this->ShowListRoomView($message, $id_cinema);
            }
        }
       
   public function modifyANDremover($id_room, $id_cinema){

            
            if(isset($_POST['id_remove'])){

                $this->RemoveRoomFromDB($id_room, $id_cinema);
            
            }
            else if (isset($_POST['id_modify'])) {
               
                $this->ShowModififyView($id_cinema);
             
            }
        }

        public function ShowModififyView($id_room){
            $room = RoomBdDAO::MapearRoom($id_room);
            
            if(!isset($_SESSION["loginUser"])){
                $message = "Upps, needs to be logged! ;)";
                require_once(VIEWS_PATH."login.php");
            }
            else {
                require_once(VIEWS_PATH."room-modify.php");
            }
        }
        
        public function modify($name, $capacity, $ticketValue, $id_room){

            $this->roomBdDAO->ModifyRoomInBd($name, $capacity, $ticketValue, $id_room);
            $room = RoomBdDAO::MapearRoom($id_room);
            $this->ShowListRoomView("Room modify succesfully!", $room->getCinema()->getId_Cinema());
   
           }

        public function ShowAddRoomView($id_cinema) {
            
            $cinema = CinemaBdDAO::MapearCinema($id_cinema);
            require_once(VIEWS_PATH."room-add.php");
        }

        
      
    } 
    
?>