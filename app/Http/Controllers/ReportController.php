<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
   // Display all reports (Admin)
   public function index()
   {
       $reports = Report::with('user')->paginate(10);
       return view('admin.reports.index', compact('reports'));
   }

   // Create a new report (User)
   public function create()
   {
       return view('user.reports.create');
   }

   // Store the report
   public function store(Request $request)
   {
       $request->validate([
           'title' => 'required|string|max:255',
           'description' => 'required|string',
           'captcha' => 'required|captcha',
       ]);
   
       Report::create([
           'title' => $request->title,
           'captcha' => $request->captcha,
           'description' => $request->description,
           'user_id' => auth()->check() ? auth()->id() : null, // Null if the user is not logged in
       ]);
   
       return redirect()->back()->with('success', 'Report submitted successfully!');
   }
   

   // Show individual report (Admin)
   public function show(Report $report)
   {
       return view('admin.reports.show', compact('report'));
   }
}
