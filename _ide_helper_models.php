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
 * @property string|null $dropdown_option
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
 * App\AsesiSUKElementMedia
 *
 * @property int $id
 * @property int $asesi_id
 * @property int $asesi_suk_element_id
 * @property string|null $description
 * @property string $media_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|AsesiSUKElementMedia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AsesiSUKElementMedia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AsesiSUKElementMedia query()
 */
	class AsesiSUKElementMedia extends \Eloquent {}
}

namespace App{
/**
 * App\AsesiSertifikasiUnitKompetensiElement
 *
 * @property int $id
 * @property int $asesi_id
 * @property int $unit_kompetensi_id
 * @property string $desc
 * @property string $upload_instruction
 * @property bool $is_verified
 * @property string|null $verification_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\UserAsesi|null $Asesi
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AsesiSUKElementMedia[] $Media
 * @property-read int|null $media_count
 * @property-read \App\SertifikasiUnitKompentensi|null $UnitKompentensi
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
 * @property int $asesi_id
 * @property int $unit_kompetensi_id
 * @property string $order
 * @property int $sertifikasi_id
 * @property string $kode_unit_kompetensi
 * @property string $title
 * @property string|null $sub_title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AsesiSertifikasiUnitKompetensiElement[] $AsesiSertifikasiUnitKompetensiElement
 * @property-read int|null $asesi_sertifikasi_unit_kompetensi_element_count
 * @property-read \App\Sertifikasi|null $Sertifikasi
 * @property-read \App\User|null $User
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
 * @property string|null $sertifikat_number_old
 * @property string|null $sertifikat_number_new
 * @property mixed|null $sertifikat_date_old
 * @property mixed|null $sertifikat_date_new
 * @property string|null $sertifikat_media_url_old
 * @property string|null $sertifikat_media_url_new
 * @property string|null $kode_sertifikat
 * @property float $original_price
 * @property float $tuk_price
 * @property float|null $tuk_price_training
 * @property string $status
 * @property string|null $comment_rejected
 * @property string|null $comment_verification
 * @property string|null $transfer_from_bank_name
 * @property string|null $transfer_from_bank_account
 * @property string|null $transfer_from_bank_number
 * @property string|null $transfer_to_bank_name
 * @property string|null $transfer_to_bank_account
 * @property string|null $transfer_to_bank_number
 * @property mixed|null $transfer_date
 * @property string|null $media_url_bukti_transfer
 * @property mixed $expired_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Sertifikasi|null $Sertifikasi
 * @property-read \App\Tuk|null $Tuk
 * @property-read \App\User|null $User
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
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\AsesiUnitKompetensiDokumen[] $AsesiUnitKompetensiDokumen
 * @property-read int|null $asesi_unit_kompetensi_dokumen_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SertifikasiTuk[] $SertifikasiTuk
 * @property-read int|null $sertifikasi_tuk_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SertifikasiUnitKompentensi[] $SertifikasiUnitKompentensi
 * @property-read int|null $sertifikasi_unit_kompentensi_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UnitKompetensi[] $UnitKompetensi
 * @property-read int|null $unit_kompetensi_count
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
 * @property float|null $tuk_price_training
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Sertifikasi|null $Sertifikasi
 * @property-read \App\Tuk|null $Tuk
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
 * @property int $sertifikasi_id
 * @property int $unit_kompetensi_id
 * @property int $order
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Sertifikasi|null $Sertifikasi
 * @property-read \App\UnitKompetensi|null $UnitKompetensi
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
 * @property-read \App\SertifikasiUnitKompentensi|null $UnitKompetensi
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
 * @property int $unit_kompetensi_id
 * @property int|null $asesor_id
 * @property string $question
 * @property string $question_type
 * @property string|null $answer_essay
 * @property string|null $answer_option
 * @property string $max_score
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SoalPilihanGanda[] $SoalPilihanGanda
 * @property-read int|null $soal_pilihan_ganda_count
 * @property-read \App\UnitKompetensi|null $UnitKompetensi
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
 * @property string $durasi_ujian
 * @property int $sertifikasi_id
 * @property int|null $asesor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Sertifikasi|null $Sertifikasi
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\SoalPaketItem[] $SoalPaketItem
 * @property-read int|null $soal_paket_item_count
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
 * @property-read \App\Soal|null $Soal
 * @property-read \App\SoalPaket|null $SoalPaket
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
 * @property-read \App\Soal|null $Soal
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
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TukBank[] $Bank
 * @property-read int|null $bank_count
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
 * @property-read \App\Tuk|null $Tuk
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
 * @property int|null $soal_paket_id
 * @property string|null $ujian_start
 * @property string $status
 * @property bool|null $is_kompeten
 * @property int|null $final_score_percentage
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Order|null $Order
 * @property-read \App\Sertifikasi|null $Sertifikasi
 * @property-read \App\SoalPaket|null $SoalPaket
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UjianAsesiJawaban[] $UjianAsesiJawaban
 * @property-read int|null $ujian_asesi_jawaban_count
 * @property-read \App\UjianJadwal|null $Ujianjadwal
 * @property-read \App\User|null $UserAsesi
 * @property-read \App\User|null $UserAsesor
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
 * @property int $ujian_asesi_asesor_id
 * @property int $soal_id
 * @property int $asesi_id
 * @property string $question
 * @property string $question_type
 * @property string|null $answer_essay
 * @property string|null $answer_option
 * @property array|null $options_label
 * @property int $urutan
 * @property string|null $user_answer
 * @property string|null $catatan_asesor
 * @property int|null $max_score
 * @property int|null $final_score
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User|null $Asesi
 * @property-read \App\Soal|null $Soal
 * @method static \Illuminate\Database\Eloquent\Builder|UjianAsesiJawaban newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UjianAsesiJawaban newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UjianAsesiJawaban query()
 */
	class UjianAsesiJawaban extends \Eloquent {}
}

namespace App{
/**
 * App\UjianJadwal
 *
 * @property int $id
 * @property string $tanggal
 * @property string $jam_mulai
 * @property string $jam_berakhir
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
 * App\UnitKompetensi
 *
 * @property int $id
 * @property string $kode_unit_kompetensi
 * @property string $title
 * @property string|null $sub_title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Sertifikasi|null $Sertifikasi
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UnitKompetensiElement[] $UKElement
 * @property-read int|null $u_k_element_count
 * @method static \Illuminate\Database\Eloquent\Builder|UnitKompetensi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitKompetensi newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitKompetensi query()
 */
	class UnitKompetensi extends \Eloquent {}
}

namespace App{
/**
 * App\UnitKompetensiElement
 *
 * @property int $id
 * @property int $unit_kompetensi_id
 * @property string $desc
 * @property string $upload_instruction
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\UnitKompetensi|null $UnitKompetensi
 * @method static \Illuminate\Database\Eloquent\Builder|UnitKompetensiElement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitKompetensiElement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UnitKompetensiElement query()
 */
	class UnitKompetensiElement extends \Eloquent {}
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
 * @property string|null $media_url_sign_user
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\UserAsesi|null $Asesi
 * @property-read \App\UserAsesor|null $Asesor
 * @property-read \App\UserTuk|null $Tuk
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
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App{
/**
 * App\UserAsesi
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $address
 * @property string|null $phone_number
 * @property string $gender
 * @property string|null $birth_place
 * @property string $birth_date
 * @property string|null $no_ktp
 * @property string|null $pendidikan_terakhir
 * @property bool|null $has_job
 * @property string|null $job_title
 * @property string|null $job_address
 * @property string|null $company_name
 * @property string|null $company_phone
 * @property string|null $company_email
 * @property int|null $user_id_admin
 * @property bool|null $is_verified
 * @property string|null $verification_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserAsesiCustomData[] $AsesiCustomData
 * @property-read int|null $asesi_custom_data_count
 * @property-read \App\User|null $User
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
 * @property int $asesi_id
 * @property string $title
 * @property string $input_type
 * @property string $value
 * @property bool $is_verified
 * @property string|null $verification_note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\UserAsesi|null $Asesi
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
 * @property-read \App\Tuk|null $Tuk
 * @property-read \App\User|null $User
 * @method static \Illuminate\Database\Eloquent\Builder|UserTuk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTuk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserTuk query()
 */
	class UserTuk extends \Eloquent {}
}

