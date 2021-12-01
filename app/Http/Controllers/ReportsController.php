<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrganizationCollection;
use App\Http\Resources\ReportCollection;
use App\Http\Resources\ReportResource;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class ReportsController extends Controller
{
  //  public function __invoke()
  //  {
    //    return Inertia::render('Reports/Index');
    //}

    public function index()
    {
        return Inertia::render('Reports/Index', [
            'filters' => Request::all('search', 'trashed'),
            'reports' => new ReportCollection(
                Auth::user()->account->reports()
                    ->orderBy('title')
                    ->filter(Request::only('search', 'trashed'))
                    ->paginate()
                    ->appends(Request::all())
            ),
        ]);
    }

}

