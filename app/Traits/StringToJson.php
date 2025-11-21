<?php

namespace App\Traits;

use RuntimeException;

trait StringToJson
{
    public static function  parseAiJson(string $raw): array
    {
        $clean = trim($raw);
        $clean = str_replace('\\n', "\n", $clean);
        $clean = preg_replace(['/^```json\s*/i', '/\s*```$/'], '', $clean);
        $clean = trim($clean);

        $data = json_decode($clean, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $data;
        }

        $firstBrace = strpos($clean, '{');
        $lastBrace  = strrpos($clean, '}');

        if ($firstBrace !== false && $lastBrace !== false && $lastBrace > $firstBrace) {
            $candidate = substr($clean, $firstBrace, $lastBrace - $firstBrace + 1);
            $data = json_decode($candidate, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $data;
            }
        }

        // 6. أخيراً: رمي استثناء واضح مع رسالة الخطأ
        throw new RuntimeException("JSON Parse Error: " . json_last_error_msg());
    }
}
