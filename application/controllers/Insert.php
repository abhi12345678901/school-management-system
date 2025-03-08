<?php

class Insert extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_Insert');
    }
    public function index()
    {
        $this->load->view('insert');
    }

    public function insertt()
    {
        $this->Model_Insert->insertdata();
        $this->load->view('insert');
    }

    public function fetch()
    {

        $result = $this->Model_Insert->fetchdata();
        // echo $result;
        echo ("<table border='1'>");

        $i = 1;
        echo ("<tr>");

        echo ("<th>Sr. No</th>");
        echo ("<th>Discount</th>");
        echo ("<th>Payment Name</th>");
        echo ("<th>Payment ID</th>");
        echo ("<th>PaymentName ID</th>");
        echo ("<th>Class ID</th>");
        echo ("<th>Section ID</th>");
        echo ("<th>Student ID</th>");
        echo ("<th>Transport Fee</th>");
        echo ("<th>Payable Transport Fee</th>");
        echo ("<th>Monthly Fee</th>");
        echo ("<th>Payable Monthly Fee</th>");
        echo ("<th>Duration</th>");
        echo ("<th>Transport Fee</th>");
        echo ("<th>Monthly Fee</th>");

        echo ("<th>Due Amount</th>");

        echo ("<th>Total Fee</th>");
        echo ("<th>Reg No</th>");
        echo ("<th>Status</th>");
        echo ("<th>Student Status</th>");
        echo ("</tr>");
        foreach ($result as $row) {


            echo ("<tr>");
            echo ("<td>" . $i . "</td>");
            echo ($session = $row->session);
            echo ("<td>" . $discount = $row->discount . "</td>");
            echo ("<td>" . $row->name . "</td>");
            echo ("<td>" . $paymentid = $row->payment_id . "</td>");
            echo ("<td>" . $paymentnameid = $row->id . "</td>");
            echo ("<td>" . $classid = $row->class_id . "</td>");
            echo ("<td>" . $sectionid = $row->section_id . "</td>");
            echo ("<td>" . $studentid = $row->student_id . "</td>");
            echo ("<td>" . $transportfee = $row->transport_fee . "</td>");
            echo ("<td>" . $payabletransportfee = $row->payabletransportfee . "</td>");
            echo ("<td>" . $monthlyfee = $row->monthly_fee . "</td>");
            echo ("<td>" . $payablemonthlyfee = $row->payablemonthlyfee . "</td>");
            echo ("<td>" . $duration = $row->duration . "</td>");
            echo ("<td>" . $due_amount = $row->due_amount . "</td>");
            //$transportfee = ((int)$paidtransportfee)/((int)$duration);
            //$monthlyfee = ((int)$paidmonthlyfee)/((int)$duration);
            $updatepayabletransportfee = (float)$payabletransportfee + (float)$transportfee;
            $updatepayablemonthlyfee = (float)$payablemonthlyfee + (float)$monthlyfee;
            $updateDueAmount = (float)$transportfee + (float)$monthlyfee + (float)$due_amount;
            $updatetotalfee = (float)$payabletransportfee + (float)$transportfee + (float)$payablemonthlyfee + (float)$monthlyfee;
            $updateduration = (int)$duration + 1;

            $totalfee =  (float)$transportfee + (float)$monthlyfee;
            echo ("<td>" . $transportfee . "</td>");
            echo ("<td>" . $monthlyfee . "</td>");

            echo ("<td>" . $totalfee . "</td>");
            echo ($regNo = $row->reg_no);
            echo ("<td>" . $status = $row->status . "</td>");
            echo ("<td>" . $st_status = $row->st_status . "</td>");
            echo ("</tr>");
            //echo $row->paid_amount;
            echo $updateStartDate = $row->start_date;
            echo $date = $row->end_date;
            if ($row->name == "Admission Fee") {
                $paymentname = 0;
                $updatePaybleAmount = "";
            } else if ($row->name == "Monthly Fee") {
                $paymentname = 1;
                if ($due_amount == 0) {
                    $discount = 0;
                    $status = 1;
                    $updatePaybleAmount = $updatetotalfee;
                } elseif ($due_amount != 0) {
                    $updatetotalfee = $updatetotalfee + (float)$row->p_examination_fee + (float)$row->p_tie + (float)$row->p_belt + (float)$row->p_diary + (float)$row->p_development_fee + (float)$row->late_fine;
                    $updatePaybleAmount = $updatetotalfee - (float)$discount;
                }
            }
            $this->Model_Insert->insertname($session, $st_status, $updatePaybleAmount, $discount, $paymentname, $updateStartDate, $paymentid, $paymentnameid, $updateduration, $totalfee, $updatetotalfee, $updateDueAmount, $transportfee, $updatepayabletransportfee, $monthlyfee, $updatepayablemonthlyfee, $regNo, $classid, $sectionid, $studentid, $date, $status);
            $i++;
        }
        echo ("</table>");
    }
}
