<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use App\Models\JobApplication;
use App\Models\JobVacancy;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(auth()->user()->role == 'admin'){
            $analytics = $this->adminDashboardAnalytics();
            return view('dashboard.index', compact('analytics'));
        }else{
            $analytics = $this->companyDashboardAnalytics();
            return view('dashboard.index', compact('analytics'));
        }
        
    }

    private function adminDashboardAnalytics(){
        //last 30 days active users (job-seeker role)
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
                            ->where('role', 'job-seeker')->count();   
        
        //total jobs (not deleted)                    
        $totalJobs = JobVacancy::whereNull('deleted_at')->count();
        
        //total applications
        $totalApplications = JobApplication::whereNull('deleted_at')->count();

        

        //most aplied jobs (top 10)
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount')
                                    ->whereNull('deleted_at')
                                    ->orderByDesc('totalCount')
                                    ->limit(5)
                                    ->get();
        
        //conversion rates (top 10)
        $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
                                    ->having('totalCount', '>', 0)
                                    ->orderByDesc('totalCount')
                                    ->limit(5)
                                    ->get()
                                    ->map(function($job){
                                        if($job->view_count == 0){
                                            $job->conversion_rate = 0;
                                        }else{
                                            $job->conversion_rate = round($job->totalCount / $job->view_count * 100 , 2);
                                        }
                                        return $job;
                                    });
                                    
        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates,
        ];
       
        
        return $analytics;
    }

    private function companyDashboardAnalytics(){
        $company = auth()->user()->companies;
        
        $activeUsers = User::where('last_login_at', '>=', now()->subDays(30))
                            ->where('role', 'job-seeker')
                            ->whereHas('jobApplications' , function($query) use ($company){
                                $query->whereIn('job_id', $company->jobVacancies->pluck('id'));
                            })
                            ->count();
        
        //total jobs of the company
        $totalJobs = $company->jobVacancies->count();
        
        //total applications of the company
        $totalApplications = JobApplication::whereIn('job_id', $company->jobVacancies->pluck('id'))->count();
        
        //most applied jobs of the company
        $mostAppliedJobs = JobVacancy::withCount('jobApplications as totalCount')
                                                ->whereIn('id', $company->jobVacancies->pluck('id'))
                                                ->orderByDesc('totalCount')
                                                ->limit(5)
                                                ->get();
        
        //conversion rates of the company
        $conversionRates = JobVacancy::withCount('jobApplications as totalCount')
                                                ->whereIn('id', $company->jobVacancies->pluck('id'))
                                                ->having('totalCount', '>', 0)
                                                ->orderByDesc('totalCount')
                                                ->limit(5)
                                                ->get()
                                                ->map(function($job){
                                                    if($job->view_count == 0){
                                                        $job->conversion_rate = 0;
                                                    }else{
                                                        $job->conversion_rate = round($job->totalCount / $job->view_count * 100 , 2);
                                                    }
                                                    return $job;
                                                });
                                    
        $analytics = [
            'activeUsers' => $activeUsers,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversionRates' => $conversionRates,
        ];
       
        
        return $analytics;
    }
}
