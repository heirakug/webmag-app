<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Mews\Purifier\Facades\Purifier;

class Post extends Model
{
    use HasFactory;

    // ステータス定数
    public const STATUS_DRAFT = 'draft';
    public const STATUS_READY_FOR_REVIEW = 'ready_for_review';
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_EDITOR_REVIEW = 'editor_review';
    public const STATUS_REVISION_REQUIRED = 'revision_required';
    public const STATUS_EDITOR_APPROVED = 'editor_approved';
    public const STATUS_EDITOR_REJECTED = 'editor_rejected';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_ARCHIVED = 'archived';

    // ステータスリスト
    public const STATUS_LIST = [
        self::STATUS_DRAFT => '作業中',
        self::STATUS_READY_FOR_REVIEW => 'レビュー準備完了',
        self::STATUS_SUBMITTED => '投稿済み',
        self::STATUS_EDITOR_REVIEW => '編集者レビュー中',
        self::STATUS_REVISION_REQUIRED => '修正要求',
        self::STATUS_EDITOR_APPROVED => '編集者承認済み',
        self::STATUS_EDITOR_REJECTED => '編集者却下',
        self::STATUS_PUBLISHED => '公開済み',
        self::STATUS_ARCHIVED => 'アーカイブ済み',
    ];

    protected $fillable = [
        'title',
        'title_background',
        'category',
        'body',
        'tags',
        'status',
        'writer_id',
        'writer_name',
        'editor_id',
        'editor_name',
    ];

    // リレーションシップ
    public function writer(): BelongsTo
    {
        return $this->belongsTo(Writer::class, 'writer_id');
    }

    public function editor(): BelongsTo
    {
        return $this->belongsTo(Editor::class, 'editor_id');
    }

    // ステータスに関連するスコープを追加
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // ステータスの表示名を取得するメソッド
    public function getStatusNameAttribute()
    {
        return self::STATUS_LIST[$this->status] ?? '不明なステータス';
    }

    // アクセサとミューテータ
    public function getBodyAttribute($value)
    {
        return Purifier::clean($value);
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = Purifier::clean($value);
    }
}
