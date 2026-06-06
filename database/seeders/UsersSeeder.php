<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        $adminRoleId = cache()->get('role_admin_id');
        $userRoleId  = cache()->get('role_user_id');

        $users = [
            [
                'Ma_nguoi_dung'    => Str::uuid()->toString(),
                'Ho_ten'           => 'Quản Trị Viên',
                'Email'            => 'admin@petjam.vn',
                'So_dien_thoai'    => '0901234567',
                'Mat_khau_hash'    => Hash::make('Admin@123456'),
                'Loai_tai_khoan'   => 'ca_nhan',
                'Trang_thai'       => 'hoat_dong',
                'Nguon_dang_ky'    => 'nhan_vien_tao',
                'Email_da_xac_thuc' => true,
                'role'             => 'admin',
            ],
            [
                'Ma_nguoi_dung'    => Str::uuid()->toString(),
                'Ho_ten'           => 'Nguyễn Thị Lan',
                'Email'            => 'nguyen.thi.lan@gmail.com',
                'So_dien_thoai'    => '0912345678',
                'Mat_khau_hash'    => Hash::make('User@123456'),
                'Ngay_sinh'        => '1995-03-15',
                'Loai_tai_khoan'   => 'ca_nhan',
                'Trang_thai'       => 'hoat_dong',
                'Nguon_dang_ky'    => 'web',
                'Email_da_xac_thuc' => true,
                'role'             => 'user',
            ],
            [
                'Ma_nguoi_dung'    => Str::uuid()->toString(),
                'Ho_ten'           => 'Trần Văn Minh',
                'Email'            => 'tran.van.minh@gmail.com',
                'So_dien_thoai'    => '0923456789',
                'Mat_khau_hash'    => Hash::make('User@123456'),
                'Ngay_sinh'        => '1990-07-22',
                'Loai_tai_khoan'   => 'ca_nhan',
                'Trang_thai'       => 'hoat_dong',
                'Nguon_dang_ky'    => 'web',
                'Email_da_xac_thuc' => true,
                'role'             => 'user',
            ],
            [
                'Ma_nguoi_dung'    => Str::uuid()->toString(),
                'Ho_ten'           => 'Lê Phương Anh',
                'Email'            => 'le.phuong.anh@gmail.com',
                'So_dien_thoai'    => '0934567890',
                'Mat_khau_hash'    => Hash::make('User@123456'),
                'Ngay_sinh'        => '1998-11-05',
                'Loai_tai_khoan'   => 'ca_nhan',
                'Trang_thai'       => 'hoat_dong',
                'Nguon_dang_ky'    => 'web',
                'Email_da_xac_thuc' => true,
                'role'             => 'user',
            ],
            [
                'Ma_nguoi_dung'    => Str::uuid()->toString(),
                'Ho_ten'           => 'Phạm Đức Long',
                'Email'            => 'pham.duc.long@gmail.com',
                'So_dien_thoai'    => '0945678901',
                'Mat_khau_hash'    => Hash::make('User@123456'),
                'Ngay_sinh'        => '1993-01-30',
                'Loai_tai_khoan'   => 'ca_nhan',
                'Trang_thai'       => 'hoat_dong',
                'Nguon_dang_ky'    => 'web',
                'Email_da_xac_thuc' => false,
                'role'             => 'user',
            ],
            [
                'Ma_nguoi_dung'    => Str::uuid()->toString(),
                'Ho_ten'           => 'Hoàng Thị Mai',
                'Email'            => 'hoang.thi.mai@gmail.com',
                'So_dien_thoai'    => '0956789012',
                'Mat_khau_hash'    => Hash::make('User@123456'),
                'Ngay_sinh'        => '2000-06-18',
                'Loai_tai_khoan'   => 'ca_nhan',
                'Trang_thai'       => 'hoat_dong',
                'Nguon_dang_ky'    => 'web',
                'Email_da_xac_thuc' => true,
                'role'             => 'user',
            ],
        ];

        $userRoleMap = [];

        foreach ($users as $userData) {
            $role = $userData['role'];
            unset($userData['role']);

            DB::table('users')->insert($userData);

            // Gán vai trò qua Spatie
            $userModel = \App\Models\User::find($userData['Ma_nguoi_dung']);
            if ($role === 'admin') {
                $userModel->assignRole('admin');
            } else {
                $userModel->assignRole('customer');
            }

            $userRoleMap[$role][] = $userData['Ma_nguoi_dung'];
        }

        // Cache admin ID và user IDs để seeders khác dùng
        cache()->put('admin_id', $userRoleMap['admin'][0], 600);
        cache()->put('user_ids', $userRoleMap['user'], 600);

        $this->command->info('✅ UsersSeeder hoàn thành: 1 admin + 5 users.');
    }
}
