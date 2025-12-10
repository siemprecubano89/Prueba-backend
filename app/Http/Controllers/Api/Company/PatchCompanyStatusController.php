<?php

namespace App\Http\Controllers\Api\Company;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\UpdateCompanyStatusRequest;
use OptimaCultura\Company\Application\CompanyStatusUpdater;

class PatchCompanyStatusController extends Controller
{
    /**
     * Update company status
     */
    public function __invoke(string $id, UpdateCompanyStatusRequest $request, CompanyStatusUpdater $service)
    {
        DB::beginTransaction();
        try {
            $service->handle($id, $request->status);
            DB::commit();
            return response()->json([
                'message' => 'Company status updated successfully'
            ], 200);
        } catch (\Exception $error) {
            DB::rollback();
            return response()->json([
                'message' => $error->getMessage()
            ], 404);
        }
    }
}
