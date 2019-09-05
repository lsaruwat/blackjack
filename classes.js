window.addEventListener("load", start, false);

function start()
{
	play();
}

function play()
{
	var deck1 = new Deck();
	deck1.createDeck();
	deck1.shuffle();
	document.getElementById("hit").addEventListener("click", function(){deck1.hit();},false);
	document.getElementById("stand").addEventListener("click", function(){deck1.stand();},false);
	document.getElementById("replay").addEventListener("click", function(){deck1.deal21();}, false);
	document.getElementById("doubleDown").addEventListener("click", function(){deck1.doubleDown();}, false);
}

function Deck()
{
	this.deck = new Array();
	this.userTotal;
	this.dealerTotal;
	this.money = 100;
	this.bet = 1;
	this.userBust;
	this.dealerBust;
	this.curusrHand;
	this.curdlrHand;
	var userHand = document.getElementById("user-hand");
	var dealerHand = document.getElementById("dealer-hand");
	var userScore = document.getElementById("user-score");
	var dealerScore = document.getElementById("dealer-score");
	var status = document.getElementById("game-status");
	var moneyDiv = document.getElementById("money");
	var bet = document.getElementById("bet");
	var sessionMoneyInput = document.getElementById("sessionMoney");
	var sessionMoney;
	if(sessionMoneyInput) 
	{
		this.money =  parseFloat(sessionMoneyInput.value);
		this.username = sessionUsername.value;
	}
	this.newDeck = function newDeck()
	{
		this.createDeck();
		this.shuffle();
		status.innerHTML="NEW DECK IN PLAY!";
	}

	this.createDeck = function createDeck()
	{
		var numCards=0;
		var suit, symbol, name;
		for(var k=1; k<=4; k++)
		{
			switch(k)
			{
				case 1: suit ="hearts";
				break;
				case 2: suit ="diamonds";
				break;
				case 3: suit ="spades";
				break;
				case 4: suit ="clubs";
				break;
			}

			for(var i=1; i<=13; i++)
			{
				symbol = i;
				switch(i)
				{
					case 1: name= "Ace";
					symbol = "A";
					break;
					case 2: name= "two";
					break;
					case 3: name= "three";
					break;
					case 4: name= "four";
					break;
					case 5: name= "five";
					break;
					case 6: name= "six";
					break;
					case 7: name= "seven";
					break;
					case 8: name= "eight";
					break;
					case 9: name= "nine";
					break;
					case 10: name= "ten";
					break;
					case 11: name= "jack";
					symbol = "J";
					break;
					case 12: name= "queen";
					symbol = "Q";
					break;
					case 13: name= "king";
					symbol = "K";
					break;
				}
				this.deck[numCards] = new Card(suit, i, name, symbol);
				numCards++;
			}
		}
	}

	this.shuffle = function shuffle()
	{
		var randomDeck = new Array();
		var empty = false;
		while(!empty)
		{
		var randomIndex = Math.floor(Math.random()*this.deck.length);
		randomDeck.push(this.deck[randomIndex]);
		this.deck.splice(randomIndex, 1);
		if(this.deck.length <=0) empty = true;
		}
		for(var i=0; i<randomDeck.length; i++)
		{
			this.deck[i] = randomDeck[i];
		}
	};

	this.sortVal = function sortVal(hand)
	{
		for(var i=0; i<hand.length; i++)
		{
			for(var k=i; k<hand.length; k++)
			{
				if(hand[k].val <= hand[i].val)
				{
					var temp = hand[k];
					hand[k] = hand[i];
					hand[i] = temp;
				}
			}
		}
		return hand;
	}

	this.compare = function compare(a,b) 
	{
  	if (a.val < b.val)return -1;
  	if (a.val > b.val)return 1;
  	return 0;
	}


	this.calcValue = function calcValue(hand)
	{
		var val = 0;
		var tempArr = new Array();
		tempArr = hand;
		tempArr = this.sortVal(tempArr);
		for(var i=tempArr.length-1; i>=0; i--)
		{
			var temp = tempArr[i].val;
			if(tempArr[i].val >=10) temp = 10;
			else if(tempArr[i].val === 1 && val <=10 && i<1)temp = 11;
			val += temp;
		}
		return val;
	};

	this.emptyDeck = function emptyDeck()
	{
		if(this.deck.length < 1) return true;
		else return false;
	}

	this.deal21 = function deal21()
	{
		if(this.money < -200) this.reset();
		this.bet = parseInt(bet.value);
		console.log(this.bet);
		if(this.bet != 1 && this.bet != 2 && this.bet != 5 && this.bet != 10 && this.bet != 50)this.bet =1;
		console.log(this.bet);
		status.innerHTML="";
		this.money -=this.bet;
		
		//reset all the stuff that needs to be reset if the game is being replayed
		money.innerHTML= "Money: " + this.money;
		dealerHand.innerHTML="<h2>Dealer Hand</h2>";
		userHand.innerHTML="<h2>User Hand</h2>";
		this.userTotal=0;
		this.dealerTotal=0;
		this.userBust=false;
		this.dealerBust=false;
		hit.setAttribute("style", "");
		stand.setAttribute("style", "");
		doubleDown.setAttribute("style", "");
		bet.setAttribute("style", "visibility: hidden;");
		dealerScore.setAttribute("style", "");
		betValue.innerHTML="<p>Bet: " + this.bet + "</p>";
		this.curusrHand = new Array();
		this.curdlrHand = new Array();


		for(i=0; i<2; i++)
		{
			if(this.emptyDeck())this.newDeck();
			this.curusrHand.push(this.deck.pop());
			userHand.innerHTML+=this.curusrHand[i].showCard();
		}
		this.userTotal = this.calcValue(this.curusrHand);
		userScore.innerHTML=this.userTotal;

		for(i=0; i<2; i++)
		{
			if(this.emptyDeck())this.newDeck();
			this.curdlrHand.push(this.deck.pop());
			dealerHand.innerHTML+=this.curdlrHand[i].showCard();
		}
		this.dealerTotal = this.calcValue(this.curdlrHand);
		dealerScore.innerHTML=this.dealerTotal;
		//hide dealers first card
		var firstCard = dealerHand.getElementsByClassName("card")[0];
		firstCard.setAttribute("id", "hidden-card");
		var blackjack =true;
		if(this.userTotal === 21 && this.dealerTotal < 21) this.gameOver(blackjack);
		else if(this.dealerTotal === 21) this.gameOver();
	};

	this.hit = function hit()
	{
		doubleDown.setAttribute("style", "visibility:hidden;");
		if(this.emptyDeck())this.newDeck();
		this.curusrHand.push(this.deck.pop());
		userHand.innerHTML+=this.curusrHand[this.curusrHand.length-1].showCard();
		this.userTotal = this.calcValue(this.curusrHand);
		userScore.innerHTML=this.userTotal;
		if(this.userTotal >21) 
			{
				userScore.innerHTML+=" <span style='color:red; font-weight: bold;'> BUST</span>";
				this.userBust = true;
				this.gameOver();
			}
	};

	this.stand = function stand()
	{
		//if(this.dealerTotal === 18 && this.curdlrHand[0].val ===11||this.curdlrHand[1]===11)
		while(this.dealerTotal < 17)
		{
			if(this.emptyDeck())this.newDeck();
			this.curdlrHand.push(this.deck.pop());
			dealerHand.innerHTML+=this.curdlrHand[this.curdlrHand.length-1].showCard();
			this.dealerTotal = this.calcValue(this.curdlrHand);
			dealerScore.innerHTML=this.dealerTotal;
			if(this.dealerTotal > 21) 
				{
					dealerScore.innerHTML+=" <span style='color:red; font-weight: bold;'> BUST</span>";
					this.dealerBust = true;
				}
		}
		this.gameOver();
	};

	this.doubleDown = function doubleDown()
	{
		this.money -= this.bet;
		this.bet+= this.bet;
		this.hit();
		this.stand();
	};

	this.gameOver = function gameOver(blackjack)
	{
		document.getElementById("hidden-card").setAttribute("id","");
		dealerScore.setAttribute("style", "visibility: visible;");
		hit.setAttribute("style", "visibility:hidden;");
		stand.setAttribute("style", "visibility:hidden;");
		doubleDown.setAttribute("style", "visibility:hidden;");
		bet.setAttribute("style", "");

		if(blackjack) 
		{
			this.money += this.bet*2.5;
			status.innerHTML ="BLACKJACK!!!!!!!!!";
		}

		else if(this.userTotal > this.dealerTotal && this.userBust === false || this.dealerBust ===true)
		{
			//user wins
			this.money+= this.bet*2;
			status.innerHTML ="YOU WIN!";
		}
		else if(this.userTotal === this.dealerTotal && this.userBust === false)
		{
			//push
			this.money+= this.bet;
			status.innerHTML="PUSH";
		}

		else status.innerHTML="YOU LOSE!";

		money.innerHTML="Money: "+this.money;
		if(typeof this.username != "undefined") this.save();

	};

	this.save = function save()
	{
		var xmlhttp;
		if (window.XMLHttpRequest)
		  {// code for IE7+, Firefox, Chrome, Opera, Safari
		  xmlhttp=new XMLHttpRequest();
		  }
		else
		  {// code for IE6, IE5
		  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		  }
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		    {
		   		console.log(xmlhttp.responseText);
		    }
		}
		xmlhttp.open("POST","save.php",true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send("money="+this.money+"&username="+this.username);
	};

	this.reset = function reset()
	{
		this.money = 0;
		this.save();
		window.alert(this.username+" lost and cannot borrow anymore money! Game resets!");
	}

	this.dump = function dump()
	{
		for(var i=0; i<this.deck.length; i++)
		{
			this.deck[i].showCard();
		}
	};
}

function Card(suit, val, name, symbol)
{
		this.suit = suit;
		this.val = val;
		this.name = name;
		this.symbol = symbol;

	this.showCard =function showCard()
	{
		var html="";
		switch(this.suit)
		{
			case "hearts": suit_text = "&hearts;";
			break;
			case "diamonds": suit_text = "&diams;";
			break;
			case "spades": suit_text = "&spades;";
			break;
			case "clubs": suit_text = "&clubs;";
			break;
		}
		html="<div class='card " + this.suit + "'><div class='card-value'>" + this.symbol + "</div><div class='suit'>" + suit_text + "</div><div class='main-number'>"+this.symbol +"</div><div class='invert card-value'>"+this.symbol+"</div><div class='invert suit'>"+suit_text+"</div></div>";
		return html;
	}
}