<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Categories') }} {{request()->input('archived') == 'true' ? '(Archived)' : ''}}
        </h2>
    </x-slot>

    
    <div class="overflow-x-auto p-6">
        <x-toast-notification />
    
        <div class="flex justify-end space-x-4">
            @if(request()->input('archived') == 'true')
                <!-- Active -->

                <a href="{{  route('job-category.index') }}" 
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Active Categories
                </a>
            @else
                <!-- Archived -->

                <a href="{{  route('job-category.index' , ['archived' => 'true']) }}" 
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Archived Categories
                </a>
            @endif
            <!-- add job category button -->
        
            <a href="{{ route('job-category.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Add Job Category') }}
            </a>

        </div>    

        
        <!-- job category table -->
         <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Category Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                          <div class="flex space-x-4">
                          @if(request()->input('archived') == 'true')
                               <!-- restore button -->
                                <form action="{{ route('job-category.restore', $category->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-blue-500 hover:text-blue-700">🗂️ Restore</button>
                                </form>
                          @else
                                <!-- edit button -->
                                <a href="{{ route('job-category.edit', $category->id) }}" class="text-blue-500 hover:text-blue-700">✍️ Edit</a> 

                                <!-- delete button -->
                                <form action="{{ route('job-category.destroy', $category->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">🗃️ Archive</button>
                                </form>
                           @endif
                          </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900" colspan="2">No Job Categories Found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        
        <!-- pagination -->
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    </div>
</x-app-layout>
