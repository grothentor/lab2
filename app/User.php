<?php

namespace App;

use App\Notifications\ResetPassword;
use App\Services\TransactionService;
use App\Traits\Notifiable;
use App\Traits\SerializeJsonDates;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Validation\Rule;

class User extends Authenticatable
{
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected static $cacheTime = 10; //minutes

    public static $validationRules = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:100|unique:users',
        'password' => 'required|min:6|confirmed',
        'phone' => 'required|phone:UA|unique:phones,phone'
    ];

    public static $validationAdmin = [
        'name' => 'required|max:255',
        'email' => ['required', 'email', 'max:255', 'unique:users'],
        'password' => 'required|min:6',
        'phones.*' => ['required', 'phone:UA', 'unique:phones,phone'],
    ];

    public static $agencyRoles = ['agent', 'agency'];
    public static $defaultNotifications = ['newAdsNotification', 'adExpiredNotification'];

    public function getEditValidation() {
        $rules = self::$validationAdmin;
        unset($rules['password']);

        foreach (['email', 'phones.*'] as $field) {
            foreach (preg_grep('/^unique/', $rules[$field]) as $key => $rule) {
                unset($rules[$field][$key]);
            }
        }

        $rules['email'][] = Rule::unique('users', 'email')
            ->ignore($this->id, 'id');

        return $rules;
    }

    public function setPasswordAttribute($password){
        $this->attributes['password'] = bcrypt($password);
    }

    public static function checkAccess($user, $role, $equals = false) {
        if ($equals) return $role === $user->role;
        $otherRoles = ['admin', 'agency', 'agent', 'user'];
        $roles = ['superadmin'];

        $lastRole = array_search($role, $otherRoles);
        if (false !== $lastRole)
            for ($i = 0; $i <= $lastRole; $i++)
                $roles[] = $otherRoles[$i];

        return $user && in_array($user->role, $roles);
    }

    public function haveAccess($role, $equals = false) {
        return self::checkAccess($this, $role, $equals);
    }

    public static function createNew($data) {
        $data['api_token'] = str_random(60);
        if (isset($data['password_confirmation'])) unset ($data['password_confirmation']);

        $user = self::query()->create($data);

        return $user;
    }

    public function forJs() {
        $fields = ['id', 'email', 'name', 'role'];
        $user = [];
        foreach ($fields as $field)
            $user[$field] = $this->$field;
        return $user;
    }

    public static function getAdmin() {
        // TODO: check if super admin not exists
        return self::query()->where('role', 'superadmin')->first();
    }

    public static function getDeveloper() {
        // TODO: check if admin not exists
        return self::query()->where('role', 'admin')->first();
    }
}
