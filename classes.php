<?php

class Page
{
	public $title, $style, $scripts, $header, $content, $footer, $html;
	private $tagline;

	public function __construct($title)
                {
                    $this->title = $title;
                }
    public function build()
    {
    	$this->tagline = "<h1>" . $this->title . "</h1>";
    	$this->html = "<html><head><title>". $this->title ."</title><link rel='stylesheet' href='cards.css'></head><body>" . $this->tagline . "</body></html>";
    	echo $this->html;
    }

}

class Deck
{
	private $deck = Array();
	private $value = 0;

	public function __construct()
	{
		$numCards=0;
		for($k=1; $k<=4; $k++)
		{
			switch($k)
			{
				case 1: $suit ="hearts";
				break;
				case 2: $suit ="diamonds";
				break;
				case 3: $suit ="spades";
				break;
				case 4: $suit ="clubs";
				break;
			}

			for($i=1; $i<=13; $i++)
			{
				$symbol = $i;
				switch($i)
				{
					case 1: $name= "one";
					break;
					case 2: $name= "two";
					break;
					case 3: $name= "three";
					break;
					case 4: $name= "four";
					break;
					case 5: $name= "five";
					break;
					case 6: $name= "six";
					break;
					case 7: $name= "seven";
					break;
					case 8: $name= "eight";
					break;
					case 9: $name= "nine";
					break;
					case 10: $name= "ten";
					break;
					case 11: $name= "jack";
					$symbol = "J";
					break;
					case 12: $name= "queen";
					$symbol = "Q";
					break;
					case 13: $name= "king";
					$symbol = "K";
					break;
				}
				$this->deck[$numCards] = new Card($suit, $i, $name, $symbol);
				$numCards++;
			}
		}
	}

	public function shuffle()
	{
		shuffle($this->deck);
	}

	public function calcValue($hand)
	{
		foreach($hand as $card)
		{
			$this->value += $card->value;
		}
		return $this->value;
	}

	public function dealPoker()
	{
		for($i=0; $i <5; $i++)
		{
			$flop = array_pop($this->deck);
			$flop->showCard();
		}
	}

	public function deal21()
	{
		for($i=0; $i<2; $i++)
		{
			$flop[$i] = array_pop($this->deck);
			$flop[$i]->showCard();
		}
		echo $this->calcValue($flop);
	}

	public function dump()
	{
		foreach($this->deck as $card)
		{
			$card->showCard();
		}
		echo "--------------------------------";
	}
}

class Card
{
	public $suit, $value, $name, $symbol;

	public function __construct($suit, $value, $name, $symbol)
	{
		$this->suit = $suit;
		$this->value = $value;
		$this->name = $name;
		$this->symbol = $symbol;
	}

	public function showCard()
	{
		switch($this->suit)
		{
			case "hearts": $suit_text = "&hearts;";
			break;
			case "diamonds": $suit_text = "&diams;";
			break;
			case "spades": $suit_text = "&spades;";
			break;
			case "clubs": $suit_text = "&clubs;";
			break;
		}
		echo "<div class='card " . $this->suit . "'><div class='card-value'>" . $this->symbol . "</div><div class='suit'>" . $suit_text . "</div><div class='main-number'>". $this->symbol ."</div></div>";
	}
}