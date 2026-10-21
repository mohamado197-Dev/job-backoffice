<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }} {{request()->input('archived') == 'true' ? '(Archived)' : ''}}
        </h2>
    </x-slot>

    
    <div class="overflow-x-auto p-6">
        <x-toast-notification />
    
        <div class="flex justify-end space-x-4">
            @if(request()->input('archived') == 'true')
                <!-- Active -->

                <a href="{{  route('user.index') }}" 
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Active Users
                </a>
            @else
                <!-- Archived -->

                <a href="{{  route('user.index' , ['archived' => 'true']) }}" 
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Archived Users
                </a>
            @endif
            

        </div>    

        
        <!-- Users table -->
         <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Role</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-sm text-gray-900">
                                <span class="text-gray-400">{{ $user->name }}</span>
                            
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->role }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                          <div class="flex space-x-4">
                          @if(request()->input('archived') == 'true')
                               <!-- restore button -->
                                <form action="{{ route('user.restore', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-blue-500 hover:text-blue-700">🗂️ Restore</button>
                                </form>
                          @else
                            @if($user->role != 'admin')
                            
                                <!-- edit button -->
                                <a href="{{ route('user.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700">✍️ Edit</a> 

                                <!-- Archive button -->
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">🗃️ Archive</button>
                            @endif      </form>
                          @endif
                          </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900" colspan="5">No users found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        
        <!-- pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
