<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Applications') }} {{request()->input('archived') == 'true' ? '(Archived)' : ''}}
        </h2>
    </x-slot>

    
    <div class="overflow-x-auto p-6">
        <x-toast-notification />
    
        <div class="flex justify-end space-x-4">
            @if(request()->input('archived') == 'true')
                <!-- Active -->

                <a href="{{  route('job-application.index') }}" 
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Active Applications
                </a>
            @else
                <!-- Archived -->

                <a href="{{  route('job-application.index' , ['archived' => 'true']) }}" 
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Archived Applications
                </a>
            @endif
            
        </div>    

        
        <!-- job-application table -->
         <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow mt-4 bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Applicant Name</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Position (Job Vacancy)</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                    @if(auth()->user()->role == 'admin') 
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Company</th>
                    @endif
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jobApplications as $jobApplication)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-sm text-gray-900">
                            @if(request()->input('archived') == 'true')
                                <span class="text-gray-400">{{ $jobApplication->user->name }}</span>
                            @else
                                <a class="text-blue-500 hover:text-blue-700 underline" href="{{ route('job-application.show', $jobApplication->id) }}">{{ $jobApplication->user->name }}</a>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $jobApplication->jobVacancy->title }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if($jobApplication->status == 'accepted')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 capitalize">{{ $jobApplication->status }}</span>
                            @elseif($jobApplication->status == 'rejected')
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 capitalize">{{ $jobApplication->status }}</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 capitalize">{{ $jobApplication->status }}</span>
                            @endif
                        </td>
                        @if(auth()->user()->role == 'admin')
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $jobApplication->jobVacancy->company->name }}</td>
                        @endif
                        <td class="px-6 py-4 text-sm text-gray-900">
                          <div class="flex space-x-4">
                          @if(request()->input('archived') == 'true')
                               <!-- restore button -->
                                <form action="{{ route('job-application.restore', $jobApplication->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-blue-500 hover:text-blue-700">🗂️ Restore</button>
                                </form>
                          @else
                                <!-- edit button -->
                                <a href="{{ route('job-application.edit', $jobApplication->id) }}" class="text-blue-500 hover:text-blue-700">✍️ Edit</a> 

                                <!-- Archive button -->
                                <form action="{{ route('job-application.destroy', $jobApplication->id) }}" method="POST">
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
            {{ $jobApplications->links() }}
        </div>
    </div>
</x-app-layout>
