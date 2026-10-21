<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $industries = ['Technology', 'Education', 'Healthcare', 'Finance', 'Manufacturing', 'Retail', 'Other'];
   public function index(Request $request)
    {
        //Active
        $query = Company::latest();
        
        //Archived
        if($request->input('archived') == 'true'){
            $query->onlyTrashed();

        }
        $companies = $query->paginate(10)->onEachSide(1);
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = $this->industries;
        return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest  $request)
    {
        $validated = $request->validated();
        //owner
        $owner = User::create([
            'name' => $validated['owner_name'],
            'email' => $validated['owner_email'],
            'password' => Hash::make($validated['owner_password']),
            'role' => 'company-owner',
        ]);

        //return error if there is no user
        if(!$owner){
            return redirect()->back()->with('error', 'Failed to create user');
        }
        //company 
        Company::create([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'website' => $validated['website'],
            'industry' => $validated['industry'],
            'owner_id' => $owner->id,
        ]);

        return redirect()->route('company.index')->with('success', 'Company created successfully');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id =null)
    {   
        $company = $this->getCompany($id);
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id=null)
    {
        $company = $this->getCompany($id);
        $industries = $this->industries;
        return view('company.edit', compact('company', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id = null)
    {
        $validated = $request->validated();
        $company = $this->getCompany($id);
        //Update Company
        $company->update([
            'name' => $validated['name'],
            'address' => $validated['address'],
            'website' => $validated['website'],
            'industry' => $validated['industry'],
        ]);

        //Update Owner 
        $ownerData = [];
        $ownerData['name'] = $validated['owner_name'];
        if($validated['owner_password']){
            $ownerData['password'] = Hash::make($validated['owner_password']);
        }
        $company->owner->update($ownerData);
        
        if(auth()->user()->role == 'company-owner'){
            return redirect()->route('my-company.show' , $id)->with('success', 'Company updated successfully');
        }
        //redirect to company.index and if else redirect to company.show
        if($request->query('redirectToList')  == 'false'){
            return redirect()->route('company.show' , $id)->with('success', 'Company updated successfully');
        }
        return redirect()->route('company.index')->with('success', 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('company.index')->with('success', 'Company archived successfully');
    }

    public function restore(string $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('company.index' , ['archived' => 'true'])->with('success', 'Company restored successfully');
    }

    private function getCompany($id=null){
        if($id){
            return Company::findOrFail($id);
        }else{
            return Company::where('owner_id', auth()->user()->id)->first();
        }    
    }
}