<?php
namespace DAO;

use Models\Room as Room;
use DAO\Iroom as Iroom;
use DAO\Connection as Connection;
use FFI\Exception;

class RoomBdDAO implements Iroom {

    private $tableName = "Room";
    private $connection;
    private $roomList = [];
   
    public function __construct(){
        
    }

    public function SaveRoomInBd($Room) {
    
        $sql = " INSERT INTO ". $this->tableName ."(name, capacity,ticketvalue,idcinema) VALUES (:name, :capacity ,:ticketvalue , :idcinema)";
      
              $parameters["name"] = $Room->getName();
              $parameters["capacity"] = $Room->getCapacity();
              $parameters["ticketvalue"] = $Room->getTicketvalue();
              $parameters["idcinema"] = $Room->getCinema()->getId_Cinema();
              try {
                  $this->connection = Connection::GetInstance();
                  return $this->connection->ExecuteNonQuery($sql, $parameters);
              } catch (Exception $ex) {
                  throw $ex;
              }
          }

          
    public function getRoomFromDB(){
        
        $query = "SELECT * FROM " . $this->tableName;
        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);

        } catch (Exception $ex) {
            throw $ex;
        }
        
        return $result;
    
    }

    protected function mapear($value) {

        $value = is_array($value) ? $value : [];

        $resp = array_map(function($p){
            $room = new Room($p['name'],$p['capacity'],$p['ticketvalue'],CinemaBdDao::MapearCinema($p["idcinema"]));
            $room->setId_room($p['id_room']);
            return $room;

        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }
    
    
    public function getAllRoom() {

        $roomArray = $this->getRoomFromDB();
        if(!empty($roomArray)) {
            
            $result = $this->mapear($roomArray);
            if(is_array($result)) {
                $this->roomList = $result;
            }
            else {
                $arrayResult[0] = $result;
                $this->roomList = $arrayResult;
            }
            return $this->roomList;
        }
        else {
            return $errorArray[0] = "ERROR while reading the database.";
        }
    }
        public function GetRoomById($searchidRoom)
        {
            $room = null;
    
            $query = "SELECT * FROM " . $this->tableName . " WHERE (id_room = :id_room) ";
    
            $parameters["id_room"] = $searchidRoom;
    
            try{
    
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters);
            
            } catch (Exception $ex) {
                throw $ex;
            }
            
            $return = $this->mapear($results);
    
    
            return $return;
        }  
        public function DeleteRoomInDB($id_room) {
  
            $sql = "DELETE FROM "  . $this->tableName . " WHERE (id_room = :id_room) ";
      
            $parameters["id_room"] = $id_room;
    
            try {
    
                $this->connection = Connection::GetInstance();
                return $this->connection->ExecuteNonQuery($sql, $parameters);
    
            }catch (Exception $ex){
                throw $ex;
            }
        }
        public static function MapearRoom($idRoomToMapear) {
            $roomDAOBdAux = new RoomBdDAO();
            return $roomDAOBdAux->GetRoomById($idRoomToMapear);
        }
        
       
        
        
        
    

}