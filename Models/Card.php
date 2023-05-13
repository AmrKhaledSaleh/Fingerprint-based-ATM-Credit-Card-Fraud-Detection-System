<?php
class card
{
	private string $id;
	private string $CVV;
	private $expDate;
	private $state;
	

	public function __construct($id = null, $CVV = null, $expDate = null, $state = null){
		if($id)
			$this->id = $id;
		if($CVV)
			$this->CVV = $CVV;
		if($expDate)
			$this->expDate = $expDate;
		if($state)
			$this->state = $state;

	}
	public function getState()
	{
		return $this->state;
	}


	public function setState(bool $state)
	{
		$this->state = $state;
	}


	public function getDate()
	{
		return $this->expDate;
	}


	public function setDate($expDate): self
	{
		$this->expDate = $expDate;
		return $this;
	}


	public function getCVV(): string
	{
		return $this->CVV;
	}


	public function setCVV(string $CVV): self
	{
		$this->CVV = $CVV;
		return $this;
	}


	public function getId(): string
	{
		return $this->id;
	}


	public function setId(string $id): self
	{
		$this->id = $id;
		return $this;
	}

	public function generateCardID()
	{
		$card_number = rand(1, 9);
		for ($i = 1; $i < 16; $i++) {
			$card_number .= rand(0, 9);
		}
		return $card_number;
	}

	public function generateCVV()
	{
		$CVV_number = rand(1, 9);
		for ($i = 1; $i < 3; $i++) {
			$CVV_number .= rand(0, 9);
		}
		return $CVV_number;
	}

	public function generateExpDate()
	{
		// Get today's date
		$today = new DateTime();

		// Add 3 years to today's date
		$three_years_from_today = $today->add(new DateInterval('P3Y'));

		// Print the result
		return $three_years_from_today->format('Y-m-d');
	}

	public function generateCard()
	{
		$this->setId($this->generateCardID());
		$this->setCVV($this->generateCVV());
		$this->setDate($this->generateExpDate());
		return $this;
	}
}
