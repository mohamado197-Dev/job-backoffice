<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Edit Job Application Status') }}
    </h2>
  </x-slot>

  <div class="over-flow-x-auto p-6">
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <form action="{{ route('job-application.update', ['job_application'=> $jobApplication->id , 'redirectToList' => request()->redirectToList]) }}" method="POST">
          @csrf
          @method('PUT')
          <!-- Job Application Details -->
          <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
            <h3 class="text-lg font-bold">Job Application Details</h3>
            <p class="text-sm mb-2 text-gray-500">Enter job application details</p>
            
            <!-- Applicant Name (Read-only) -->
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-600">{{ __('Applicant Name') }}</label>
              <div class="mt-1 text-base font-semibold text-gray-900">{{ $jobApplication->user->name ?? '-' }}</div>
            </div>

            <!-- Job Vacancy (Read-only) -->
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-600">{{ __('Job Vacancy') }}</label>
              <div class="mt-1 text-base font-semibold text-gray-900">{{ $jobApplication->jobVacancy->title ?? '-' }}</div>
            </div>

            <!-- Company (Read-only) -->
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-600">{{ __('Company') }}</label>
              <div class="mt-1 text-base font-semibold text-gray-900">{{ $jobApplication->jobVacancy->company->name ?? '-' }}</div>
            </div>
            <!-- Ai Generated FeedBack (Read-only) -->
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-600">{{ __('Ai Generated FeedBack') }}</label>
              <div class="mt-1 text-base font-semibold text-gray-900">{{ $jobApplication->aiGeneratedFeedback ?? '-' }}</div>
            </div>
            <!-- Ai Generated Score (Read-only) -->
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-600">{{ __('Ai Generated Score') }}</label>
              <div class="mt-1 text-base font-semibold text-gray-900">{{ $jobApplication->aiGeneratedScore ?? '-' }}</div>
            </div>

            <!-- Status Dropdown -->
            <div class="mb-4">
              <div class="flex items-center justify-between mb-1">
                <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                <div>
                  <span class="text-xs text-gray-500 mr-1">{{ __('Current:') }}</span>
                  @if($jobApplication->status == 'accepted')
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800 capitalize">{{ $jobApplication->status }}</span>
                  @elseif($jobApplication->status == 'rejected')
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-800 capitalize">{{ $jobApplication->status }}</span>
                  @else
                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 capitalize">{{ $jobApplication->status }}</span>
                  @endif
                </div>
              </div>
              <select name="status" id="status" 
                class="{{ $errors->has('status') ? 'outline-red-500' : 'outline-gray-300' }} outline outline-1 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="pending" {{ old('status', $jobApplication->status) == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                <option value="accepted" {{ old('status', $jobApplication->status) == 'accepted' ? 'selected' : '' }}>{{ __('Accepted') }}</option>
                <option value="rejected" {{ old('status', $jobApplication->status) == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
              </select>
              @error('status')
                <p class="text-red-500 text-xs italic" role="alert">{{ $message }}</p>
              @enderror
            </div>

          </div>

            <div class="flex justify-end space-x-4">
            <!-- cancel button -->  
              <a href="{{ request()->query('redirectToList') == 'false' ? route('job-application.show', $jobApplication->id) : route('job-application.index') }}" class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                {{ __('Cancel') }}
              </a>
            
            <!-- submit button -->
              <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                {{ __('Update Status') }}
              </button>
            </div>

         
        </form>
    </div>
  </div>

</x-app-layout>