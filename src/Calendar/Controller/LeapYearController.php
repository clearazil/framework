<?php 

namespace Calendar\Controller;

use Symfony\Component\HttpFoundation\Response;

use Calendar\Model\LeapYear;

class LeapYearController
{
	public function indexAction($year)
	{
		$leapYear = new LeapYear;
		if($leapYear->isLeapYear($year)) {
			$response = new Response('Yep, this is a leap year!' . rand());
		} else {
			$response = new Response('Nope, this is not a leap year.');
		}

		$response->setTtl(10);

		return $response;
	}
}