<?php

namespace KiriminAja\Services\Profile;

require_once __DIR__ . '/ProfileMock.php';

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ProfileServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    public static function successfulProfilePayloads(): array
    {
        $profile = [
            'id' => 123,
            'name' => 'KiriminAja Merchant',
            'email' => 'merchant@example.com',
            'metadata' => ['payment_method' => 'TOP'],
        ];

        return [
            'plural results envelope' => [['status' => true, 'text' => 'loaded', 'results' => $profile], $profile],
            'singular result envelope' => [['status' => true, 'message' => 'loaded', 'result' => $profile], $profile],
            'data envelope' => [['status' => true, 'data' => $profile], $profile],
            'unwrapped profile' => [$profile, $profile],
        ];
    }

    #[DataProvider('successfulProfilePayloads')]
    public function testItNormalizesSuccessfulProfilePayloads(array $payload, array $expected): void
    {
        (new ProfileMock())->profileMock()
            ->shouldReceive('get')
            ->once()
            ->andReturn([true, $payload]);

        $result = (new ProfileService())->call();

        self::assertTrue($result->status);
        self::assertSame($expected, $result->data);
    }

    public function testItRejectsSuccessfulResponsesWithoutProfileData(): void
    {
        (new ProfileMock())->profileMock()
            ->shouldReceive('get')
            ->once()
            ->andReturn([true, ['status' => true, 'text' => 'loaded']]);

        $result = (new ProfileService())->call();

        self::assertFalse($result->status);
        self::assertSame('Profile data is missing from the API response', $result->message);
        self::assertNull($result->data);
    }
}
