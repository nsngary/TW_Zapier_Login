<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'account',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

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
     * 範圍查詢：只取得管理員
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * 檢查是否為管理員
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    /**
     * 驗證密碼
     */
    public function checkPassword($password)
    {
        return \Hash::check($password, $this->password);
    }

    /**
     * 關聯到權限
     */
    public function permissions()
    {
        return $this->hasMany(AdminPermission::class, 'account', 'account');
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