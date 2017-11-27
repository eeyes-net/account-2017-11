<?php

namespace App;

use App\Exceptions\CustomException;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Klaravel\Ntrust\Traits\NtrustUserTrait;
use Laravel\Passport\HasApiTokens;
use SoapClient;

/**
 * App\User
 *
 * @property int $id
 * @property string $username NetId
 * @property string $password
 * @property string $user_id 学工号
 * @property string $name 姓名
 * @property string $email E-mail
 * @property string $mobile 手机号码
 * @property string $gender 性别（“男”或“女”）
 * @property string $classid 班级名称
 * @property string $dep 学院名称
 * @property string $speciality 专业名称
 * @property string $depid 学院id
 * @property string $idcardname 证件类型（一般为“身份证”）
 * @property string $idcardno 证件号码
 * @property string $birthday 生日
 * @property string $roomnumber 宿舍地址
 * @property string $marriage “已婚”或“未婚”
 * @property string $nation 民族
 * @property string $nationplace 籍贯
 * @property string $polity 政治面貌（“中国共产主义青年团”“中国共产党党员”等）
 * @property string $studenttype 考生类型（“统考本科生”等）
 * @property string $tutoremployeeid 导师姓名
 * @property string $usertype 身份（具体不详，可能与是教师还是学生有关）
 * @property string $roomphone 宿舍电话（一般为null）
 * @property string|null $remember_token
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereClassid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDep($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDepid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIdcardname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereIdcardno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMarriage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereNationplace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePolity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoomnumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRoomphone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSpeciality($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereStudenttype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTutoremployeeid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUsertype($value)
 * @mixin \Eloquent
 * @property-read mixed $role_ids
 */
class User extends Authenticatable
{
    use HasApiTokens, NtrustUserTrait;

    /*
     * Role profile to get value from ntrust config file.
     */
    protected static $roleProfile = 'user';

    protected $fillable = [
        'username',
        'password',
        'user_id',
        'mobile',
        'name',
        'email',
        'gender',
        'birthday',
        'classid',
        'dep',
        'speciality',
        'depid',
        'roomnumber',
        'idcardname',
        'idcardno',
        'marriage',
        'nation',
        'nationplace',
        'polity',
        'studenttype',
        'tutoremployeeid',
        'usertype',
        'roomphone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'role_ids',
    ];

    public function getRoleIdsAttribute()
    {
        return $this->roles()->pluck('id');
    }

    public function perms()
    {
        return Permission::whereIn('name', $this->permNames())->get();
    }

    public function permNames()
    {
        $roles = $this->roles;
        $perms = [];
        /** @var \App\Role $role */
        foreach ($roles as $role) {
            $perms = array_merge($perms, $role->perms->pluck('name')->toArray());
        }
        return array_values(array_unique($perms));
    }

    public static function getInfoByNetId($net_id)
    {
        $client = new SoapClient(config('services.xjtu.user.info.url'));
        $result = $client->getInfoById([
            'auth' => config('services.xjtu.user.info.auth'),
            'uid' => $net_id,
        ]);
        if (!$result->return) {
            throw new CustomException('NetID not exists.');
        }
        $result = get_object_vars($result->return);
        foreach ($result as &$item) {
            if (is_null($item)) {
                $item = '';
            }
        }
        return $result;
    }

    public static function getUserPhotoByUserId($user_id)
    {
        $client = new SoapClient(config('services.xjtu.user.photo.url'));
        $result = $client->getPhotoByNo([
            'auth' => config('services.xjtu.user.photo.auth'),
            'sno' => $user_id,
        ]);
        return $result->return;
    }

    public static function newByNetId($net_id)
    {
        $info = User::getInfoByNetId($net_id);
        return new User([
            'username' => $net_id,
            'password' => '*',
            'user_id' => $info['userno'],
            'mobile' => $info['mobile'],
            'name' => $info['username'],
            'email' => $info['email'],
            'gender' => $info['gender'],
            'birthday' => $info['birthday'],
            'classid' => $info['classid'],
            'dep' => $info['dep'],
            'speciality' => $info['speciality'],
            'depid' => $info['depid'],
            'roomnumber' => $info['roomnumber'],
            'idcardname' => $info['idcardname'],
            'idcardno' => $info['idcardno'],
            'marriage' => $info['marriage'],
            'nation' => $info['nation'],
            'nationplace' => $info['nationplace'],
            'polity' => $info['polity'],
            'studenttype' => $info['studenttype'],
            'tutoremployeeid' => $info['tutoremployeeid'],
            'usertype' => $info['usertype'],
            'roomphone' => $info['roomphone'],
        ]);
    }
}
