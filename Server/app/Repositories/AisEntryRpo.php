<?php

namespace App\Repositories;

use App\Models\AccountingTransaction;
use App\Models\ChartOfAccount;
use App\Utilities\AppConstant;
use Database\Factories\ChartOfAccountFactory;
use Database\Factories\VoucherTypeFactory;
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
            $res["voucherTypes"] = VoucherTypeFactory::getData();

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
        $voucherTypeId = $accountingTransaction['voucherTypeId'];
        $cashChartOfAccount = self::getChartOfAccountOidAndRootOid(AppConstant::$CASH_ACCOUNT_NAME);
        $voucherType = VoucherTypeFactory::findByTypeId($voucherTypeId);

        try{

            if(!empty($accountingTransaction["voucherNo"]) || !is_null($accountingTransaction["voucherNo"])){
                AccountingTransaction::where("voucherNo",$accountingTransaction["voucherNo"])
                ->update([
                    'is_countable' => 0
                ]);
            }

                // cash payment voucher
            if ($voucherTypeId==1){

                $crAmt = 0;
                $maxVoucherNo = self::getMaxVoucherNumber($voucherType["preFix"],$voucherTypeId);

                foreach ($accountingTransactions as $key=>$val) {
                    $crAmt = $crAmt + $val['amt'];
                    self::saveAccountingTransaction([
                        "voucherNo" => $maxVoucherNo,
                        "voucherDate" => $accountingTransaction['voucherDate'],
                        "voucherTypeId" => $voucherTypeId,
                        "narration" => $accountingTransaction['narration'],
                        "amtType" => "dr",
                        "amt" => $val['amt'],
                        "chartOfAccountOid" => $val["chartOfAccountOid"],
                        "chartOfAccountRootOid" => $val["chartOfAccountRootOid"],
                        "checkNo" => null,
                        "checkDate" => null,
                        "ip" => $request->ip(),
                        "modifiedBy" => $authInfo['id']
                    ]);
                }

                self::saveAccountingTransaction([
                    "voucherNo" => $maxVoucherNo,
                    "voucherDate" => $accountingTransaction['voucherDate'],
                    "voucherTypeId" => $voucherTypeId,
                    "narration" => $accountingTransaction['narration'],
                    "amtType" => "cr",
                    "amt" => $crAmt,
                    "chartOfAccountOid" => $cashChartOfAccount["chartOfAccountOid"],
                    "chartOfAccountRootOid" => $cashChartOfAccount["chartOfAccountRootOid"],
                    "checkNo" => null,
                    "checkDate" => null,
                    "ip" => $request->ip(),
                    "modifiedBy" => $authInfo['id']
                ]);

                // cash receive voucher
            }else if ($voucherTypeId==2){

                $drAmt = 0;
                $maxVoucherNo = self::getMaxVoucherNumber($voucherType["preFix"],$voucherTypeId);

                foreach ($accountingTransactions as $key=>$val) {
                    $drAmt = $drAmt + $val['amt'];
                }

                self::saveAccountingTransaction([
                    "voucherNo" => $maxVoucherNo,
                    "voucherDate" => $accountingTransaction['voucherDate'],
                    "voucherTypeId" => $voucherTypeId,
                    "narration" => $accountingTransaction['narration'],
                    "amtType" => "dr",
                    "amt" => $drAmt,
                    "chartOfAccountOid" => $cashChartOfAccount["chartOfAccountOid"],
                    "chartOfAccountRootOid" => $cashChartOfAccount["chartOfAccountRootOid"],
                    "checkNo" => null,
                    "checkDate" => null,
                    "ip" => $request->ip(),
                    "modifiedBy" => $authInfo['id']
                ]);

                foreach ($accountingTransactions as $key=>$val) {
                    self::saveAccountingTransaction([
                        "voucherNo" => $maxVoucherNo,
                        "voucherDate" => $accountingTransaction['voucherDate'],
                        "voucherTypeId" => $voucherTypeId,
                        "narration" => $accountingTransaction['narration'],
                        "amtType" => "cr",
                        "amt" => $val['amt'],
                        "chartOfAccountOid" => $val["chartOfAccountOid"],
                        "chartOfAccountRootOid" => $val["chartOfAccountRootOid"],
                        "checkNo" => null,
                        "checkDate" => null,
                        "ip" => $request->ip(),
                        "modifiedBy" => $authInfo['id']
                    ]);
                }

                // bank payment voucher
            }else if ($voucherTypeId==3){

                $crAmt = 0;
                $maxVoucherNo = self::getMaxVoucherNumber($voucherType["preFix"],$voucherTypeId);

                foreach ($accountingTransactions as $key=>$val) {
                    $crAmt = $crAmt + $val['amt'];
                    self::saveAccountingTransaction([
                        "voucherNo" => $maxVoucherNo,
                        "voucherDate" => $accountingTransaction['voucherDate'],
                        "voucherTypeId" => $voucherTypeId,
                        "narration" => $accountingTransaction['narration'],
                        "amtType" => "dr",
                        "amt" => $val['amt'],
                        "chartOfAccountOid" => $val["chartOfAccountOid"],
                        "chartOfAccountRootOid" => $val["chartOfAccountRootOid"],
                        "checkNo" => null,
                        "checkDate" => null,
                        "ip" => $request->ip(),
                        "modifiedBy" => $authInfo['id']
                    ]);
                }

                self::saveAccountingTransaction([
                    "voucherNo" => $maxVoucherNo,
                    "voucherDate" => $accountingTransaction['voucherDate'],
                    "voucherTypeId" => $voucherTypeId,
                    "narration" => $accountingTransaction['narration'],
                    "amtType" => "cr",
                    "amt" => $crAmt,
                    "chartOfAccountOid" => $accountingTransaction['chartOfAccountOid'],
                    "chartOfAccountRootOid" =>$accountingTransaction['chartOfAccountRootOid'],
                    "checkNo" => $accountingTransaction['checkNo'],
                    "checkDate" => $accountingTransaction['checkDate'],
                    "ip" => $request->ip(),
                    "modifiedBy" => $authInfo['id']
                ]);

                // bank receive voucher
            }else if ($voucherTypeId==4){

                $drAmt = 0;
                $maxVoucherNo = self::getMaxVoucherNumber($voucherType["preFix"],$voucherTypeId);

                foreach ($accountingTransactions as $key=>$val) {
                    $drAmt = $drAmt + $val['amt'];
                }

                self::saveAccountingTransaction([
                    "voucherNo" => $maxVoucherNo,
                    "voucherDate" => $accountingTransaction['voucherDate'],
                    "voucherTypeId" => $voucherTypeId,
                    "narration" => $accountingTransaction['narration'],
                    "amtType" => "dr",
                    "amt" => $drAmt,
                    "chartOfAccountOid" => $accountingTransaction['chartOfAccountOid'],
                    "chartOfAccountRootOid" =>$accountingTransaction['chartOfAccountRootOid'],
                    "checkNo" => $accountingTransaction['checkNo'],
                    "checkDate" => $accountingTransaction['checkDate'],
                    "ip" => $request->ip(),
                    "modifiedBy" => $authInfo['id']
                ]);

                foreach ($accountingTransactions as $key=>$val) {
                    self::saveAccountingTransaction([
                        "voucherNo" => $maxVoucherNo,
                        "voucherDate" => $accountingTransaction['voucherDate'],
                        "voucherTypeId" => $voucherTypeId,
                        "narration" => $accountingTransaction['narration'],
                        "amtType" => "cr",
                        "amt" => $val['amt'],
                        "chartOfAccountOid" => $val["chartOfAccountOid"],
                        "chartOfAccountRootOid" => $val["chartOfAccountRootOid"],
                        "checkNo" => null,
                        "checkDate" => null,
                        "ip" => $request->ip(),
                        "modifiedBy" => $authInfo['id']
                    ]);
                }

                // journal voucher credit
            }else if ($voucherTypeId==5){

                $crAmt = 0;
                $maxVoucherNo = self::getMaxVoucherNumber($voucherType["preFix"],$voucherTypeId);

                foreach ($accountingTransactions as $key=>$val) {
                    $crAmt = $crAmt + $val['amt'];
                    self::saveAccountingTransaction([
                        "voucherNo" => $maxVoucherNo,
                        "voucherDate" => $accountingTransaction['voucherDate'],
                        "voucherTypeId" => $voucherTypeId,
                        "narration" => $accountingTransaction['narration'],
                        "amtType" => 'dr',
                        "amt" => $val['amt'],
                        "chartOfAccountOid" => $val["chartOfAccountOid"],
                        "chartOfAccountRootOid" => $val["chartOfAccountRootOid"],
                        "checkNo" => null,
                        "checkDate" => null,
                        "ip" => $request->ip(),
                        "modifiedBy" => $authInfo['id']
                    ]);

                }

                self::saveAccountingTransaction([
                    "voucherNo" => $maxVoucherNo,
                    "voucherDate" => $accountingTransaction['voucherDate'],
                    "voucherTypeId" => $voucherTypeId,
                    "narration" => $accountingTransaction['narration'],
                    "amtType" => 'cr',
                    "amt" => $crAmt,
                    "chartOfAccountOid" => $accountingTransaction['chartOfAccountOid'],
                    "chartOfAccountRootOid" =>$accountingTransaction['chartOfAccountRootOid'],
                    "checkNo" => null,
                    "checkDate" => null,
                    "ip" => $request->ip(),
                    "modifiedBy" => $authInfo['id']
                ]);
                
                // journal voucher debit
            }else if ($voucherTypeId==6){

                $drAmt = 0;
                $maxVoucherNo = self::getMaxVoucherNumber($voucherType["preFix"],$voucherTypeId);

                foreach ($accountingTransactions as $key=>$val) {
                    $drAmt = $drAmt + $val['amt'];
                }

                self::saveAccountingTransaction([
                    "voucherNo" => $maxVoucherNo,
                    "voucherDate" => $accountingTransaction['voucherDate'],
                    "voucherTypeId" => $voucherTypeId,
                    "narration" => $accountingTransaction['narration'],
                    "amtType" => 'dr',
                    "amt" => $drAmt,
                    "chartOfAccountOid" => $accountingTransaction['chartOfAccountOid'],
                    "chartOfAccountRootOid" =>$accountingTransaction['chartOfAccountRootOid'],
                    "checkNo" => null,
                    "checkDate" => null,
                    "ip" => $request->ip(),
                    "modifiedBy" => $authInfo['id']
                ]);

                foreach ($accountingTransactions as $key=>$val) {
                    self::saveAccountingTransaction([
                        "voucherNo" => $maxVoucherNo,
                        "voucherDate" => $accountingTransaction['voucherDate'],
                        "voucherTypeId" => $voucherTypeId,
                        "narration" => $accountingTransaction['narration'],
                        "amtType" => 'cr',
                        "amt" => $val['amt'],
                        "chartOfAccountOid" => $val["chartOfAccountOid"],
                        "chartOfAccountRootOid" => $val["chartOfAccountRootOid"],
                        "checkNo" => null,
                        "checkDate" => null,
                        "ip" => $request->ip(),
                        "modifiedBy" => $authInfo['id']
                    ]);
                }
                
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

    private static function getMaxVoucherNumber($voucherPrefix,$voucherTypeId)
    {
        return DB::select("SELECT IF(MAX(voucher_no) IS NULL,CONCAT('$voucherPrefix','1'),CONCAT('$voucherPrefix',SUBSTRING_INDEX(MAX(voucher_no),'-',-1)+1)) AS voucher_no FROM accounting_transactions WHERE org_id = 101 AND voucher_type_id = $voucherTypeId")[0]->voucher_no;
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
        $at->voucher_type_id = $array['voucherTypeId'];
        $at->narration = $array['narration'];

        if($array['amtType'] == "cr"){
            $at->cr_amt = $array['amt'];
        }else{
            $at->dr_amt = $array['amt'];
        }

        $at->chart_of_account_oid = $array["chartOfAccountOid"];
        $at->chart_of_account_root_oid = $array["chartOfAccountRootOid"];
        $at->chq_no = $array["checkNo"];
        $at->chq_date = $array["checkDate"];
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

            $res['accountingTransactionList'] = DB::table('accounting_transactions')
                ->join('chart_of_accounts', 'chart_of_accounts.oId', '=',
                    'accounting_transactions.chart_of_account_oid')
                ->select(
                    'accounting_transactions.id',
                    'accounting_transactions.voucher_date AS voucherDate',
                    'accounting_transactions.voucher_type_id AS voucherTypeId',
                    'accounting_transactions.voucher_no AS voucherNo',
                    'accounting_transactions.dr_amt AS drAmt',
                    'accounting_transactions.cr_amt AS crAmt',
                    'accounting_transactions.chart_of_account_oid AS chartOfAccountOid',
                    'accounting_transactions.chart_of_account_root_oid AS chartOfAccountRootOid',
                    'accounting_transactions.chq_no AS checkNo',
                    'accounting_transactions.chq_date AS checkDate',
                    'accounting_transactions.narration',
                    'chart_of_accounts.account_name AS accountName'
                )
                ->whereBetween("voucher_date",[$startDate,$endDate])
                ->where("is_countable",1)
                ->orderBy('accounting_transactions.id')
                ->get();

//            $voucherDates = DB::table("accounting_transactions")
//                ->select("voucher_date")
//                ->whereBetween("voucher_date",[$startDate,$endDate])
//                ->distinct("voucher_date")
//                ->get();
//
//            foreach ($voucherDates as $dateKey=>$dateVal){
//
//                $voucherNumbers = DB::table("accounting_transactions")
//                    ->select("voucher_no")
//                    ->where("voucher_date",$dateVal->voucher_date)
//                    ->distinct("voucher_no")
//                    ->get();
//
//                $res["accountingTransactionList"][$dateKey]=[
//                    'voucherDate'=>$dateVal->voucher_date,
//                    'accountingTransactionList'=>[]
//                ];
//
//                foreach ($voucherNumbers as $voucherNumberKey=>$voucherNumberVal){
//                    $res["accountingTransactionList"][$dateKey]["accountingTransactionList"][$voucherNumberKey]=[
//                        'voucherNo'=>$voucherNumberVal->voucher_no,
//                        'accountingTransactionList'=>[]
//                    ];
//
//                    $accountingTransactions = DB::table('accounting_transactions')
//                        ->join('chart_of_accounts', 'chart_of_accounts.oId', '=',
//                            'accounting_transactions.chart_of_account_oid')
//                        ->select('accounting_transactions.*','chart_of_accounts.account_name')
//                        ->where('accounting_transactions.voucher_no', '=',
//                            $voucherNumberVal->voucher_no)
//                        ->where('accounting_transactions.voucher_date', '=',
//                            $dateVal->voucher_date)
//                        ->orderBy('accounting_transactions.id')
//                        ->get();
//
//                    foreach ($accountingTransactions as $tKey=>$tVal){
//
//                        $res['accountingTransactionList'][$dateKey]
//                        ['accountingTransactionList'][$voucherNumberKey]
//                        ['accountingTransactionList'][$tKey]
//                            =[
//                            'id'=>$tVal->id,
//                            'voucherTypeId'=>$tVal->voucher_type_id,
//                            'narration'=>$tVal->narration,
//                            'drAmt'=>$tVal->dr_amt,
//                            'crAmt'=>$tVal->cr_amt,
//                            'chartOfAccountOid'=>$tVal->chart_of_account_oid,
//                            'chartOfAccountRootOid'=>$tVal->chart_of_account_root_oid,
//                            'accountName'=>$tVal->account_name
//                        ];
//
//                    }
//
//                }
//
//            }

            $res["code"]= 200;
            $res["msg"] = "Success";

        }

        return response()->json($res, 200);
    }

}
