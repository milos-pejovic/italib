<?php
class Memberships_model extends Model {
    
    /**
     * 
     * @param type $memberships_controller
     */
    
    public function addMembership($memberships_controller) {
        $data = Validate::isFilled($_POST);
        
        $userExists = $this->db->selectOne('users', ['membership_number' => $data['membership_number']]);
        
        if (!$userExists) {
            $error = 'Uneti korisnički broj ne postoji u bazi.';
            $memberships_controller->loadView('memberships/addMembershipErrorPage', $error);
            die;
        } else {
            $data['user_id'] = $userExists->id;
        }
        
        if ($data['from_year'] > $data['to_year'] || 
            ($data['from_year'] == $data['to_year'] && $data['from_month'] > $data['to_month']) ||
            ($data['from_year'] == $data['to_year'] && $data['from_month'] == $data['to_month'] && $data['from_date'] >= $data['to_date'])) 
        {
            $error = 'Po&#269;etni datum ne mo&#382e biti kasniji ili isti kao krajnji datum.';
            $memberships_controller->loadView('memberships/addMembershipErrorPage', $error);
            die;
        }
        
        if ($data['price'] == '') {
            $error = 'Cena nije uneta.';
            $memberships_controller->loadView('memberships/addMembershipErrorPage', $error);
            die;
        }
        
        $data['date_from'] = implode('.', [$data['from_date'], $data['from_month'], $data['from_year']]);
        $data['date_to'] = implode('.', [$data['to_date'], $data['to_month'], $data['to_year']]);

        // Checking if the user has already paid the membership
        
        $endMem = $this->db->query('SELECT * FROM memberships WHERE user_id =' . $data['user_id']);
        if ($endMem) {
            $length = count($endMem);
            $endMem = $endMem[($length - 1)]->date_to;
            $endMem = explode('.', $endMem);
            $endMemDay = (integer)$endMem[0];
            $endMemMonth = (integer)$endMem[1];
            $endMemYear = (integer)$endMem[2];
            
            $startMem = explode('.', $data['date_from']);
            $startMemDay = (integer)$startMem[0];
            $startMemMonth = (integer)$startMem[1];
            $startMemYear = (integer)$startMem[2];
            
            if (
                    $endMemYear > $startMemYear || 
                    ($endMemYear == $startMemYear && $endMemMonth > $startMemMonth) || 
                    ($endMemYear == $startMemYear && $endMemMonth == $startMemMonth && $endMemDay >= $startMemDay)
                ) {
                    $error = 'Korisnik ima pla&#263;enu &#269;lanarinu do ' . $endMemDay . '.' . $endMemMonth . '.' . $endMemYear;
                    $memberships_controller->loadView('memberships/addMembershipErrorPage', $error);
                    die;
                }
        }
        
        unset($data['from_date']);
        unset($data['from_month']);
        unset($data['from_year']);
        unset($data['to_date']);
        unset($data['to_month']);
        unset($data['to_year']);
        unset($data['unesi']);
        unset($data['membership_number']);

        $this->db->insertFields('memberships', $data);
        $memberships_controller->loadView('memberships/successfullyAddedMembership');
    }
    
    /**
     * 
     */
    
    public function findMemberships($memb_ctrl) {
        $data = Validate::isFilled($_POST);
        
        $user_data = $this->db->selectOne('users', ['membership_number' => $data['membership_number']]);
          
        if (!$user_data) {
            $error = 'Uneti &#269;lanski broj ne postoji u bazi.';
            $memb_ctrl->loadView('memberships/findMembershipsError', $error);
            die;
        }
        
        $membs= $this->db->selectSome('memberships', ['user_id' => $user_data->id]);
        unset($data);
        
        $data = [];
        array_push($data, $user_data);
        array_push($data, $membs);
        return $data;
    }
    
    /**
     * 
     * @param type $user_id
     * @param type $memb_id
     */
    
    public function findMemb($memb_id) {
        $memb = $this->db->selectOne('memberships', ['id' => $memb_id]);
        $memb->date_from = explode('.',$memb->date_from);
        $memb->date_to = explode('.',$memb->date_to);
        return $memb;
    }
    
    /**
     * 
     */
    
    public function saveMembDataChange($memb_ctrl) {
        $data = Validate::isFilled($_POST);
        $data['date_from'] = $data['from_date'] . '.' . $data['from_month'] . '.' . $data['from_year'];
        $data['date_to'] = $data['to_date'] . '.' . $data['to_month'] . '.' . $data['to_year'];
        
        unset($data['from_date']);
        unset($data['from_month']);
        unset($data['from_year']);
        unset($data['to_date']);
        unset($data['to_month']);
        unset($data['to_year']);
        
        $this->db->update('memberships', $data, 'id = ' . $data['id']);
        $memb_ctrl->loadView('memberships/membDataChanged');
    }
}