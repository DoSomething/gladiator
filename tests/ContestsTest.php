<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
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
		$signup_start_date = Carbon::now()->startOfDay();
		$signup_end_date = Carbon::now()->addMonth()->endOfDay();

		// Fill out form.
		$this->asAdminUser()
		->visit(route('contests.create'))
		->see('Add a new contest')
		->type($signup_start_date, 'signup_start_date')
		->type($signup_end_date, 'signup_end_date')
		// @TODO - use faker to build dumb email and name and stuff.
		->type('1234', 'campaign_id')
		->type('123', 'campaign_run_id')
		->type('ssmith@dosomething.org', 'sender_email')
		->type('Shae', 'sender_name')
		->press('Submit');

		$this->see('Contest has been saved!');

		// Make sure contest was created.
        $this->seeInDatabase('contests', [
            'id' => '1',
            'campaign_id' => '1234',
            'campaign_run_id' => '123',
            'sender_email' => 'ssmith@dosomething.org',
            'sender_name' => 'Shae',
        ]);

        // Make sure a waiting room was created.
        $this->seeInDatabase('waiting_rooms', [
			'id' => '1',
			'contest_id' => '1',
			'signup_start_date' => $signup_start_date,
			'signup_end_date' => $signup_end_date,
        ]);

        // Make sure default messages are created. Just test that required fields are there.
		$correspondence = app(Gladiator\Http\Utilities\Correspondence::class);

		foreach (correspondence()->defaults() as $message) {
			$this->seeInDatabase('messages', [
				'contest_id' => '1',
				'type' => $message['type'],
				'label' => $message['label'],
				'subject' => $message['subject'],
				'body' => $message['body'],
			]);
		}
	}
}
