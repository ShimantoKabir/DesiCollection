<?php

namespace App\Repositories;

use App\Models\AccountingTransaction;
use App\Models\ChartOfAccount;
use Database\Factories\ChartOfAccountFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AisEntryRpo
{

    public static function getInitialData(Request $request)
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
                "parent_tree_id AS parentTreeId",
                DB::raw("CONVERT(SUBSTRING_INDEX(path, ',', 1),UNSIGNED INTEGER) AS rootOid")
            )->where("is_ledger","=",1)->get();

            $chartOfAccountOidAndRootOidRes = self::getChartOfAccountOidAndRootOid("cash");

            $res["cashChartOfAccount"] = [
                "oid" => $chartOfAccountOidAndRootOidRes["chartOfAccountOid"],
                "rootOid" => $chartOfAccountOidAndRootOidRes["chartOfAccountRootOid"]
            ];

            $res['msg'] = "Initial date fetched successfully!";
            $res['code'] = 200;

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }

    public static function create(Request $request)
    {

        $res = [
            'msg' => '',
            'code' => ''
        ];

        $authInfo = $request->authInfo;
        $accountingTransaction = $request->accountingTransaction;
        $accountingTransactions = $request->accountingTransactions;
        $voucherType = $accountingTransaction['voucherType'];

        try{

            // cash payment voucher
            if ($voucherType==1){

                $voucherName = 'DR-CH-';
                $crAmt = 0;
                $srl = 0;
                $maxVoucherNo = self::getMaxVoucherNumber($voucherName,$voucherType);

                foreach ($accountingTransactions as $key=>$val) {

                    $srl++;
                    $crAmt = $crAmt + $val['amt'];

                    $at = new AccountingTransaction();
                    $at->org_id = 101;
                    $at->voucher_no = $maxVoucherNo;
                    $at->voucher_date = $accountingTransaction['voucherDate'];
                    $at->voucher_type = $voucherType;
                    $at->narration = $accountingTransaction['narration'];
                    $at->dr_amt = $val['amt'];
                    $at->srl = $srl;
                    $at->chart_of_account_oid = $val['chartOfAccountOid'];
                    $at->chart_of_account_root_oid = $val['chartOfAccountRootOid'];
                    $at->ip = $request->ip();
                    $at->created_at = now();
                    $at->modified_by = $authInfo['id'];
                    $at->save();

                }

                $chartOfAccountOidAndRootOidRes = self::getChartOfAccountOidAndRootOid("cash");

                $srl++;
                $at = new AccountingTransaction();
                $at->org_id = 101;
                $at->voucher_no = $maxVoucherNo;
                $at->voucher_date = $accountingTransaction['voucherDate'];
                $at->voucher_type = $voucherType;
                $at->narration = $accountingTransaction['narration'];
                $at->cr_amt = $crAmt;
                $at->srl = $srl;
                $at->chart_of_account_oid = $chartOfAccountOidAndRootOidRes["chartOfAccountOid"];
                $at->chart_of_account_root_oid = $chartOfAccountOidAndRootOidRes["chartOfAccountRootOid"];
                $at->ip = $request->ip();
                $at->created_at = now();
                $at->modified_by = $authInfo['id'];
                $at->save();

            }

            DB::commit();
            $res["msg"] = "Transaction save successfully";
            $res["code"] = 200;

        }catch (\Exception $e) {
            $res['msg'] = $e->getMessage();
            $res['code'] = 404;
        }

        return response()->json($res, 200);

    }

    private static function getMaxVoucherNumber($voucherName,$voucherType)
    {
        return DB::select("SELECT IF(MAX(voucher_no) IS NULL,CONCAT('$voucherName','1'),CONCAT('$voucherName',SUBSTRING_INDEX(MAX(voucher_no),'-',-1)+1)) AS voucher_no FROM accounting_transactions WHERE org_id = 101 AND voucher_type = $voucherType")[0]->voucher_no;
    }

    private static function getChartOfAccountOidAndRootOid($accountName)
    {

        $res = [
            "chartOfAccountOid" => 0,
            "chartOfAccountRootOid" => 0
        ];

        $chartOfAccounts = ChartOfAccountFactory::getData();

        foreach ($chartOfAccounts as $key => $val) {
            if(strtolower(str_replace(' ', '',$val['account_name']))
                == strtolower(str_replace(' ', '',$accountName))){
                $res['chartOfAccountOid'] = $val['oid'];
                $res['chartOfAccountRootOid'] = explode(",",$val['path'])[0];
                break;
            }
        }

        return $res;

    }
}
