<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Vacancies') }} {{request()->input('archived') == 'true' ? '(Archived)' : ''}}
        </h2>
    </x-slot>

    
    <div class="overflow-x-auto p-6">
        <x-toast-notification />
    
        <div class="flex justify-end space-x-4">
            @if(request()->input('archived') == 'true')
                <!-- Active -->

                <a href="{{  route('job-vacancy.index') }}" 
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Active Companies
                </a>
            @else
                <!-- Archived -->

                <a href="{{  route('job-vacancy.index' , ['archived' => 'true']) }}" 
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Archived Companies
                </a>
            @endif
            <!-- add job category button -->
        
            <a href="{{ route('job-vacancy.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Add Job Vacancy') }}
            </a>

        </div>    

        
        <!-- job-vacancy table -->
         <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Title</th>
                    @if(auth()->user()->role == 'admin')
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                    @endif
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Location</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Type</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Salary</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobVacancies as $jobVacancy)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @if(request()->input('archived') == 'true')
                                <span class="text-gray-400">{{ $jobVacancy->title }}</span>
                            @else
                                <a class="text-blue-500 hover:text-blue-700 underline" href="{{ route('job-vacancy.show', $jobVacancy->id) }}">{{ $jobVacancy->title }}</a>
                            @endif
                        </td>
                        @if(auth()->user()->role == 'admin')
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $jobVacancy->company->name }}</td>
                        @endif
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $jobVacancy->location }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $jobVacancy->type }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">${{ number_format($jobVacancy->salary , 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                          <div class="flex space-x-4">
                          @if(request()->input('archived') == 'true')
                               <!-- restore button -->
                                <form action="{{ route('job-vacancy.restore', $jobVacancy->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-blue-500 hover:text-blue-700">🗂️ Restore</button>
                                </form>
                          @else
                                <!-- edit button -->
                                <a href="{{ route('job-vacancy.edit', $jobVacancy->id) }}" class="text-blue-500 hover:text-blue-700">✍️ Edit</a> 

                                <!-- Archive button -->
                                <form action="{{ route('job-vacancy.destroy', $jobVacancy->id) }}" method="POST">
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
                        <td class="px-6 py-4 text-sm text-gray-900" colspan="5">No job vacancies found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        
        <!-- pagination -->
        <div class="mt-4">
            {{ $jobVacancies->links() }}
        </div>
    </div>
</x-app-layout>
