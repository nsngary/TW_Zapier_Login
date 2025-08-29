<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    use HasFactory;

    protected $table = 'mright';
    public $timestamps = false;

    protected $fillable = [
        'account',
        'sid'
    ];

    /**
     * 關聯到管理員（使用 User 模型）
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'account', 'account');
    }

    /**
     * 關聯到權限程式
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'sid', 'sid');
    }

    /**
     * 檢查管理員是否有特定權限
     */
    public static function hasPermission($account, $sid)
    {
        return self::where('account', $account)
                  ->where('sid', $sid)
                  ->exists();
    }

    /**
     * 取得管理員的所有權限
     */
    public static function getAdminPermissions($account)
    {
        return self::where('account', $account)
                  ->with('program')
                  ->get()
                  ->pluck('sid')
                  ->toArray();
    }

    /**
     * 為管理員分配權限
     */
    public static function assignPermission($account, $sid)
    {
        return self::firstOrCreate([
            'account' => $account,
            'sid' => $sid
        ]);
    }

    /**
     * 移除管理員權限
     */
    public static function removePermission($account, $sid)
    {
        return self::where('account', $account)
                  ->where('sid', $sid)
                  ->delete();
    }
}
