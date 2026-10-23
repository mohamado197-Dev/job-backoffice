<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $faker = Faker::create();
    //seed admin user
        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        //Seed data 
        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);
        $jobApplications = json_decode(file_get_contents(database_path('data/job_applications.json')), true);

        // Seed job categories
        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category,
            ]);
        }

        // Seed companies

        foreach ($jobData['companies'] as $company) {
            //create users who is company owner
            $companyOwner = User::firstOrCreate([
                'email' => $faker->unique()->safeEmail(),
            ], [
                'name' => $faker->name(),
                'password' => Hash::make('12345678'),
                'role' => 'company-owner',
                'email_verified_at' => now(),
            ]);


            Company::firstOrCreate([
                'name' => $company['name'],
            ], [
                'address' => $company['address'],
                'industry' => $company['industry'],
                'website' => $company['website'],
                'owner_id' => $companyOwner->id,
            ]);
        }

        //seed job vacancies
        foreach ($jobData['jobVacancies'] as $jobVacancy) {
            //get the created company by name
            $company = Company::where('name', $jobVacancy['company'])->firstOrFail();
        
            //get the created job category by name
            $jobCategory = JobCategory::where('name', $jobVacancy['category'])->firstOrFail();
            
            JobVacancy::firstOrCreate([
                'title' => $jobVacancy['title'],
                'company_id' => $company->id,
                
            ], [
                'description' => $jobVacancy['description'],
                'location' => $jobVacancy['location'],
                'salary' => $jobVacancy['salary'],
                'type' => strtolower($jobVacancy['type']),
                'category_id' => $jobCategory->id,
                ]);
            
            }

            foreach ($jobApplications['jobApplications'] as $jobApplication) {
                //get random job vacancy
                $jobVacancy = JobVacancy::inRandomOrder()->firstOrFail();

                //create user who is job seeker
                $jobSeeker = User::firstOrCreate([
                    'email' => $faker->unique()->safeEmail(),
                ], [
                    'name' => $faker->name(),
                    'password' => Hash::make('12345678'),
                    'role' => 'job-seeker',
                    'email_verified_at' => now(),
                ]);

                //create a resume for the job seeker
                $resume = $jobSeeker->resume()->create([
                    'user_id' => $jobSeeker->id,
                    'fileName' => $jobApplication['resume']['filename'],
                    'fileUrl' => $jobApplication['resume']['fileUri'],
                    'contactDetails' => $jobApplication['resume']['contactDetails'],
                    'summary' => $jobApplication['resume']['summary'],
                    'skills' => $jobApplication['resume']['skills'],
                    'experience' => $jobApplication['resume']['experience'],
                    'education' => $jobApplication['resume']['education'],
                ]);

                //create a job application for the job seeker
                $jobVacancy->jobApplications()->create([
                    'user_id' => $jobSeeker->id,
                    'resume_id' => $resume->id,
                    'aiGeneratedScore' => $jobApplication['aiGeneratedScore'],
                    'aiGeneratedFeedback' => $jobApplication['aiGeneratedFeedback'],
                    'status' => strtolower($jobApplication['status']),
                ]);
            }
        }

        
}
