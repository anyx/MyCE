<?php
$word_items = array();

$word_items = $sf_data->getRaw('result_items');

echo json_encode( $word_items );