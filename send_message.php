<?php
    include ($_SERVER["DOCUMENT_ROOT"] . "/inc/param.php");
    $sql = "select * from sports_descriptions  WHERE sport_nom = '".$message."' AND langue_num = 1";
    $result = $db->query($sql);
    $nom = $result['tab'][0]['sport_nom'];
    $description = $result['tab'][0]['sport_description'];
    $return = array('nom'=>$nom, 'desc'=>$description);
    $return = json_encode($return);
    echo $return;
?>

