<?php
    session_name("IV");
    session_start();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>