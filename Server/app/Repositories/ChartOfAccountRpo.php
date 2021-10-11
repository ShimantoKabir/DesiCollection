<?php

namespace App\Repositories;

use App\Models\ChartOfAccount;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ChartOfAccountRpo
{

    public static function getInitialData(Request $request): JsonResponse
    {

        $res = [
            'msg' => '',
            'code' => ''
        ];

        $authInfo = $request->authInfo;
        try{

            $res["chartOfAccounts"] = ChartOfAccount::select(
                "id",
                "oid",
                "path",
                "org_id AS orgOid",
                "tree_id AS treeId",
                "is_ledger AS isLedger",
                "account_name AS accountName",
                "parent_tree_id AS parentTreeId"
            )->get();
            $res['msg'] = "Initial date fetched successfully!";
            $res['code'] = 200;

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }
}
