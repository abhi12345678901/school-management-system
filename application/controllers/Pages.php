<?php 

class Pages extends MY_Controller
{
	public function view($page = 'adminlogin')
	{
        if (!file_exists(APPPATH.'views/'.$page.'.php'))
        {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $data['title'] = ucfirst($page); // Capitalize the first letter

        if($page == 'section' || $page == 'subject' || $page == 'student' || $page == 'marksheet' || $page == 'accounting' || $page == 'admission' || $page == 'printadmissionslip' || $page == 'transfercertificate' || $page == 'studentpayment' || $page == 'marksheetsubject') {
            $this->load->model('Model_Classes');
            $data['classData'] = $this->Model_Classes->fetchClassData();

            $this->load->model('Model_Teacher');
            $data['teacherData'] = $this->Model_Teacher->fetchTeacherData();

            
            $this->load->model('Model_Accounting');
            $data['totalIncome'] = $this->Model_Accounting->totalIncome();
            $data['totalExpenses'] = $this->Model_Accounting->totalExpenses();
            $data['totalBudget'] = $this->Model_Accounting->totalBudget();
        }


        if($page == 'setting') {
            $this->load->model('Model_Users');
            $this->load->library('session');
            $userId = $this->session->userdata('id');
            $data['userData'] = $this->Model_Users->fetchUserData($userId);
        }

        if($page == 'dashboard') {
            $this->load->model('Model_Student');
            $this->load->model('Model_Teacher');
            $this->load->model('Model_Classes');
            $this->load->model('Model_Marksheet');
            $this->load->model('Model_Accounting');

            $data['countTotalStudent'] = $this->Model_Student->countTotalStudent();
            $data['countTotalTeacher'] = $this->Model_Teacher->countTotalTeacher();
            $data['countTotalClasses'] = $this->Model_Classes->countTotalClass();
            $data['countTotalMarksheet'] = $this->Model_Marksheet->countTotalMarksheet();

            $data['totalIncome'] = $this->Model_Accounting->totalIncome();
            $data['totalExpenses'] = $this->Model_Accounting->totalExpenses();
            $data['totalBudget'] = $this->Model_Accounting->totalBudget();
        }

        if($page == 'adminlogin') {
            $data['title'] = 'ADMIN PANEL';
            $this->isLoggedIn();
            $this->load->view($page, $data);
        } 
        else if($page == 'userlogin') {
            $data['title'] = 'USER PANEL';
            $this->isLoggedIn();
            $this->load->view($page, $data);
        }
        else{
            $this->isNotLoggedIn();

            $this->load->view('templates/header', $data);
            $this->load->view($page, $data);    
            $this->load->view('templates/footer', $data);    
        }
	}
    
}