<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class PublicCourseControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config([
            'course_catalog.base_url' => 'https://partner.test',
            'course_catalog.token' => 'fake-token',
            'course_catalog.storefront_url_template' => 'https://partner.test/courses/{slug}',
        ]);
    }

    public function test_index_strips_gated_fields_from_partner_response(): void
    {
        Http::fake([
            'partner.test/api/courses*' => Http::response([
                'data' => [$this->partnerCoursePayload()],
                'meta' => ['current_page' => 1, 'last_page' => 1, 'per_page' => 15, 'total' => 1],
            ], 200),
        ]);

        $response = $this->getJson('/api/public/courses');

        $response->assertOk();
        $response->assertJsonCount(1, 'data');
        $response->assertJsonPath('data.0.title', 'Quit Porn and Sex Addiction');
        $response->assertJsonPath('data.0.purchase_url', 'https://partner.test/courses/quit-porn-sex-addiction');
        $response->assertJsonMissingPath('data.0.weeks');
        $response->assertJsonMissingPath('data.0.materials');
    }

    public function test_show_returns_a_single_trimmed_course(): void
    {
        Http::fake([
            'partner.test/api/courses/quit-porn-sex-addiction' => Http::response([
                'data' => $this->partnerCoursePayload(),
            ], 200),
        ]);

        $response = $this->getJson('/api/public/courses/quit-porn-sex-addiction');

        $response->assertOk();
        $response->assertJsonPath('data.category.name', 'Addiction Recovery');
        $response->assertJsonMissingPath('data.weeks');
        $response->assertJsonMissingPath('data.materials');
    }

    public function test_show_returns_404_when_partner_reports_not_found(): void
    {
        Http::fake([
            'partner.test/api/courses/nonexistent' => Http::response(['message' => 'Not Found'], 404),
        ]);

        $this->getJson('/api/public/courses/nonexistent')->assertNotFound();
    }

    public function test_index_returns_a_clean_502_when_partner_api_is_unreachable(): void
    {
        Http::fake([
            'partner.test/api/courses*' => Http::response(['message' => 'Unauthorized'], 401),
        ]);

        $response = $this->getJson('/api/public/courses');

        $response->assertStatus(502);
        $response->assertJsonMissing(['token' => 'fake-token']);
    }

    public function test_index_returns_a_clean_502_when_not_configured(): void
    {
        config(['course_catalog.base_url' => null, 'course_catalog.token' => null]);

        $this->getJson('/api/public/courses')->assertStatus(502);
    }

    /**
     * Mirrors App\Http\Resources\CourseApiResource on the partner app.
     *
     * @return array<string, mixed>
     */
    protected function partnerCoursePayload(): array
    {
        return [
            'id' => 1,
            'slug' => 'quit-porn-sex-addiction',
            'title' => 'Quit Porn and Sex Addiction',
            'type' => 'video',
            'details' => 'A budget-friendly recovery programme.',
            'price' => 15000.0,
            'original_price' => 20000.0,
            'discount_percentage' => 25,
            'image_url' => 'https://partner.test/storage/courses/quit-porn.jpg',
            'has_certificate' => true,
            'requires_registration' => false,
            'access_duration_months' => 6,
            'is_lifetime_access' => false,
            'rating_avg' => 4.8,
            'ratings_count' => 32,
            'category' => ['id' => 1, 'name' => 'Addiction Recovery', 'slug' => 'addiction-recovery'],
            'weeks' => [
                ['week_number' => 1, 'title' => 'Week 1', 'details' => 'Intro', 'resources' => [
                    ['title' => 'Video 1', 'youtube_url' => 'https://youtube.com/secret-video'],
                ]],
            ],
            'materials' => [
                ['label' => 'Workbook', 'week_number' => 1, 'download_url' => 'https://files.partner.test/secret.pdf'],
            ],
            'created_at' => '2026-01-01T00:00:00+00:00',
            'updated_at' => '2026-01-01T00:00:00+00:00',
        ];
    }
}
