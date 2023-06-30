<?php
    include ($_SERVER["DOCUMENT_ROOT"] . "/inc/param.php");
    $sql = "select * from sports s, sports_descriptions d WHERE s.sport_num = d.sport_num AND s.sport_visible = 1 AND d.langue_num = 1";
    $result = $db->query($sql);
    $sports_name = array();
    foreach ($result['tab'] as $item) {
        $sport = array('titre' => $item['sport_nom'], 'nbr' => 0);
        array_push($sports_name, $sport); 
    }
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta charset="UTF-8">
    <title>Liste de Sports</title>
    <style>
        .sports-list {
            list-style-type: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 10px;
        }
        .sports-list li {
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        /* Styles pour le pop-up */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
        }
        .popup-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        .popup-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }
        .popup-description {
            color: #666;
            margin-bottom: 20px;
        }
        .popup-close-btn {
            background-color: #ff3366;
            color: #fff;
            padding: 8px 16px;
            border-radius: 3px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .popup-close-btn:hover {
            background-color: #e6004c;
        }
    </style>
</head>
<body>
    <div id="back"></div>
    <ul class="sports-list">
        <?php
            foreach ($sports_name as $var) {
                $name = $var['titre'];
                echo "<li>
                    <form method='post' class='myForm'>
                        <input type='submit' name='sport.$name' class='form-submit' value='$name'></input>
                    </form>
                </li>";
            }
        ?>
    </ul>

    <div class="popup-overlay" id="popupOverlay">
        <div class="popup-content" id="popupContent">
            <h2 class="popup-title" id="popupTitle"></h2>
            <p class="popup-description" id="popupDescription"></p>
            <button class="popup-close-btn" onclick="hidePopup()">Fermer</button>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.myForm').submit(function(event) {
                event.preventDefault();
                var value = $(this).find('.form-submit').val();
                console.log(value);
                $.ajax({
                    url: 'send_message.php',
                    type: 'POST',
                    data: { message: value },
                    success: function(reponse) {
                        var back = JSON.parse(reponse);
                        console.log(back);
                        $('#popupTitle').text(back.nom);
                        $('#popupDescription').text(back.desc);
                        showPopup();
                    }
                });
            });
        });

        function showPopup() {
            $('#popupOverlay').fadeIn();
        }

        function hidePopup() {
            $('#popupOverlay').fadeOut();
        }
    </script>
</body>
</html>
