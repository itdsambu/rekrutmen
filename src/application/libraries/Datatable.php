<?php

/*
 *
 * SERVER SIDE DATATABLE SERVER SIDE LIBRARY CODE IGNITER 3
 * CREATED BY FARIH NAZIHULLAH
 *
 */

# Tested on SQL SERVER
# PHP 5.6 up
# CI 3

defined('BASEPATH') OR exit('No direct script access allowed');


class Datatable
{
    private $db;
    private $table;
    private $primary_key;
    private $where;

    public function __construct($config)
    {
    	$_CI =& get_instance();
    	$this->db = $_CI->load->database('default',true);
    	$this->table = $config['table_name'];
    	$this->primary_key = $config['primary_key'];
    	if(isset($config['where'])){
    	    $this->where = $config['where'];
        }
    }

    public function make($data){
        # Prepare Query
        $param['search_column'] = [];
        $param['order_by'] = [
            'column' => $this->primary_key,
            'dir' => 'asc'
        ];
        $offset = 0;
        $limit = 10;

        if(isset($data['order'])){
            $order = $data['order'][0];
            if($order['column']!=0){
                $param['order_by'] = $order;
            }else{
                $param['order_by']['dir'] = $order['dir'];
            }
        }

        if(isset($data['start'])){
            $offset = $data['start'];
        }

        if(isset($data['length'])){
            $limit = $data['length'];
        }

        $param['keyword'] = (isset($data['search']['value'])) ? $data['search']['value'] : '';

        # Get Column Information Searchable
        if(isset($data['columns']))
        {
            foreach($data['columns'] as $column) {
                if(!in_array($column['data'],['index','update','delete'])){
                    if($column['searchable'] == 'true')
                    {
                        array_push($param['search_column'],$column['data']);
                    }
                }
            }
        }


        $data['recordsTotal'] = $this->query(false,$param,true)->num_rows();
        $data['recordsFiltered'] = $this->query(true,$param,true)->num_rows();
        $data['data'] = $this->query(true,$param,false,$limit,$offset)->result();


        $index = 1;
        if($param['order_by']['dir']=='asc'){
            $numbering_start = intval($offset);
        }else{
            $numbering_start = $data['recordsFiltered']-intval($offset)+1;
        }

        foreach($data['data'] as $item){
            if($param['order_by']['dir']=='asc'){
                $item->index =  $numbering_start + ($index++);
            }else{
                $item->index =  $numbering_start - ($index++);
            }

        }

        return $data;
    }

    protected function query($filtered=false,$param=[],$count=false,$limit=0,$offset=0)
    {
        if($filtered)
        {
            $search = '';
            foreach($param['search_column'] as $key => $sc ){
                if($key == 0){
                    $search .= "CAST($sc AS varchar) LIKE '%{$param['keyword']}%'";
                }else{
                    $search .= " OR CAST($sc AS varchar) LIKE '%{$param['keyword']}%'";
                }
            }

            if($search!='')
            {
                $this->db->where("($search)");
            }
        }

        if(!empty($this->where)){
            $this->db->where($this->where);
        }

        if(!$count){
            $this->db->order_by($param['order_by']['column'],$param['order_by']['dir']);
        }
        


        $this->db->from($this->table);

        $sql = $this->db->get_compiled_select();

        if(!$count)
        {
            $sql .= " OFFSET $offset ROWS FETCH NEXT $limit ROWS ONLY";
        }
        
        return $this->db->query($sql);
    }
}
