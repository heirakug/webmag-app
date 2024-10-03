<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Mews\Purifier\Facades\Purifier;

class SafeHtml implements Rule
{
    protected $errorDetails = [];

    protected $allowedProperties = [
        'aspect-ratio',  // 許可したいスタイルプロパティ
        // 他の許可したいスタイルプロパティを追加
    ];

    public function passes($attribute, $value)
    {
        $purified = Purifier::clean($value, 'default');

        // if ($purified !== $value) {
        //     $this->errorDetails = $this->findDifferences($value, $purified);

        //     // エラーの詳細が空の場合はtrueを返す
        //     return empty($this->errorDetails);
        // }

         // Purifierでクリーニングされた内容を解析
         preg_match_all('/style\s*=\s*"([^"]*)"/i', $purified, $matches);

         foreach ($matches[1] as $style) {
            $properties = explode(';', $style);
            foreach ($properties as $property) {
                $property = trim($property);
                if ($property) {
                    $name = explode(':', $property)[0];
                    if (!in_array($name, $this->allowedProperties)) {
                        // 許可されていないプロパティがある場合、具体的なエラーメッセージを設定
                        $this->errorDetails[] = $name; // 許可されていないプロパティを保存
                        return false; // バリデーション失敗
                    }
                }
            }
        }

        return true;
    }

    public function message()
    {
        return 'The :attribute contains potentially unsafe HTML: ' . implode(', ', $this->errorDetails);
    }

    // protected function findDifferences($original, $purified)
    // {
    //     $differences = [];
    //     $originalTags = $this->extractTags($original);
    //     $purifiedTags = $this->extractTags($purified);

    //     $diffOriginal = array_diff($originalTags, $purifiedTags);
    //     $diffPurified = array_diff($purifiedTags, $originalTags);

    //     foreach ($diffOriginal as $tag) {
    //         $differences[] = "Tag removed: <$tag>";
    //     }

    //     foreach ($diffPurified as $tag) {
    //         $differences[] = "Tag added: <$tag>";
    //     }

    //     // タグの差異がない場合、内容の差異を確認
    //     // if (empty($differences) && $original !== $purified) {
    //     //     $differences[] = "Content difference detected";
    //     // }

    //     return $differences;
    // }

    // protected function extractTags($html)
    // {
    //     preg_match_all('/<([^>]+)>/i', $html, $matches);
    //     return $matches[1];
    // }
}
