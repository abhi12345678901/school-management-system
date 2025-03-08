<?php

class Model_Insert extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function insertdata()
    {

        $userName = $this->input->post('userName');
        $email = $this->input->post('email');
        $insertdate = $this->input->post('date');
        $data = array(
            'username' => $userName,
            'email' => $email,
            'date' => $insertdate
        );
        $this->db->insert('user', $data);
    }

    public function fetchdata()
    {
        $query = $this->db->query("select * from admission a inner join payment p on
        a.student_id = p.student_id inner join payment_name m on 
        p.payment_name_id = m.id WHERE m.id IN(
        SELECT MAX(m.id) FROM admission a inner join payment p on a.student_id = p.student_id inner join payment_name m on p.payment_name_id = m.id GROUP by a.student_id
        );");
        return $query->result();
    }

    public function insertname($session, $st_status, $updatePaybleAmount, $discount, $paymentname, $updateStartDate, $paymentid, $paymentnameid, $updateduration, $totalfee, $updatetotalfee, $updateDueAmount, $transportfee, $updatepayabletransportfee, $monthlyfee, $updatepayablemonthlyfee, $regNo, $classid, $sectionid, $studentid, $date, $status)
    {
        //echo $paymentname;
        //exit();
        $lastdate = strtotime($date);
        $currentDate = strtotime(date("d-m-Y"));
        $startDate = date("Y-m-01", $currentDate);
        $lastDate = date("Y-m-t", $currentDate);
        //echo strval($paymentname);

        if ($currentDate > $lastdate && $st_status == 0) {

            //echo trim($paymentname);
            //exit();
            if ($paymentname == 0) {
                $paymentdata = array(
                    //'student_id' => $userid,
                    //'end_date' => $date
                    'name' => 'Monthly Fee',
                    'start_date'     => $startDate,
                    'end_date'         => $lastDate,
                    'total_amount'     => $totalfee,
                    'total_payableamount'     => $totalfee,
                    'reg_no'         => $regNo,
                    'transport_fee'  => $transportfee,
                    'payabletransportfee'  => $transportfee,
                    'duration'  => 1,
                    'monthly_fee'    => $monthlyfee,
                    'payablemonthlyfee'    => $monthlyfee,
                    'type'            => 1
                );
                $this->db->insert('payment_name', $paymentdata);
                $payment_name_id = $this->db->insert_id();

                $data = array(
                    //'student_id' => $userid,
                    // 'date' => $date
                    'name' => 'Monthly Fee',
                    'payment_type'         => '1',
                    'due_amount'         => $totalfee,
                    'session'             => $session,
                    'status'             => '2',
                    'class_id'         => $classid,
                    'section_id'     => $sectionid,
                    'student_id'     => $studentid,
                    'payment_name_id' => $payment_name_id
                );
                $this->db->insert('payment', $data);
            } else if ($paymentname == 1) {
                if ($status == 0 || $status == 2) {
                    $paymentdata = array(
                        //'student_id' => $userid,
                        //'end_date' => $date
                        'name' => 'Monthly Fee',
                        'start_date'     => $updateStartDate,
                        'end_date'         => $lastDate,
                        'total_amount'     => $updatetotalfee,
                        'total_payableamount'     => $updatePaybleAmount,
                        'discount'     => $discount,
                        'reg_no'         => $regNo,
                        'transport_fee'  => $transportfee,
                        'payabletransportfee'  => $updatepayabletransportfee,
                        'duration'  => $updateduration,
                        'monthly_fee'    => $monthlyfee,
                        'payablemonthlyfee'    => $updatepayablemonthlyfee,
                        'type'            => 1
                    );
                    $this->db->where('id', $paymentnameid);
                    $this->db->update('payment_name', $paymentdata);
                    // $payment_name_id = $this->db->update_id();

                    $data = array(
                        //'student_id' => $userid,
                        // 'date' => $date
                        'name' => 'Monthly Fee',
                        'payment_type'         => '1',
                        'due_amount'         => $updateDueAmount,
                        'session'             => $session,
                        'status'             => '2',
                        'class_id'         => $classid,
                        'section_id'     => $sectionid,
                        'student_id'     => $studentid,
                        'payment_name_id' => $paymentnameid
                    );
                    $this->db->where('payment_id', $paymentid);
                    $this->db->update('payment', $data);
                } elseif ($status == 1) {
                    $paymentdata = array(
                        //'student_id' => $userid,
                        //'end_date' => $date
                        'name' => 'Monthly Fee',
                        'start_date'     => $startDate,
                        'end_date'         => $lastDate,
                        'total_amount'     => $totalfee,
                        'total_payableamount'     => $totalfee,
                        'discount'     => $discount,
                        'reg_no'         => $regNo,
                        'transport_fee'  => $transportfee,
                        'payabletransportfee	'  => $transportfee,
                        'duration'  => 1,
                        'monthly_fee'    => $monthlyfee,
                        'payablemonthlyfee'    => $monthlyfee,
                        'type'            => 1
                    );
                    $this->db->insert('payment_name', $paymentdata);
                    $payment_name_id = $this->db->insert_id();

                    $data = array(
                        //'student_id' => $userid,
                        // 'date' => $date
                        'name' => 'Monthly Fee',
                        'payment_type'         => '1',
                        'due_amount'         => $totalfee,
                        'session'             => $session,
                        'status'             => '2',
                        'class_id'         => $classid,
                        'section_id'     => $sectionid,
                        'student_id'     => $studentid,
                        'payment_name_id' => $payment_name_id
                    );
                    $this->db->insert('payment', $data);
                }
                ///if else end
            }
        } else {
            return false;
        }
    }
}
