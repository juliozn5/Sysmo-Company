<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{

   // Dashboard - Analytics user
   public function dashboardAnalyticsUser()
   {
     $pageConfigs = ['pageHeader' => false];
 
     return view('content.dashboard.user.dashboard-analytics', ['pageConfigs' => $pageConfigs]);
   }

  // Dashboard - Analytics
  public function dashboardAnalytics()
  {
    $pageConfigs = ['pageHeader' => false];

    return view('.content.dashboard.admin.dashboard-analytics', ['pageConfigs' => $pageConfigs]);
  }

  // Dashboard - Ecommerce
  public function dashboardEcommerce()
  {
    $pageConfigs = ['pageHeader' => false];
    
    return view('.content.dashboard.admin.dashboard-ecommerce', ['pageConfigs' => $pageConfigs]);
  }
}
