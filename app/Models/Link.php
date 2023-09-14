<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

/**
 * Медиа
 *
 * @property-read int         $id            ID ссылки
 * @property string           $original_url  Оригинальный URL
 * @property string           $shortened_url Короткий URL
 * @property string|null      $name          Имя ссылки
 * @property int              $visits        Количество посещений
 * @property int              $user_id       ID пользователя
 * @property User             $user          Пользователь
 * @property-read Carbon|null $created_at
 * @property-read Carbon|null $updated_at
 */
class Link extends Model
{
    protected $fillable = [
        'original_url',
        'shortened_url',
        'name',
        'visits',
        'user_id',
    ];

    /**
     * Пользователь
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить все ссылки пользователя
     *
     * @return Collection
     */
    public static function getLinks(): Collection
    {
        return Link::where('user_id', Auth::id())->get();
    }

    /**
     * Получить ссылку
     *
     * @param string $short_url
     *
     * @return Link|null
     */
    public static function getLink(string $short_url): ?Link
    {
        return Link::firstWhere('shortened_url', $short_url);
    }

    /**
     * Увеличить счетчик посещений
     *
     * @return $this
     */
    public function incrementCounter(): Link
    {
        $this->visits++;
        $this->save();

        return $this;
    }

    /**
     * Создать ссылку
     *
     * @param array $attributes
     *
     * @return Link
     */
    public static function storeLink(array $attributes): Link
    {
        $attributes['user_id'] = Auth::id();

        if (empty($attributes['shortened_url'])) {
            do {
                $attributes['shortened_url'] = hash('crc32b', $attributes['original_url'] . rand());
            } while (Link::query()->where('shortened_url', $attributes['shortened_url'])->count());
        }

        return Link::create($attributes);
    }

    /**
     * Обновить ссылку
     *
     * @param Link  $link
     * @param array $attributes
     *
     * @return Link
     */
    public static function updateLink(Link $link, array $attributes): Link
    {
        if (empty($attributes['shortened_url'])) {
            do {
                $attributes['shortened_url'] = hash('crc32b', $attributes['original_url'] . rand());
            } while (Link::query()->where('shortened_url', $attributes['shortened_url'])->count());
        }

        $link->update($attributes);

        return $link;
    }

    /**
     * Удалить ссылку
     *
     * @param Link $link
     *
     * @return bool|null
     */
    public static function destroyLink(Link $link): ?bool
    {
        return $link->delete();
    }
}
