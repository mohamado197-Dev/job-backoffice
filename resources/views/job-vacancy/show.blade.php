<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($jobVacancy->title) }}
        </h2>   
    </x-slot>
    <div class="overflow-x-auto p-6">
        <x-toast-notification />
        <!--Back button-->
        <a href="{{ route('job-vacancy.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mb-2">Back</a>
        <div class="bg-white p-6 mx-auto w-full shadow rounded-lg">
            <!-- job details -->
            <div class="p-6 text-gray-900">
                <div class="text-2xl font-semibold mb-4">Job Details</div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- job vacany details -->
                    <div class="col-span-2">
                        <label class="text-sm font-medium text-gray-600">Title</label>
                        <div class="text-lg">{{ $jobVacancy->title }}</div>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Company Name</label>
                        <div class="text-lg">{{ $jobVacancy->company->name }}</div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Address</label>
                        <div class="text-lg">{{ $jobVacancy->company->address }}</div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Website</label>
                        <div class="text-lg"><a class="text-blue-500 hover:text-blue-700 underline" href="{{ $jobVacancy->company->website }}"  target="_blank">{{ $jobVacancy->company->website }}</a></div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Industry</label>
                        <div class="text-lg">{{ $jobVacancy->company->industry }}</div>
                    </div>
                </div>
            </div>
            <!-- Edit and archive buttons -->
            <div class="flex justify-end space-x-4 ">
                <a href="{{ route('job-vacancy.edit', ['job_vacancy' => $jobVacancy->id , 'redirectToList' => 'false']) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">✍️ Edit</a> 
                <form action="{{ route('job-vacancy.destroy', $jobVacancy->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">🗃️ Archive</button>
                </form>
            </div>
            
            <!--Tabs navigation -->
            <div class="m-4">
                <ul class="flex space-x-4" >
                    <li class="text-gray-800 py-2 px-4 font-semibold">
                        <a href="{{ route('job-vacancy.show' , ['job_vacancy' =>$jobVacancy->id, 'tab' => 'applications']) }}" 
                        class="{{ request('tab') == 'applications' || request('tab') == '' ? 'border-b-2 border-blue-500' : '' }}">Applications</a>
                    </li>
                </ul>
            </div>
            
            <!-- tab content -->
            <div>

                <!-- applications tab content -->
                <div id="applications" class="{{ request('tab') == 'applications' || request('tab') == '' ? 'block' : 'hidden' }}">
                  <table class="min-w-full  rounded-lg shadow bg-gray-50">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Applicant Name</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Job title</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Status</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($jobVacancy->jobApplications as $application)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $application->user->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $application->jobVacancy->title }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        @if($application->status == 'accepted')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 capitalize">{{ $application->status }}</span>
                                        @elseif($application->status == 'rejected')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 capitalize">{{ $application->status }}</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 capitalize">{{ $application->status }}</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                      <div class="flex space-x-4">
                                        <a href="{{ route('job-application.show', $application->id) }}" class="text-blue-500 hover:text-blue-700">👁️ View</a>
                                      </div>
                                    </td>

                                    @empty
                                        <td colspan="4" class="px-6 py-4 text-sm text-gray-900">No applications found</td>
                                    </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    
</x-app-layout>
