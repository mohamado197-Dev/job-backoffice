<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __($jobApplication->user->name) . " | Applied To | " . $jobApplication->jobVacancy->title }}
        </h2>   
    </x-slot>
    <div class="overflow-x-auto p-6">
        <x-toast-notification />
        <!--Back button-->
        <a href="{{ route('job-application.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 mb-2">Back</a>
        <div class="bg-white p-6 mx-auto w-full shadow rounded-lg">
            <!-- Application details -->
            <div class="p-6 text-gray-900">
                <div class="text-2xl font-semibold mb-4">Application Details</div>

                <div class="grid grid-cols-2 gap-4">
                    <!-- applicant details -->
                    <div class="col-span-2">
                        <label class="text-sm font-medium text-gray-600">Applicant</label>
                        <div class="text-lg">{{ $jobApplication->user->name }}</div>
                    </div>
                    <div class="col-span-2">
                        <label class="text-sm font-medium text-gray-600">Company</label>
                        <div class="text-lg">{{ $jobApplication->jobVacancy->company->name }}</div>
                    </div>
                    
                    <div>
                        <label class="text-sm font-medium text-gray-600">Job Vacancy</label>
                        <div class="text-lg">{{ $jobApplication->jobVacancy->title }}</div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600 block">Application status</label>
                        <div class="mt-1">
                            @if($jobApplication->status == 'accepted')
                                <span class="px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 capitalize">{{ $jobApplication->status }}</span>
                            @elseif($jobApplication->status == 'rejected')
                                <span class="px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800 capitalize">{{ $jobApplication->status }}</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 capitalize">{{ $jobApplication->status }}</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-600">Resume</label>
                        <div class="text-lg">{{ $jobApplication->resume->fileUrl }}</div>
                    </div>
                </div>
            </div>
            <!-- Edit and archive buttons -->
            <div class="flex justify-end space-x-4 ">
                <a href="{{ route('job-application.edit', ['job_application' => $jobApplication->id , 'redirectToList' => 'false']) }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">✍️ Edit</a> 
                <form action="{{ route('job-application.destroy', $jobApplication->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">🗃️ Archive</button>
                </form>
            </div>
            
            <!--Tabs navigation -->
            <div class="m-4">
                <ul class="flex space-x-4" >
                    <li class="text-gray-800 py-2 px-4 font-semibold">
                        <a href="{{ route('job-application.show' , ['job_application' =>$jobApplication->id, 'tab' => 'resume']) }}" 
                        class="{{ request('tab') == 'resume' || request('tab') == '' ? 'border-b-2 border-blue-500' : '' }}">Resume</a>
                    </li>
                    <li class="text-gray-800 py-2 px-4 font-semibold">
                        <a href="{{ route('job-application.show' , ['job_application' =>$jobApplication->id, 'tab' => 'ai_feedback']) }}" 
                        class="{{ request('tab') == 'ai_feedback'? 'border-b-2 border-blue-500' : '' }}">Ai FeedBack</a>
                    </li>
                </ul>
            </div>
            
            <!-- tab content -->
            <div>

                <!-- resume tab content -->
                <div id="resume" class="{{ request('tab') == 'resume' || request('tab') == '' ? 'block' : 'hidden' }}">
                  <table class="min-w-full  rounded-lg shadow bg-gray-50">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Summary</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Skills</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Experience</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Education</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @if($jobApplication->resume)
                                <tr>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $jobApplication->resume->summary }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $jobApplication->resume->skills }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $jobApplication->resume->experience }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $jobApplication->resume->education }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-sm text-gray-900">No resume found</td>
                                </tr>
                            @endif
                        </tbody>

                    </table>
                </div>

                <!-- ai_feedback tab content -->
                <div id="ai_feedback" class="{{ request('tab') == 'ai_feedback' ? 'block' : 'hidden' }}">
                  <table class="min-w-full  rounded-lg shadow bg-gray-50">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Ai Score</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-600">Feedback</th>
                                
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @if($jobApplication->aiGeneratedScore != null)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $jobApplication->aiGeneratedScore }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $jobApplication->aiGeneratedFeedback }}</td>
                                
                            </tr>
                            @else
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-sm text-gray-900">No AI Feedback found</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    
</x-app-layout>
