<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $type
 * @property string $status
 * @property string|null $media_url
 * @property bool $is_active
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read int|null $tokens_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\UserAssesi
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $address
 * @property bool $gender
 * @property string $birth_place
 * @property \Illuminate\Support\Carbon $birth_date
 * @property string $no_ktp
 * @property string $pendidikan_terakhir
 * @property bool $has_job
 * @property string|null $job_title
 * @property string|null $job_address
 * @property string|null $media_url_sign_admin
 * @property int|null $user_id_admin
 * @property string $media_url_sign_user
 * @property string|null $note_admin
 * @property bool $is_verified
 * @property string|null $verification_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserAssesi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAssesi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAssesi query()
 */
	class UserAssesi extends \Eloquent {}
}

namespace App{
/**
 * App\UserAssesor
 *
 * @property int $id
 * @property int $user_id
 * @property string $met
 * @property string $name
 * @property string $expired_date
 * @property string $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $User
 * @method static \Illuminate\Database\Eloquent\Builder|UserAssesor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAssesor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAssesor query()
 */
	class UserAssesor extends \Eloquent {}
}

namespace App{
/**
 * App\UserTuk
 *
 * @property int $id
 * @property int $user_id
 * @property int $tuk_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $User
 * @method static \Illuminate\Database\Eloquent\Builder|UserTuk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTuk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTuk query()
 */
	class UserTuk extends \Eloquent {}
}

