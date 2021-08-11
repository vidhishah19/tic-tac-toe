<?php
        const boxes = 9;
        const row = 3;
        $empty = str_repeat('.', boxes);
        function gameover($board, $dot) {
            $chances = '/X{3}|' . //horizontal
                    'X..X..X..|' . //vertical left
                    '.X..X..X.|' . //vertical middle
                    '..X..X..X|' . //vertical right
                    '..X.X.X..|' . //diagonal topleft to bottomright
                    'X...X...X|' . //diagonal topright to bottomleft
                    '[^\.]{9}/i'; //none
            if ($dot == 'O')
                $chances = str_replace('X', 'O', $chances);
            return preg_match($chances, $board);
        }

//Start Playing
        $play = isset($_GET['b']) ? $_GET['b'] : $empty;
        $turn = substr_count($play, '.') % 2 == 0 ? 'O' : 'X';
        $nextturn = $turn == 'X' ? 'O' : 'X';
        $endgame = gameover($play, $nextturn);

//Tic-Tac_Toe Board Design
        echo '<style>';
        echo 'td {text-align: center; width: 100px; height: 100px;}';
        echo '.dot {color: black; font-size:70pt; text-decoration:none;}';
        echo '.dot.X {color:blue}';
        echo '.dot.O {color:red}';
        echo '</style>';
        echo '<table border="1">';
        $a = 0;
        for ($r = 0; $r < row; $r++) {
            echo '<tr>';
            for ($c = 0; $c < row; $c++) {
                $dot = $play[$a];

                echo '<td>';
                if ($endgame || $dot != '.')
                    echo '<span class="dot ', $dot, '">', $dot, '</span>'; //Already full
                else {                                                    //Space left out
                    $spaces = $play;
                    $spaces[$a] = $turn;
                    echo '<a class="dot', $dot, '" href="?b=', $spaces, '">';
                    echo $play[$a];
                    echo '</a>';
                }

                echo '</td>';
                $a++;
            }
            echo '</tr>';
            echo '<input type="hidden" name="b" value="', $play, '"/>';
        }
        echo '</table>';
        echo '<a href="?b=', $empty, '">RESET</a>';
        if ($endgame) echo '<h1>GAME OVER!</h1>';
