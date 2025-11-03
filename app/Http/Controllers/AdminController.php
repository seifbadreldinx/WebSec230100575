<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:Admin']);
    }

    /**
     * Display admin dashboard.
     */
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_customers' => User::whereHas('role', function($q) {
                $q->where('name', 'Customer');
            })->count(),
            'total_employees' => User::whereHas('role', function($q) {
                $q->where('name', 'Employee');
            })->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }

    /**
     * Display a listing of employees.
     */
    public function employees()
    {
        $employeeRole = Role::where('name', 'Employee')->first();
        $employees = User::where('role_id', $employeeRole->id)->paginate(15);

        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     */
    public function createEmployee()
    {
        return view('admin.employees.create');
    }

    /**
     * Store a newly created employee in storage.
     */
    public function storeEmployee(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get the Employee role
        $employeeRole = Role::where('name', 'Employee')->first();

        // Create the employee
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $employeeRole ? $employeeRole->id : null,
        ]);

        return redirect()->route('admin.employees')
            ->with('success', 'Employee created successfully!');
    }

    /**
     * Show the form for editing an employee.
     */
    public function editEmployee(User $employee)
    {
        // Ensure the user is an employee
        if (!$employee->isEmployee()) {
            abort(404);
        }

        return view('admin.employees.edit', compact('employee'));
    }

    /**
     * Update the specified employee in storage.
     */
    public function updateEmployee(Request $request, User $employee)
    {
        // Ensure the user is an employee
        if (!$employee->isEmployee()) {
            abort(404);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $employee->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $employee->name = $request->name;
        $employee->email = $request->email;
        
        if ($request->filled('password')) {
            $employee->password = Hash::make($request->password);
        }
        
        $employee->save();

        return redirect()->route('admin.employees')
            ->with('success', 'Employee updated successfully!');
    }

    /**
     * Remove the specified employee from storage.
     */
    public function destroyEmployee(User $employee)
    {
        // Ensure the user is an employee
        if (!$employee->isEmployee()) {
            abort(404);
        }

        $employee->delete();

        return redirect()->route('admin.employees')
            ->with('success', 'Employee deleted successfully!');
    }

    /**
     * Display a listing of all users.
     */
    public function users()
    {
        $users = User::with('role')->paginate(15);
        return view('admin.users.index', compact('users'));
    }
}
