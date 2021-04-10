<?php

function getAccidents() {
    return json_decode(file_get_contents(dirname(__DIR__, 1)."/db/accidents.json"), true);
}

function createAccident($data) {
    $accidents = getAccidents();
    $data['id'] = end($accidents)['id'] + 1;
    array_push($accidents, $data);
        
    file_put_contents(dirname(__DIR__, 1)."/db/accidents.json", json_encode($accidents, JSON_PRETTY_PRINT));
}