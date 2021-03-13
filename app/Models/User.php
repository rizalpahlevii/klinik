<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Eloquent;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\Permission\Traits\HasRoles;
use Webpatser\Uuid\Uuid;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $fullname
 * @property string $username
 * @property string $password
 * @property string $phone
 * @property string $gender
 * @property string $role
 * @property date $start_working_date
 * @property string|null $address
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAddressId($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDeletedAt($value)
 * @method static Builder|User whereDepartmentId($value)
 * @method static Builder|User whereDesignation($value)
 * @method static Builder|User whereDob($value)
 * @method static Builder|User whereEducation($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereFirstName($value)
 * @method static Builder|User whereGender($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereLastName($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User wherePhone($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property string|null $blood_group
 * @property int|null $owner_id
 * @property string|null $owner_type
 * @property-read mixed $image_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
 * @property-read int|null $media_count
 * @property-read \App\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Department[] $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBloodGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereOwnerType($value)
 * @property string|null $qualification
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereQualification($value)
 */
class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use Notifiable, HasMediaTrait, HasRoles, SoftDeletes;

    const COLLECTION_PROFILE_PICTURES = 'profile_photo';
    const COLLECTION_MAIL_ATTACHMENTS = 'mail_attachments';

    const LANGUAGES = [
        'en' => 'English',
        'es' => 'Spanish',
        'fr' => 'French',
        'de' => 'German',
        'ru' => 'Russian',
        'pt' => 'Portuguese',
        'ar' => 'Arabic',
        'zh' => 'Chinese',
        'tr' => 'Turkish',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'phone',
        'gender',
        'fullname',
        'start_working_date',
        'address',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) Uuid::generate(4);
        });
    }

    /**
     * @var array
     */
    public static $messages = [
        'phone.digits' => 'The phone number must be 13 digits long.',
        'email.regex'  => 'Please enter valid email.',
        'photo.mimes'  => 'The profile image must be a file of type: jpeg, jpg, png.',
    ];

    public static $rules = [
        'name_form' => 'required|min:3',
        'address_form' => 'required|min:3',
        'role_form' => 'required',
        'phone_form' => 'required|numeric',
        'gender_form' => 'required',
        'start_working_date' => 'required',
        'username_form' => 'required|unique:users,username',
        'password' => 'required|same:password_confirmation|min:6'
    ];


    /**
     * @return mixed
     */
    public function getImageUrlAttribute()
    {
        /** @var Media $media */
        $media = $this->getMedia(User::COLLECTION_PROFILE_PICTURES)->first();
        if (!empty($media)) {
            return $media->getFullUrl();
        }

        return getUserImageInitial($this->id, $this->full_name);
    }

    public function getGenderAttribute()
    {
        return $this->attributes['gender'] == "female" ? "Wanita" : "Pria";
    }

    /**
     * Accessor for Age.
     */


    /**
     * @return MorphTo
     */



    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * @param  array  $ownerType
     *
     * @return string
     */

    public static function getOwnerType($ownerType)
    {
        switch ($ownerType) {
            case Accountant::class:
                return Notification::ACCOUNTANT;
            case Patient::class:
                return Notification::PATIENT;
            case Doctor::class:
                return Notification::DOCTOR;
            case Receptionist::class:
                return Notification::RECEPTIONIST;
            case CaseHandler::class:
                return Notification::CASE_HANDLER;
            case LabTechnician::class:
                return Notification::LAB_TECHNICIAN;
            case Nurse::class:
                return Notification::NURSE;
            case Pharmacist::class:
                return Notification::PHARMACIST;
            default:
                return Notification::ADMIN;
        }
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = strtolower($value);
    }
}
