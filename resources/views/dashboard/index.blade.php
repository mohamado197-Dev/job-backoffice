<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 px-6 gap-4">
        <!-- OverView Cards -->
        <div class="grid grid-cols-3 gap-6 mb-6">
            <!--Avtive Users-->
            <div class="overflow-hidden bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-900">Total Users</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['activeUsers'] }}</p>
                <p class="text-gray-500 text-sm">Last 30 Days</p>
            </div>

            <!--Total Jobs -->
            <div class="overflow-hidden bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-900">Total Jobs</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['totalJobs'] }}</p>
                <p class="text-gray-500 text-sm">All time</p>
            </div>

            <!--Total Applications -->
            <div class="overflow-hidden bg-white p-6 rounded-lg shadow-sm">
                <h3 class="text-lg font-medium text-gray-900">Total Applications</h3>
                <p class="text-3xl font-bold text-indigo-600">{{ $analytics['totalApplications'] }}</p>
                <p class="text-gray-500 text-sm">All time</p>
            </div>
        </div>
        <!-- Most Applied Jobs -->
        <div class="overflow-hidden bg-white p-6 rounded-lg shadow-sm">
            <h3 class="text-lg font-medium text-gray-900">Most Applied Jobs</h3>
            <div class="mt-4">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job Title</th>
                            @if(auth()->user()->role == 'admin')
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                            @endif
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applications</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($analytics['mostAppliedJobs'] as $job)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $job->title }}</td>
                                @if(auth()->user()->role == 'admin')
                                <td class="px-6 py-4 whitespace-nowrap">{{ $job->company->name }}</td>
                                @endif
                                <td class="px-6 py-4 whitespace-nowrap">{{ $job->totalCount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Conversion Rates -->
        <div class="overflow-hidden bg-white p-6 rounded-lg shadow-sm mt-5">
            <h3 class="text-lg font-medium text-gray-900"> Conversion Rates</h3>
            <div>
                <table class="w-full">
                       <thead class="bg-gray-50">
                           <tr>
                               <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Job Title</th>
                               <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Views</th>
                               <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Applications</th>
                               <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Conversion Rate</th>
                           </tr>
                       </thead>
                       <tbody class="bg-white divide-y divide-gray-200">
                          @foreach($analytics['conversionRates'] as $job)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $job->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $job->view_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $job->totalCount }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $job->conversion_rate }}%</td>
                            </tr>
                        @endforeach
                        </tbody>
                </table>

            </div>
        </div>

    </div>
</x-app-layout>