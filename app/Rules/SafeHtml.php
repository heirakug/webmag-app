<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Mews\Purifier\Facades\Purifier;

class SafeHtml implements Rule
{
    protected $errorDetails = [];

    public function passes($attribute, $value)
    {
        $purified = Purifier::clean($value);

        if ($purified !== $value) {
            $this->errorDetails = $this->findDifferences($value, $purified);

            // エラーの詳細が空の場合はtrueを返す
            return empty($this->errorDetails);
        }

        return true;
    }

    public function message()
    {
        return 'The :attribute contains potentially unsafe HTML: ' . implode(', ', $this->errorDetails);
    }

    protected function findDifferences($original, $purified)
    {
        $differences = [];
        $originalTags = $this->extractTags($original);
        $purifiedTags = $this->extractTags($purified);

        $diffOriginal = array_diff($originalTags, $purifiedTags);
        $diffPurified = array_diff($purifiedTags, $originalTags);

        foreach ($diffOriginal as $tag) {
            $differences[] = "Tag removed: <$tag>";
        }

        foreach ($diffPurified as $tag) {
            $differences[] = "Tag added: <$tag>";
        }

        // タグの差異がない場合、内容の差異を確認
        // if (empty($differences) && $original !== $purified) {
        //     $differences[] = "Content difference detected";
        // }

        return $differences;
    }

    protected function extractTags($html)
    {
        preg_match_all('/<([^>]+)>/i', $html, $matches);
        return $matches[1];
    }
}
