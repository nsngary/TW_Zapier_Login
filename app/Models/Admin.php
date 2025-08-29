<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin';
    protected $primaryKey = 'account';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false; // 禁用時間戳

    protected $fillable = [
        'account',
        'password',
        'username'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * 取得用於認證的使用者名稱欄位
     */
    public function getAuthIdentifierName()
    {
        return 'account';
    }

    /**
     * 取得用於認證的密碼欄位
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * 範圍查詢：依帳號或使用者名稱搜尋
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('account', $search)
                    ->orWhere('username', 'LIKE', "%{$search}%");
    }

    /**
     * 驗證密碼
     */
    public function checkPassword($password)
    {
        // 如果密碼是明文儲存（舊系統），直接比較
        // 建議之後改用 Hash::check()
        return $this->password === $password;
    }

    /**
     * 設定密碼（建議使用 Hash）
     */
    public function setPasswordAttribute($value)
    {
        // 暫時保持明文，之後可改用：
        // $this->attributes['password'] = Hash::make($value);
        $this->attributes['password'] = $value;
    }

    /**
     * 關聯到管理員權限
     */
    public function permissions()
    {
        return $this->hasMany(AdminPermission::class, 'account', 'account');
    }

    /**
     * 關聯到權限程式
     */
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'mright', 'account', 'sid');
    }

    /**
     * 檢查是否有特定權限
     */
    public function hasPermission($sid)
    {
        return AdminPermission::hasPermission($this->account, $sid);
    }

    /**
     * 檢查是否有任何權限
     */
    public function hasAnyPermission()
    {
        return $this->permissions()->exists();
    }

    /**
     * 取得所有權限
     */
    public function getPermissions()
    {
        return AdminPermission::getAdminPermissions($this->account);
    }

    /**
     * 檢查是否有權限管理權限
     */
    public function canManagePermissions()
    {
        return $this->hasPermission('s00');
    }

    /**
     * 檢查是否有帳號管理權限
     */
    public function canManageAccounts()
    {
        return $this->hasPermission('s01');
    }

    /**
     * 檢查是否有產品管理權限
     */
    public function canManageProducts()
    {
        return $this->hasPermission('s02');
    }

    /**
     * 檢查是否有產品資料維護權限
     */
    public function canMaintainProducts()
    {
        return $this->hasPermission('s03');
    }
}
