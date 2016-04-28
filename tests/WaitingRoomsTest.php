<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Carbon\Carbon;
use Gladiator\Models\Contest;
use Gladiator\Models\WaitingRoom;
use Gladiator\Models\User;
use Gladiator\Services\Phoenix\Phoenix;

class WaitingRoomsTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDefaultWaitingRoomSplit()
    {
        // Create contest
        $contest = Contest::create([
            'campaign_id' => 5,
            'campaign_run_id' => 10,
            'sender_email' => 'epictestemail@fantini.com',
            'sender_name' => '@george',
        ]);

        // Create waiting room
        $contest->waitingRoom->signup_start_date = Carbon::now()->startOfDay();
        $contest->waitingRoom->signup_end_date = Carbon::now()->addWeeks(3)->endOfDay();
        $contest->waitingRoom->save();

        // Add 600 people
        $users = factory(User::class, 600)->create();
        foreach ($users as $user) {
            $contest->waitingRoom->users()->attach($user->id);
        }

        // Mock Phoenix API call
        $this->mock(Phoenix::class)
            ->shouldReceive('getCampaign')
            ->andReturn((object) [
                'data' => [
                    'id' => 1,
                ],
            ]);

        $this->asAdminUser()
            ->visit(route('split', [$contest->waitingRoom->id]))
            ->type(Carbon::now()->addWeeks(3)->endOfDay(), 'competition_end_date')
            ->type(300, 'competition_max')
            ->type('http://docs.google.com/lol', 'rules_url')
            ->press('Split');

        $this->see('Waiting Room has been split!');

        $this->assertCount(2, $contest->competitions->toArray());
    }
}
