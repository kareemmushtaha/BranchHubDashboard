<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserWallet;
use App\Models\Session;
use App\Models\SessionPayment;
use App\Models\Drink;
use App\Models\SessionDrink;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إضافة مستخدمين تجريبيين إضافيين
        $users = [
            [
                'name' => 'أحمد محمد',
                'email' => 'ahmed@example.com',
                'password' => bcrypt('password'),
                'user_type' => 'hourly',
                'phone' => '123456789',
                'status' => 'active'
            ],
            [
                'name' => 'فاطمة علي',
                'email' => 'fatima@example.com',
                'password' => bcrypt('password'),
                'user_type' => 'subscription',
                'phone' => '987654321',
                'status' => 'active'
            ],

            [
                'name' => 'نور الدين',
                'email' => 'nour@example.com',
                'password' => bcrypt('password'),
                'user_type' => 'hourly',
                'phone' => '111222333',
                'status' => 'active'
            ],
            [
                'name' => 'سارة أحمد',
                'email' => 'sara@example.com',
                'password' => bcrypt('password'),
                'user_type' => 'subscription',
                'phone' => '444555666',
                'status' => 'active'
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);
            
            // إنشاء محفظة رقمية لكل مستخدم
            UserWallet::create([
                'user_id' => $user->id,
                'balance' => rand(10, 100)
            ]);
        }

        // الحصول على جميع المستخدمين والمشروبات
        $allUsers = User::all();
        $drinks = Drink::all();

        // إنشاء جلسات تجريبية على مدار الشهرين الماضيين
        for ($day = 0; $day < 60; $day++) {
            $date = Carbon::now()->subDays($day);
            
            // تخطي بعض الأيام عشوائياً
            if (rand(1, 10) <= 2) continue;
            
            // عدد الجلسات في اليوم (1-8 جلسات)
            $sessionsCount = rand(1, 8);
            
            for ($i = 0; $i < $sessionsCount; $i++) {
                $user = $allUsers->random();
                
                // تحديد فئة الجلسة بناءً على نوع المستخدم
                $category = $user->user_type;
                if ($user->user_type === 'hourly' && rand(1, 5) === 1) {
                    $category = 'overtime'; // 20% من الجلسات الساعية تكون إضافية
                }
                
                // تحديد أوقات الجلسة
                $startHour = rand(8, 22);
                $startTime = $date->copy()->setHour($startHour)->setMinute(rand(0, 59));
                $duration = rand(30, 300); // من 30 دقيقة إلى 5 ساعات
                $endTime = $startTime->copy()->addMinutes($duration);
                
                // إنشاء الجلسة
                $session = Session::create([
                    'start_at' => $startTime,
                    'end_at' => $endTime,
                    'session_status' => 'completed',
                    'session_category' => $category,
                    'user_id' => $user->id,
                    'note' => rand(1, 10) <= 3 ? 'جلسة تجريبية - ' . fake()->sentence(3) : null,
                ]);

                // حساب تكلفة الجلسة
                $sessionCost = 0;
                if ($category === 'hourly') {
                    $sessionCost = ($duration / 60) * 5.00; // $5 per hour
                } elseif ($category === 'overtime') {
                    $rate = $startHour >= 18 || $startHour <= 6 ? 7.00 : 5.00;
                    $sessionCost = ($duration / 60) * $rate;
                }
                
                // إضافة مشروبات عشوائية للجلسة
                $drinksCount = rand(0, 4);
                $drinksCost = 0;
                
                for ($j = 0; $j < $drinksCount; $j++) {
                    $drink = $drinks->random();
                    SessionDrink::create([
                        'session_id' => $session->id,
                        'drink_id' => $drink->id,
                        'price' => $drink->price,
                        'status' => 'served',
                        'note' => rand(1, 10) <= 2 ? fake()->sentence(2) : null,
                    ]);
                    $drinksCost += $drink->price;
                }

                $totalCost = $sessionCost + $drinksCost;

                // إنشاء سجل الدفع
                $paymentStatus = 'paid';
                $amountBank = 0;
                $amountCash = 0;
                $remainingAmount = 0;

                // محاكاة حالات دفع مختلفة
                $paymentType = rand(1, 10);
                if ($paymentType <= 7) { // 70% مدفوعة بالكامل
                    $paymentStatus = 'paid';
                    if (rand(1, 2) === 1) {
                        $amountCash = $totalCost;
                    } else {
                        $amountBank = $totalCost;
                    }
                } elseif ($paymentType <= 9) { // 20% مدفوعة جزئياً
                    $paymentStatus = 'partial';
                    $paidAmount = $totalCost * (rand(30, 80) / 100);
                    $amountCash = $paidAmount;
                    $remainingAmount = $totalCost - $paidAmount;
                } else { // 10% معلقة
                    $paymentStatus = 'pending';
                    $remainingAmount = $totalCost;
                }

                SessionPayment::create([
                    'session_id' => $session->id,
                    'total_price' => $totalCost,
                    'amount_bank' => $amountBank,
                    'amount_cash' => $amountCash,
                    'payment_status' => $paymentStatus,
                    'remaining_amount' => $remainingAmount,
                    'created_at' => $endTime->addMinutes(rand(1, 30)),
                ]);
            }
        }

        // إنشاء بعض الجلسات النشطة الحالية
        for ($i = 0; $i < 3; $i++) {
            $user = $allUsers->random();
            
            $startTime = Carbon::now()->subHours(rand(1, 6));
            
            $session = Session::create([
                'start_at' => $startTime,
                'end_at' => null,
                'session_status' => 'active',
                'session_category' => $user->user_type === 'hourly' ? 'hourly' : $user->user_type,
                'user_id' => $user->id,
                'note' => 'جلسة نشطة حالياً',
            ]);

            // إنشاء سجل دفع فارغ للجلسات النشطة
            SessionPayment::create([
                'session_id' => $session->id,
                'total_price' => 0,
                'payment_status' => 'pending',
            ]);

            // إضافة بعض المشروبات للجلسات النشطة
            if (rand(1, 2) === 1) {
                $drink = $drinks->random();
                SessionDrink::create([
                    'session_id' => $session->id,
                    'drink_id' => $drink->id,
                    'price' => $drink->price,
                    'status' => 'ordered',
                ]);
            }
        }

        echo "تم إنشاء البيانات التجريبية بنجاح!\n";
        echo "- " . Session::count() . " جلسة\n";
        echo "- " . SessionPayment::count() . " سجل دفع\n";
        echo "- " . SessionDrink::count() . " طلب مشروب\n";
        echo "- " . User::count() . " مستخدم\n";
    }
}
