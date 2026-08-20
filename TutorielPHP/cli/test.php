<?php

require_once 'class/Form.php';

echo Form::$class . PHP_EOL; 

echo Form::checkbox('demo', '1', ['demo' => '1']) . PHP_EOL;

echo Form::radio('gender', 'M', ['gender' => 'M']) . PHP_EOL;

echo Form::select('country', ['fr' => 'France', 'en' => 'England'], ['country' => 'fr']) . PHP_EOL;