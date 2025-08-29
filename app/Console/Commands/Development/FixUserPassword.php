<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FixUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:user-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '修復用戶密碼加密';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 修復用戶密碼
        $user = DB::table('users')->where('account', 'user')->first();
        if ($user) {
            $this->info('用戶存在，當前密碼長度: ' . strlen($user->password));

            // 更新為正確的 bcrypt 密碼
            $hashedPassword = Hash::make('123');
            DB::table('users')
                ->where('account', 'user')
                ->update(['password' => $hashedPassword]);

            $this->info('密碼已更新為 bcrypt 加密');
            $this->info('新密碼長度: ' . strlen($hashedPassword));
        } else {
            $this->error('用戶不存在');
        }

        return 0;
    }
}
