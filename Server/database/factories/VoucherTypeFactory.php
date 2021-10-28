<?php
/**
 * Created by PhpStorm.
 * User: kabir
 * Date: 10/28/2021
 * Time: 7:10 AM
 */

namespace Database\Factories;


class VoucherTypeFactory
{

    private static $data = [
        [
            "typeId" => 1,
            "typeName" => "Cash Payment Voucher",
            "preFix" => "DR-CH-"
        ],
        [
            "typeId" => 2,
            "typeName" => "Cash Receive Voucher",
            "preFix" => "CR-CH-"
        ],
        [
            "typeId" => 3,
            "typeName" => "Bank Payment Voucher",
            "preFix" => "DR-BK-"
        ],
        [
            "typeId" => 4,
            "typeName" => "Bank Receive Voucher",
            "preFix" => "CR-BK-"
        ],
        [
            "typeId" => 5,
            "typeName" => "Journal Voucher(Debit)",
            "preFix" => "DR-JV-"
        ],
        [
            "typeId" => 6,
            "typeName" => "Journal Voucher(Credit)",
            "preFix" => "CR-JV-"
        ]
    ];

    public static function getData()
    {
        return self::$data;
    }

    public static function findByTypeId($typeId){
        foreach (self::$data as $key => $val) {
            if ($val['typeId'] === $typeId) {
                return [
                    "typeId" => $val['typeId'],
                    "typeName" => $val['typeName'],
                    "preFix" => $val['preFix']
                ];
            }
        }
        return null;
    }

}