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
 * App\AsesiCustomData
 *
 * @property int $id
 * @property string $title
 * @property string $input_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AsesiCustomData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AsesiCustomData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AsesiCustomData query()
 */
	class AsesiCustomData extends \Eloquent {}
}

namespace App{
/**
 * App\AsesiSertifikasiUnitKompetensiElement
 *
 * @property int $id
 * @property int $user_asesi_id
 * @property int $unit_kompetensi_id
 * @property string $desc
 * @property string $upload_instruction
 * @property string|null $media_url
 * @property int $is_verified
 * @property string|null $verification_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AsesiSertifikasiUnitKompetensiElement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AsesiSertifikasiUnitKompetensiElement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AsesiSertifikasiUnitKompetensiElement query()
 */
	class AsesiSertifikasiUnitKompetensiElement extends \Eloquent {}
}

namespace App{
/**
 * App\AsesiUnitKompetensiDokumen
 *
 * @property int $id
 * @property int $user_asesi_id
 * @property int $unit_kompetensi_id
 * @property string $order
 * @property int $sertifikasi_id
 * @property string $kode_unit_kompetensi
 * @property string $title
 * @property string $sub_title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AsesiUnitKompetensiDokumen newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AsesiUnitKompetensiDokumen newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AsesiUnitKompetensiDokumen query()
 */
	class AsesiUnitKompetensiDokumen extends \Eloquent {}
}

namespace App{
/**
 * App\Order
 *
 * @property int $id
 * @property int $asesi_id
 * @property int $sertifikasi_id
 * @property int $tuk_id
 * @property string $tipe_sertifikasi
 * @property string $kode_sertifikat
 * @property float $original_price
 * @property float $tuk_price
 * @property string $status
 * @property string|null $comment_rejected
 * @property string|null $comment_verification
 * @property string|null $transfer_from_bank_name
 * @property string|null $transfer_from_bank_account
 * @property int|null $transfer_from_bank_number
 * @property string $transfer_to_bank_name
 * @property string $transfer_to_bank_account
 * @property int $transfer_to_bank_number
 * @property string|null $transfer_date
 * @property string|null $media_url_bukti_transfer
 * @property string $expired_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 */
	class Order extends \Eloquent {}
}

namespace App{
/**
 * App\Sertifikasi
 *
 * @property int $id
 * @property string $nomor_skema
 * @property string $title
 * @property float $original_price_baru
 * @property float $original_price_perpanjang
 * @property string $jenis_sertifikasi
 * @property int $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Sertifikasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sertifikasi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sertifikasi query()
 */
	class Sertifikasi extends \Eloquent {}
}

namespace App{
/**
 * App\SertifikasiTuk
 *
 * @property int $id
 * @property int $sertifikasi_id
 * @property int $tuk_id
 * @property float $tuk_price_baru
 * @property float $tuk_price_perpanjang
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SertifikasiTuk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SertifikasiTuk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SertifikasiTuk query()
 */
	class SertifikasiTuk extends \Eloquent {}
}

namespace App{
/**
 * App\SertifikasiUnitKompentensi
 *
 * @property int $id
 * @property string $order
 * @property int $sertifikasi_id
 * @property string $kode_unit_kompetensi
 * @property string $title
 * @property string $sub_title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SertifikasiUnitKompentensi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SertifikasiUnitKompentensi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SertifikasiUnitKompentensi query()
 */
	class SertifikasiUnitKompentensi extends \Eloquent {}
}

namespace App{
/**
 * App\SertifikasiUnitKompetensiElement
 *
 * @property int $id
 * @property int $unit_kompetensi_id
 * @property string $desc
 * @property string $upload_instruction
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SertifikasiUnitKompetensiElement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SertifikasiUnitKompetensiElement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SertifikasiUnitKompetensiElement query()
 */
	class SertifikasiUnitKompetensiElement extends \Eloquent {}
}

namespace App{
/**
 * App\Soal
 *
 * @property int $id
 * @property string $question
 * @property string $question_type
 * @property string $answer_essay
 * @property string $answer_option
 * @property string $max_score
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Soal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Soal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Soal query()
 */
	class Soal extends \Eloquent {}
}

namespace App{
/**
 * App\SoalPaket
 *
 * @property int $id
 * @property string $title
 * @property int $sertifikasi_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SoalPaket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SoalPaket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SoalPaket query()
 */
	class SoalPaket extends \Eloquent {}
}

namespace App{
/**
 * App\SoalPaketItem
 *
 * @property int $id
 * @property int $soal_paket_id
 * @property int $soal_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SoalPaketItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SoalPaketItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SoalPaketItem query()
 */
	class SoalPaketItem extends \Eloquent {}
}

namespace App{
/**
 * App\SoalPilihanGanda
 *
 * @property int $id
 * @property int $soal_id
 * @property string $option
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SoalPilihanGanda newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SoalPilihanGanda newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SoalPilihanGanda query()
 */
	class SoalPilihanGanda extends \Eloquent {}
}

namespace App{
/**
 * App\SoalUnitKompetensi
 *
 * @property int $id
 * @property int $soal_id
 * @property int $unit_kompetensi_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SoalUnitKompetensi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SoalUnitKompetensi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SoalUnitKompetensi query()
 */
	class SoalUnitKompetensi extends \Eloquent {}
}

namespace App{
/**
 * App\Tuk
 *
 * @property int $id
 * @property string $code
 * @property string $title
 * @property string $telp
 * @property string $address
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Tuk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tuk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tuk query()
 */
	class Tuk extends \Eloquent {}
}

namespace App{
/**
 * App\TukBank
 *
 * @property int $id
 * @property int $tuk_id
 * @property string $bank_name
 * @property string $account_number
 * @property string $account_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|TukBank newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TukBank newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TukBank query()
 */
	class TukBank extends \Eloquent {}
}

namespace App{
/**
 * App\UjianAsesiAsesor
 *
 * @property int $id
 * @property int $asesi_id
 * @property int $asesor_id
 * @property int $ujian_jadwal_id
 * @property int $sertifikasi_id
 * @property int $order_id
 * @property string $status
 * @property int $is_kompeten
 * @property int $final_score_percentage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UjianAsesiAsesor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UjianAsesiAsesor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UjianAsesiAsesor query()
 */
	class UjianAsesiAsesor extends \Eloquent {}
}

namespace App{
/**
 * App\UjianAsesiJawaban
 *
 * @property int $id
 * @property int $soal_id
 * @property string $question
 * @property string $question_type
 * @property string|null $answer_essay
 * @property string|null $answer_option
 * @property int $urutan
 * @property string|null $user_answer
 * @property string|null $catatan_asesor
 * @property int|null $max_score
 * @property int|null $final_score
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UjianAsesiJawaban newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UjianAsesiJawaban newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UjianAsesiJawaban query()
 */
	class UjianAsesiJawaban extends \Eloquent {}
}

namespace App{
/**
 * App\UjianAsesiJawabanPilihan
 *
 * @property int $id
 * @property string $option
 * @property string $label
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UjianAsesiJawabanPilihan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UjianAsesiJawabanPilihan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UjianAsesiJawabanPilihan query()
 */
	class UjianAsesiJawabanPilihan extends \Eloquent {}
}

namespace App{
/**
 * App\UjianJadwal
 *
 * @property int $id
 * @property string $tanggal
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UjianJadwal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UjianJadwal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UjianJadwal query()
 */
	class UjianJadwal extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string $type
 * @property string $status
 * @property string|null $media_url
 * @property bool $is_active
 * @property string|null $media_url_sign_user
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
 * App\UserAsesi
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
 * @property int|null $user_id_admin
 * @property string|null $note_admin
 * @property bool $is_verified
 * @property string|null $verification_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserAsesi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAsesi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAsesi query()
 */
	class UserAsesi extends \Eloquent {}
}

namespace App{
/**
 * App\UserAsesiCustomData
 *
 * @property int $id
 * @property int $user_asesi_id
 * @property string $title
 * @property string $input_type
 * @property string $value
 * @property bool $is_verified
 * @property string|null $verification_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserAsesiCustomData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAsesiCustomData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAsesiCustomData query()
 */
	class UserAsesiCustomData extends \Eloquent {}
}

namespace App{
/**
 * App\UserAsesor
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
 * @method static \Illuminate\Database\Eloquent\Builder|UserAsesor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAsesor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAsesor query()
 */
	class UserAsesor extends \Eloquent {}
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

