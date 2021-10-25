<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 10/25/2021
 * Time: 9:20 AM
 */

namespace App\Repositories;


class AisReportRpo
{

    public static function showReportByType($request)
    {

        $reportViewModel = $request->reportViewModel;
        $reportType = $reportViewModel["reportType"];

        if ($reportType==1){

            return self::prepareLedgerReport($request);

        }else if ($reportType==2){

            return self::prepareJournalReport($request);

        }else if ($reportType==3){

            return self::trialBalanceReport($request);

        }else if ($reportType==4){

            return self::incomeStatementReport($request);

        }else if ($reportType==5){

            return self::balanceSheetReportReport($request);

        }

    }

    private static function prepareLedgerReport($request)
    {

        $res = [
            "msg"  => "",
            "code" => 200
        ];

        $reportViewModel = $request->reportViewModel;
        $dateRange = $reportViewModel["dateRange"];
        $middleDate = explode("T",$dateRange[0])[0];
        $endDate = explode("T",$dateRange[1])[0];

        $res["msg"] = "Report date fetch successfully!";
        $res["code"] = 200;
        // $res["ledgerReport"] =

        return response()->json($res, 200);

    }

    private static function prepareJournalReport($request)
    {

    }

    private static function trialBalanceReport($request)
    {

    }

    private static function incomeStatementReport($request)
    {

    }

    private static function balanceSheetReportReport($request)
    {

    }

}