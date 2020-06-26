<?php
/**
Author: Levi Schanding
 */
namespace DataLoader {
    use \PDO;
    use \Exception;
    const DB_SETTINGS = [
        'host'=>'localhost',
        'dbname'=>'creativeaging',
        'charset'=>'utf8mb4',
        'username'=>'admin',
        'password'=>'12345678'
    ];
    const DB_OPTIONS = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES=>false
    ];
    abstract class DataHandler
    {
        protected $isCreated = false;
        protected $date_created;

        abstract function createEntry($database);
        abstract function updateEntry($database);
        abstract function deleteEntry($database);

        protected function get_date_created(){
            return $this->date_created;
        }
        //protected function set_date_created(){}


        protected static function is_PDO($database){
            if(!($database instanceof PDO)){
                throw new Exception("Function expects PDO Object for database parameter");
            } else {
                return true;
            }
        }

        public static function connectToDB(){
            return new PDO('mysql:host='.DB_SETTINGS['host'].';dbname='.DB_SETTINGS['dbname'].';charset='.DB_SETTINGS['charset'],DB_SETTINGS['username'],DB_SETTINGS['password'], DB_OPTIONS);
        }
    }
    class CACEvent extends DataHandler{
        private $event_id;
        private $event_type;
        private $program_id;
        private $date_start;
        private $date_end;
        private $event_notes;
        public function __construct($event_type, $program_id, $date_start=null, $date_end=null, $notes=null, $event_id=null){
            $this->event_id = $event_id;
            $this->event_type = $event_type;
            $this->program_id = $program_id;
            $this->date_start = $date_start;
            $this->date_end = $date_end;
            $this->event_notes = $notes;
        }

        public function createEntry($database){
            $this->is_PDO($database);
            if($this->isCreated){
                throw new Exception('Entry has already been created');
            }
            $query = $database->prepare("INSERT INTO events(event_type, program_id, date_start, date_end, event_notes) VALUES (?,?,?,?,?)");
            $query->execute([$this->event_type, $this->program_id, $this->date_start, $this->date_end, $this->event_notes]);
            $this->event_id = $database->lastInsertId();
            $this->isCreated = true;

        }
        public function updateEntry($database){
            $this->is_PDO($database);
            if($this->event_id == null){
                throw new Exception('Entry has no ID');
            }
            $query = $database->prepare("UPDATE events SET event_type=?, program_id=?, date_start=?, date_end=?, event_notes=? WHERE event_id=?");
            $query->execute([$this->event_type, $this->program_id, $this->date_start, $this->date_end, $this->event_notes, $this->event_id]);
        }
        public function deleteEntry($database){
            $this->is_PDO($database);
            if($this->event_id == null){
                throw new Exception('Entry has no ID');
            }
            $query = $database->prepare("DELETE FROM events WHERE event_id=?");
            $query->execute([$this->event_id]);
        }

        public function get_eventID(){
            return $this->event_id;
        }
        public function get_event_type(){
            return $this->event_type;
        }
        public function get_programID(){
            return $this->program_id;
        }
        public function get_date_start(){
            return $this->date_start;
        }
        public function get_date_end(){
            return $this->date_end;
        }
        public function get_notes(){
            return $this->event_notes;
        }

        public function set_event_type($event_type){
            $this->event_type = $event_type;
        }
        public function set_programID($program_id){
            $this->program_id = $program_id;
        }
        public function set_date_start($start_date){
            $this->date_start = $start_date;
        }
        public function set_date_end($end_date){
            $this->date_end = $end_date;
        }
        public function set_notes($notes){
            $this->event_notes = $notes;
        }

    }
    class CACFacility extends DataHandler{
        private $facility_id;
        private $facility_name;
        private $facility_contact;
        private $facility_notes;
        public function __construct($facility_name, $facility_contact=null, $facility_notes=null, $facility_id=null){
            $this->facility_id = $facility_id;
            $this->facility_name = $facility_name;
            $this->facility_contact = $facility_contact;
            $this->facility_notes = $facility_notes;
        }
        public function createEntry($database){

            $this->is_PDO($database);
            if($this->isCreated){
                throw new Exception('Entry has already been created');
            }
            $query = $database->prepare("INSERT INTO facilities(facility_name, facility_contact, facility_notes) VALUES (?,?,?)");
            $query->execute([$this->facility_name, $this->facility_contact, $this->facility_notes]);
            $this->facility_id = $database->lastInsertId();
            $this->isCreated = true;
        }
        public function updateEntry($database){
            $this->is_PDO($database);
            if($this->facility_id == null){
                throw new Exception('Entry has no ID');
            }
            $query = $database->prepare("UPDATE facilities SET facility_name=?, facility_contact=?, facility_notes=? WHERE facility_id=?");
            $query->execute([$this->facility_name, $this->facility_contact, $this->facility_notes, $this->facility_id]);
        }
        public function deleteEntry($database){
            $this->is_PDO($database);
            if($this->facility_id == null){
                throw new Exception('Entry has no ID');
            }
            $query = $database->prepare("DELETE FROM facilities WHERE facility_id=?");
            $query->execute([$this->facility_id]);
        }

        public function get_id(){
            return $this->facility_id;
        }
        public function get_name(){
            return $this->facility_name;
        }
        public function get_contact(){
            return $this->facility_contact;
        }
        public function get_notes(){
            return $this->facility_notes;
        }

        public function set_name($facility_name){
            $this->facility_name = $facility_name;
        }
        public function set_contact($facility_contact){
            $this->facility_contact = $facility_contact;
        }
        public function set_notes($facility_notes){
            $this->facility_notes = $facility_notes;
        }
    }
    class CACFunding extends DataHandler{
        private $funding_id;
        private $funding_name;
        private $funding_amount;
        private $funding_type;
        private $funding_period;
        private $funding_notes;
        public function __construct($funding_name, $funding_type, $funding_amount=null, $funding_period=null, $funding_notes=null, $funding_id=null){
            $this->funding_id = $funding_id;
            $this->funding_name = $funding_name;
            $this->funding_amount = $funding_amount;
            $this->funding_type = $funding_type;
            $this->funding_period = $funding_period;
            $this->funding_notes = $funding_notes;
        }
        public function createEntry($database){
            $this->is_PDO($database);
            if($this->isCreated){
                throw new Exception('Entry has already been created');
            }
            $query = $database->prepare("INSERT INTO funding(funding_name, funding_amount, funding_type, funding_period, funding_notes) VALUES (?,?,?,?,?)");
            $query->execute([$this->funding_name, $this->funding_amount, $this->funding_type, $this->funding_period, $this->funding_notes]);
            $this->funding_id = $database->lastInsertId();
            $this->isCreated = true;
        }
        public function updateEntry($database){
            $this->is_PDO($database);
            if($this->funding_id == null){
                throw new Exception('Entry has no ID');
            }
            $query = $database->prepare("UPDATE funding SET funding_name=?, funding_amount=?, funding_type=?, funding_period=?, funding_notes=? WHERE funding_id=?");
            $query->execute([$this->funding_name, $this->funding_amount, $this->funding_type, $this->funding_period, $this->funding_notes, $this->funding_id]);
        }
        public function deleteEntry($database){
            $this->is_PDO($database);
            if($this->funding_id == null){
                throw new Exception('Entry has no ID');
            }
            $query = $database->prepare("DELETE FROM funding WHERE funding_id=?");
            $query->execute([$this->funding_id]);
        }

        public function get_id(){
            return $this->funding_id;
        }
        public function get_name(){
            return $this->funding_name;
        }
        public function get_type(){
            return $this->funding_type;
        }
        public function get_amount(){
            return $this->funding_amount;
        }
        public function get_period(){
            return $this->funding_period;
        }
        public function get_notes(){
            return $this->funding_notes;
        }

        public function set_name($funding_name){
            $this->funding_name = $funding_name;
        }
        public function set_type($funding_type){
            $this->funding_type = $funding_type;
        }
        public function set_period($funding_period){
            $this->funding_period = $funding_period;
        }
        public function set_amount($funding_amount){
            $this->funding_amount = $funding_amount;
        }
        public function set_notes($funding_notes){
            $this->funding_notes = $funding_notes;
        }
    }
    class CACPrograms extends DataHandler{
        private $program_id;
        private $program_name;
        private $program_topic;
        private $program_description;
        private $program_notes;
        public function __construct($program_name, $program_topic, $program_description, $program_notes, $program_id=null){
            $this->program_id = $program_id;
            $this->program_name = $program_name;
            $this->program_topic = $program_topic;
            $this->program_description = $program_description;
            $this->program_notes = $program_notes;
        }
        public function createEntry($database){
            $this->is_PDO($database);
            if($this->isCreated){
                throw new Exception('Entry has already been created');
            }
            $query = $database->prepare("INSERT INTO programs(program_name, program_topic, program_description, program_notes) VALUES (?,?,?,?)");
            $query->execute([$this->program_name, $this->program_topic, $this->program_description, $this->program_notes]);
            $this->program_id = $database->lastInsertId();
            $this->isCreated = true;
        }
        public function updateEntry($database){
            $this->is_PDO($database);
            if($this->program_id == null){
                throw new Exception('Entry has no ID');
            }
            $query = $database->prepare("UPDATE programs SET program_name=?, program_topic=?, program_description=?, program_notes=? WHERE program_id=?");
            $query->execute([$this->program_name, $this->program_topic, $this->program_description, $this->program_notes, $this->program_id]);
        }
        public function deleteEntry($database){
            $this->is_PDO($database);
            if($this->program_id == null){
                throw new Exception('Entry has no ID');
            }
            $query = $database->prepare("DELETE FROM programs WHERE program_id=?");
            $query->execute([$this->program_id]);
        }
        public function get_id(){
            return $this->program_id;
        }
        public function get_name(){
            return $this->program_name;
        }
        public function get_topic(){
            return $this->program_topic;
        }
        public function get_description(){
            return $this->program_description;
        }
        public function get_notes(){
            return $this->program_notes;
        }

        public function set_name($program_name){
            $this->program_name = $program_name;
        }
        public function set_type($program_type){
            $this->program_type = $program_type;
        }
        public function set_description($program_description){
            $this->program_description = $program_description;
        }
        public function set_notes($program_notes){
            $this->program_notes = $program_notes;
        }
    }
    class CACEventFacility extends DataHandler{
        private $ef_id;
        private $event_id;
        private $facility_id;
        private $funding_id;
        private $num_children;
        private $num_adults;
        private $num_seniors;
        private $feedback;

        public function __construct($event_id, $facility_id, $funding_id, $num_children, $num_adults, $num_seniors, $feedback=null){
            $this->event_id = $event_id;
            $this->facility_id = $facility_id;
            $this->funding_id = $funding_id;
            $this->num_children = $num_children;
            $this->num_adults = $num_adults;
            $this->num_seniors = $num_seniors;
            $this->feedback = $feedback;
        }
        public function createEntry($database){
            $this->is_PDO($database);
            if($this->isCreated){
                throw new Exception('Entry has already been created');
            }
            $query = $database->prepare("INSERT INTO events_facilities(event_id, facility_id, funding_id, num_children, num_adults, num_seniors, feedback) VALUES (?,?,?,?,?,?,?)");
            $query->execute([$this->event_id, $this->facility_id, $this->funding_id, $this->num_children, $this->num_adults, $this->num_seniors, $this->feedback]);
            $this->isCreated = true;
        }
        public function updateEntry($database){
            $this->is_PDO($database);
            $query = $database->prepare("UPDATE events_facilities SET event_id=?, facility_id=?, funding_id=?, num_children=?, num_adults=?, num_seniors=?, feedback=? WHERE event_id=? AND facility_id=? AND funding_id=?");
            $query->execute([$this->event_id, $this->facility_id, $this->funding_id, $this->num_children, $this->num_adults, $this->num_seniors, $this->feedback, $this->event_id, $this->facility_id, $this->funding_id]);
        }
        public function deleteEntry($database){

            $this->is_PDO($database);
            $query = $database->prepare("DELETE FROM events_facilities WHERE event_id=? AND facility_id=? AND funding_id=?");
            $query->execute([$this->event_id, $this->facility_id], $this->funding_id);
        }
        public function get_eventID(){
            return $this->event_id;
        }
        public function get_facilityID(){
            return $this->facility_id;
        }
        public function get_fundingID(){
            return $this->funding_id;
        }
        public function get_num_children(){
            return $this->num_children;
        }
        public function get_num_adults(){
            return $this->num_adults;
        }
        public function get_num_seniors(){
            return $this->num_seniors;
        }
        public function get_feedback(){
            return $this->feedback;
        }

        public function set_eventID($event_id){
            $this->event_id = $event_id;
        }
        public function set_facilityID($facility_id){
            $this->facility_id = $facility_id;
        }
        public function set_fundingID($funding_id){
            $this->funding_id = $funding_id;
        }
        public function set_num_children($num_children){
            $this->num_children = $num_children;
        }
        public function set_num_adults($num_adults){
            $this->num_adults = $num_adults;
        }
        public function set_num_seniors($num_seniors){
            $this->num_seniors = $num_seniors;
        }
        public function set_feedback($feedback){
            $this->feedback = $feedback;
        }
    }
}