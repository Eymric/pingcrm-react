<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\Report;
use App\Models\User;
use Inertia\Testing\Assert;
use Tests\TestCase;

class ReportsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $account = Account::create(['name' => 'Acme Corporation']);

        $this->user = User::factory()->make([
            'account_id' => $account->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'owner' => true,
        ]);
    }

    public function test_can_view_reports()
    {
        $this->user->account->reports()->saveMany(
            Report::factory()->count(5)->make()
        );

        $this->actingAs($this->user)
            ->get('/reports')
            ->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                $page->component('Reports/Index');
                $page->has('reports.data', 5, function (Assert $page) {
                    $page->hasAll(['id', 'title', 'description', 'date']);
                });
            });
    }

}
