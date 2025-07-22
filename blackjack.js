/*      Created by Matthew Urban
		This file handles user interactions and functionality 
        for the main game screen.
*/


//global variables
var data = "";
var fileName = "cards.json";

var dealerCards = 0;
var playerCards = 0;
var dealerScore = 0;
var playerScore = 0;
var dealerAceCount = 0;
var playerAceCount = 0;
var betAmount = 0;


//initialization function
window.onload = function() {

    //set balance for run
    document.getElementById('highestBalance').innerHTML = "100"
    document.getElementById('currentBalance').innerHTML = "100";

    
    disableStart();

    //request card data
    new Ajax.Request (
        fileName,
        {
            method: "get",
            parameters: {type: "list"},
            onSuccess: getCards,
            onFailure: cardsFailed,
            onException: cardsFailed 
        }
    );
    
    //set up listeners
    $('bid').oninput = bidChange;
    $('newGame').onclick = newGame;
    $('stand').onclick = dealersTurn;
    $('hit').onclick = playerAddCard;
}


function bidChange() {
    //change the global bid amount variable
    var bidNode = $('bid');
    betAmount = parseInt(bidNode.value);
}


function disableStart() {
    //disable buttons on startup
    $('hit').disabled = "disabled";
    $('stand').disabled = "disabled";
}


function getCards(ajax) {
    //get card data
    data = JSON.parse(ajax.responseText);
}

function resetScores() {
    //access dom objects
    var dealerNode = $("dealerTotal");
    var playerNode = $("playerTotal");
    var resultNode = $("resultText");

    //change html to default values.
    dealerNode.innerHTML = "Dealer Score: ";
    playerNode.innerHTML = "Player Score: ";
    resultNode.innerHTML = "Result: "
}


function newGame() {


    resetScores();

    //access nodes
    var currentNode = $('currentBalance')
    var currentBalance = parseInt(currentNode.innerHTML);
    var error = $('errorText');
    
    //check if the bet amount is valid.
    if (betAmount > currentBalance) {
        error.innerHTML = "INSUFFICIENT FUNDS: Bid is too high for your current balance."
        return;
    } else if ( betAmount <= 0) {
        error.innerHTML = "Invalid bet: Bid is too low.";
        return;
    } else {
        currentNode.innerHTML = currentBalance - betAmount;
        error.innerHTML = "";


    }

    //disable new game button and bid change if bet amount is valid
    $('newGame').disabled = "disabled";
    $('bid').disabled = "disabled";

    //reset global variables
    dealerScore = 0;
    playerScore = 0;
    dealerAceCount = 0;
    playerAceCount = 0;
    dealerCards = 0;
    playerCards = 0;
    


    removeCards();
    dealerAddCard();
    playerAddCard();

    //delay half a second before showing second card
    setTimeout(function() {
        dealerAddBlank();
        playerAddCard();

        $('hit').disabled = false;
        $('stand').disabled = false;

    }, 500);
}

function removeCards() {
    var dealerCards = document.getElementById('dealerCards');
    var playerCards = document.getElementById('playerCards');
    
    var dealNodes = dealerCards.childNodes;
    var playNodes = playerCards.childNodes;
    
    //removing all dealer cards
    if (dealerCards.hasChildNodes()) {
        for (var i = dealNodes.length - 1; i >= 0; i--) {
            dealNodes[i].remove();
        }
    }

    //removing all player cards
    if (playerCards.hasChildNodes()) {
        for (var i = playNodes.length - 1; i >= 0; i--) {
            playNodes[i].remove();
        }
    }
    
}


function dealerAddBlank() {

    //creating a blank card object
    var cardOb = document.createElement('img');
    cardOb.src = "Cards/card_back.png";
    cardOb.id = "blankCard";

    //appending the blank card to the dealer section
    $('dealerCards').appendChild(cardOb);
    dealerCards++;
    
}


function dealerAddCard() {
    
    //checking if dealer has too many cards
    if (dealerCards < 5) {
        //getting a random card
        var num = Math.floor(Math.random() * 52);
        var faceNum = Math.floor(num / 13);
        var cardNum = num % 13;

        var card = data[(faceNum + 1).toString()][(cardNum + 1).toString()].split(",");
        var face = card[1];
        var cardNumber = card[0];
        
        //checking value of the card
        if (cardNum == 12) {
            dealerScore += 11;
            dealerAceCount++;
        } else if (cardNum >= 9) {
            dealerScore += 10;
        } else {
            dealerScore += cardNum + 2;
        }  
        
        //creating card object and adding it to dealer section
        var cardOb = document.createElement('img');
        cardOb.classList.add("card");
        cardOb.src = "Cards/"+ cardNumber + "_of_" + face + ".svg";

        
        $('dealerCards').appendChild(cardOb);

        dealerCards++;

    } else {
        return
    }
    
    //checking if the ace needs to count as 1 instead of 11
    if (dealerAceCount >= 1 && dealerScore > 21) {
        dealerScore -= 10;
        dealerAceCount--;
    }

}


function playerAddCard() {
    
    //checking if the player has too many cards
    if (playerCards < 5) {

        //getting random card values
        var num = Math.floor(Math.random() * 52);
        var faceNum = Math.floor(num / 13);
        var cardNum = num % 13;

        var card = data[(faceNum + 1).toString()][(cardNum + 1).toString()].split(",");
        var face = card[1];
        var cardNumber = card[0];

        //getting the value of the card
        if (cardNum == 12) {
            playerScore += 11;
            playerAceCount++;
        } else if (cardNum >= 9) {
            playerScore += 10;
        } else {
            playerScore += cardNum + 2;
        }  

        //creating card object and appending to player section
        var cardOb = document.createElement('img');
        cardOb.classList.add("card");
        cardOb.src = "Cards/"+ cardNumber + "_of_" + face + ".svg";
        
        $('playerCards').appendChild(cardOb);

        playerCards++;

    } 

    //checking if player has 5 cards already
    if (playerCards >= 5) {
        //disable hit button
        $('hit').disabled = "disabled";
    }

    //checking if player has aces that can be lowered to a value of 1.
     if (playerAceCount >= 1 && playerScore > 21) {
        playerScore -= 10;
        playerAceCount--;
    } else if (playerAceCount == 0 && playerScore > 21) {
        dealersTurn();
    }
}


function cardsFailed(ajax, exception) {
    //setting error text
    $('head').innerhtml = exception.status;
}

function flipBlank() {
    //removing the blank card and replacing with a random card
    $('blankCard').remove();
    dealerAddCard();
}


function dealersTurn() {
    //disable user action buttons
    $('stand').disabled = "disabled";
    $('hit').disabled = "disabled";

    //playing the dealers turn
    var turn = true;
    flipBlank();
    while (turn) {
        //checking if dealer score is high enough to stop turn.
        if (dealerScore < 17) {
            dealerAddCard();
        } else {
            turn = false;
        }
    }

    getResults();

    //enabling and disabling buttons for post game.
    $('stand').disabled = "disabled";
    $('hit').disabled = "disabled";
    $("newGame").disabled = false;
    $('bid').disabled = false;
}


function getResults() {
    var dealerText = document.getElementById('dealerTotal');
    var playerText = document.getElementById('playerTotal');
    var resultText = document.getElementById('resultText');

    //setting the text results
    dealerText.innerHTML = "Dealer Score: " + dealerScore;
    playerText.innerHTML = "Player Score: " + playerScore;
    resultText.innerHTML = resultingText();

    //setting the hidden score tracker.
    var highScoreNode = $('highestBalance');
    var hiddenVal = $('hiddenScore');
    hiddenVal.value = highScoreNode.innerHTML;


}


function resultingText() {

    //checking for result of game.
    if (dealerScore > 21) {
        playerWin();
        return "Result: Player wins... Dealer broke 21."
    } else if (playerScore > 21) {
        return "Result: Dealer wins... Player broke 21."
    } else if (dealerScore > playerScore) {
        return "Result: Dealer wins with a higher score.";
    } else if (dealerScore == playerScore) {
        tieGame();
        return "Result: Tie... Score is even.";
    } else {
        playerWin();
        return "Result: Player wins with a higher score.";
    }
}


function playerWin() {
    
    //setting new user balance.
    var currentNode = $('currentBalance')
    var currentBalance = parseInt(currentNode.innerHTML);
    currentNode.innerHTML = currentBalance + (betAmount * 2);

    checkHighest(parseInt(currentNode.innerHTML));
}


function tieGame() {
    
    //setting user balance back to original.
    var currentNode = $('currentBalance')
    var currentBalance = parseInt(currentNode.innerHTML);
    currentNode.innerHTML = currentBalance + betAmount;

}

function checkHighest(balance) {
    //checking if the user has a new highscore.
    var highestNode = $('highestBalance');
    var highestVal = parseInt(highestNode.innerHTML);
    if (highestVal < balance) {
        highestNode.innerHTML = balance;
    }
}