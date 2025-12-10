<?php

  namespace App\Http\Controllers\Api\Company;

  use App\Http\Controllers\Controller;
  use OptimaCultura\Company\Application\CompanyLister;

  class GetCompanyListController extends Controller
  {
      /**
       * List all companies
       */
      public function __invoke(CompanyLister $service)
      {
          $companies = $service->handle();

          return response()->json([
              'data' => $companies,
              'total' => count($companies)
          ], 200);
      }
  }