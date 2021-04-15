<?php

function getAccidents($search=NULL) {
    ($search==NULL) ?: $search= date('Y');
    $datas = json_decode(file_get_contents(dirname(__DIR__, 1)."/db/accidents.json"), true);
    $newData = [];
    if ($search != NULL){
        foreach($datas as $data){
            if ($search == get_year($data['date'])){
                array_push($newData, $data);
            }
            
        }
    }
    return $search ? $newData : $datas;
}

function createAccident($data) {
    $accidents = getAccidents();
    $data['id'] = end($accidents)['id'] + 1;
    array_push($accidents, $data);
        
    file_put_contents(dirname(__DIR__, 1)."/db/accidents.json", json_encode($accidents, JSON_PRETTY_PRINT));
}


/**
 * Function that groups an array of associative arrays by some key.
 * 
 * @param {String} $key Property to sort by.
 * @param {Array} $data Array that stores multiple associative arrays.
 */
function group_by($key, $data) {
    $result = array();

    foreach($data as $val) {
        if(array_key_exists($key, $val)){
            $result[$val[$key]][] = $val;
        }else{
            $result[""][] = $val;
        }
    }

    return $result;
}


function get_month($str) {
    $date = strtotime($str);
    $newformat = date('m',$date);
    return $newformat;
}


function get_year($str) {
    $date = strtotime($str);
    $newformat = date('Y',$date);
    return $newformat;
}


function get_year_data($datas, $year=null){
    $newData=array('01' => 0, '02'=>0, '03'=>0, '04'=>0, '05'=>0, '06'=>0, '07'=>0, '08'=>0, '09'=>0, '10'=>0, '11'=>0, '12'=>0);
    ($year == null) ? $year = date('Y') : $year;
    foreach($datas as $data){
        if ($year == get_year($data['date'])){
            $newData[get_month($data['date'])]+= (int)$data['nb_victime'];
        }
        
    }
    return $newData;
}