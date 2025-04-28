<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class MySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'slug' => Str::random(10),
                'name' => 'Rech',
                'login' => 'admin',
                'email' => 'karol.group.time@gmail.com',
                'password' => Hash::make('12345678'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'slug' => Str::random(10),
                'name' => 'Aly',
                'login' => 'teacher',
                'email' => 'teacher@gmail.com',
                'password' => Hash::make('12345678'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
        DB::table('degres')->insert([
            ['name' => 'mugallym'],
            ['name' => 'uly mugallym'],
            ['name' => 'müdir'],
            ['name' => 'zam-dekan'],
            ['name' => 'dekan'],
            ['name' => 'dosent'],
            ['name' => 'kandidat'],
            ['name' => 'professor'],
            ['name' => 'doktor'],
            ['name' => 'prorektor'],
            ['name' => 'rektor'],
        ]);
        DB::table('nationalities')->insert([
            ['name' => 'türkmen'],
            ['name' => 'rus'],
            ['name' => 'özbek'],
            ['name' => 'tatar'],
            ['name' => 'gazak'],
            ['name' => 'ermeni'],
            ['name' => 'azerbeýjan'],
        ]);
        DB::table('permissions')->insert([
            ['name' => 'dashboard'],
            ['name' => 'serviceManInfo'],
            ['name' => 'teacher_show'],
            ['name' => 'teacher_change'],
            ['name' => 'student_show'],
            ['name' => 'student_change'],
            ['name' => 'all_journal'],
            ['name' => 'my_journal'],
            ['name' => 'allJournalChange'],
            ['name' => 'faculties_show'],
            ['name' => 'users_show'],
            ['name' => 'users_change'],
            ['name' => 'logs_show'],
            ['name' => 'settings_show'],
            ['name' => 'settings_change'],
            ['name' => 'assessment_change'],
        ]);

        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'mugallym'],
        ]);

        DB::table('role_permissions')->insert([
            ['role_id' => 1, 'permission_id' => 1],
            ['role_id' => 1, 'permission_id' => 2],
            ['role_id' => 1, 'permission_id' => 3],
            ['role_id' => 1, 'permission_id' => 4],
            ['role_id' => 1, 'permission_id' => 5],
            ['role_id' => 1, 'permission_id' => 6],
            ['role_id' => 1, 'permission_id' => 7],
            ['role_id' => 1, 'permission_id' => 9],
            ['role_id' => 1, 'permission_id' => 10],
            ['role_id' => 1, 'permission_id' => 11],
            ['role_id' => 1, 'permission_id' => 12],
            ['role_id' => 1, 'permission_id' => 13],
            ['role_id' => 1, 'permission_id' => 14],
            ['role_id' => 1, 'permission_id' => 16],
            ['role_id' => 2, 'permission_id' => 8],
            ['role_id' => 2, 'permission_id' => 2],
        ]);

        DB::table('user_roles')->insert([
            ['user_id' => 1, 'role_id' => 1],
            ['user_id' => 2, 'role_id' => 2],
        ]);
        DB::table('subjects')->insert([
            ['name' =>'Fizika', 'type' => 'Ylmy',],
            ['name' =>'Algebra', 'type' => 'Ylmy',],
        ]);
        DB::table('faculties')->insert([
            [
                'slug' => Str::random(10),
                'name' => 'Ykdysadyýet',
            ],
            [
                'slug' => Str::random(10),
                'name' => 'Maliýe',
            ],
        ]);
        DB::table('kathedras')->insert([
            [
                'slug' => Str::random(10),
                'name' => 'Kompýuter tehnologiýalary',
                'faculty_id' => 1,
            ],
            [
                'slug' => Str::random(10),
                'name' => 'Maglumaty goramak',
                'faculty_id' => 2,
            ],
        ]);
        DB::table('assessments')->insert([
            [
                'value' => '2',
            ],
            [
                'value' => '3',
            ],
            [
                'value' => '4',
            ],
            [
                'value' => '5',
            ],
            [
                'value' => 'TK',
            ],
            [
                'value' => 'LN',
            ],
            [
                'value' => 'HA',
            ],
            [
                'value' => 'IS',
            ],
            [
                'value' => 'IT',
            ],
            [
                'value' => 'MÇ',
            ],
            [
                'value' => 'DÝ',
            ],
            [
                'value' => 'SÇ',
            ],
            [
                'value' => 'HP',
            ],
            [
                'value' => 'BH',
            ],
            [
                'value' => 'GM',
            ],
        ]);
        DB::table('groups')->insert([
            [

                'slug' => Str::random(10),
                'name' => 'ADU',
                'number' => '18/1-1',
                'kathedra_id' => 1,
            ],
            [

                'slug' => Str::random(10),
                'name' => 'Maglumat howpsuzlyk',
                'number' => '18/1-2',
                'kathedra_id' => 1,
            ],
            [

                'slug' => Str::random(10),
                'name' => 'Maliýa',
                'number' => '17/1-2',
                'kathedra_id' => 2,
            ],
        ]);
        DB::table('courses')->insert([
            ['number' => 1],
            ['number' => 2],
            ['number' => 3],
            ['number' => 4],
            ['number' => 5],
        ]);
        DB::table('semesters')->insert([
            [
                'number' => 1,
                'course_id' => 1,
            ],
            [
                'number' => 2,
                'course_id' => 1,
            ],
            [
                'number' => 3,
                'course_id' => 2,
            ],
            [
                'number' => 4,
                'course_id' => 2,
            ],
            [
                'number' => 5,
                'course_id' => 3,
            ],
            [
                'number' => 6,
                'course_id' => 3,
            ],
            [
                'number' => 7,
                'course_id' => 4,
            ],
            [
                'number' => 8,
                'course_id' => 4,
            ],
            [
                'number' => 9,
                'course_id' => 5,
            ],
            [
                'number' => 10,
                'course_id' => 5,
            ],
        ]);

    }
}
