<?php
session_start();

$tags = $_POST['tags'] ?? [];

if (count($tags) > 7) {
    $tags = array_slice($tags, 0, 7);
}

$_SESSION['selected_tags'] = $tags;

header("Location: partnership_sketch_confirm.php");
exit;
