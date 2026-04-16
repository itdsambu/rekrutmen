<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Author by ITD15
 */

class Chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        
        if(!$this->session->userdata('userid')){
            redirect('login');
        }

        date_default_timezone_set("Asia/Jakarta");
        $this->load->model(array('m_chat'));

        $this->load->library('table');
        $this->load->helper('smiley');
    }

    public function index() {
        $image_array = get_clickable_smileys(base_url() . 'assets/emot/', 'txtMessage');
        $col_array = $this->table->make_columns($image_array, 6);
        $data['smiley_table'] = $this->table->generate($col_array);

        $this->template->display('utility/chat/index', $data);
    }
    
    function sendMessage(){        
        $data   = array(
            'IDLogin'   => trim(strip_tags($this->session->userdata('userid'))),
            'Message'   => trim(strip_tags($this->input->post('txtMessage'))),
            'Date'      => date('Y-m-d H:i:s')
        );
        $this->m_chat->insertChat($data);
    }
    
    function viewMessage() {
        $selectChat = $this->m_chat->selectChat();
//        foreach ($selectChat as $row) {
//            $str = parse_smileys($row->Message, base_url() . "assets/emot/");
//            $datetime   = $this->timeAgo($row->Date);
//            echo "<p><a id='chat" . $row->DetailID . "' title='Hapus'>x</a>&nbsp;<strong>" . $row->NamaUser . "</strong>&nbsp;(" . $datetime. ")&nbsp;: " . $str . "</p>";
//        }
        
        echo '<div class="timeline-container">
                <div class="timeline-items">';
        foreach ($selectChat as $row): 
            $str = parse_smileys($row->Message, base_url() . "assets/emot/");
            $datetime   = $this->timeAgo($row->Date);
            $time       = date('H:i',  strtotime($row->Date));
                    echo '<div class="timeline-item clearfix">
                        <div class="timeline-info">';
                    
                    if($row->AdaPhoto == 0){
                        echo '<img alt="'.$row->NamaUser.' Avatar" src="'.base_url().'dataupload/fotoProfil/no-avatar.png">';
                    }else{
                        echo '<img alt="'.$row->NamaUser.' Avatar" src="'.base_url().'dataupload/fotoProfil/'.$row->IDLogin.'.png">';
                    }
                            echo '<span class="label label-info label-sm">'.$time.'</span>
                        </div>

                        <div class="widget-box transparent">
                            <div class="widget-header widget-header-small">
                                <h5 class="widget-title smaller">';
                    if($row->NamaDepan == NULL){
                        echo '<span class="blue"><strong>'.ucwords(strtolower($row->NamaUser)).'</strong></span>';
                    }else{
                        echo '<span class="blue"><strong>'.ucwords(strtolower($row->NamaDepan)).'</strong></span>';
                    }
                                echo '&nbsp;<span class="grey">says</span>
                                </h5>
                                <span class="widget-toolbar no-border">
                                    <i class="ace-icon fa fa-clock-o bigger-110"></i>
                                    <small>'.$datetime.'</small>
                                </span>
                            </div>

                            <div class="widget-body" style="display: block;">
                                <div class="widget-main">
                                    '.$str.'
                                </div>
                            </div>
                        </div>
                    </div>';
        endforeach;
        
        echo'</div></div>';
    }
    
    function timeAgo($datetime){
        $time_ago = strtotime($datetime);
        $cur_time   = time();
        $time_elapsed   = $cur_time - $time_ago;
        $seconds    = $time_elapsed ;
        $minutes    = round($time_elapsed / 60 );
        $hours      = round($time_elapsed / 3600);
        $days       = round($time_elapsed / 86400 );
        $weeks      = round($time_elapsed / 604800);
        $months     = round($time_elapsed / 2600640 );
        $years      = round($time_elapsed / 31207680 );
        // Seconds
        if($seconds <= 60){
            return "just now";
        }
        //Minutes
        else if($minutes <=60){
            if($minutes==1){
                return "one minute ago";
            }
            else{
                return "$minutes minutes ago";
            }
        }
        //Hours
        else if($hours <=24){
            if($hours==1){
                return "an hour ago";
            }else{
                return "$hours hrs ago";
            }
        }
        //Days
        else if($days <= 7){
            if($days==1){
                return "yesterday";
            }else{
                return "$days days ago";
            }
        }
        //Weeks
        else if($weeks <= 4.3){
            if($weeks==1){
                return "a week ago";
            }else{
                return "$weeks weeks ago";
            }
        }
        //Months
        else if($months <=12){
            if($months==1){
                return "a month ago";
            }else{
                return "$months months ago";
            }
        }
        //Years
        else{
            if($years==1){
                return "one year ago";
            }else{
                return "$years years ago";
            }
        }
    }
}