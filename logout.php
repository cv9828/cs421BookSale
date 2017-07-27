<?php
require_once 'connect.php';

session_start();
session_unset();
session_destroy();

isLogOutGoToHome();