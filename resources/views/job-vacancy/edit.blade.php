<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Edit Job Vacancy') }}
    </h2>
  </x-slot>

  <div class="over-flow-x-auto p-6">
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-lg shadow-md">
        <form action="{{ route('job-vacancy.update', ['job_vacancy'=> $jobVacancy->id , 'redirectToList' => request()->redirectToList]) }}" method="POST">
          @csrf
          @method('PUT')
          <!-- Job Vacancy Details -->
          <div class="mb-4 p-6 bg-gray-50 border border-gray-100 rounded-lg shadow-sm">
            <h3 class="text-lg font-bold">Job Vacancy Details</h3>
            <p class="text-sm mb-2 text-gray-500">Enter your job vacancy details</p>
            
            <div class="mb-4">
              <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Job Title') }}</label>
              <input type="text" value="{{ old('title' , $jobVacancy->title) }}" name="title" id="title" 
              class=" {{ $errors->has('title') ? 'outline-red-500' : 'outline-gray-300' }}  outline outline-1  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
              @error('title')
                <p class="text-red-500 text-xs italic" role="alert">{{ $message }}</p>
              @enderror
            </div>
            
            <div class="mb-4">
              <label for="location" class="block text-sm font-medium text-gray-700">{{ __('Location') }}</label>
              <input type="text" value="{{ old('location', $jobVacancy->location) }}" name="location" id="location" 
              class=" {{ $errors->has('location') ? 'outline-red-500' : 'outline-gray-300' }}  outline outline-1  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
              @error('location')
                <p class="text-red-500 text-xs italic" role="alert">{{ $message }}</p>
              @enderror
            </div>
            
            <div class="mb-4">
              <label for="salary" class="block text-sm font-medium text-gray-700">{{ __('Expected Salary (USD)') }}</label>
              <input type="number" value="{{ old('salary', $jobVacancy->salary) }}" name="salary" id="salary" 
              class=" {{ $errors->has('salary') ? 'outline-red-500' : 'outline-gray-300' }}  outline outline-1  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
              @error('salary')
                <p class="text-red-500 text-xs italic" role="alert">{{ $message }}</p>
              @enderror
            </div>

            <div class="mb-4">
              <label for="type" class="block text-sm font-medium text-gray-700">{{ __('Type') }}</label>
              <select name="type" id="type" class=" {{ $errors->has('type') ? 'outline-red-500' : 'outline-gray-300' }}  outline outline-1  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                <option value="full-time" {{ old('type', $jobVacancy->type) == 'full-time' ? 'selected' : '' }}>Full Time</option>
                <option value="contract" {{ old('type', $jobVacancy->type) == 'contract' ? 'selected' : '' }}>Contract</option>
                <option value="hybrid" {{ old('type', $jobVacancy->type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                <option value="remote" {{ old('type', $jobVacancy->type) == 'remote' ? 'selected' : '' }}>Remote</option>
              </select>
              @error('type')
                <p class="text-red-500 text-xs italic" role="alert">{{ $message }}</p>
              @enderror
            </div>


            <!-- company select dropdown-->
            <div class="mb-4">
              <label for="company_id" class="block text-sm font-medium text-gray-700">{{ __('Company') }}</label>
              <select name="company_id" id="company_id" class=" {{ $errors->has('company_id') ? 'outline-red-500' : 'outline-gray-300' }}  outline outline-1  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @foreach($companies as $company)
                  <option value="{{ $company->id }}" {{ old('company_id', $jobVacancy->company_id) == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                @endforeach
              </select>
              @error('company_id')
                <p class="text-red-500 text-xs italic" role="alert">{{ $message }}</p>
              @enderror
            </div>

            <!-- category select dropdown-->
            <div class="mb-4">
              <label for="category_id" class="block text-sm font-medium text-gray-700">{{ __('Category') }}</label>
              <select name="category_id" id="category_id" class=" {{ $errors->has('category_id') ? 'outline-red-500' : 'outline-gray-300' }}  outline outline-1  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                @foreach($categories as $category)
                  <option value="{{ $category->id }}" {{ old('category_id', $jobVacancy->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
              </select>
              @error('category_id')
                <p class="text-red-500 text-xs italic" role="alert">{{ $message }}</p>
              @enderror
            </div>

            <!-- job description text area -->
            <div class="mb-4">
              <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Job Description') }}</label>
              <textarea name="description" id="description" class=" {{ $errors->has('description') ? 'outline-red-500' : 'outline-gray-300' }}  outline outline-1  mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">{{ old('description', $jobVacancy->description) }}</textarea>
              @error('description')
                <p class="text-red-500 text-xs italic" role="alert">{{ $message }}</p>
              @enderror
            </div>

          </div>

            <div class="flex justify-end space-x-4">
            <!-- cancel button -->  
              <a href="{{ route('job-vacancy.index') }}" class="px-4 py-2 rounded-md text-gray-500 hover:text-gray-700">
                {{ __('Cancel') }}
              </a>
            
            <!-- submit button -->
              <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                {{ __('Update Job Vacancy') }}
              </button>
            </div>

         
        </form>
    </div>
  </div>

</x-app-layout>