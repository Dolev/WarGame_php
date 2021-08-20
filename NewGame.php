<!DOCTYPE html>
<html lang="he">
<html dir="rtl" lang= "he-il">
<meta charset= "utf-8">
<head>
    <meta charset="UTF-8">
    <title> warGame dolev !</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
    
   
// אם הגדרתי את הכפתור רדיו שלי.
    $isContinue = isset($_POST['isContinue']) ? $_POST['isContinue']: '';  
   
   
    
// אם לחצו על התחל או בחרו להמשיך סיבוב נוסף מופיע דף המשחק, מוגרלים מספרים ונצברות נקודות

if (isset($_POST["start"]) || ($isContinue == "yes")) {
    session_start();
    // יצירת משתנה שמות השחקנים
    $FPlayer="";
    $SPlayer="";
    if(isset($_POST["FPlayer"]) && isset($_POST["SPlayer"])){
        $FPlayer = $_POST["FPlayer"];
        $SPlayer = $_POST["SPlayer"];
        $_SESSION["FPlayer"] = $_POST["FPlayer"];
        $_SESSION["SPlayer"] = $_POST["SPlayer"];
        $_SESSION["score1"] = 0;
        $_SESSION["score2"] = 0;
    }
    //  pre_r($_SESSION);
    // חפיסת הקלפים שלנו:
    $deck = array(
        '2D', '3D', '4D', '5D', '6D', '7D', '8D', '9D', 'TD', 'JD', 'QD', 'KD', 'AD',
        '2C', '3C', '4C', '5C', '6C', '7C', '8C', '9C', 'TC', 'JC', 'QC', 'KC', 'AC',
        '2H', '3H', '4H', '5H', '6H', '7H', '8H', '9H', 'TH', 'JH', 'QH', 'KH', 'AH',
        '2S', '3S', '4S', '5S', '6S', '7S', '8S', '9S', 'TS', 'JS', 'QS', 'KS', 'AS'
    );

    $Card_Player1 = array_rand($deck, 1);
    $Card_Player2 = array_rand($deck, 1);
    // תנאי שמטרתו לשנות את הקלף עד שיצא קלף ששונה מהכלף של שחקן מספר 1  
    while($Card_Player1==$Card_Player2){
       $Card_Player2 = array_rand($deck, 1);
    }

    

    // הסבר התנאי הוא שקיימים 13 קלפים מכל צורה לכן חוזרים לשארית שהיא תמיד תהיה בין 0-13 ואז נוכל לבצע השוואה בין ערכי הקלפים
    //(כלומר כבייכול הערך השוואה שלה אמור להיות נמוך יותר ) לדוגמא מלכה יהלום גדול מ2 תילתן אפילו שהמלכה נמצאת במיקום לפניו ברשימה!
        if ($Card_Player1 % 13>$Card_Player2 % 13) {
            $_POST["FPlayer"]= $FPlayer;
            $_POST["SPlayer"]= $SPlayer;
            $_SESSION["win"] = $_SESSION["FPlayer"];
            $_SESSION["score1"] ++;
                ?>
    <center><div class="page Game"> 
        <table>
            <tr>
            <?php 
                echo '<center><h4> '. $_SESSION["FPlayer"] . ' הגריל/ה :  '. $_SESSION["SPlayer"] . ' הגריל/ה :</h4></center>',
                    '<label for="fname">'. $_SESSION["FPlayer"] .' :</label>
                    <img src="cards/'. $Card_Player1 .'.jpg" width="60" height="90">',
                    '&nbsp;&nbsp;&nbsp;&nbsp;<label for="fname">'. $_SESSION["SPlayer"] .' :</label>
                    <img src="cards/'. $Card_Player2 .'.jpg" width="60" height="90">';
                ?>
            </tr>   
        </table>
        <h2><?php echo $_SESSION["win"]?> ניצח/ה</h2>
        מצב הנקודות הנוכחי: <br>
        <?php echo $_SESSION["FPlayer"]?>: <?php echo $_SESSION["score1"]?> נקודות <br>
        <?php echo $_SESSION["SPlayer"]?>: <?php echo $_SESSION["score2"]?> נקודות <br><br>

        סיבוב נוסף?
        <form action="NewGame.php" method="POST">
            כן   <input type="radio" name="isContinue" value="yes" checked>
            לא   <input type="radio" name="isContinue" value="no">
            <input type="submit" name="continue" value="המשך"/>
        </form>
    </div></center>
<?php
        }

    // אם הקלף של השחקן השני גבוה יותר הוא המנצח והוא מקבל נקודה
        elseif ($Card_Player1 % 13<$Card_Player2 % 13) {
            $_SESSION["win"] = $_SESSION["SPlayer"];
            $_SESSION["score2"] ++;
                ?>
    <center><div class="page Game"> 
        <table>
            <tr>
                <td>
                <?php echo '<center><h4> '. $_SESSION["FPlayer"] . ' הגריל/ה :  '. $_SESSION["SPlayer"] . ' הגריל/ה :</h4></center>',
                            '<label for="fname">'. $_SESSION["FPlayer"] .' :</label>
                            <img src="cards/'. $Card_Player1 .'.jpg" width="60" height="90">',
                            '&nbsp;&nbsp;&nbsp;&nbsp;<label for="fname">'. $_SESSION["SPlayer"] .' :</label>
                            <img src="cards/'. $Card_Player2 .'.jpg" width="60" height="90">';
                ?>
                </td>
            </tr>   
        </table>
        <h2><?php echo $_SESSION["win"]?> ניצח/ה</h2>
        מצב הנקודות הנוכחי: <br>
        <?php echo $_SESSION["FPlayer"]?>: <?php echo $_SESSION["score1"]?> נקודות <br>
        <?php echo $_SESSION["SPlayer"]?>: <?php echo $_SESSION["score2"]?> נקודות <br><br>

        סיבוב נוסף?
        <form action="NewGame.php" method="POST">
            כן   <input type="radio" name="isContinue" value="yes" checked>
            לא   <input type="radio" name="isContinue" value="no">
            <input type="submit" name="continue" value="המשך"/>
        </form>
    </div></center>
<?php
        }

        else {
            ?>
            <center><div class="War Page"> 
                <br>
                <table>
                <tr>
                <td>
                <?php 
                
                echo '<center><h4> '. $_SESSION["FPlayer"] . ' הגריל/ה :  '. $_SESSION["SPlayer"] . ' הגריל/ה :</h4></center>',
                    '<center><label for="fname">'. $_SESSION["FPlayer"] .' :</label>
                    <img src="cards/'. $Card_Player1 .'.jpg" width="60" height="90">',
                    '&nbsp;&nbsp;&nbsp;&nbsp;<label for="fname">'. $_SESSION["SPlayer"] .' :</label>
                    <img src="cards/'. $Card_Player2 .'.jpg" width="60" height="90"></center>';
                echo '<center><h3> הופה יש כאן <br> מ - ל - ח - מ - ה !!</h3></center>';
                ?>
                    </td>
                </table>

                האם אתם מוכנים? !
                <form action="NewGame.php" method="POST">
                    <input type="submit" name="milhama" value="מלחמה!"/>
                </form>
            </div></center>

            <?php
        }



}

// אם בחרו לא להמשיך למשחק נוסף מופיע דף יציאה
elseif ($isContinue == "no") { 
    session_start();
    // להדפיס את כל משתני ה session.
    //pre_r($_SESSION);
    
    $FPlayer = $_SESSION["FPlayer"]; 
    $SPlayer = $_SESSION["SPlayer"]; 
    $score1 = $_SESSION["score1"];
    $score2 = $_SESSION["score2"];
    
    if($score1>$score2){
        ?>
        <center><?php echo $_SESSION["FPlayer"]?>: <?php echo $_SESSION["score1"]?> נקודות ,  <?php echo $_SESSION["SPlayer"]?>: <?php echo $_SESSION["score2"]?> נקודות <br><br>
        <h3><?php echo  $FPlayer?>  הביס/ה את  <?php echo  $SPlayer?>.</h3></center>  <?php
    }
    elseif($score1<$score2){
        $winner=$SPlayer;
        ?> 
        <center><?php echo $_SESSION["FPlayer"]?>: <?php echo $_SESSION["score1"]?> נקודות ,  <?php echo $_SESSION["SPlayer"]?>: <?php echo $_SESSION["score2"]?> נקודות <br><br>
        <h3><?php echo  $SPlayer?>  הביס/ה את  <?php echo  $FPlayer?>.</h3></center>  <?php
    }
    else{
        ?><center><?php echo $_SESSION["FPlayer"]?>: <?php echo $_SESSION["score1"]?> נקודות ,  <?php echo $_SESSION["SPlayer"]?>: <?php echo $_SESSION["score2"]?> נקודות <br><br>
         <h3>לצערינו המחשק נגמר בתיקו.</h3></center>  <?php
    }
     //to fix session warning
    error_reporting(0);
    session_destroy();
    ?>
    <center><div class="page goodbay"> 
        <br>
        <h2>  תודה על השתתפותכם במשחק המלחמה הלוהט שלנו ! </h2>
        <h2>נתראה במשחק הבא!!!</h2>
        <form class="form" action="NewGame.php" method="POST">
            <input name="newGame" type="submit" value="התחל משחק חדש!"/>
        </form>
        
    </div></center>
    <?php
}

// אם בחרו להמשיך למלחמה
elseif (isset($_POST["milhama"])) {
        session_start();

        $deck = array(
            '2D', '3D', '4D', '5D', '6D', '7D', '8D', '9D', 'TD', 'JD', 'QD', 'KD', 'AD',
            '2C', '3C', '4C', '5C', '6C', '7C', '8C', '9C', 'TC', 'JC', 'QC', 'KC', 'AC',
            '2H', '3H', '4H', '5H', '6H', '7H', '8H', '9H', 'TH', 'JH', 'QH', 'KH', 'AH',
            '2S', '3S', '4S', '5S', '6S', '7S', '8S', '9S', 'TS', 'JS', 'QS', 'KS', 'AS'
        );

        $Card_Player1_1 = array_rand($deck, 1);
        $Card_Player2_1 = array_rand($deck, 1);
        // תנאי שמטרתו לשנות  את הקלף עד שיצא קלף ששונה מהכלף של שחקן מספר 1  
        while($Card_Player1_1==$Card_Player2_1){
        $Card_Player2_1 = array_rand($deck, 1);
        }

        // סיבוב מלחמה שני 
        $Card_Player1_2 = array_rand($deck, 1);
        $Card_Player2_2 = array_rand($deck, 1);
        // תנאי שמטרתו לשנות את הקלף עד שיצא קלף ששונה מהכלף של שחקן מספר 1  
        while($Card_Player1_2==$Card_Player2_2){
        $Card_Player2_2 = array_rand($deck, 1);
        }

        // הסיבוב המכריע!
        $Card_Player1_3 = array_rand($deck, 1);
        $Card_Player2_3 = array_rand($deck, 1);
        // תנאי שמטרתו לשנות את הקלף עד שיצא קלף ששונה מהכלף של שחקן מספר 1  
        while($Card_Player1_3==$Card_Player2_3){
        $Card_Player2_3 = array_rand($deck, 1);
        }
        
        if($Card_Player1_3 % 13>$Card_Player2_3 % 13){
                " <br> סיבוב מספר 1 <br>";
                $_SESSION["win"] = $_SESSION["FPlayer"];
                $_SESSION["score1"] += 3;
        }
        elseif($Card_Player1_3 % 13<$Card_Player2_3 % 13){
                " <br> סיבוב מספר 2 <br>";
                $_SESSION["win"] = $_SESSION["SPlayer"];
                $_SESSION["score2"] += 3;
        }
        elseif ($Card_Player1_3 % 13 == $Card_Player2_3 % 13) {
                ?>
                <center><div class="War Page"> 
                    <br>
                    <table>
                    <tr>
                    <td>
                    <?php
                    $print="<center><h1> $name1  הגריל/ה:      $name2  הגריל/ה:</h1></center>";
                    echo $print;
                    echo '<label for="fname">'. $_SESSION["FPlayer"] .' :</label>
                    <img src="cards/'. $Card_Player1 .'.jpg" width="60" height="90">',
                    '&nbsp;&nbsp;&nbsp;&nbsp;<label for="fname">'. $_SESSION["SPlayer"] .' :</label>
                    <img src="cards/'. $Card_Player2 .'.jpg" width="60" height="90">';
                    ?>"> <br><br>
                        </td>
                    </table>
                    <h2>מ-ל-ח-מ-ה</h2>

                    מוכנים?
                    <form action="NewGame.php" method="POST">
                        <input type="submit" name="milhama" value="מלחמה!"/>
                    </form>
                </div></center>

                <?php
            }

        ?>
            <center><div class="page War"> 
            <br>  סיבוב מספר 1 : <br>
            <br>
            <table>
            <?php echo '<center><label for="fname">'. $_SESSION["FPlayer"] .' :</label>
                <img src="cards/'. $Card_Player1_1 .'.jpg" width="60" height="90">',
                '&nbsp;&nbsp;&nbsp;&nbsp;<label for="fname">'. $_SESSION["SPlayer"] .' :</label>
                <img src="cards/'. $Card_Player2_1 .'.jpg" width="60" height="90"></center>';
                ?>
            </table>

            <br> סיבוב מספר 2 : <br>
            <br>
            <table>
            <?php echo '<center><label for="fname">'. $_SESSION["FPlayer"] .' :</label>
                <img src="cards/'. $Card_Player1_2 .'.jpg" width="60" height="90">',
                '&nbsp;&nbsp;&nbsp;&nbsp;<label for="fname">'. $_SESSION["SPlayer"] .' :</label>
                <img src="cards/'. $Card_Player2_2 .'.jpg" width="60" height="90"></center>';
                ?>
            </table>

            <br> ולסיבוב הקובע... : <br>
            <br>
            <table>
            <?php echo '<center><label for="fname">'. $_SESSION["FPlayer"] .' :</label>
                <img src="cards/'. $Card_Player1_1 .'.jpg" width="60" height="90">',
                '&nbsp;&nbsp;&nbsp;&nbsp;<label for="fname">'. $_SESSION["SPlayer"] .' :</label>
                <img src="cards/'. $Card_Player2_1 .'.jpg" width="60" height="90"></center>';
                ?>
            </table>

        <h2> <?php echo $_SESSION["win"]?> ניצח/ה</h2>

            מצב הנקודות הנוכחי: <br>
            <?php echo $_SESSION["FPlayer"]?>: <?php echo $_SESSION["score1"]?> נקודות <br>
            <?php echo $_SESSION["SPlayer"]?>: <?php echo $_SESSION["score2"]?> נקודות <br><br>

            סיבוב נוסף?
            <form action="NewGame.php" method="POST">
                כן   <input type="radio" name="isContinue" value="yes" checked>
                לא   <input type="radio" name="isContinue" value="no">
                <input type="submit" name="continue" value="המשך"/>
            </form>
            <br>
            <br>
        </div></center>

    <?php
}

// אם לא לחצו על התחל או שהפעילו את כפתור המשחק הנוסף הדףמוביל אל מסך הכניסה
else {
    ?>
    <div class="Login page">    
    <br>
    <center><h2>  ברוכים הבאים למשחק המלחמה של דולב!</h2>
    <h2>אנא הכניסו את שמות השחקנים/ות ולחצו על כפתור "התחל"</h2>
    <form action="NewGame.php" method="POST">
        <label for="FPlayer">שחקנ/ית ראשונ/ה</label><br>
        <input type="text" name="FPlayer"><br><br>          
        <label for="SPlayer">שחקנ/ית שני/ה</label><br>
        <input type="text" name="SPlayer"><br><br>
        <input name="start" type="submit" value="התחל!"/>
    </form></center>
    
</div>
<?php
}

// פונקציות עזר  :
// פונקציית הדפסת תמונה ושמות השחקנים.
/*
function GiveMePicture($Card_Player1,$name1,$Card_Player2,$name2){
    echo '<center><label for="fname">'. $name1 .' :</label>
    <img src="cards/'. $Card_Player1 .'.jpg" width="60" height="90">',
    '&nbsp;&nbsp;&nbsp;&nbsp;<label for="fname">'. $name2 .' :</label>
    <img src="cards/'. $Card_Player2 .'.jpg" width="60" height="90"></center>';
    //echo $Card_Player1/$Card_Player2;               //to prove the funcion working well
}
*/

// פונקציית להדפסת נתוני ה session .
function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
  }
?>
</body>

</html>

