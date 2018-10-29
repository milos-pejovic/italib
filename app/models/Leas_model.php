<?php
class Leas_model extends Model {
    
    public function enterLeas($leas_ctrl) {
        $data = Validate::isFilled($_POST);

        if ($data['membership_number'] == '') {
            $error = 'Morate uneti &#269;lanski broj korisnika.';
            $leas_ctrl->loadView('leas/enterLeasError', $error);
            die;
        }
        
        if ($data['inventory_number'] == '') {
            $error = 'Morate uneti inventarni broj knjige.';
            $leas_ctrl->loadView('leas/enterLeasError', $error);
            die;
        }
        
        if ($data['from_year'] > $data['to_year'] ||
            ($data['from_year'] == $data['to_year'] && $data['from_month'] > $data['to_month']) ||
            ($data['from_year'] == $data['to_year'] && $data['from_month'] == $data['to_month'] && $data['from_date'] > $data['to_date'])    
            ) {
            $error = 'Datum vra&#263;anja knjige ne mo&#382;e biti raniji od datuma izdavanja knjige.';
            $leas_ctrl->loadView('leas/enterLeasError', $error);
            die;
        }
        
        if ($data['from_year'] == $data['to_year'] && $data['from_month'] == $data['to_month'] && $data['from_date'] == $data['to_date']) {
            $error = 'Datum vra&#263;anja knjige ne mo&#382;e biti isti kao datum izdavanja knjige.';
            $leas_ctrl->loadView('leas/enterLeasError', $error);
            die;
        }
        
    // Checking if the user exists in the database    
        
        $user = $this->db->selectOne('users', ['membership_number' => $data['membership_number']]);
        
        if (!$user) {
            $error = 'Korisnik sa unetim &#269;lanskim brojem ne postoji u bazi.';
            $leas_ctrl->loadView('leas/enterLeasError', $error);
            die;
        }
        
    // Checking if the book exists in the database
        
        $book = $this->db->selectOne('copies', ['inventory_number' => $data['inventory_number']]);
        
        if (!$book) {
            $error = 'Knjiga sa unetim inventarnim brojem ne postoji u bazi.';
            $leas_ctrl->loadView('leas/enterLeasError', $error);
            die;
        }
        
    // Checking if the is already leased
        
        if ($book->status == 'leased') {
            $error = 'Ova kopija knjige je ve&#263; izdata.';
            $leas_ctrl->loadView('leas/enterLeasError', $error);
            die;
        }
        
    // Checking if the user has membership
        
        $memb = $this->db->selectSome('memberships', ['user_id' => $user->id]);
        
        if (!$memb) {
            $error = 'Uneti korisnik nema upla&#263;enu &#269;lanarinu.';
            $leas_ctrl->loadView('leas/enterLeasError', $error);
            die;
        }
        
    // Checking if the book rental period is within user's membership
        
        $length = count($memb);
        $memb = $memb[($length - 1)];
        $m_date_from = explode('.', $memb->date_from);
        $m_date_to = explode('.', $memb->date_to);
   
        if ($data['from_year'] < $m_date_from[2] ||
            ($data['from_year'] == $m_date_from[2] && $data['from_month'] < $m_date_from[1]) ||
            ($data['from_year'] == $m_date_from[2] && $data['from_month'] == $m_date_from[1] && $data['from_date'] == $m_date_from[0])) 
        {
            $error = 'Korisnikova &#269;lanarina po&#269;inje ' . $m_date_from[0] . '.' . $m_date_from[1] . '.' . $m_date_from[2] 
                    . ', a datum izdavanja knjige je ' . $data['from_date'] . '.' . $data['from_month'] . '.' . $data['from_year'] . 
                    '.<br /> Datum izdavanja knjige mora biti kasniji od datuma po&#269etka &#269;lanarine.';
            $leas_ctrl->loadView('leas/enterLeasError', $error);
            die;
        }
        
        if ($data['to_year'] > $m_date_to[2] ||
            ($data['to_year'] == $m_date_to[2] && $data['to_month'] > $m_date_to[1]) ||
            ($data['to_year'] == $m_date_to[2] && $data['to_month'] == $m_date_to[1] && $data['to_date'] == $m_date_to[0])) 
        {
            $error = 'Korisnikova &#269;lanarina traje do ' . $m_date_to[0] . '.' . $m_date_to[1] . '.' . $m_date_to[2] 
                    . ', a datum najkasnijeg vra&#263;anja knjige je ' . $data['to_date'] . '.' . $data['to_month'] . '.' . $data['to_year'] . 
                    '.<br /> Datum najkasnijeg vra&#263;anja knjige mora biti raniji od datuma kraja &#269;lanarine.';
            $leas_ctrl->loadView('leas/enterLeasError', $error);
            die;
        }
        
        $query_data['date_of_leas'] = $data['from_date'] . '.' . $data['from_month'] . '.' . $data['from_year'];
        $query_data['latest_date_of_return'] = $data['to_date'] . '.' . $data['to_month'] . '.' . $data['to_year'];
        $query_data['member_id'] = $user->id;
        $query_data['copy_id'] = $book->copy_id;

        $this->db->insertFields('leasing', $query_data);
        
        $this->db->update('copies', ['status' => 'leased'], 'copy_id = ' . $book->copy_id);
        
    // Getting the number of available copies from the books table    
        
        $available_copies = $this->db->query('SELECT available_copies FROM books WHERE book_id = ' . $book->title . ';');
        $available_copies = $available_copies[0]->available_copies;
        $available_copies--;
        
        $this->db->update('books', ['available_copies' => $available_copies], 'book_id = ' . $book->title);
        $leas_ctrl->loadView('leas/leasEntered');
    }
    
    /**
     * 
     */
    
    public function returnBook($leas_ctrl) {
        $data = Validate::isFilled($_POST);

    // Checking if the user exists in the database    
        
        $user = $this->db->selectOne('users', ['membership_number' => $data['membership_number']]);
        
        if (!$user) {
            $error = 'Korisnik sa unetim &#269;lanskim brojem ne postoji u bazi.';
            $leas_ctrl->loadView('leas/returnBookError', $error);
            die;
        }
        
    // Checking if the book exists in the database
        
        $book = $this->db->selectOne('copies', ['inventory_number' => $data['inventory_number']]);
        
        if (!$book) {
            $error = 'Knjiga sa unetim inventarnim brojem ne postoji u bazi.';
            $leas_ctrl->loadView('leas/returnBookError', $error);
            die;
        }
        
    // Checking if the book is already returned
        
        if ($book->status == 'available') {
            $error = 'Knjiga sa unetim inventarnim brojem trenutno nije izdata.';
            $leas_ctrl->loadView('leas/returnBookError', $error);
            die;
        }
    
    // Sending data to database    
        
        $date_of_return = $data['from_date'] . '.' . $data['from_month'] . '.' . $data['from_year'];
 
        $where = 'member_id = ' . $user->id . 
                ' AND copy_id = ' . $book->copy_id . 
                ' AND date_of_return is null';
        
        
        $this->db->update('leasing', ['date_of_return' => $date_of_return], $where);
        
    // Getting the number of available copies from the books table    
        
        $available_copies = $this->db->query('SELECT available_copies FROM books WHERE book_id = ' . $book->title . ';');
        $available_copies = $available_copies[0]->available_copies;
        $available_copies++;
        
        $this->db->update('books', ['available_copies' => $available_copies], 'book_id = ' . $book->title);
        
        $this->db->update('copies', ['status' => 'available'], 'copy_id = ' . $book->copy_id);
        $leas_ctrl->loadView('leas/returnAdded');
    }
}