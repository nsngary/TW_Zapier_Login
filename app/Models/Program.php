<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';
    protected $primaryKey = 'program';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'sid',
        'sname',
        'program'
    ];

    /**
     * 關聯到管理員權限
     */
    public function adminPermissions()
    {
        return $this->hasMany(AdminPermission::class, 'sid', 'sid');
    }

    /**
     * 取得擁有此權限的管理員
     */
    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'mright', 'sid', 'account');
    }

    /**
     * 權限等級定義
     */
    public static function getPermissionLevels()
    {
        return [
            's00' => '權限管理',
            's01' => '帳號管理',
            's02' => '產品管理',
            's03' => '產品資料維護'
        ];
    }

    /**
     * 檢查權限等級
     */
    public function isHigherThan($otherSid)
    {
        $levels = ['s00', 's01', 's02', 's03'];
        $thisLevel = array_search($this->sid, $levels);
        $otherLevel = array_search($otherSid, $levels);

        return $thisLevel !== false && $otherLevel !== false && $thisLevel < $otherLevel;
    }
}
