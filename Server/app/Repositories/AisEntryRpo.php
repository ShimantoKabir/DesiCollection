<?php

namespace App\Repositories;

use App\Models\AccountingTransaction;
use App\Models\ChartOfAccount;
use App\Utilities\AppConstant;
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

            $cashChartOfAccount = self::getChartOfAccountOidAndRootOid("cash");

            $res["cashChartOfAccount"] = [
                "oid" => $cashChartOfAccount["chartOfAccountOid"],
                "rootOid" => $cashChartOfAccount["chartOfAccountRootOid"]
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

        // credit always be the last transaction
        $res = [
            'msg' => '',
            'code' => ''
        ];

        $authInfo = $request->authInfo;
        $accountingTransaction = $request->accountingTransaction;
        $accountingTransactions = $request->accountingTransactions;
        $voucherType = $accountingTransaction['voucherType'];
        $cashChartOfAccount = self::getChartOfAccountOidAndRootOid(AppConstant::$CASH_ACCOUNT_NAME);

        try{

            // cash payment voucher
            if ($voucherType==1){

                $voucherName = 'DR-CH-';
                $crAmt = 0;
                $maxVoucherNo = self::getMaxVoucherNumber($voucherName,$voucherType);

                foreach ($accountingTransactions as $key=>$val) {
                    $crAmt = $crAmt + $val['amt'];
                    self::saveAccountingTransaction([
                        "voucherNo" => $maxVoucherNo,
                        "voucherDate" => $accountingTransaction['voucherDate'],
                        "voucherType" => $voucherType,
                        "narration" => $accountingTransaction['narration'],
                        "amtType" => "dr",
                        "amt" => $val['amt'],
                        "chartOfAccountOid" => $val["chartOfAccountOid"],
                        "chartOfAccountRootOid" => $val["chartOfAccountRootOid"],
                        "ip" => $request->ip(),
                        "modifiedBy" => $authInfo['id']
                    ]);
                }

                self::saveAccountingTransaction([
                    "voucherNo" => $maxVoucherNo,
                    "voucherDate" => $accountingTransaction['voucherDate'],
                    "voucherType" => $voucherType,
                    "narration" => $accountingTransaction['narration'],
                    "amtType" => "cr",
                    "amt" => $crAmt,
                    "chartOfAccountOid" => $cashChartOfAccount["chartOfAccountOid"],
                    "chartOfAccountRootOid" => $cashChartOfAccount["chartOfAccountRootOid"],
                    "ip" => $request->ip(),
                    "modifiedBy" => $authInfo['id']
                ]);

                // cash receive voucher
            }else if ($voucherType==2){

                $voucherName = 'CR-CH-';
                $drAmt = 0;

                $maxVoucherNo = self::getMaxVoucherNumber($voucherName,$voucherType);

                foreach ($accountingTransactions as $key=>$val) {
                    $drAmt = $drAmt + $val['amt'];
                }

                self::saveAccountingTransaction([
                    "voucherNo" => $maxVoucherNo,
                    "voucherDate" => $accountingTransaction['voucherDate'],
                    "voucherType" => $voucherType,
                    "narration" => $accountingTransaction['narration'],
                    "amtType" => "dr",
                    "amt" => $drAmt,
                    "chartOfAccountOid" => $cashChartOfAccount["chartOfAccountOid"],
                    "chartOfAccountRootOid" => $cashChartOfAccount["chartOfAccountRootOid"],
                    "ip" => $request->ip(),
                    "modifiedBy" => $authInfo['id']
                ]);

                foreach ($accountingTransactions as $key=>$val) {
                    self::saveAccountingTransaction([
                        "voucherNo" => $maxVoucherNo,
                        "voucherDate" => $accountingTransaction['voucherDate'],
                        "voucherType" => $voucherType,
                        "narration" => $accountingTransaction['narration'],
                        "amtType" => "cr",
                        "amt" => $val['amt'],
                        "chartOfAccountOid" => $val["chartOfAccountOid"],
                        "chartOfAccountRootOid" => $val["chartOfAccountRootOid"],
                        "ip" => $request->ip(),
                        "modifiedBy" => $authInfo['id']
                    ]);
                }

                // bank payment voucher
            }else if ($voucherType==3){

                $voucherName = 'DR-BK-';
                $crAmt = 0;

                $maxVoucherNo = self::getMaxVoucherNumber($voucherName,$voucherType);

                foreach ($accountingTransactions as $key=>$val) {
                    $crAmt = $crAmt + $val['amt'];
                    self::saveAccountingTransaction([
                        "voucherNo" => $maxVoucherNo,
                        "voucherDate" => $accountingTransaction['voucherDate'],
                        "voucherType" => $voucherType,
                        "narration" => $accountingTransaction['narration'],
                        "amtType" => "dr",
                        "amt" => $val['amt'],
                        "chartOfAccountOid" => $val["chartOfAccountOid"],
                        "chartOfAccountRootOid" => $val["chartOfAccountRootOid"],
                        "ip" => $request->ip(),
                        "modifiedBy" => $authInfo['id']
                    ]);
                }

                self::saveAccountingTransaction([
                    "voucherNo" => $maxVoucherNo,
                    "voucherDate" => $accountingTransaction['voucherDate'],
                    "voucherType" => $voucherType,
                    "narration" => $accountingTransaction['narration'],
                    "amtType" => "cr",
                    "amt" => $crAmt,
                    "chartOfAccountOid" => $accountingTransaction['chartOfAccountOid'],
                    "chartOfAccountRootOid" =>$accountingTransaction['chartOfAccountRootOid'],
                    "ip" => $request->ip(),
                    "modifiedBy" => $authInfo['id']
                ]);

                // bank receive voucher
            }else if ($voucherType==4){

                $voucherName = 'CR-BK-';
                $drAmt = 0;

                $maxVoucherNo = self::getMaxVoucherNumber($voucherName,$voucherType);

                foreach ($accountingTransactions as $key=>$val) {
                    $drAmt = $drAmt + $val['amt'];
                }

                self::saveAccountingTransaction([
                    "voucherNo" => $maxVoucherNo,
                    "voucherDate" => $accountingTransaction['voucherDate'],
                    "voucherType" => $voucherType,
                    "narration" => $accountingTransaction['narration'],
                    "amtType" => "dr",
                    "amt" => $drAmt,
                    "chartOfAccountOid" => $accountingTransaction['chartOfAccountOid'],
                    "chartOfAccountRootOid" =>$accountingTransaction['chartOfAccountRootOid'],
                    "ip" => $request->ip(),
                    "modifiedBy" => $authInfo['id']
                ]);

                foreach ($accountingTransactions as $key=>$val) {
                    self::saveAccountingTransaction([
                        "voucherNo" => $maxVoucherNo,
                        "voucherDate" => $accountingTransaction['voucherDate'],
                        "voucherType" => $voucherType,
                        "narration" => $accountingTransaction['narration'],
                        "amtType" => "cr",
                        "amt" => $val['amt'],
                        "chartOfAccountOid" => $val["chartOfAccountOid"],
                        "chartOfAccountRootOid" => $val["chartOfAccountRootOid"],
                        "ip" => $request->ip(),
                        "modifiedBy" => $authInfo['id']
                    ]);
                }

                // journal voucher debit
            }else if ($voucherType==5){

                $voucherName = 'DR-JV-';
                $drAmt = 0;

                $maxVoucherNo = self::getMaxVoucherNumber($voucherName,$voucherType);

                foreach ($accountingTransactions as $key=>$val) {
                    $drAmt = $drAmt + $val['amt'];
                }

                self::saveAccountingTransaction([
                    "voucherNo" => $maxVoucherNo,
                    "voucherDate" => $accountingTransaction['voucherDate'],
                    "voucherType" => $voucherType,
                    "narration" => $accountingTransaction['narration'],
                    "amtType" => 'dr',
                    "amt" => $drAmt,
                    "chartOfAccountOid" => $accountingTransaction['chartOfAccountOid'],
                    "chartOfAccountRootOid" =>$accountingTransaction['chartOfAccountRootOid'],
                    "ip" => $request->ip(),
                    "modifiedBy" => $authInfo['id']
                ]);

                foreach ($accountingTransactions as $key=>$val) {
                    self::saveAccountingTransaction([
                        "voucherNo" => $maxVoucherNo,
                        "voucherDate" => $accountingTransaction['voucherDate'],
                        "voucherType" => $voucherType,
                        "narration" => $accountingTransaction['narration'],
                        "amtType" => 'cr',
                        "amt" => $val['amt'],
                        "chartOfAccountOid" => $val["chartOfAccountOid"],
                        "chartOfAccountRootOid" => $val["chartOfAccountRootOid"],
                        "ip" => $request->ip(),
                        "modifiedBy" => $authInfo['id']
                    ]);
                }
                
                // journal voucher credit
            }else if ($voucherType==6){

                $voucherName = 'CR-JV-';
                $crAmt = 0;

                $maxVoucherNo = self::getMaxVoucherNumber($voucherName,$voucherType);
                
                foreach ($accountingTransactions as $key=>$val) {
                    $crAmt = $crAmt + $val['amt'];
                    self::saveAccountingTransaction([
                        "voucherNo" => $maxVoucherNo,
                        "voucherDate" => $accountingTransaction['voucherDate'],
                        "voucherType" => $voucherType,
                        "narration" => $accountingTransaction['narration'],
                        "amtType" => 'dr',
                        "amt" => $val['amt'],
                        "chartOfAccountOid" => $val["chartOfAccountOid"],
                        "chartOfAccountRootOid" => $val["chartOfAccountRootOid"],
                        "ip" => $request->ip(),
                        "modifiedBy" => $authInfo['id']
                    ]);

                }

                self::saveAccountingTransaction([
                    "voucherNo" => $maxVoucherNo,
                    "voucherDate" => $accountingTransaction['voucherDate'],
                    "voucherType" => $voucherType,
                    "narration" => $accountingTransaction['narration'],
                    "amtType" => 'cr',
                    "amt" => $crAmt,
                    "chartOfAccountOid" => $accountingTransaction['chartOfAccountOid'],
                    "chartOfAccountRootOid" =>$accountingTransaction['chartOfAccountRootOid'],
                    "ip" => $request->ip(),
                    "modifiedBy" => $authInfo['id']
                ]);
                
            }else {
                $res["msg"] = "Unknown voucher type!";
                $res["code"] = 200;
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

    public static function saveAccountingTransaction($array)
    {
        $at = new AccountingTransaction();
        $at->org_id = AppConstant::$ORG_ID;
        $at->voucher_no = $array["voucherNo"];
        $at->voucher_date = $array['voucherDate'];
        $at->voucher_type = $array['voucherType'];
        $at->narration = $array['narration'];

        if($array['amtType'] == "cr"){
            $at->cr_amt = $array['amt'];
        }else{
            $at->dr_amt = $array['amt'];
        }

        $at->chart_of_account_oid = $array["chartOfAccountOid"];
        $at->chart_of_account_root_oid = $array["chartOfAccountRootOid"];
        $at->ip = $array['ip'];
        $at->created_at = now();
        $at->modified_by =$array['modifiedBy'];
        $at->save();
    }

    public static function read($request)
    {

        $res = [
            'msg' => '',
            'code' => ''
        ];

        if (!$request->has('start-date')) {
            $res['code'] = 404;
            $res['msg'] = "Start date required!";
        }else if (!$request->has('end-date')) {
            $res['code'] = 404;
            $res['msg'] = "End date required!";
        }else {

            $startDate = $request->query('start-date');
            $endDate = $request->query('end-date');



        }
    }

}
