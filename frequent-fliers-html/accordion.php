<!DOCTYPE html>
<html>
<header>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=800px, initial-scale=1.0">
    <title>Los Angeles Kite Fighting</title>
    <link rel="stylesheet" href="game-running.css">
</header>


<body>
    <p>Accordion Test</p>
    <form method = "post" action = "">
        <div class="accordion">

            <div class="accordion-item"><h2 class="accordion-title"> Match 1</h2>


                <div class="match-menu">    

                    <label for = "M1P1Score">Player 1 Score</label>
                    <input class = "score" type="number" id="M1P1Score" value = "0" readonly/>
                    <input id = "M1P1" class= "increment-button" type="button" value="+" />
                    <input id = "M1P1" class= "decrement-button" type="button" value="-" />


                    <label for = "M1P2Score">Player 2 Score</label>
                    <input class = "score" type="number" id="M1P2Score" value = "0" readonly/>
                    <input id = "M1P2" class= "increment-button" type="button" value="+" />
                    <input id = "M1P2" class= "decrement-button" type="button" value="-" />


                </div>

            </div>


        </div><br>


    </form>
    <script src="app.js"></script>
</body>
</html>