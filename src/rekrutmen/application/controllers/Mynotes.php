<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author ITD15
 */

class Mynotes extends CI_Controller{
    public function __construct() {
        parent::__construct();
        
        $this->load->model('m_notes','mynotes');
        $this->load->library('calendar', $this->_setting());
    }
    
    public function index(){
        redirect('mynotes/notes');
    }
            
    function _month($mon){
        $mon    = (int) $mon;
        switch ($mon){
            case 1: $mon    = 'Januari';    break;
            case 2: $mon    = 'Februari';   break;
            case 3: $mon    = 'Maret';      break;
            case 4: $mon    = 'April';      break;
            case 5: $mon    = 'Mei';        break;
            case 6: $mon    = 'Juni';       break;
            case 7: $mon    = 'Juli';       break;
            case 8: $mon    = 'Agustus';    break;
            case 9: $mon    = 'September';  break;
            case 10: $mon   = 'Oktober';    break;
            case 11: $mon   = 'November';   break;
            case 12: $mon   = 'Desember';   break;
        }
        return $mon;
    }
    
    function add_note($date){
        $data   = array(
            'day'   => $date,
            'mon'   => $this->input->post('mon'),
            'month' => $this->_month($this->input->post('mon')),
            'year'  => $this->input->post('year')
        );
        $this->load->view('utility/event_note/add_note', $data);
    }
    
    function do_add($year, $mon, $day){
        $this->mynotes->addNote($year, $mon, $day, $this->input->post('note', TRUE));
        $this->notes($year, $mon);
    }
    
    function updel_note($date){
        $date = array(
            'day'   => $date,
            'mon'   => $this->input->post('mon'),
            'month' => $this->_month($this->input->post('mon')),
            'year'  => $this->input->post('year'),
            'note'  => $this->mynotes->getNote($this->input->post('year'), $this->input->post('mon'), $date)
        );
        $this->load->view('utility/event_note/updel_note', $date);
    }
    
    function edit_note($year, $mon, $day){
        $this->mynotes->editNote($year, $mon, $day, $this->input->post('note', TRUE));
        $this->notes($year, $mon);
    }

    function delete_note($year, $mon, $day){
        $this->mynotes->deleteNote($year, $mon, $day);
        $this->notes($year, $mon);
    }
    
    function notes($year = NULL, $mon = NULL){
        $year   = (empty($year)|| !is_numeric($year)) ? date('Y') :$year;
        $mon    = (empty($mon)|| !is_numeric($mon)) ? date('m') :$mon;
        
        $date   = $this->mynotes->getCalendar($year, $mon);
        $data   = array(
            'notes' => $this->calendar->generate($year, $mon, $date),
            'year'  => $year,
            'mon'   => $mon
        );
        $this->load->view('utility/event_note/mynotes', $data);
    }
    
    function _setting(){
        return array(
            'start_day'         => 'sunday',
            'show_next_prev'    => true,
            'next_prev_url' 	=> site_url('mynotes/notes'),
            'month_type'        => 'long',
            'day_type'          => 'short',
            'template'          => '{table_open}<table class="date">{/table_open}
                                   {heading_previous_cell}<caption><a href="{previous_url}" class="prev_date" title="Previous Month">&lt;&lt;</a>{/heading_previous_cell}
                                   {heading_title_cell}{heading}{/heading_title_cell}
                                   {heading_next_cell}<a href="{next_url}" class="next_date"  title="Next Month">&gt;&gt;</a></caption>{/heading_next_cell}
                                   {heading_row_end}<col class="weekend_sun"><col class="weekday" span="5"><col class="weekend_sat">{/heading_row_end}
                                   {week_row_start}<thead><tr>{/week_row_start}
                                   {week_day_cell}<th>{week_day}</th>{/week_day_cell}
                                   {week_row_end}</tr></thead><tbody>{/week_row_end}
                                   {cal_row_start}<tr>{/cal_row_start}
                                   {cal_cell_start}<td>{/cal_cell_start}
                                   {cal_cell_content}<a href="'.site_url('mynotes/updel_note').'/{day}" class="act_note" title="Edit/hapus catatan untuk tanggal {day}"><div class="active act_note" val="{day}" title="Edit/Hapus catatan untuk tanggal {day}">{day}</div></a><div class="notes">{content}</div></div>{/cal_cell_content}
                                   {cal_cell_content_today}<a href="'.site_url('mynotes/updel_note').'/{day}" class="act_note" title="Edit/hapus catatan untuk tanggal {day}"><div class="t_active" title="Edit/Hapus catatan untuk tanggal {day}">{day}</div></a><div class="t_notes">{content}</div>{/cal_cell_content_today}
                                   {cal_cell_no_content}<a href="'.site_url('mynotes/add_note').'/{day}" class="act_note" title="Tambah catatan untuk tanggal {day}"><div class="day" title="Tambah catatan untuk tanggal {day}">{day}</div></a>{/cal_cell_no_content}
                                   {cal_cell_no_content_today}<a href="'.site_url('mynotes/add_note').'/{day}" class="act_note" title="Tambah catatan untuk tanggal {day}"><div class="today" title="Tambah catatan untuk tanggal {day}">{day}</div></a>{/cal_cell_no_content_today}
                                   {cal_cell_blank}&nbsp;{/cal_cell_blank}
                                   {cal_cell_end}</td>{/cal_cell_end}
                                   {cal_row_end}</tr>{/cal_row_end}
                                   {table_close}</tbody></table>{/table_close}');
    }
        
}