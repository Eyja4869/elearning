<?php

namespace App\Model\StudentClass;

use Auth;
use App\Model\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentClass extends Model
{
    protected $table = 'tbl_class';
    protected $guard_name = 'web';

    protected $fillable = [
        'class_name',
        'note',
        'jurusan',
        'kelas',
        'teacher_id',
        'teacher_name'
    ];

    public static $rules = [
        'class_name' => 'required',
        'jurusan' => 'string',
        'kelas' => 'string',
        'note' => 'string',
        'teacher_id' => 'required | interger',
        'teacher_name' => 'string'
    ];

    protected $hidden = [];

    public static function validateClass($jurusan, $class_name, $guru)
    {
        $data = self::where('jurusan', $jurusan)->where('class_name', $class_name)->where('teacher_id', $guru)->first();
        if ($data != null) {
            return true;
        }
        return false;
    }

    public static function getClass($search = null)
    {
        $user = Auth::user();
        if ($user->account_type == User::ACCOUNT_TYPE_TEACHER) {
            return self::where('class_name', 'like', '%' . $search . '%')->where('teacher_id', $user->id)->get();
        }
        return self::where('class_name', 'like', '%' . $search . '%')->get();
    }

    public function getTeacher()
    {
        return $this->hasOne('App\Model\User\User', 'id', 'teacher_id');
    }

    public function getSiswa()
    {
        return $this->belongsTo('App\Model\Siswa\Siswa');
    }

    public function hasUser()
    {
        return $this->belongsToMany(User::class, 'tbl_class_user', 'class_id', 'user_id');
    }
}
