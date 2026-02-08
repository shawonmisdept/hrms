<?php

namespace App\Http\Controllers;

use App\Models\Employee;
// use App\Models\Attendance; // এই লাইনটি সরানো হয়েছে, কারণ আপনি অ্যাটেনডেন্স মডিউল ব্যবহার করতে চান না
use App\Models\LeaveRequest; // নিশ্চিত করুন যে আপনার LeaveRequest মডেল আছে
use App\Models\Department; // নিশ্চিত করুন যে আপনার Department মডেল আছে
use App\Models\PolicyMaster; // নিশ্চিত করুন যে আপনার PolicyMaster মডেল আছে (যদি ছুটি/উপস্থিতি নিয়মের জন্য ব্যবহৃত হয়)
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * ড্যাশবোর্ডের প্রাথমিক ভিউ লোড করে।
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // সমস্ত ইউনিট নাম সংগ্রহ করুন
        // 'unit_id' এর উপর ভিত্তি করে অনন্য ইউনিট আইডি সংগ্রহ করুন এবং তাদের নাম পেতে unit সম্পর্ক ব্যবহার করুন
        $companies = Employee::distinct('unit_id')
                            ->whereNotNull('unit_id') // নিশ্চিত করুন যে unit_id null নয়
                            ->with('unit') // unit সম্পর্ক লোড করুন
                            ->get()
                            ->pluck('unit.name') // unit সম্পর্ক থেকে নাম পান
                            ->filter()
                            ->unique() // নিশ্চিত করুন যে নামগুলো অনন্য
                            ->values()
                            ->toArray();

        // 'All Units' এর জন্য প্রাথমিক ডেটা লোড করুন
        $employeeStats = $this->getEmployeeStats();
        $attendanceStats = $this->getAttendanceStats(); // এখন এটি ডেমো ডেটা দেবে
        $departments = $this->getDepartmentAttendance(); // এখন এটি ডেমো ডেটা দেবে

        return view('dashboard', compact('companies', 'employeeStats', 'attendanceStats', 'departments'));
    }

    /**
     * AJAX অনুরোধের মাধ্যমে ড্যাশবোর্ডের ডেটা সরবরাহ করে।
     * ইউনিট এবং পেজ নম্বর অনুযায়ী ডেটা ফিল্টার এবং পেজিনেট করে।
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDashboardData(Request $request)
    {
        $unitName = $request->input('unit', 'All Units'); // এখন unitName ব্যবহার করুন
        $page = $request->input('page', 1); // অনুরোধ করা পেজ নম্বর পান
        $perPage = 10; // প্রতি পেজে আইটেমের সংখ্যা

        $employeeStats = $this->getEmployeeStats($unitName);
        $attendanceStats = $this->getAttendanceStats($unitName); // এখন এটি ডেমো ডেটা দেবে

        // নির্দিষ্ট ইউনিটের জন্য সমস্ত ডিপার্টমেন্ট অ্যাটেনডেন্স ডেটা পান
        $allDepartmentsForUnit = $this->getDepartmentAttendance($unitName); // এখন এটি ডেমো ডেটা দেবে

        // কালেকশনকে ম্যানুয়ালি পেজিনেট করুন
        $departmentsCollection = collect($allDepartmentsForUnit);
        $paginatedDepartments = $departmentsCollection->forPage($page, $perPage)->values()->toArray();

        // মোট পেজ সংখ্যা গণনা করুন
        $totalDepartments = $departmentsCollection->count();
        $lastPage = ceil($totalDepartments / $perPage);


        return response()->json([
            'employeeStats' => $employeeStats,
            'attendanceStats' => $attendanceStats,
            'departments' => $paginatedDepartments,
            'pagination' => [
                'current_page' => $page,
                'last_page' => $lastPage,
                'per_page' => $perPage,
                'total' => $totalDepartments,
            ]
        ]);
    }

    /**
     * কর্মচারীর পরিসংখ্যান পান।
     *
     * @param string $unitName ইউনিট নাম (ডিফল্ট 'All Units')
     * @return array
     */
    private function getEmployeeStats($unitName = 'All Units')
    {
        $baseQuery = Employee::query(); // একটি বেস ক্যোয়ারি তৈরি করুন
        if ($unitName !== 'All Units') {
            // ইউনিট নামের উপর ভিত্তি করে ফিল্টার করুন
            $baseQuery->whereHas('unit', function ($q) use ($unitName) {
                $q->where('name', $unitName);
            });
        }

        return [
            'total' => $baseQuery->count(),
            'male' => (clone $baseQuery)->where('gender', 'Male')->count(), // ক্যোয়ারি ক্লোন করে শুধুমাত্র পুরুষদের গণনা করুন
            'female' => (clone $baseQuery)->where('gender', 'Female')->count(), // ক্যোয়ারি ক্লোন করে শুধুমাত্র মহিলাদের গণনা করুন
            'other' => (clone $baseQuery)->where('gender', 'Other')->whereNotIn('gender', ['Male', 'Female'])->count(), // ক্যোয়ারি ক্লোন করে অন্যদের গণনা করুন
            'production_staff' => (clone $baseQuery)->where('staff_category_id', /* Production Staff এর ID */)->count(), // ক্যোয়ারি ক্লোন করে প্রোডাকশন স্টাফ গণনা করুন
            'office_staff' => (clone $baseQuery)->where('staff_category_id', /* Office Staff এর ID */)->count(), // ক্যোয়ারি ক্লোন করে অফিস স্টাফ গণনা করুন
        ];
    }

    /**
     * উপস্থিতির পরিসংখ্যান পান (এখন ডেমো ডেটা)।
     *
     * @param string $unitName ইউনিট নাম (ডিফল্ট 'All Units')
     * @return array
     */
    private function getAttendanceStats($unitName = 'All Units')
    {
        // ডেমো ডেটা
        $demoData = [
            'All Units' => [
                'present' => 750,
                'absent' => 50,
                'late' => 25,
                'on_leave' => 10,
                'early_exit' => 5,
            ],
            'Unit A' => [
                'present' => 450,
                'absent' => 30,
                'late' => 15,
                'on_leave' => 5,
                'early_exit' => 3,
            ],
            'Unit B' => [
                'present' => 200,
                'absent' => 15,
                'late' => 8,
                'on_leave' => 3,
                'early_exit' => 1,
            ],
            'Unit C' => [
                'present' => 100,
                'absent' => 5,
                'late' => 2,
                'on_leave' => 2,
                'early_exit' => 1,
            ],
        ];

        return $demoData[$unitName] ?? $demoData['All Units'];
    }

    /**
     * ডিপার্টমেন্ট অনুযায়ী উপস্থিতির ডেটা পান (এখন ডেমো ডেটা)।
     *
     * @param string $unitName ইউনিট নাম (ডিফল্ট 'All Units')
     * @return array
     */
    private function getDepartmentAttendance($unitName = 'All Units')
    {
        // ডেমো ডেটা
        $demoData = [
            'All Units' => [
                ['name' => 'Cutting', 'present' => 250, 'male' => 180, 'female' => 70, 'absent' => 20],
                ['name' => 'Sewing', 'present' => 300, 'male' => 200, 'female' => 100, 'absent' => 25],
                ['name' => 'Finishing', 'present' => 150, 'male' => 100, 'female' => 50, 'absent' => 5],
                ['name' => 'HR & Admin', 'present' => 30, 'male' => 15, 'female' => 15, 'absent' => 0],
                ['name' => 'Quality Control', 'present' => 20, 'male' => 10, 'female' => 10, 'absent' => 0],
                ['name' => 'Maintenance', 'present' => 10, 'male' => 10, 'female' => 0, 'absent' => 0],
                ['name' => 'Store', 'present' => 15, 'male' => 10, 'female' => 5, 'absent' => 2],
                ['name' => 'Marketing', 'present' => 10, 'male' => 5, 'female' => 5, 'absent' => 1],
                ['name' => 'Accounts', 'present' => 8, 'male' => 4, 'female' => 4, 'absent' => 0],
                ['name' => 'Security', 'present' => 7, 'male' => 7, 'female' => 0, 'absent' => 0],
                ['name' => 'IT', 'present' => 5, 'male' => 3, 'female' => 2, 'absent' => 0],
                ['name' => 'R&D', 'present' => 5, 'male' => 3, 'female' => 2, 'absent' => 0],
            ],
            'Unit A' => [
                ['name' => 'Cutting', 'present' => 100, 'male' => 70, 'female' => 30, 'absent' => 10],
                ['name' => 'Sewing', 'present' => 200, 'male' => 140, 'female' => 60, 'absent' => 15],
                ['name' => 'Finishing', 'present' => 100, 'male' => 80, 'female' => 20, 'absent' => 5],
                ['name' => 'HR & Admin', 'present' => 50, 'male' => 30, 'female' => 20, 'absent' => 0],
            ],
            'Unit B' => [
                ['name' => 'Cutting', 'present' => 80, 'male' => 50, 'female' => 30, 'absent' => 5],
                ['name' => 'Sewing', 'present' => 180, 'male' => 120, 'female' => 60, 'absent' => 5],
                ['name' => 'Finishing', 'present' => 90, 'male' => 60, 'female' => 30, 'absent' => 0],
                ['name' => 'Quality Control', 'present' => 30, 'male' => 20, 'female' => 10, 'absent' => 0],
            ],
            'Unit C' => [
                ['name' => 'Sewing', 'present' => 120, 'male' => 80, 'female' => 40, 'absent' => 10],
                ['name' => 'Finishing', 'present' => 80, 'male' => 50, 'female' => 30, 'absent' => 10],
                ['name' => 'Quality Control', 'present' => 40, 'male' => 20, 'female' => 20, 'absent' => 5],
                ['name' => 'HR & Admin', 'present' => 30, 'male' => 20, 'female' => 10, 'absent' => 5],
            ]
        ];

        return $demoData[$unitName] ?? $demoData['All Units'];
    }
}
