<?php

namespace App\Support;

class TherapyOptions
{
    public const OPTIONS = [
        'consultation' => [
            'label' => 'Consultation',
            'amount' => 200,
        ],
        'quarter_massage' => [
            'label' => '1/4 Massage',
            'amount' => 800,
        ],
        'half_back_massage' => [
            'label' => 'Half Back Massage',
            'amount' => 500,
        ],
        'full_body_massage' => [
            'label' => 'Full Body Massage',
            'amount' => 1000,
        ],
        'navarakili_massage' => [
            'label' => 'Navarakili Massage',
            'amount' => 1000,
        ],
        'leg_massage' => [
            'label' => 'Leg Massage',
            'amount' => 750,
        ],
    ];

    public static function all(): array
    {
        return self::OPTIONS;
    }

    public static function amount(?string $key): float
    {
        return (float) (self::OPTIONS[$key]['amount'] ?? 0);
    }

    public static function label(?string $key): string
    {
        return (string) (self::OPTIONS[$key]['label'] ?? '');
    }

    public static function keys(): array
    {
        return array_keys(self::OPTIONS);
    }
}
