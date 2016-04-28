<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;

class ContestsTest extends TestCase
{
	/**
	 * Test creating a new contest.
	 *
	 * @return void
	 */
	public function testCreatingAContest()
	{

		$this->asAdminUser()
		->visit(route('contests.create'))
		->see('Add a new contest');

		$signupStartDate = Carbon::now()->startOfDay();
		$signupEndDate = Carbon::now()->addMonth()->endOfDay();
		$senderName = $this->faker->firstName;
		$senderEmail = $this->faker->unique()->safeEmail;
		$campaignID = $this->faker->randomNumber(4);
		$campaignRunID = $this->faker->randomNumber(3);

		// Fill out form.
		$this->asAdminUser()
		->visit(route('contests.create'))
		->see('Add a new contest')
		->type($signupStartDate, 'signup_start_date')
		->type($signupEndDate, 'signup_end_date')
		->type($campaignID, 'campaign_id')
		->type($campaignRunID, 'campaign_run_id')
		->type($senderEmail, 'sender_email')
		->type($senderName, 'sender_name')
		// ->press('Submit');

		// $this->see('Contest has been saved!');

		// // Make sure contest was created.
  //       $this->seeInDatabase('contests', [
  //           'id' => '1',
  //           'campaign_id' => $campaignID,
  //           'campaign_run_id' => $campaignRunID,
  //           'sender_email' => $senderEmail,
  //           'sender_name' =>$senderName,
  //       ]);

  //       // Make sure a waiting room was created.
  //       $this->seeInDatabase('waiting_rooms', [
		// 	'id' => '1',
		// 	'contest_id' => '1',
		// 	'signup_start_date' => $signupStartDate,
		// 	'signup_end_date' => $signupEndDate,
  //       ]);

  //       // Make sure default messages are created. Just test that required fields are there.
		// $correspondence = app(Gladiator\Http\Utilities\Correspondence::class);

		// foreach (correspondence()->defaults() as $message) {
		// 	$this->seeInDatabase('messages', [
		// 		'contest_id' => '1',
		// 		'type' => $message['type'],
		// 		'label' => $message['label'],
		// 		'subject' => $message['subject'],
		// 		'body' => $message['body'],
		// 	]);
		// }
	}
}
