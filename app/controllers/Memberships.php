<?php
class Memberships extends Controller {
    
    public function index() {
        $this->checkLog();
        $this->checkLib();
        $this->loadView('memberships/index');
    }
    
    public function addMembership() {
        $this->checkLog();
        $this->checkLib();
        $this->model->addMembership($this);
    }

    public function membOverviewPage() {
        $this->checkLog();
        $this->checkLib();
        $this->loadView('memberships/membOverviewPage');
    }
    
    public function findMemberships() {
        $this->checkLog();
        $this->checkLib();
        $membs = $this->model->findMemberships($this);
        $this->loadView('memberships/membOverviewPage', $membs);
    }
    
    public function changeMembsDataPage($memb_id) {
        $this->checkLog();
        $this->checkLib();
        $membership = $this->model->FindMemb($memb_id);
        $this->loadView('memberships/changeMembsDataPage', $membership);
    }
    
    public function saveMembDataChange() {
        $this->model->saveMembDataChange($this);
    }
    
}