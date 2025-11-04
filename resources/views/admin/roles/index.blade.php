<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles & Permissions - Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold text-gray-800">Admin Portal</a>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">Dashboard</a>
                    <a href="{{ route('admin.employees') }}" class="text-gray-600 hover:text-gray-900">Employees</a>
                    <a href="{{ route('admin.users') }}" class="text-gray-600 hover:text-gray-900">Users</a>
                    <a href="{{ route('admin.roles') }}" class="text-blue-600 font-semibold">Roles</a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-gray-900">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Roles & Permissions</h2>

                @foreach($roles as $role)
                <div class="mb-8 border border-gray-200 rounded-lg p-6">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $role->name }}</h3>
                            <p class="text-sm text-gray-600">Total Users: <span class="font-semibold">{{ $role->users_count }}</span></p>
                        </div>
                        <span class="px-4 py-2 rounded-full text-sm font-semibold
                            @if($role->name === 'Admin') bg-red-100 text-red-800
                            @elseif($role->name === 'Employee') bg-blue-100 text-blue-800
                            @else bg-green-100 text-green-800
                            @endif
                        ">
                            {{ $role->name }}
                        </span>
                    </div>

                    <!-- Permissions/Capabilities -->
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-700 mb-2">Permissions:</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                            @if($role->name === 'Admin')
                                <div class="flex items-center text-sm text-gray-600"><span class="mr-2">✓</span> Full system access</div>
                                <div class="flex items-center text-sm text-gray-600"><span class="mr-2">✓</span> Create/manage employees</div>
                                <div class="flex items-center text-sm text-gray-600"><span class="mr-2">✓</span> View all users</div>
                                <div class="flex items-center text-sm text-gray-600"><span class="mr-2">✓</span> Manage all products</div>
                                <div class="flex items-center text-sm text-gray-600"><span class="mr-2">✓</span> View all roles & permissions</div>
                            @elseif($role->name === 'Employee')
                                <div class="flex items-center text-sm text-gray-600"><span class="mr-2">✓</span> View customer list</div>
                                <div class="flex items-center text-sm text-gray-600"><span class="mr-2">✓</span> Charge customer credit</div>
                                <div class="flex items-center text-sm text-gray-600"><span class="mr-2">✓</span> Add/Edit/Delete products</div>
                                <div class="flex items-center text-sm text-gray-600"><span class="mr-2">✓</span> Manage product stock</div>
                            @else
                                <div class="flex items-center text-sm text-gray-600"><span class="mr-2">✓</span> View products</div>
                                <div class="flex items-center text-sm text-gray-600"><span class="mr-2">✓</span> Purchase products</div>
                                <div class="flex items-center text-sm text-gray-600"><span class="mr-2">✓</span> View purchase history</div>
                                <div class="flex items-center text-sm text-gray-600"><span class="mr-2">✓</span> Manage credit balance</div>
                            @endif
                        </div>
                    </div>

                    <!-- Users with this role -->
                    @if(isset($roleUsers[$role->name]) && $roleUsers[$role->name]->count() > 0)
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-2">Users with this role:</h4>
                        <div class="bg-gray-50 rounded p-4">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="text-left text-xs text-gray-500 uppercase">
                                        <th class="pb-2">Name</th>
                                        <th class="pb-2">Email</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm">
                                    @foreach($roleUsers[$role->name] as $user)
                                    <tr class="border-t border-gray-200">
                                        <td class="py-2">{{ $user->name }}</td>
                                        <td class="py-2 text-gray-600">{{ $user->email }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @else
                    <p class="text-sm text-gray-500 italic">No users assigned to this role</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
