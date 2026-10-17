<?php

namespace Tests\Feature;

use App\Repository\Resource\ResourceStatusesLkp;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MobileExercisesTest extends TestCase {
    use RefreshDatabase;

    private const PRIVATE_CARER = 2;

    protected function setUp(): void {
        parent::setUp();

        $this->seedLookupTables();
    }

    public function test_mobile_list_contains_only_approved_exercises(): void {
        $creator = $this->createUserWithRole(self::PRIVATE_CARER);
        $approved = $this->createResource($creator, ResourceStatusesLkp::APPROVED);
        $pending = $this->createResource($creator, ResourceStatusesLkp::CREATED_PENDING_APPROVAL);
        $approved->update(['display_in_api' => true]);
        $pending->update(['display_in_api' => true]);

        $slugs = collect($this->getJson('/mobile/exercises')->assertOk()->json('data'))->pluck('slug');

        $this->assertSame([$approved->slug], $slugs->all());
    }
}
