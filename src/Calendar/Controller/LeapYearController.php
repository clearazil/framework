<?php 

namespace Calendar\Controller;

use Symfony\Component\HttpFoundation\Response;

use Acme\Core\Controller;

use Calendar\Model\LeapYear;

class LeapYearController extends Controller
{
	public function indexAction($year)
	{
		$leapYear = new LeapYear;
		if($leapYear->isLeapYear($year)) {
			$response = 'Yep, this is a leap year!' . rand();
		} else {
			$response = 'Nope, this is not a leap year.';
		}

		//$response->setTtl(10);

		return $this->view->render('index', ['leapYear' => $response]);
	}
}