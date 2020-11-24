<?php 
namespace DAO;

use Models\Ticket as Ticket;
use DAO\Connection as Connection;
use DAO\ScreeningBdDAO as ScreeningBdDAO;
use DAO\UserBdDAO as UserBdDAO;
use FFI\Exception;

class TicketBdDAO {

    private $tableName ="ticket";
    private $connection;
    private $ticketList = [];
   
    public function __construct(){
        
    }

    public function SaveTicketInBd($ticket){
    
        $sql = " INSERT INTO ". $this->tableName ."(idstreening,userid) VALUES (:idstreening,:userid)";
      
              $parameters["idstreening"] = $ticket->getScreening()->getId_screening();
              $parameters['userid'] = $ticket->getUser()->getUserId();
              try {
                  $this->connection = Connection::GetInstance();
                  return $this->connection->ExecuteNonQuery($sql, $parameters);
              } catch (Exception $ex) {
                  throw $ex;
              }
          }

          
    public function getTicketFromDB(){
        
        $query = "SELECT * FROM " . $this->tableName;
        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);

        } catch (Exception $ex) {
            throw $ex;
        }
        
        return $result;
    
    }

    public function getAllTicket() {

        $ticketArray = $this->getTicketFromDB();
        if(!empty($ticketArray)) {
            
            $result = $this->mapear($ticketArray);
            if(is_array($result)) {
                $this->ticketList = $result;
            }
            else {
                $arrayResult[0] = $result;
                $this->ticketList = $arrayResult;
            }
            return $this->ticketList;
        }
        else {
            return $errorArray[0] = "ERROR while reading the database.";
        }
    }
    protected function mapear($value) {


        $value = is_array($value) ? $value : [];

        $resp = array_map(function($p){
            $ticket = new Ticket( ScreeningBdDAO::MapearScreening($p["idstreening"]) ,UserBdDAO::MapearUser($p["userid"]));
            $ticket->setId_ticket($p['id_ticket']);
            return $ticket;
        }, $value);

        return count($resp) > 1 ? $resp : $resp['0'];
    }
   
        public function GetTicketById($searchidticket)
        {
            $ticket = null;
    
            $query = "SELECT * FROM " . $this->tableName . " WHERE (id_ticket =:id_ticket) ";
    
            $parameters["id_ticket"] = $searchidticket;
    
            try{
    
                $this->connection = Connection::GetInstance();
                $results = $this->connection->Execute($query, $parameters);
            
            } catch (Exception $ex) {
                throw $ex;
            }
            
            $return = $this->mapear($results);

        }

        public static function MapearTicket($idTicketToMapear) {
            $ticketDAOBdAux = new TicketBdDAO();
            return $ticketDAOBdAux->GetTicketById($idTicketToMapear);
        }

        public function DeleteTicketInDB($id_Ticket) {

            $sql = "call deleteTicket(".$id_Ticket.")";
      
            $parameters["id_ticket"] = $id_Ticket;
    
            try {
    
                $this->connection = Connection::GetInstance();
                $result = $this->connection->ExecuteNonQuery($sql, $parameters);
                
                return $result;

            }catch (Exception $ex){
                throw $ex;
            }
        }

        private function getTickesFromAUserDB($id_user){
        
            $query = "SELECT * FROM " . $this->tableName . " WHERE (userid = :userid)";

            $parameters["userid"] = intval($id_user);

            try {
            
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query, $parameters);
    
            } catch (Exception $ex) {

                return null;
            }
            
            return $result;
        
        }
        public function GetTicketFromUser($id_user) {

            $ticketfromUser = $this->getTickesFromAUserDB($id_user);

            if(!empty($ticketfromUser)) {
            
                $result = $this->mapear($ticketfromUser);

                if(is_array($result)) {
                    $this->ticketList = $result;
                }
                else {
                    $arrayResult[0] = $result;
                    $this->ticketList = $arrayResult;
                }
                return $this->ticketList;
            }
            else {
                return $errorArray[0] = "Error al leer la base de datos.";
            }
            
        }

        
    }
    ?>