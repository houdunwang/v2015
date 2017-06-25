define(['jquery'], function ($) {
    var province = [{id: "1", provinceID: "110000", province: "\u5317\u4eac\u5e02"}, {id: "2", provinceID: "120000", province: "\u5929\u6d25\u5e02"}, {id: "3", provinceID: "130000", province: "\u6cb3\u5317\u7701"}, {id: "4", provinceID: "140000", province: "\u5c71\u897f\u7701"}, {id: "5", provinceID: "150000", province: "\u5185\u8499\u53e4\u81ea\u6cbb\u533a"}, {id: "6", provinceID: "210000", province: "\u8fbd\u5b81\u7701"}, {id: "7", provinceID: "220000", province: "\u5409\u6797\u7701"}, {id: "8", provinceID: "230000", province: "\u9ed1\u9f99\u6c5f\u7701"}, {id: "9", provinceID: "310000", province: "\u4e0a\u6d77\u5e02"}, {id: "10", provinceID: "320000", province: "\u6c5f\u82cf\u7701"}, {id: "11", provinceID: "330000", province: "\u6d59\u6c5f\u7701"}, {
        id: "12",
        provinceID: "340000",
        province: "\u5b89\u5fbd\u7701"
    }, {id: "13", provinceID: "350000", province: "\u798f\u5efa\u7701"}, {id: "14", provinceID: "360000", province: "\u6c5f\u897f\u7701"}, {id: "15", provinceID: "370000", province: "\u5c71\u4e1c\u7701"}, {id: "16", provinceID: "410000", province: "\u6cb3\u5357\u7701"}, {id: "17", provinceID: "420000", province: "\u6e56\u5317\u7701"}, {id: "18", provinceID: "430000", province: "\u6e56\u5357\u7701"}, {id: "19", provinceID: "440000", province: "\u5e7f\u4e1c\u7701"}, {id: "20", provinceID: "450000", province: "\u5e7f\u897f\u58ee\u65cf\u81ea\u6cbb\u533a"}, {id: "21", provinceID: "460000", province: "\u6d77\u5357\u7701"}, {id: "22", provinceID: "500000", province: "\u91cd\u5e86\u5e02"}, {id: "23", provinceID: "510000", province: "\u56db\u5ddd\u7701"}, {
        id: "24",
        provinceID: "520000",
        province: "\u8d35\u5dde\u7701"
    }, {id: "25", provinceID: "530000", province: "\u4e91\u5357\u7701"}, {id: "26", provinceID: "540000", province: "\u897f\u85cf\u81ea\u6cbb\u533a"}, {id: "27", provinceID: "610000", province: "\u9655\u897f\u7701"}, {id: "28", provinceID: "620000", province: "\u7518\u8083\u7701"}, {id: "29", provinceID: "630000", province: "\u9752\u6d77\u7701"}, {id: "30", provinceID: "640000", province: "\u5b81\u590f\u56de\u65cf\u81ea\u6cbb\u533a"}, {id: "31", provinceID: "650000", province: "\u65b0\u7586\u7ef4\u543e\u5c14\u81ea\u6cbb\u533a"}, {id: "32", provinceID: "710000", province: "\u53f0\u6e7e\u7701"}, {id: "33", provinceID: "810000", province: "\u9999\u6e2f\u7279\u522b\u884c\u653f\u533a"}, {id: "34", provinceID: "820000", province: "\u6fb3\u95e8\u7279\u522b\u884c\u653f\u533a"}];
    var city = [{id: "1", cityID: "110100", city: "\u5e02\u8f96\u533a", fatherID: "110000"}, {id: "2", cityID: "110200", city: "\u53bf", fatherID: "110000"}, {id: "3", cityID: "120100", city: "\u5e02\u8f96\u533a", fatherID: "120000"}, {id: "4", cityID: "120200", city: "\u53bf", fatherID: "120000"}, {id: "5", cityID: "130100", city: "\u77f3\u5bb6\u5e84\u5e02", fatherID: "130000"}, {id: "6", cityID: "130200", city: "\u5510\u5c71\u5e02", fatherID: "130000"}, {id: "7", cityID: "130300", city: "\u79e6\u7687\u5c9b\u5e02", fatherID: "130000"}, {id: "8", cityID: "130400", city: "\u90af\u90f8\u5e02", fatherID: "130000"}, {id: "9", cityID: "130500", city: "\u90a2\u53f0\u5e02", fatherID: "130000"}, {id: "10", cityID: "130600", city: "\u4fdd\u5b9a\u5e02", fatherID: "130000"}, {
        id: "11",
        cityID: "130700",
        city: "\u5f20\u5bb6\u53e3\u5e02",
        fatherID: "130000"
    }, {id: "12", cityID: "130800", city: "\u627f\u5fb7\u5e02", fatherID: "130000"}, {id: "13", cityID: "130900", city: "\u6ca7\u5dde\u5e02", fatherID: "130000"}, {id: "14", cityID: "131000", city: "\u5eca\u574a\u5e02", fatherID: "130000"}, {id: "15", cityID: "131100", city: "\u8861\u6c34\u5e02", fatherID: "130000"}, {id: "16", cityID: "140100", city: "\u592a\u539f\u5e02", fatherID: "140000"}, {id: "17", cityID: "140200", city: "\u5927\u540c\u5e02", fatherID: "140000"}, {id: "18", cityID: "140300", city: "\u9633\u6cc9\u5e02", fatherID: "140000"}, {id: "19", cityID: "140400", city: "\u957f\u6cbb\u5e02", fatherID: "140000"}, {id: "20", cityID: "140500", city: "\u664b\u57ce\u5e02", fatherID: "140000"}, {id: "21", cityID: "140600", city: "\u6714\u5dde\u5e02", fatherID: "140000"}, {
        id: "22",
        cityID: "140700",
        city: "\u664b\u4e2d\u5e02",
        fatherID: "140000"
    }, {id: "23", cityID: "140800", city: "\u8fd0\u57ce\u5e02", fatherID: "140000"}, {id: "24", cityID: "140900", city: "\u5ffb\u5dde\u5e02", fatherID: "140000"}, {id: "25", cityID: "141000", city: "\u4e34\u6c7e\u5e02", fatherID: "140000"}, {id: "26", cityID: "141100", city: "\u5415\u6881\u5e02", fatherID: "140000"}, {id: "27", cityID: "150100", city: "\u547c\u548c\u6d69\u7279\u5e02", fatherID: "150000"}, {id: "28", cityID: "150200", city: "\u5305\u5934\u5e02", fatherID: "150000"}, {id: "29", cityID: "150300", city: "\u4e4c\u6d77\u5e02", fatherID: "150000"}, {id: "30", cityID: "150400", city: "\u8d64\u5cf0\u5e02", fatherID: "150000"}, {id: "31", cityID: "150500", city: "\u901a\u8fbd\u5e02", fatherID: "150000"}, {
        id: "32",
        cityID: "150600",
        city: "\u9102\u5c14\u591a\u65af\u5e02",
        fatherID: "150000"
    }, {id: "33", cityID: "150700", city: "\u547c\u4f26\u8d1d\u5c14\u5e02", fatherID: "150000"}, {id: "34", cityID: "150800", city: "\u5df4\u5f66\u6dd6\u5c14\u5e02", fatherID: "150000"}, {id: "35", cityID: "150900", city: "\u4e4c\u5170\u5bdf\u5e03\u5e02", fatherID: "150000"}, {id: "36", cityID: "152200", city: "\u5174\u5b89\u76df", fatherID: "150000"}, {id: "37", cityID: "152500", city: "\u9521\u6797\u90ed\u52d2\u76df", fatherID: "150000"}, {id: "38", cityID: "152900", city: "\u963f\u62c9\u5584\u76df", fatherID: "150000"}, {id: "39", cityID: "210100", city: "\u6c88\u9633\u5e02", fatherID: "210000"}, {id: "40", cityID: "210200", city: "\u5927\u8fde\u5e02", fatherID: "210000"}, {id: "41", cityID: "210300", city: "\u978d\u5c71\u5e02", fatherID: "210000"}, {
        id: "42",
        cityID: "210400",
        city: "\u629a\u987a\u5e02",
        fatherID: "210000"
    }, {id: "43", cityID: "210500", city: "\u672c\u6eaa\u5e02", fatherID: "210000"}, {id: "44", cityID: "210600", city: "\u4e39\u4e1c\u5e02", fatherID: "210000"}, {id: "45", cityID: "210700", city: "\u9526\u5dde\u5e02", fatherID: "210000"}, {id: "46", cityID: "210800", city: "\u8425\u53e3\u5e02", fatherID: "210000"}, {id: "47", cityID: "210900", city: "\u961c\u65b0\u5e02", fatherID: "210000"}, {id: "48", cityID: "211000", city: "\u8fbd\u9633\u5e02", fatherID: "210000"}, {id: "49", cityID: "211100", city: "\u76d8\u9526\u5e02", fatherID: "210000"}, {id: "50", cityID: "211200", city: "\u94c1\u5cad\u5e02", fatherID: "210000"}, {id: "51", cityID: "211300", city: "\u671d\u9633\u5e02", fatherID: "210000"}, {
        id: "52",
        cityID: "211400",
        city: "\u846b\u82a6\u5c9b\u5e02",
        fatherID: "210000"
    }, {id: "53", cityID: "220100", city: "\u957f\u6625\u5e02", fatherID: "220000"}, {id: "54", cityID: "220200", city: "\u5409\u6797\u5e02", fatherID: "220000"}, {id: "55", cityID: "220300", city: "\u56db\u5e73\u5e02", fatherID: "220000"}, {id: "56", cityID: "220400", city: "\u8fbd\u6e90\u5e02", fatherID: "220000"}, {id: "57", cityID: "220500", city: "\u901a\u5316\u5e02", fatherID: "220000"}, {id: "58", cityID: "220600", city: "\u767d\u5c71\u5e02", fatherID: "220000"}, {id: "59", cityID: "220700", city: "\u677e\u539f\u5e02", fatherID: "220000"}, {id: "60", cityID: "220800", city: "\u767d\u57ce\u5e02", fatherID: "220000"}, {id: "61", cityID: "222400", city: "\u5ef6\u8fb9\u671d\u9c9c\u65cf\u81ea\u6cbb\u5dde", fatherID: "220000"}, {
        id: "62",
        cityID: "230100",
        city: "\u54c8\u5c14\u6ee8\u5e02",
        fatherID: "230000"
    }, {id: "63", cityID: "230200", city: "\u9f50\u9f50\u54c8\u5c14\u5e02", fatherID: "230000"}, {id: "64", cityID: "230300", city: "\u9e21\u897f\u5e02", fatherID: "230000"}, {id: "65", cityID: "230400", city: "\u9e64\u5c97\u5e02", fatherID: "230000"}, {id: "66", cityID: "230500", city: "\u53cc\u9e2d\u5c71\u5e02", fatherID: "230000"}, {id: "67", cityID: "230600", city: "\u5927\u5e86\u5e02", fatherID: "230000"}, {id: "68", cityID: "230700", city: "\u4f0a\u6625\u5e02", fatherID: "230000"}, {id: "69", cityID: "230800", city: "\u4f73\u6728\u65af\u5e02", fatherID: "230000"}, {id: "70", cityID: "230900", city: "\u4e03\u53f0\u6cb3\u5e02", fatherID: "230000"}, {id: "71", cityID: "231000", city: "\u7261\u4e39\u6c5f\u5e02", fatherID: "230000"}, {
        id: "72",
        cityID: "231100",
        city: "\u9ed1\u6cb3\u5e02",
        fatherID: "230000"
    }, {id: "73", cityID: "231200", city: "\u7ee5\u5316\u5e02", fatherID: "230000"}, {id: "74", cityID: "232700", city: "\u5927\u5174\u5b89\u5cad\u5730\u533a", fatherID: "230000"}, {id: "75", cityID: "310100", city: "\u5e02\u8f96\u533a", fatherID: "310000"}, {id: "76", cityID: "310200", city: "\u53bf", fatherID: "310000"}, {id: "77", cityID: "320100", city: "\u5357\u4eac\u5e02", fatherID: "320000"}, {id: "78", cityID: "320200", city: "\u65e0\u9521\u5e02", fatherID: "320000"}, {id: "79", cityID: "320300", city: "\u5f90\u5dde\u5e02", fatherID: "320000"}, {id: "80", cityID: "320400", city: "\u5e38\u5dde\u5e02", fatherID: "320000"}, {id: "81", cityID: "320500", city: "\u82cf\u5dde\u5e02", fatherID: "320000"}, {
        id: "82",
        cityID: "320600",
        city: "\u5357\u901a\u5e02",
        fatherID: "320000"
    }, {id: "83", cityID: "320700", city: "\u8fde\u4e91\u6e2f\u5e02", fatherID: "320000"}, {id: "84", cityID: "320800", city: "\u6dee\u5b89\u5e02", fatherID: "320000"}, {id: "85", cityID: "320900", city: "\u76d0\u57ce\u5e02", fatherID: "320000"}, {id: "86", cityID: "321000", city: "\u626c\u5dde\u5e02", fatherID: "320000"}, {id: "87", cityID: "321100", city: "\u9547\u6c5f\u5e02", fatherID: "320000"}, {id: "88", cityID: "321200", city: "\u6cf0\u5dde\u5e02", fatherID: "320000"}, {id: "89", cityID: "321300", city: "\u5bbf\u8fc1\u5e02", fatherID: "320000"}, {id: "90", cityID: "330100", city: "\u676d\u5dde\u5e02", fatherID: "330000"}, {id: "91", cityID: "330200", city: "\u5b81\u6ce2\u5e02", fatherID: "330000"}, {
        id: "92",
        cityID: "330300",
        city: "\u6e29\u5dde\u5e02",
        fatherID: "330000"
    }, {id: "93", cityID: "330400", city: "\u5609\u5174\u5e02", fatherID: "330000"}, {id: "94", cityID: "330500", city: "\u6e56\u5dde\u5e02", fatherID: "330000"}, {id: "95", cityID: "330600", city: "\u7ecd\u5174\u5e02", fatherID: "330000"}, {id: "96", cityID: "330700", city: "\u91d1\u534e\u5e02", fatherID: "330000"}, {id: "97", cityID: "330800", city: "\u8862\u5dde\u5e02", fatherID: "330000"}, {id: "98", cityID: "330900", city: "\u821f\u5c71\u5e02", fatherID: "330000"}, {id: "99", cityID: "331000", city: "\u53f0\u5dde\u5e02", fatherID: "330000"}, {id: "100", cityID: "331100", city: "\u4e3d\u6c34\u5e02", fatherID: "330000"}, {id: "101", cityID: "340100", city: "\u5408\u80a5\u5e02", fatherID: "340000"}, {
        id: "102",
        cityID: "340200",
        city: "\u829c\u6e56\u5e02",
        fatherID: "340000"
    }, {id: "103", cityID: "340300", city: "\u868c\u57e0\u5e02", fatherID: "340000"}, {id: "104", cityID: "340400", city: "\u6dee\u5357\u5e02", fatherID: "340000"}, {id: "105", cityID: "340500", city: "\u9a6c\u978d\u5c71\u5e02", fatherID: "340000"}, {id: "106", cityID: "340600", city: "\u6dee\u5317\u5e02", fatherID: "340000"}, {id: "107", cityID: "340700", city: "\u94dc\u9675\u5e02", fatherID: "340000"}, {id: "108", cityID: "340800", city: "\u5b89\u5e86\u5e02", fatherID: "340000"}, {id: "109", cityID: "341000", city: "\u9ec4\u5c71\u5e02", fatherID: "340000"}, {id: "110", cityID: "341100", city: "\u6ec1\u5dde\u5e02", fatherID: "340000"}, {id: "111", cityID: "341200", city: "\u961c\u9633\u5e02", fatherID: "340000"}, {
        id: "112",
        cityID: "341300",
        city: "\u5bbf\u5dde\u5e02",
        fatherID: "340000"
    }, {id: "113", cityID: "341400", city: "\u5de2\u6e56\u5e02", fatherID: "340000"}, {id: "114", cityID: "341500", city: "\u516d\u5b89\u5e02", fatherID: "340000"}, {id: "115", cityID: "341600", city: "\u4eb3\u5dde\u5e02", fatherID: "340000"}, {id: "116", cityID: "341700", city: "\u6c60\u5dde\u5e02", fatherID: "340000"}, {id: "117", cityID: "341800", city: "\u5ba3\u57ce\u5e02", fatherID: "340000"}, {id: "118", cityID: "350100", city: "\u798f\u5dde\u5e02", fatherID: "350000"}, {id: "119", cityID: "350200", city: "\u53a6\u95e8\u5e02", fatherID: "350000"}, {id: "120", cityID: "350300", city: "\u8386\u7530\u5e02", fatherID: "350000"}, {id: "121", cityID: "350400", city: "\u4e09\u660e\u5e02", fatherID: "350000"}, {
        id: "122",
        cityID: "350500",
        city: "\u6cc9\u5dde\u5e02",
        fatherID: "350000"
    }, {id: "123", cityID: "350600", city: "\u6f33\u5dde\u5e02", fatherID: "350000"}, {id: "124", cityID: "350700", city: "\u5357\u5e73\u5e02", fatherID: "350000"}, {id: "125", cityID: "350800", city: "\u9f99\u5ca9\u5e02", fatherID: "350000"}, {id: "126", cityID: "350900", city: "\u5b81\u5fb7\u5e02", fatherID: "350000"}, {id: "127", cityID: "360100", city: "\u5357\u660c\u5e02", fatherID: "360000"}, {id: "128", cityID: "360200", city: "\u666f\u5fb7\u9547\u5e02", fatherID: "360000"}, {id: "129", cityID: "360300", city: "\u840d\u4e61\u5e02", fatherID: "360000"}, {id: "130", cityID: "360400", city: "\u4e5d\u6c5f\u5e02", fatherID: "360000"}, {id: "131", cityID: "360500", city: "\u65b0\u4f59\u5e02", fatherID: "360000"}, {
        id: "132",
        cityID: "360600",
        city: "\u9e70\u6f6d\u5e02",
        fatherID: "360000"
    }, {id: "133", cityID: "360700", city: "\u8d63\u5dde\u5e02", fatherID: "360000"}, {id: "134", cityID: "360800", city: "\u5409\u5b89\u5e02", fatherID: "360000"}, {id: "135", cityID: "360900", city: "\u5b9c\u6625\u5e02", fatherID: "360000"}, {id: "136", cityID: "361000", city: "\u629a\u5dde\u5e02", fatherID: "360000"}, {id: "137", cityID: "361100", city: "\u4e0a\u9976\u5e02", fatherID: "360000"}, {id: "138", cityID: "370100", city: "\u6d4e\u5357\u5e02", fatherID: "370000"}, {id: "139", cityID: "370200", city: "\u9752\u5c9b\u5e02", fatherID: "370000"}, {id: "140", cityID: "370300", city: "\u6dc4\u535a\u5e02", fatherID: "370000"}, {id: "141", cityID: "370400", city: "\u67a3\u5e84\u5e02", fatherID: "370000"}, {
        id: "142",
        cityID: "370500",
        city: "\u4e1c\u8425\u5e02",
        fatherID: "370000"
    }, {id: "143", cityID: "370600", city: "\u70df\u53f0\u5e02", fatherID: "370000"}, {id: "144", cityID: "370700", city: "\u6f4d\u574a\u5e02", fatherID: "370000"}, {id: "145", cityID: "370800", city: "\u6d4e\u5b81\u5e02", fatherID: "370000"}, {id: "146", cityID: "370900", city: "\u6cf0\u5b89\u5e02", fatherID: "370000"}, {id: "147", cityID: "371000", city: "\u5a01\u6d77\u5e02", fatherID: "370000"}, {id: "148", cityID: "371100", city: "\u65e5\u7167\u5e02", fatherID: "370000"}, {id: "149", cityID: "371200", city: "\u83b1\u829c\u5e02", fatherID: "370000"}, {id: "150", cityID: "371300", city: "\u4e34\u6c82\u5e02", fatherID: "370000"}, {id: "151", cityID: "371400", city: "\u5fb7\u5dde\u5e02", fatherID: "370000"}, {
        id: "152",
        cityID: "371500",
        city: "\u804a\u57ce\u5e02",
        fatherID: "370000"
    }, {id: "153", cityID: "371600", city: "\u6ee8\u5dde\u5e02", fatherID: "370000"}, {id: "154", cityID: "371700", city: "\u8377\u6cfd\u5e02", fatherID: "370000"}, {id: "155", cityID: "410100", city: "\u90d1\u5dde\u5e02", fatherID: "410000"}, {id: "156", cityID: "410200", city: "\u5f00\u5c01\u5e02", fatherID: "410000"}, {id: "157", cityID: "410300", city: "\u6d1b\u9633\u5e02", fatherID: "410000"}, {id: "158", cityID: "410400", city: "\u5e73\u9876\u5c71\u5e02", fatherID: "410000"}, {id: "159", cityID: "410500", city: "\u5b89\u9633\u5e02", fatherID: "410000"}, {id: "160", cityID: "410600", city: "\u9e64\u58c1\u5e02", fatherID: "410000"}, {id: "161", cityID: "410700", city: "\u65b0\u4e61\u5e02", fatherID: "410000"}, {
        id: "162",
        cityID: "410800",
        city: "\u7126\u4f5c\u5e02",
        fatherID: "410000"
    }, {id: "163", cityID: "410900", city: "\u6fee\u9633\u5e02", fatherID: "410000"}, {id: "164", cityID: "411000", city: "\u8bb8\u660c\u5e02", fatherID: "410000"}, {id: "165", cityID: "411100", city: "\u6f2f\u6cb3\u5e02", fatherID: "410000"}, {id: "166", cityID: "411200", city: "\u4e09\u95e8\u5ce1\u5e02", fatherID: "410000"}, {id: "167", cityID: "411300", city: "\u5357\u9633\u5e02", fatherID: "410000"}, {id: "168", cityID: "411400", city: "\u5546\u4e18\u5e02", fatherID: "410000"}, {id: "169", cityID: "411500", city: "\u4fe1\u9633\u5e02", fatherID: "410000"}, {id: "170", cityID: "411600", city: "\u5468\u53e3\u5e02", fatherID: "410000"}, {id: "171", cityID: "411700", city: "\u9a7b\u9a6c\u5e97\u5e02", fatherID: "410000"}, {
        id: "172",
        cityID: "420100",
        city: "\u6b66\u6c49\u5e02",
        fatherID: "420000"
    }, {id: "173", cityID: "420200", city: "\u9ec4\u77f3\u5e02", fatherID: "420000"}, {id: "174", cityID: "420300", city: "\u5341\u5830\u5e02", fatherID: "420000"}, {id: "175", cityID: "420500", city: "\u5b9c\u660c\u5e02", fatherID: "420000"}, {id: "176", cityID: "420600", city: "\u8944\u6a0a\u5e02", fatherID: "420000"}, {id: "177", cityID: "420700", city: "\u9102\u5dde\u5e02", fatherID: "420000"}, {id: "178", cityID: "420800", city: "\u8346\u95e8\u5e02", fatherID: "420000"}, {id: "179", cityID: "420900", city: "\u5b5d\u611f\u5e02", fatherID: "420000"}, {id: "180", cityID: "421000", city: "\u8346\u5dde\u5e02", fatherID: "420000"}, {id: "181", cityID: "421100", city: "\u9ec4\u5188\u5e02", fatherID: "420000"}, {
        id: "182",
        cityID: "421200",
        city: "\u54b8\u5b81\u5e02",
        fatherID: "420000"
    }, {id: "183", cityID: "421300", city: "\u968f\u5dde\u5e02", fatherID: "420000"}, {id: "184", cityID: "422800", city: "\u6069\u65bd\u571f\u5bb6\u65cf\u82d7\u65cf\u81ea\u6cbb\u5dde", fatherID: "420000"}, {id: "185", cityID: "429000", city: "\u7701\u76f4\u8f96\u884c\u653f\u5355\u4f4d", fatherID: "420000"}, {id: "186", cityID: "430100", city: "\u957f\u6c99\u5e02", fatherID: "430000"}, {id: "187", cityID: "430200", city: "\u682a\u6d32\u5e02", fatherID: "430000"}, {id: "188", cityID: "430300", city: "\u6e58\u6f6d\u5e02", fatherID: "430000"}, {id: "189", cityID: "430400", city: "\u8861\u9633\u5e02", fatherID: "430000"}, {id: "190", cityID: "430500", city: "\u90b5\u9633\u5e02", fatherID: "430000"}, {id: "191", cityID: "430600", city: "\u5cb3\u9633\u5e02", fatherID: "430000"}, {
        id: "192",
        cityID: "430700",
        city: "\u5e38\u5fb7\u5e02",
        fatherID: "430000"
    }, {id: "193", cityID: "430800", city: "\u5f20\u5bb6\u754c\u5e02", fatherID: "430000"}, {id: "194", cityID: "430900", city: "\u76ca\u9633\u5e02", fatherID: "430000"}, {id: "195", cityID: "431000", city: "\u90f4\u5dde\u5e02", fatherID: "430000"}, {id: "196", cityID: "431100", city: "\u6c38\u5dde\u5e02", fatherID: "430000"}, {id: "197", cityID: "431200", city: "\u6000\u5316\u5e02", fatherID: "430000"}, {id: "198", cityID: "431300", city: "\u5a04\u5e95\u5e02", fatherID: "430000"}, {id: "199", cityID: "433100", city: "\u6e58\u897f\u571f\u5bb6\u65cf\u82d7\u65cf\u81ea\u6cbb\u5dde", fatherID: "430000"}, {id: "200", cityID: "440100", city: "\u5e7f\u5dde\u5e02", fatherID: "440000"}, {id: "201", cityID: "440200", city: "\u97f6\u5173\u5e02", fatherID: "440000"}, {
        id: "202",
        cityID: "440300",
        city: "\u6df1\u5733\u5e02",
        fatherID: "440000"
    }, {id: "203", cityID: "440400", city: "\u73e0\u6d77\u5e02", fatherID: "440000"}, {id: "204", cityID: "440500", city: "\u6c55\u5934\u5e02", fatherID: "440000"}, {id: "205", cityID: "440600", city: "\u4f5b\u5c71\u5e02", fatherID: "440000"}, {id: "206", cityID: "440700", city: "\u6c5f\u95e8\u5e02", fatherID: "440000"}, {id: "207", cityID: "440800", city: "\u6e5b\u6c5f\u5e02", fatherID: "440000"}, {id: "208", cityID: "440900", city: "\u8302\u540d\u5e02", fatherID: "440000"}, {id: "209", cityID: "441200", city: "\u8087\u5e86\u5e02", fatherID: "440000"}, {id: "210", cityID: "441300", city: "\u60e0\u5dde\u5e02", fatherID: "440000"}, {id: "211", cityID: "441400", city: "\u6885\u5dde\u5e02", fatherID: "440000"}, {
        id: "212",
        cityID: "441500",
        city: "\u6c55\u5c3e\u5e02",
        fatherID: "440000"
    }, {id: "213", cityID: "441600", city: "\u6cb3\u6e90\u5e02", fatherID: "440000"}, {id: "214", cityID: "441700", city: "\u9633\u6c5f\u5e02", fatherID: "440000"}, {id: "215", cityID: "441800", city: "\u6e05\u8fdc\u5e02", fatherID: "440000"}, {id: "216", cityID: "441900", city: "\u4e1c\u839e\u5e02", fatherID: "440000"}, {id: "217", cityID: "442000", city: "\u4e2d\u5c71\u5e02", fatherID: "440000"}, {id: "218", cityID: "445100", city: "\u6f6e\u5dde\u5e02", fatherID: "440000"}, {id: "219", cityID: "445200", city: "\u63ed\u9633\u5e02", fatherID: "440000"}, {id: "220", cityID: "445300", city: "\u4e91\u6d6e\u5e02", fatherID: "440000"}, {id: "221", cityID: "450100", city: "\u5357\u5b81\u5e02", fatherID: "450000"}, {
        id: "222",
        cityID: "450200",
        city: "\u67f3\u5dde\u5e02",
        fatherID: "450000"
    }, {id: "223", cityID: "450300", city: "\u6842\u6797\u5e02", fatherID: "450000"}, {id: "224", cityID: "450400", city: "\u68a7\u5dde\u5e02", fatherID: "450000"}, {id: "225", cityID: "450500", city: "\u5317\u6d77\u5e02", fatherID: "450000"}, {id: "226", cityID: "450600", city: "\u9632\u57ce\u6e2f\u5e02", fatherID: "450000"}, {id: "227", cityID: "450700", city: "\u94a6\u5dde\u5e02", fatherID: "450000"}, {id: "228", cityID: "450800", city: "\u8d35\u6e2f\u5e02", fatherID: "450000"}, {id: "229", cityID: "450900", city: "\u7389\u6797\u5e02", fatherID: "450000"}, {id: "230", cityID: "451000", city: "\u767e\u8272\u5e02", fatherID: "450000"}, {id: "231", cityID: "451100", city: "\u8d3a\u5dde\u5e02", fatherID: "450000"}, {
        id: "232",
        cityID: "451200",
        city: "\u6cb3\u6c60\u5e02",
        fatherID: "450000"
    }, {id: "233", cityID: "451300", city: "\u6765\u5bbe\u5e02", fatherID: "450000"}, {id: "234", cityID: "451400", city: "\u5d07\u5de6\u5e02", fatherID: "450000"}, {id: "235", cityID: "460100", city: "\u6d77\u53e3\u5e02", fatherID: "460000"}, {id: "236", cityID: "460200", city: "\u4e09\u4e9a\u5e02", fatherID: "460000"}, {id: "237", cityID: "469000", city: "\u7701\u76f4\u8f96\u53bf\u7ea7\u884c\u653f\u5355\u4f4d", fatherID: "460000"}, {id: "238", cityID: "500100", city: "\u5e02\u8f96\u533a", fatherID: "500000"}, {id: "239", cityID: "500200", city: "\u53bf", fatherID: "500000"}, {id: "240", cityID: "500300", city: "\u5e02", fatherID: "500000"}, {id: "241", cityID: "510100", city: "\u6210\u90fd\u5e02", fatherID: "510000"}, {
        id: "242",
        cityID: "510300",
        city: "\u81ea\u8d21\u5e02",
        fatherID: "510000"
    }, {id: "243", cityID: "510400", city: "\u6500\u679d\u82b1\u5e02", fatherID: "510000"}, {id: "244", cityID: "510500", city: "\u6cf8\u5dde\u5e02", fatherID: "510000"}, {id: "245", cityID: "510600", city: "\u5fb7\u9633\u5e02", fatherID: "510000"}, {id: "246", cityID: "510700", city: "\u7ef5\u9633\u5e02", fatherID: "510000"}, {id: "247", cityID: "510800", city: "\u5e7f\u5143\u5e02", fatherID: "510000"}, {id: "248", cityID: "510900", city: "\u9042\u5b81\u5e02", fatherID: "510000"}, {id: "249", cityID: "511000", city: "\u5185\u6c5f\u5e02", fatherID: "510000"}, {id: "250", cityID: "511100", city: "\u4e50\u5c71\u5e02", fatherID: "510000"}, {id: "251", cityID: "511300", city: "\u5357\u5145\u5e02", fatherID: "510000"}, {
        id: "252",
        cityID: "511400",
        city: "\u7709\u5c71\u5e02",
        fatherID: "510000"
    }, {id: "253", cityID: "511500", city: "\u5b9c\u5bbe\u5e02", fatherID: "510000"}, {id: "254", cityID: "511600", city: "\u5e7f\u5b89\u5e02", fatherID: "510000"}, {id: "255", cityID: "511700", city: "\u8fbe\u5dde\u5e02", fatherID: "510000"}, {id: "256", cityID: "511800", city: "\u96c5\u5b89\u5e02", fatherID: "510000"}, {id: "257", cityID: "511900", city: "\u5df4\u4e2d\u5e02", fatherID: "510000"}, {id: "258", cityID: "512000", city: "\u8d44\u9633\u5e02", fatherID: "510000"}, {id: "259", cityID: "513200", city: "\u963f\u575d\u85cf\u65cf\u7f8c\u65cf\u81ea\u6cbb\u5dde", fatherID: "510000"}, {id: "260", cityID: "513300", city: "\u7518\u5b5c\u85cf\u65cf\u81ea\u6cbb\u5dde", fatherID: "510000"}, {
        id: "261",
        cityID: "513400",
        city: "\u51c9\u5c71\u5f5d\u65cf\u81ea\u6cbb\u5dde",
        fatherID: "510000"
    }, {id: "262", cityID: "520100", city: "\u8d35\u9633\u5e02", fatherID: "520000"}, {id: "263", cityID: "520200", city: "\u516d\u76d8\u6c34\u5e02", fatherID: "520000"}, {id: "264", cityID: "520300", city: "\u9075\u4e49\u5e02", fatherID: "520000"}, {id: "265", cityID: "520400", city: "\u5b89\u987a\u5e02", fatherID: "520000"}, {id: "266", cityID: "522200", city: "\u94dc\u4ec1\u5730\u533a", fatherID: "520000"}, {id: "267", cityID: "522300", city: "\u9ed4\u897f\u5357\u5e03\u4f9d\u65cf\u82d7\u65cf\u81ea\u6cbb\u5dde", fatherID: "520000"}, {id: "268", cityID: "522400", city: "\u6bd5\u8282\u5730\u533a", fatherID: "520000"}, {id: "269", cityID: "522600", city: "\u9ed4\u4e1c\u5357\u82d7\u65cf\u4f97\u65cf\u81ea\u6cbb\u5dde", fatherID: "520000"}, {
        id: "270",
        cityID: "522700",
        city: "\u9ed4\u5357\u5e03\u4f9d\u65cf\u82d7\u65cf\u81ea\u6cbb\u5dde",
        fatherID: "520000"
    }, {id: "271", cityID: "530100", city: "\u6606\u660e\u5e02", fatherID: "530000"}, {id: "272", cityID: "530300", city: "\u66f2\u9756\u5e02", fatherID: "530000"}, {id: "273", cityID: "530400", city: "\u7389\u6eaa\u5e02", fatherID: "530000"}, {id: "274", cityID: "530500", city: "\u4fdd\u5c71\u5e02", fatherID: "530000"}, {id: "275", cityID: "530600", city: "\u662d\u901a\u5e02", fatherID: "530000"}, {id: "276", cityID: "530700", city: "\u4e3d\u6c5f\u5e02", fatherID: "530000"}, {id: "277", cityID: "530800", city: "\u601d\u8305\u5e02", fatherID: "530000"}, {id: "278", cityID: "530900", city: "\u4e34\u6ca7\u5e02", fatherID: "530000"}, {id: "279", cityID: "532300", city: "\u695a\u96c4\u5f5d\u65cf\u81ea\u6cbb\u5dde", fatherID: "530000"}, {
        id: "280",
        cityID: "532500",
        city: "\u7ea2\u6cb3\u54c8\u5c3c\u65cf\u5f5d\u65cf\u81ea\u6cbb\u5dde",
        fatherID: "530000"
    }, {id: "281", cityID: "532600", city: "\u6587\u5c71\u58ee\u65cf\u82d7\u65cf\u81ea\u6cbb\u5dde", fatherID: "530000"}, {id: "282", cityID: "532800", city: "\u897f\u53cc\u7248\u7eb3\u50a3\u65cf\u81ea\u6cbb\u5dde", fatherID: "530000"}, {id: "283", cityID: "532900", city: "\u5927\u7406\u767d\u65cf\u81ea\u6cbb\u5dde", fatherID: "530000"}, {id: "284", cityID: "533100", city: "\u5fb7\u5b8f\u50a3\u65cf\u666f\u9887\u65cf\u81ea\u6cbb\u5dde", fatherID: "530000"}, {id: "285", cityID: "533300", city: "\u6012\u6c5f\u5088\u50f3\u65cf\u81ea\u6cbb\u5dde", fatherID: "530000"}, {id: "286", cityID: "533400", city: "\u8fea\u5e86\u85cf\u65cf\u81ea\u6cbb\u5dde", fatherID: "530000"}, {id: "287", cityID: "540100", city: "\u62c9\u8428\u5e02", fatherID: "540000"}, {
        id: "288",
        cityID: "542100",
        city: "\u660c\u90fd\u5730\u533a",
        fatherID: "540000"
    }, {id: "289", cityID: "542200", city: "\u5c71\u5357\u5730\u533a", fatherID: "540000"}, {id: "290", cityID: "542300", city: "\u65e5\u5580\u5219\u5730\u533a", fatherID: "540000"}, {id: "291", cityID: "542400", city: "\u90a3\u66f2\u5730\u533a", fatherID: "540000"}, {id: "292", cityID: "542500", city: "\u963f\u91cc\u5730\u533a", fatherID: "540000"}, {id: "293", cityID: "542600", city: "\u6797\u829d\u5730\u533a", fatherID: "540000"}, {id: "294", cityID: "610100", city: "\u897f\u5b89\u5e02", fatherID: "610000"}, {id: "295", cityID: "610200", city: "\u94dc\u5ddd\u5e02", fatherID: "610000"}, {id: "296", cityID: "610300", city: "\u5b9d\u9e21\u5e02", fatherID: "610000"}, {id: "297", cityID: "610400", city: "\u54b8\u9633\u5e02", fatherID: "610000"}, {
        id: "298",
        cityID: "610500",
        city: "\u6e2d\u5357\u5e02",
        fatherID: "610000"
    }, {id: "299", cityID: "610600", city: "\u5ef6\u5b89\u5e02", fatherID: "610000"}, {id: "300", cityID: "610700", city: "\u6c49\u4e2d\u5e02", fatherID: "610000"}, {id: "301", cityID: "610800", city: "\u6986\u6797\u5e02", fatherID: "610000"}, {id: "302", cityID: "610900", city: "\u5b89\u5eb7\u5e02", fatherID: "610000"}, {id: "303", cityID: "611000", city: "\u5546\u6d1b\u5e02", fatherID: "610000"}, {id: "304", cityID: "620100", city: "\u5170\u5dde\u5e02", fatherID: "620000"}, {id: "305", cityID: "620200", city: "\u5609\u5cea\u5173\u5e02", fatherID: "620000"}, {id: "306", cityID: "620300", city: "\u91d1\u660c\u5e02", fatherID: "620000"}, {id: "307", cityID: "620400", city: "\u767d\u94f6\u5e02", fatherID: "620000"}, {
        id: "308",
        cityID: "620500",
        city: "\u5929\u6c34\u5e02",
        fatherID: "620000"
    }, {id: "309", cityID: "620600", city: "\u6b66\u5a01\u5e02", fatherID: "620000"}, {id: "310", cityID: "620700", city: "\u5f20\u6396\u5e02", fatherID: "620000"}, {id: "311", cityID: "620800", city: "\u5e73\u51c9\u5e02", fatherID: "620000"}, {id: "312", cityID: "620900", city: "\u9152\u6cc9\u5e02", fatherID: "620000"}, {id: "313", cityID: "621000", city: "\u5e86\u9633\u5e02", fatherID: "620000"}, {id: "314", cityID: "621100", city: "\u5b9a\u897f\u5e02", fatherID: "620000"}, {id: "315", cityID: "621200", city: "\u9647\u5357\u5e02", fatherID: "620000"}, {id: "316", cityID: "622900", city: "\u4e34\u590f\u56de\u65cf\u81ea\u6cbb\u5dde", fatherID: "620000"}, {id: "317", cityID: "623000", city: "\u7518\u5357\u85cf\u65cf\u81ea\u6cbb\u5dde", fatherID: "620000"}, {
        id: "318",
        cityID: "630100",
        city: "\u897f\u5b81\u5e02",
        fatherID: "630000"
    }, {id: "319", cityID: "632100", city: "\u6d77\u4e1c\u5730\u533a", fatherID: "630000"}, {id: "320", cityID: "632200", city: "\u6d77\u5317\u85cf\u65cf\u81ea\u6cbb\u5dde", fatherID: "630000"}, {id: "321", cityID: "632300", city: "\u9ec4\u5357\u85cf\u65cf\u81ea\u6cbb\u5dde", fatherID: "630000"}, {id: "322", cityID: "632500", city: "\u6d77\u5357\u85cf\u65cf\u81ea\u6cbb\u5dde", fatherID: "630000"}, {id: "323", cityID: "632600", city: "\u679c\u6d1b\u85cf\u65cf\u81ea\u6cbb\u5dde", fatherID: "630000"}, {id: "324", cityID: "632700", city: "\u7389\u6811\u85cf\u65cf\u81ea\u6cbb\u5dde", fatherID: "630000"}, {id: "325", cityID: "632800", city: "\u6d77\u897f\u8499\u53e4\u65cf\u85cf\u65cf\u81ea\u6cbb\u5dde", fatherID: "630000"}, {
        id: "326",
        cityID: "640100",
        city: "\u94f6\u5ddd\u5e02",
        fatherID: "640000"
    }, {id: "327", cityID: "640200", city: "\u77f3\u5634\u5c71\u5e02", fatherID: "640000"}, {id: "328", cityID: "640300", city: "\u5434\u5fe0\u5e02", fatherID: "640000"}, {id: "329", cityID: "640400", city: "\u56fa\u539f\u5e02", fatherID: "640000"}, {id: "330", cityID: "640500", city: "\u4e2d\u536b\u5e02", fatherID: "640000"}, {id: "331", cityID: "650100", city: "\u4e4c\u9c81\u6728\u9f50\u5e02", fatherID: "650000"}, {id: "332", cityID: "650200", city: "\u514b\u62c9\u739b\u4f9d\u5e02", fatherID: "650000"}, {id: "333", cityID: "652100", city: "\u5410\u9c81\u756a\u5730\u533a", fatherID: "650000"}, {id: "334", cityID: "652200", city: "\u54c8\u5bc6\u5730\u533a", fatherID: "650000"}, {
        id: "335",
        cityID: "652300",
        city: "\u660c\u5409\u56de\u65cf\u81ea\u6cbb\u5dde",
        fatherID: "650000"
    }, {id: "336", cityID: "652700", city: "\u535a\u5c14\u5854\u62c9\u8499\u53e4\u81ea\u6cbb\u5dde", fatherID: "650000"}, {id: "337", cityID: "652800", city: "\u5df4\u97f3\u90ed\u695e\u8499\u53e4\u81ea\u6cbb\u5dde", fatherID: "650000"}, {id: "338", cityID: "652900", city: "\u963f\u514b\u82cf\u5730\u533a", fatherID: "650000"}, {id: "339", cityID: "653000", city: "\u514b\u5b5c\u52d2\u82cf\u67ef\u5c14\u514b\u5b5c\u81ea\u6cbb\u5dde", fatherID: "650000"}, {id: "340", cityID: "653100", city: "\u5580\u4ec0\u5730\u533a", fatherID: "650000"}, {id: "341", cityID: "653200", city: "\u548c\u7530\u5730\u533a", fatherID: "650000"}, {id: "342", cityID: "654000", city: "\u4f0a\u7281\u54c8\u8428\u514b\u81ea\u6cbb\u5dde", fatherID: "650000"}, {
        id: "343",
        cityID: "654200",
        city: "\u5854\u57ce\u5730\u533a",
        fatherID: "650000"
    }, {id: "344", cityID: "654300", city: "\u963f\u52d2\u6cf0\u5730\u533a", fatherID: "650000"}, {id: "345", cityID: "659000", city: "\u7701\u76f4\u8f96\u884c\u653f\u5355\u4f4d", fatherID: "650000"}];
    var area = [{id: "1", areaID: "110101", area: "\u4e1c\u57ce\u533a", fatherID: "110100"}, {id: "2", areaID: "110102", area: "\u897f\u57ce\u533a", fatherID: "110100"}, {id: "3", areaID: "110103", area: "\u5d07\u6587\u533a", fatherID: "110100"}, {id: "4", areaID: "110104", area: "\u5ba3\u6b66\u533a", fatherID: "110100"}, {id: "5", areaID: "110105", area: "\u671d\u9633\u533a", fatherID: "110100"}, {id: "6", areaID: "110106", area: "\u4e30\u53f0\u533a", fatherID: "110100"}, {id: "7", areaID: "110107", area: "\u77f3\u666f\u5c71\u533a", fatherID: "110100"}, {id: "8", areaID: "110108", area: "\u6d77\u6dc0\u533a", fatherID: "110100"}, {id: "9", areaID: "110109", area: "\u95e8\u5934\u6c9f\u533a", fatherID: "110100"}, {
        id: "10",
        areaID: "110111",
        area: "\u623f\u5c71\u533a",
        fatherID: "110100"
    }, {id: "11", areaID: "110112", area: "\u901a\u5dde\u533a", fatherID: "110100"}, {id: "12", areaID: "110113", area: "\u987a\u4e49\u533a", fatherID: "110100"}, {id: "13", areaID: "110114", area: "\u660c\u5e73\u533a", fatherID: "110100"}, {id: "14", areaID: "110115", area: "\u5927\u5174\u533a", fatherID: "110100"}, {id: "15", areaID: "110116", area: "\u6000\u67d4\u533a", fatherID: "110100"}, {id: "16", areaID: "110117", area: "\u5e73\u8c37\u533a", fatherID: "110100"}, {id: "17", areaID: "110228", area: "\u5bc6\u4e91\u53bf", fatherID: "110200"}, {id: "18", areaID: "110229", area: "\u5ef6\u5e86\u53bf", fatherID: "110200"}, {id: "19", areaID: "120101", area: "\u548c\u5e73\u533a", fatherID: "120100"}, {id: "20", areaID: "120102", area: "\u6cb3\u4e1c\u533a", fatherID: "120100"}, {
        id: "21",
        areaID: "120103",
        area: "\u6cb3\u897f\u533a",
        fatherID: "120100"
    }, {id: "22", areaID: "120104", area: "\u5357\u5f00\u533a", fatherID: "120100"}, {id: "23", areaID: "120105", area: "\u6cb3\u5317\u533a", fatherID: "120100"}, {id: "24", areaID: "120106", area: "\u7ea2\u6865\u533a", fatherID: "120100"}, {id: "25", areaID: "120107", area: "\u5858\u6cbd\u533a", fatherID: "120100"}, {id: "26", areaID: "120108", area: "\u6c49\u6cbd\u533a", fatherID: "120100"}, {id: "27", areaID: "120109", area: "\u5927\u6e2f\u533a", fatherID: "120100"}, {id: "28", areaID: "120110", area: "\u4e1c\u4e3d\u533a", fatherID: "120100"}, {id: "29", areaID: "120111", area: "\u897f\u9752\u533a", fatherID: "120100"}, {id: "30", areaID: "120112", area: "\u6d25\u5357\u533a", fatherID: "120100"}, {id: "31", areaID: "120113", area: "\u5317\u8fb0\u533a", fatherID: "120100"}, {
        id: "32",
        areaID: "120114",
        area: "\u6b66\u6e05\u533a",
        fatherID: "120100"
    }, {id: "33", areaID: "120115", area: "\u5b9d\u577b\u533a", fatherID: "120100"}, {id: "34", areaID: "120221", area: "\u5b81\u6cb3\u53bf", fatherID: "120200"}, {id: "35", areaID: "120223", area: "\u9759\u6d77\u53bf", fatherID: "120200"}, {id: "36", areaID: "120225", area: "\u84df\u3000\u53bf", fatherID: "120200"}, {id: "37", areaID: "130101", area: "\u5e02\u8f96\u533a", fatherID: "130100"}, {id: "38", areaID: "130102", area: "\u957f\u5b89\u533a", fatherID: "130100"}, {id: "39", areaID: "130103", area: "\u6865\u4e1c\u533a", fatherID: "130100"}, {id: "40", areaID: "130104", area: "\u6865\u897f\u533a", fatherID: "130100"}, {id: "41", areaID: "130105", area: "\u65b0\u534e\u533a", fatherID: "130100"}, {
        id: "42",
        areaID: "130107",
        area: "\u4e95\u9649\u77ff\u533a",
        fatherID: "130100"
    }, {id: "43", areaID: "130108", area: "\u88d5\u534e\u533a", fatherID: "130100"}, {id: "44", areaID: "130121", area: "\u4e95\u9649\u53bf", fatherID: "130100"}, {id: "45", areaID: "130123", area: "\u6b63\u5b9a\u53bf", fatherID: "130100"}, {id: "46", areaID: "130124", area: "\u683e\u57ce\u53bf", fatherID: "130100"}, {id: "47", areaID: "130125", area: "\u884c\u5510\u53bf", fatherID: "130100"}, {id: "48", areaID: "130126", area: "\u7075\u5bff\u53bf", fatherID: "130100"}, {id: "49", areaID: "130127", area: "\u9ad8\u9091\u53bf", fatherID: "130100"}, {id: "50", areaID: "130128", area: "\u6df1\u6cfd\u53bf", fatherID: "130100"}, {id: "51", areaID: "130129", area: "\u8d5e\u7687\u53bf", fatherID: "130100"}, {id: "52", areaID: "130130", area: "\u65e0\u6781\u53bf", fatherID: "130100"}, {
        id: "53",
        areaID: "130131",
        area: "\u5e73\u5c71\u53bf",
        fatherID: "130100"
    }, {id: "54", areaID: "130132", area: "\u5143\u6c0f\u53bf", fatherID: "130100"}, {id: "55", areaID: "130133", area: "\u8d75\u3000\u53bf", fatherID: "130100"}, {id: "56", areaID: "130181", area: "\u8f9b\u96c6\u5e02", fatherID: "130100"}, {id: "57", areaID: "130182", area: "\u85c1\u57ce\u5e02", fatherID: "130100"}, {id: "58", areaID: "130183", area: "\u664b\u5dde\u5e02", fatherID: "130100"}, {id: "59", areaID: "130184", area: "\u65b0\u4e50\u5e02", fatherID: "130100"}, {id: "60", areaID: "130185", area: "\u9e7f\u6cc9\u5e02", fatherID: "130100"}, {id: "61", areaID: "130201", area: "\u5e02\u8f96\u533a", fatherID: "130200"}, {id: "62", areaID: "130202", area: "\u8def\u5357\u533a", fatherID: "130200"}, {id: "63", areaID: "130203", area: "\u8def\u5317\u533a", fatherID: "130200"}, {
        id: "64",
        areaID: "130204",
        area: "\u53e4\u51b6\u533a",
        fatherID: "130200"
    }, {id: "65", areaID: "130205", area: "\u5f00\u5e73\u533a", fatherID: "130200"}, {id: "66", areaID: "130207", area: "\u4e30\u5357\u533a", fatherID: "130200"}, {id: "67", areaID: "130208", area: "\u4e30\u6da6\u533a", fatherID: "130200"}, {id: "68", areaID: "130223", area: "\u6ee6\u3000\u53bf", fatherID: "130200"}, {id: "69", areaID: "130224", area: "\u6ee6\u5357\u53bf", fatherID: "130200"}, {id: "70", areaID: "130225", area: "\u4e50\u4ead\u53bf", fatherID: "130200"}, {id: "71", areaID: "130227", area: "\u8fc1\u897f\u53bf", fatherID: "130200"}, {id: "72", areaID: "130229", area: "\u7389\u7530\u53bf", fatherID: "130200"}, {id: "73", areaID: "130230", area: "\u5510\u6d77\u53bf", fatherID: "130200"}, {id: "74", areaID: "130281", area: "\u9075\u5316\u5e02", fatherID: "130200"}, {
        id: "75",
        areaID: "130283",
        area: "\u8fc1\u5b89\u5e02",
        fatherID: "130200"
    }, {id: "76", areaID: "130301", area: "\u5e02\u8f96\u533a", fatherID: "130300"}, {id: "77", areaID: "130302", area: "\u6d77\u6e2f\u533a", fatherID: "130300"}, {id: "78", areaID: "130303", area: "\u5c71\u6d77\u5173\u533a", fatherID: "130300"}, {id: "79", areaID: "130304", area: "\u5317\u6234\u6cb3\u533a", fatherID: "130300"}, {id: "80", areaID: "130321", area: "\u9752\u9f99\u6ee1\u65cf\u81ea\u6cbb\u53bf", fatherID: "130300"}, {id: "81", areaID: "130322", area: "\u660c\u9ece\u53bf", fatherID: "130300"}, {id: "82", areaID: "130323", area: "\u629a\u5b81\u53bf", fatherID: "130300"}, {id: "83", areaID: "130324", area: "\u5362\u9f99\u53bf", fatherID: "130300"}, {id: "84", areaID: "130401", area: "\u5e02\u8f96\u533a", fatherID: "130400"}, {
        id: "85",
        areaID: "130402",
        area: "\u90af\u5c71\u533a",
        fatherID: "130400"
    }, {id: "86", areaID: "130403", area: "\u4e1b\u53f0\u533a", fatherID: "130400"}, {id: "87", areaID: "130404", area: "\u590d\u5174\u533a", fatherID: "130400"}, {id: "88", areaID: "130406", area: "\u5cf0\u5cf0\u77ff\u533a", fatherID: "130400"}, {id: "89", areaID: "130421", area: "\u90af\u90f8\u53bf", fatherID: "130400"}, {id: "90", areaID: "130423", area: "\u4e34\u6f33\u53bf", fatherID: "130400"}, {id: "91", areaID: "130424", area: "\u6210\u5b89\u53bf", fatherID: "130400"}, {id: "92", areaID: "130425", area: "\u5927\u540d\u53bf", fatherID: "130400"}, {id: "93", areaID: "130426", area: "\u6d89\u3000\u53bf", fatherID: "130400"}, {id: "94", areaID: "130427", area: "\u78c1\u3000\u53bf", fatherID: "130400"}, {
        id: "95",
        areaID: "130428",
        area: "\u80a5\u4e61\u53bf",
        fatherID: "130400"
    }, {id: "96", areaID: "130429", area: "\u6c38\u5e74\u53bf", fatherID: "130400"}, {id: "97", areaID: "130430", area: "\u90b1\u3000\u53bf", fatherID: "130400"}, {id: "98", areaID: "130431", area: "\u9e21\u6cfd\u53bf", fatherID: "130400"}, {id: "99", areaID: "130432", area: "\u5e7f\u5e73\u53bf", fatherID: "130400"}, {id: "100", areaID: "130433", area: "\u9986\u9676\u53bf", fatherID: "130400"}, {id: "101", areaID: "130434", area: "\u9b4f\u3000\u53bf", fatherID: "130400"}, {id: "102", areaID: "130435", area: "\u66f2\u5468\u53bf", fatherID: "130400"}, {id: "103", areaID: "130481", area: "\u6b66\u5b89\u5e02", fatherID: "130400"}, {id: "104", areaID: "130501", area: "\u5e02\u8f96\u533a", fatherID: "130500"}, {
        id: "105",
        areaID: "130502",
        area: "\u6865\u4e1c\u533a",
        fatherID: "130500"
    }, {id: "106", areaID: "130503", area: "\u6865\u897f\u533a", fatherID: "130500"}, {id: "107", areaID: "130521", area: "\u90a2\u53f0\u53bf", fatherID: "130500"}, {id: "108", areaID: "130522", area: "\u4e34\u57ce\u53bf", fatherID: "130500"}, {id: "109", areaID: "130523", area: "\u5185\u4e18\u53bf", fatherID: "130500"}, {id: "110", areaID: "130524", area: "\u67cf\u4e61\u53bf", fatherID: "130500"}, {id: "111", areaID: "130525", area: "\u9686\u5c27\u53bf", fatherID: "130500"}, {id: "112", areaID: "130526", area: "\u4efb\u3000\u53bf", fatherID: "130500"}, {id: "113", areaID: "130527", area: "\u5357\u548c\u53bf", fatherID: "130500"}, {id: "114", areaID: "130528", area: "\u5b81\u664b\u53bf", fatherID: "130500"}, {
        id: "115",
        areaID: "130529",
        area: "\u5de8\u9e7f\u53bf",
        fatherID: "130500"
    }, {id: "116", areaID: "130530", area: "\u65b0\u6cb3\u53bf", fatherID: "130500"}, {id: "117", areaID: "130531", area: "\u5e7f\u5b97\u53bf", fatherID: "130500"}, {id: "118", areaID: "130532", area: "\u5e73\u4e61\u53bf", fatherID: "130500"}, {id: "119", areaID: "130533", area: "\u5a01\u3000\u53bf", fatherID: "130500"}, {id: "120", areaID: "130534", area: "\u6e05\u6cb3\u53bf", fatherID: "130500"}, {id: "121", areaID: "130535", area: "\u4e34\u897f\u53bf", fatherID: "130500"}, {id: "122", areaID: "130581", area: "\u5357\u5bab\u5e02", fatherID: "130500"}, {id: "123", areaID: "130582", area: "\u6c99\u6cb3\u5e02", fatherID: "130500"}, {id: "124", areaID: "130601", area: "\u5e02\u8f96\u533a", fatherID: "130600"}, {
        id: "125",
        areaID: "130602",
        area: "\u65b0\u5e02\u533a",
        fatherID: "130600"
    }, {id: "126", areaID: "130603", area: "\u5317\u5e02\u533a", fatherID: "130600"}, {id: "127", areaID: "130604", area: "\u5357\u5e02\u533a", fatherID: "130600"}, {id: "128", areaID: "130621", area: "\u6ee1\u57ce\u53bf", fatherID: "130600"}, {id: "129", areaID: "130622", area: "\u6e05\u82d1\u53bf", fatherID: "130600"}, {id: "130", areaID: "130623", area: "\u6d9e\u6c34\u53bf", fatherID: "130600"}, {id: "131", areaID: "130624", area: "\u961c\u5e73\u53bf", fatherID: "130600"}, {id: "132", areaID: "130625", area: "\u5f90\u6c34\u53bf", fatherID: "130600"}, {id: "133", areaID: "130626", area: "\u5b9a\u5174\u53bf", fatherID: "130600"}, {id: "134", areaID: "130627", area: "\u5510\u3000\u53bf", fatherID: "130600"}, {
        id: "135",
        areaID: "130628",
        area: "\u9ad8\u9633\u53bf",
        fatherID: "130600"
    }, {id: "136", areaID: "130629", area: "\u5bb9\u57ce\u53bf", fatherID: "130600"}, {id: "137", areaID: "130630", area: "\u6d9e\u6e90\u53bf", fatherID: "130600"}, {id: "138", areaID: "130631", area: "\u671b\u90fd\u53bf", fatherID: "130600"}, {id: "139", areaID: "130632", area: "\u5b89\u65b0\u53bf", fatherID: "130600"}, {id: "140", areaID: "130633", area: "\u6613\u3000\u53bf", fatherID: "130600"}, {id: "141", areaID: "130634", area: "\u66f2\u9633\u53bf", fatherID: "130600"}, {id: "142", areaID: "130635", area: "\u8821\u3000\u53bf", fatherID: "130600"}, {id: "143", areaID: "130636", area: "\u987a\u5e73\u53bf", fatherID: "130600"}, {id: "144", areaID: "130637", area: "\u535a\u91ce\u53bf", fatherID: "130600"}, {
        id: "145",
        areaID: "130638",
        area: "\u96c4\u3000\u53bf",
        fatherID: "130600"
    }, {id: "146", areaID: "130681", area: "\u6dbf\u5dde\u5e02", fatherID: "130600"}, {id: "147", areaID: "130682", area: "\u5b9a\u5dde\u5e02", fatherID: "130600"}, {id: "148", areaID: "130683", area: "\u5b89\u56fd\u5e02", fatherID: "130600"}, {id: "149", areaID: "130684", area: "\u9ad8\u7891\u5e97\u5e02", fatherID: "130600"}, {id: "150", areaID: "130701", area: "\u5e02\u8f96\u533a", fatherID: "130700"}, {id: "151", areaID: "130702", area: "\u6865\u4e1c\u533a", fatherID: "130700"}, {id: "152", areaID: "130703", area: "\u6865\u897f\u533a", fatherID: "130700"}, {id: "153", areaID: "130705", area: "\u5ba3\u5316\u533a", fatherID: "130700"}, {id: "154", areaID: "130706", area: "\u4e0b\u82b1\u56ed\u533a", fatherID: "130700"}, {
        id: "155",
        areaID: "130721",
        area: "\u5ba3\u5316\u53bf",
        fatherID: "130700"
    }, {id: "156", areaID: "130722", area: "\u5f20\u5317\u53bf", fatherID: "130700"}, {id: "157", areaID: "130723", area: "\u5eb7\u4fdd\u53bf", fatherID: "130700"}, {id: "158", areaID: "130724", area: "\u6cbd\u6e90\u53bf", fatherID: "130700"}, {id: "159", areaID: "130725", area: "\u5c1a\u4e49\u53bf", fatherID: "130700"}, {id: "160", areaID: "130726", area: "\u851a\u3000\u53bf", fatherID: "130700"}, {id: "161", areaID: "130727", area: "\u9633\u539f\u53bf", fatherID: "130700"}, {id: "162", areaID: "130728", area: "\u6000\u5b89\u53bf", fatherID: "130700"}, {id: "163", areaID: "130729", area: "\u4e07\u5168\u53bf", fatherID: "130700"}, {id: "164", areaID: "130730", area: "\u6000\u6765\u53bf", fatherID: "130700"}, {
        id: "165",
        areaID: "130731",
        area: "\u6dbf\u9e7f\u53bf",
        fatherID: "130700"
    }, {id: "166", areaID: "130732", area: "\u8d64\u57ce\u53bf", fatherID: "130700"}, {id: "167", areaID: "130733", area: "\u5d07\u793c\u53bf", fatherID: "130700"}, {id: "168", areaID: "130801", area: "\u5e02\u8f96\u533a", fatherID: "130800"}, {id: "169", areaID: "130802", area: "\u53cc\u6865\u533a", fatherID: "130800"}, {id: "170", areaID: "130803", area: "\u53cc\u6ee6\u533a", fatherID: "130800"}, {id: "171", areaID: "130804", area: "\u9e70\u624b\u8425\u5b50\u77ff\u533a", fatherID: "130800"}, {id: "172", areaID: "130821", area: "\u627f\u5fb7\u53bf", fatherID: "130800"}, {id: "173", areaID: "130822", area: "\u5174\u9686\u53bf", fatherID: "130800"}, {id: "174", areaID: "130823", area: "\u5e73\u6cc9\u53bf", fatherID: "130800"}, {
        id: "175",
        areaID: "130824",
        area: "\u6ee6\u5e73\u53bf",
        fatherID: "130800"
    }, {id: "176", areaID: "130825", area: "\u9686\u5316\u53bf", fatherID: "130800"}, {id: "177", areaID: "130826", area: "\u4e30\u5b81\u6ee1\u65cf\u81ea\u6cbb\u53bf", fatherID: "130800"}, {id: "178", areaID: "130827", area: "\u5bbd\u57ce\u6ee1\u65cf\u81ea\u6cbb\u53bf", fatherID: "130800"}, {id: "179", areaID: "130828", area: "\u56f4\u573a\u6ee1\u65cf\u8499\u53e4\u65cf\u81ea\u6cbb\u53bf", fatherID: "130800"}, {id: "180", areaID: "130901", area: "\u5e02\u8f96\u533a", fatherID: "130900"}, {id: "181", areaID: "130902", area: "\u65b0\u534e\u533a", fatherID: "130900"}, {id: "182", areaID: "130903", area: "\u8fd0\u6cb3\u533a", fatherID: "130900"}, {id: "183", areaID: "130921", area: "\u6ca7\u3000\u53bf", fatherID: "130900"}, {
        id: "184",
        areaID: "130922",
        area: "\u9752\u3000\u53bf",
        fatherID: "130900"
    }, {id: "185", areaID: "130923", area: "\u4e1c\u5149\u53bf", fatherID: "130900"}, {id: "186", areaID: "130924", area: "\u6d77\u5174\u53bf", fatherID: "130900"}, {id: "187", areaID: "130925", area: "\u76d0\u5c71\u53bf", fatherID: "130900"}, {id: "188", areaID: "130926", area: "\u8083\u5b81\u53bf", fatherID: "130900"}, {id: "189", areaID: "130927", area: "\u5357\u76ae\u53bf", fatherID: "130900"}, {id: "190", areaID: "130928", area: "\u5434\u6865\u53bf", fatherID: "130900"}, {id: "191", areaID: "130929", area: "\u732e\u3000\u53bf", fatherID: "130900"}, {id: "192", areaID: "130930", area: "\u5b5f\u6751\u56de\u65cf\u81ea\u6cbb\u53bf", fatherID: "130900"}, {id: "193", areaID: "130981", area: "\u6cca\u5934\u5e02", fatherID: "130900"}, {
        id: "194",
        areaID: "130982",
        area: "\u4efb\u4e18\u5e02",
        fatherID: "130900"
    }, {id: "195", areaID: "130983", area: "\u9ec4\u9a85\u5e02", fatherID: "130900"}, {id: "196", areaID: "130984", area: "\u6cb3\u95f4\u5e02", fatherID: "130900"}, {id: "197", areaID: "131001", area: "\u5e02\u8f96\u533a", fatherID: "131000"}, {id: "198", areaID: "131002", area: "\u5b89\u6b21\u533a", fatherID: "131000"}, {id: "199", areaID: "131003", area: "\u5e7f\u9633\u533a", fatherID: "131000"}, {id: "200", areaID: "131022", area: "\u56fa\u5b89\u53bf", fatherID: "131000"}, {id: "201", areaID: "131023", area: "\u6c38\u6e05\u53bf", fatherID: "131000"}, {id: "202", areaID: "131024", area: "\u9999\u6cb3\u53bf", fatherID: "131000"}, {id: "203", areaID: "131025", area: "\u5927\u57ce\u53bf", fatherID: "131000"}, {
        id: "204",
        areaID: "131026",
        area: "\u6587\u5b89\u53bf",
        fatherID: "131000"
    }, {id: "205", areaID: "131028", area: "\u5927\u5382\u56de\u65cf\u81ea\u6cbb\u53bf", fatherID: "131000"}, {id: "206", areaID: "131081", area: "\u9738\u5dde\u5e02", fatherID: "131000"}, {id: "207", areaID: "131082", area: "\u4e09\u6cb3\u5e02", fatherID: "131000"}, {id: "208", areaID: "131101", area: "\u5e02\u8f96\u533a", fatherID: "131100"}, {id: "209", areaID: "131102", area: "\u6843\u57ce\u533a", fatherID: "131100"}, {id: "210", areaID: "131121", area: "\u67a3\u5f3a\u53bf", fatherID: "131100"}, {id: "211", areaID: "131122", area: "\u6b66\u9091\u53bf", fatherID: "131100"}, {id: "212", areaID: "131123", area: "\u6b66\u5f3a\u53bf", fatherID: "131100"}, {id: "213", areaID: "131124", area: "\u9976\u9633\u53bf", fatherID: "131100"}, {
        id: "214",
        areaID: "131125",
        area: "\u5b89\u5e73\u53bf",
        fatherID: "131100"
    }, {id: "215", areaID: "131126", area: "\u6545\u57ce\u53bf", fatherID: "131100"}, {id: "216", areaID: "131127", area: "\u666f\u3000\u53bf", fatherID: "131100"}, {id: "217", areaID: "131128", area: "\u961c\u57ce\u53bf", fatherID: "131100"}, {id: "218", areaID: "131181", area: "\u5180\u5dde\u5e02", fatherID: "131100"}, {id: "219", areaID: "131182", area: "\u6df1\u5dde\u5e02", fatherID: "131100"}, {id: "220", areaID: "140101", area: "\u5e02\u8f96\u533a", fatherID: "140100"}, {id: "221", areaID: "140105", area: "\u5c0f\u5e97\u533a", fatherID: "140100"}, {id: "222", areaID: "140106", area: "\u8fce\u6cfd\u533a", fatherID: "140100"}, {id: "223", areaID: "140107", area: "\u674f\u82b1\u5cad\u533a", fatherID: "140100"}, {
        id: "224",
        areaID: "140108",
        area: "\u5c16\u8349\u576a\u533a",
        fatherID: "140100"
    }, {id: "225", areaID: "140109", area: "\u4e07\u67cf\u6797\u533a", fatherID: "140100"}, {id: "226", areaID: "140110", area: "\u664b\u6e90\u533a", fatherID: "140100"}, {id: "227", areaID: "140121", area: "\u6e05\u5f90\u53bf", fatherID: "140100"}, {id: "228", areaID: "140122", area: "\u9633\u66f2\u53bf", fatherID: "140100"}, {id: "229", areaID: "140123", area: "\u5a04\u70e6\u53bf", fatherID: "140100"}, {id: "230", areaID: "140181", area: "\u53e4\u4ea4\u5e02", fatherID: "140100"}, {id: "231", areaID: "140201", area: "\u5e02\u8f96\u533a", fatherID: "140200"}, {id: "232", areaID: "140202", area: "\u57ce\u3000\u533a", fatherID: "140200"}, {id: "233", areaID: "140203", area: "\u77ff\u3000\u533a", fatherID: "140200"}, {
        id: "234",
        areaID: "140211",
        area: "\u5357\u90ca\u533a",
        fatherID: "140200"
    }, {id: "235", areaID: "140212", area: "\u65b0\u8363\u533a", fatherID: "140200"}, {id: "236", areaID: "140221", area: "\u9633\u9ad8\u53bf", fatherID: "140200"}, {id: "237", areaID: "140222", area: "\u5929\u9547\u53bf", fatherID: "140200"}, {id: "238", areaID: "140223", area: "\u5e7f\u7075\u53bf", fatherID: "140200"}, {id: "239", areaID: "140224", area: "\u7075\u4e18\u53bf", fatherID: "140200"}, {id: "240", areaID: "140225", area: "\u6d51\u6e90\u53bf", fatherID: "140200"}, {id: "241", areaID: "140226", area: "\u5de6\u4e91\u53bf", fatherID: "140200"}, {id: "242", areaID: "140227", area: "\u5927\u540c\u53bf", fatherID: "140200"}, {id: "243", areaID: "140301", area: "\u5e02\u8f96\u533a", fatherID: "140300"}, {
        id: "244",
        areaID: "140302",
        area: "\u57ce\u3000\u533a",
        fatherID: "140300"
    }, {id: "245", areaID: "140303", area: "\u77ff\u3000\u533a", fatherID: "140300"}, {id: "246", areaID: "140311", area: "\u90ca\u3000\u533a", fatherID: "140300"}, {id: "247", areaID: "140321", area: "\u5e73\u5b9a\u53bf", fatherID: "140300"}, {id: "248", areaID: "140322", area: "\u76c2\u3000\u53bf", fatherID: "140300"}, {id: "249", areaID: "140401", area: "\u5e02\u8f96\u533a", fatherID: "140400"}, {id: "250", areaID: "140402", area: "\u57ce\u3000\u533a", fatherID: "140400"}, {id: "251", areaID: "140411", area: "\u90ca\u3000\u533a", fatherID: "140400"}, {id: "252", areaID: "140421", area: "\u957f\u6cbb\u53bf", fatherID: "140400"}, {id: "253", areaID: "140423", area: "\u8944\u57a3\u53bf", fatherID: "140400"}, {
        id: "254",
        areaID: "140424",
        area: "\u5c6f\u7559\u53bf",
        fatherID: "140400"
    }, {id: "255", areaID: "140425", area: "\u5e73\u987a\u53bf", fatherID: "140400"}, {id: "256", areaID: "140426", area: "\u9ece\u57ce\u53bf", fatherID: "140400"}, {id: "257", areaID: "140427", area: "\u58f6\u5173\u53bf", fatherID: "140400"}, {id: "258", areaID: "140428", area: "\u957f\u5b50\u53bf", fatherID: "140400"}, {id: "259", areaID: "140429", area: "\u6b66\u4e61\u53bf", fatherID: "140400"}, {id: "260", areaID: "140430", area: "\u6c81\u3000\u53bf", fatherID: "140400"}, {id: "261", areaID: "140431", area: "\u6c81\u6e90\u53bf", fatherID: "140400"}, {id: "262", areaID: "140481", area: "\u6f5e\u57ce\u5e02", fatherID: "140400"}, {id: "263", areaID: "140501", area: "\u5e02\u8f96\u533a", fatherID: "140500"}, {
        id: "264",
        areaID: "140502",
        area: "\u57ce\u3000\u533a",
        fatherID: "140500"
    }, {id: "265", areaID: "140521", area: "\u6c81\u6c34\u53bf", fatherID: "140500"}, {id: "266", areaID: "140522", area: "\u9633\u57ce\u53bf", fatherID: "140500"}, {id: "267", areaID: "140524", area: "\u9675\u5ddd\u53bf", fatherID: "140500"}, {id: "268", areaID: "140525", area: "\u6cfd\u5dde\u53bf", fatherID: "140500"}, {id: "269", areaID: "140581", area: "\u9ad8\u5e73\u5e02", fatherID: "140500"}, {id: "270", areaID: "140601", area: "\u5e02\u8f96\u533a", fatherID: "140600"}, {id: "271", areaID: "140602", area: "\u6714\u57ce\u533a", fatherID: "140600"}, {id: "272", areaID: "140603", area: "\u5e73\u9c81\u533a", fatherID: "140600"}, {id: "273", areaID: "140621", area: "\u5c71\u9634\u53bf", fatherID: "140600"}, {
        id: "274",
        areaID: "140622",
        area: "\u5e94\u3000\u53bf",
        fatherID: "140600"
    }, {id: "275", areaID: "140623", area: "\u53f3\u7389\u53bf", fatherID: "140600"}, {id: "276", areaID: "140624", area: "\u6000\u4ec1\u53bf", fatherID: "140600"}, {id: "277", areaID: "140701", area: "\u5e02\u8f96\u533a", fatherID: "140700"}, {id: "278", areaID: "140702", area: "\u6986\u6b21\u533a", fatherID: "140700"}, {id: "279", areaID: "140721", area: "\u6986\u793e\u53bf", fatherID: "140700"}, {id: "280", areaID: "140722", area: "\u5de6\u6743\u53bf", fatherID: "140700"}, {id: "281", areaID: "140723", area: "\u548c\u987a\u53bf", fatherID: "140700"}, {id: "282", areaID: "140724", area: "\u6614\u9633\u53bf", fatherID: "140700"}, {id: "283", areaID: "140725", area: "\u5bff\u9633\u53bf", fatherID: "140700"}, {
        id: "284",
        areaID: "140726",
        area: "\u592a\u8c37\u53bf",
        fatherID: "140700"
    }, {id: "285", areaID: "140727", area: "\u7941\u3000\u53bf", fatherID: "140700"}, {id: "286", areaID: "140728", area: "\u5e73\u9065\u53bf", fatherID: "140700"}, {id: "287", areaID: "140729", area: "\u7075\u77f3\u53bf", fatherID: "140700"}, {id: "288", areaID: "140781", area: "\u4ecb\u4f11\u5e02", fatherID: "140700"}, {id: "289", areaID: "140801", area: "\u5e02\u8f96\u533a", fatherID: "140800"}, {id: "290", areaID: "140802", area: "\u76d0\u6e56\u533a", fatherID: "140800"}, {id: "291", areaID: "140821", area: "\u4e34\u7317\u53bf", fatherID: "140800"}, {id: "292", areaID: "140822", area: "\u4e07\u8363\u53bf", fatherID: "140800"}, {id: "293", areaID: "140823", area: "\u95fb\u559c\u53bf", fatherID: "140800"}, {
        id: "294",
        areaID: "140824",
        area: "\u7a37\u5c71\u53bf",
        fatherID: "140800"
    }, {id: "295", areaID: "140825", area: "\u65b0\u7edb\u53bf", fatherID: "140800"}, {id: "296", areaID: "140826", area: "\u7edb\u3000\u53bf", fatherID: "140800"}, {id: "297", areaID: "140827", area: "\u57a3\u66f2\u53bf", fatherID: "140800"}, {id: "298", areaID: "140828", area: "\u590f\u3000\u53bf", fatherID: "140800"}, {id: "299", areaID: "140829", area: "\u5e73\u9646\u53bf", fatherID: "140800"}, {id: "300", areaID: "140830", area: "\u82ae\u57ce\u53bf", fatherID: "140800"}, {id: "301", areaID: "140881", area: "\u6c38\u6d4e\u5e02", fatherID: "140800"}, {id: "302", areaID: "140882", area: "\u6cb3\u6d25\u5e02", fatherID: "140800"}, {id: "303", areaID: "140901", area: "\u5e02\u8f96\u533a", fatherID: "140900"}, {
        id: "304",
        areaID: "140902",
        area: "\u5ffb\u5e9c\u533a",
        fatherID: "140900"
    }, {id: "305", areaID: "140921", area: "\u5b9a\u8944\u53bf", fatherID: "140900"}, {id: "306", areaID: "140922", area: "\u4e94\u53f0\u53bf", fatherID: "140900"}, {id: "307", areaID: "140923", area: "\u4ee3\u3000\u53bf", fatherID: "140900"}, {id: "308", areaID: "140924", area: "\u7e41\u5cd9\u53bf", fatherID: "140900"}, {id: "309", areaID: "140925", area: "\u5b81\u6b66\u53bf", fatherID: "140900"}, {id: "310", areaID: "140926", area: "\u9759\u4e50\u53bf", fatherID: "140900"}, {id: "311", areaID: "140927", area: "\u795e\u6c60\u53bf", fatherID: "140900"}, {id: "312", areaID: "140928", area: "\u4e94\u5be8\u53bf", fatherID: "140900"}, {id: "313", areaID: "140929", area: "\u5ca2\u5c9a\u53bf", fatherID: "140900"}, {
        id: "314",
        areaID: "140930",
        area: "\u6cb3\u66f2\u53bf",
        fatherID: "140900"
    }, {id: "315", areaID: "140931", area: "\u4fdd\u5fb7\u53bf", fatherID: "140900"}, {id: "316", areaID: "140932", area: "\u504f\u5173\u53bf", fatherID: "140900"}, {id: "317", areaID: "140981", area: "\u539f\u5e73\u5e02", fatherID: "140900"}, {id: "318", areaID: "141001", area: "\u5e02\u8f96\u533a", fatherID: "141000"}, {id: "319", areaID: "141002", area: "\u5c27\u90fd\u533a", fatherID: "141000"}, {id: "320", areaID: "141021", area: "\u66f2\u6c83\u53bf", fatherID: "141000"}, {id: "321", areaID: "141022", area: "\u7ffc\u57ce\u53bf", fatherID: "141000"}, {id: "322", areaID: "141023", area: "\u8944\u6c7e\u53bf", fatherID: "141000"}, {id: "323", areaID: "141024", area: "\u6d2a\u6d1e\u53bf", fatherID: "141000"}, {
        id: "324",
        areaID: "141025",
        area: "\u53e4\u3000\u53bf",
        fatherID: "141000"
    }, {id: "325", areaID: "141026", area: "\u5b89\u6cfd\u53bf", fatherID: "141000"}, {id: "326", areaID: "141027", area: "\u6d6e\u5c71\u53bf", fatherID: "141000"}, {id: "327", areaID: "141028", area: "\u5409\u3000\u53bf", fatherID: "141000"}, {id: "328", areaID: "141029", area: "\u4e61\u5b81\u53bf", fatherID: "141000"}, {id: "329", areaID: "141030", area: "\u5927\u5b81\u53bf", fatherID: "141000"}, {id: "330", areaID: "141031", area: "\u96b0\u3000\u53bf", fatherID: "141000"}, {id: "331", areaID: "141032", area: "\u6c38\u548c\u53bf", fatherID: "141000"}, {id: "332", areaID: "141033", area: "\u84b2\u3000\u53bf", fatherID: "141000"}, {id: "333", areaID: "141034", area: "\u6c7e\u897f\u53bf", fatherID: "141000"}, {
        id: "334",
        areaID: "141081",
        area: "\u4faf\u9a6c\u5e02",
        fatherID: "141000"
    }, {id: "335", areaID: "141082", area: "\u970d\u5dde\u5e02", fatherID: "141000"}, {id: "336", areaID: "141101", area: "\u5e02\u8f96\u533a", fatherID: "141100"}, {id: "337", areaID: "141102", area: "\u79bb\u77f3\u533a", fatherID: "141100"}, {id: "338", areaID: "141121", area: "\u6587\u6c34\u53bf", fatherID: "141100"}, {id: "339", areaID: "141122", area: "\u4ea4\u57ce\u53bf", fatherID: "141100"}, {id: "340", areaID: "141123", area: "\u5174\u3000\u53bf", fatherID: "141100"}, {id: "341", areaID: "141124", area: "\u4e34\u3000\u53bf", fatherID: "141100"}, {id: "342", areaID: "141125", area: "\u67f3\u6797\u53bf", fatherID: "141100"}, {id: "343", areaID: "141126", area: "\u77f3\u697c\u53bf", fatherID: "141100"}, {
        id: "344",
        areaID: "141127",
        area: "\u5c9a\u3000\u53bf",
        fatherID: "141100"
    }, {id: "345", areaID: "141128", area: "\u65b9\u5c71\u53bf", fatherID: "141100"}, {id: "346", areaID: "141129", area: "\u4e2d\u9633\u53bf", fatherID: "141100"}, {id: "347", areaID: "141130", area: "\u4ea4\u53e3\u53bf", fatherID: "141100"}, {id: "348", areaID: "141181", area: "\u5b5d\u4e49\u5e02", fatherID: "141100"}, {id: "349", areaID: "141182", area: "\u6c7e\u9633\u5e02", fatherID: "141100"}, {id: "350", areaID: "150101", area: "\u5e02\u8f96\u533a", fatherID: "150100"}, {id: "351", areaID: "150102", area: "\u65b0\u57ce\u533a", fatherID: "150100"}, {id: "352", areaID: "150103", area: "\u56de\u6c11\u533a", fatherID: "150100"}, {id: "353", areaID: "150104", area: "\u7389\u6cc9\u533a", fatherID: "150100"}, {
        id: "354",
        areaID: "150105",
        area: "\u8d5b\u7f55\u533a",
        fatherID: "150100"
    }, {id: "355", areaID: "150121", area: "\u571f\u9ed8\u7279\u5de6\u65d7", fatherID: "150100"}, {id: "356", areaID: "150122", area: "\u6258\u514b\u6258\u53bf", fatherID: "150100"}, {id: "357", areaID: "150123", area: "\u548c\u6797\u683c\u5c14\u53bf", fatherID: "150100"}, {id: "358", areaID: "150124", area: "\u6e05\u6c34\u6cb3\u53bf", fatherID: "150100"}, {id: "359", areaID: "150125", area: "\u6b66\u5ddd\u53bf", fatherID: "150100"}, {id: "360", areaID: "150201", area: "\u5e02\u8f96\u533a", fatherID: "150200"}, {id: "361", areaID: "150202", area: "\u4e1c\u6cb3\u533a", fatherID: "150200"}, {id: "362", areaID: "150203", area: "\u6606\u90fd\u4ed1\u533a", fatherID: "150200"}, {id: "363", areaID: "150204", area: "\u9752\u5c71\u533a", fatherID: "150200"}, {
        id: "364",
        areaID: "150205",
        area: "\u77f3\u62d0\u533a",
        fatherID: "150200"
    }, {id: "365", areaID: "150206", area: "\u767d\u4e91\u77ff\u533a", fatherID: "150200"}, {id: "366", areaID: "150207", area: "\u4e5d\u539f\u533a", fatherID: "150200"}, {id: "367", areaID: "150221", area: "\u571f\u9ed8\u7279\u53f3\u65d7", fatherID: "150200"}, {id: "368", areaID: "150222", area: "\u56fa\u9633\u53bf", fatherID: "150200"}, {id: "369", areaID: "150223", area: "\u8fbe\u5c14\u7f55\u8302\u660e\u5b89\u8054\u5408\u65d7", fatherID: "150200"}, {id: "370", areaID: "150301", area: "\u5e02\u8f96\u533a", fatherID: "150300"}, {id: "371", areaID: "150302", area: "\u6d77\u52c3\u6e7e\u533a", fatherID: "150300"}, {id: "372", areaID: "150303", area: "\u6d77\u5357\u533a", fatherID: "150300"}, {id: "373", areaID: "150304", area: "\u4e4c\u8fbe\u533a", fatherID: "150300"}, {
        id: "374",
        areaID: "150401",
        area: "\u5e02\u8f96\u533a",
        fatherID: "150400"
    }, {id: "375", areaID: "150402", area: "\u7ea2\u5c71\u533a", fatherID: "150400"}, {id: "376", areaID: "150403", area: "\u5143\u5b9d\u5c71\u533a", fatherID: "150400"}, {id: "377", areaID: "150404", area: "\u677e\u5c71\u533a", fatherID: "150400"}, {id: "378", areaID: "150421", area: "\u963f\u9c81\u79d1\u5c14\u6c81\u65d7", fatherID: "150400"}, {id: "379", areaID: "150422", area: "\u5df4\u6797\u5de6\u65d7", fatherID: "150400"}, {id: "380", areaID: "150423", area: "\u5df4\u6797\u53f3\u65d7", fatherID: "150400"}, {id: "381", areaID: "150424", area: "\u6797\u897f\u53bf", fatherID: "150400"}, {id: "382", areaID: "150425", area: "\u514b\u4ec0\u514b\u817e\u65d7", fatherID: "150400"}, {id: "383", areaID: "150426", area: "\u7fc1\u725b\u7279\u65d7", fatherID: "150400"}, {
        id: "384",
        areaID: "150428",
        area: "\u5580\u5587\u6c81\u65d7",
        fatherID: "150400"
    }, {id: "385", areaID: "150429", area: "\u5b81\u57ce\u53bf", fatherID: "150400"}, {id: "386", areaID: "150430", area: "\u6556\u6c49\u65d7", fatherID: "150400"}, {id: "387", areaID: "150501", area: "\u5e02\u8f96\u533a", fatherID: "150500"}, {id: "388", areaID: "150502", area: "\u79d1\u5c14\u6c81\u533a", fatherID: "150500"}, {id: "389", areaID: "150521", area: "\u79d1\u5c14\u6c81\u5de6\u7ffc\u4e2d\u65d7", fatherID: "150500"}, {id: "390", areaID: "150522", area: "\u79d1\u5c14\u6c81\u5de6\u7ffc\u540e\u65d7", fatherID: "150500"}, {id: "391", areaID: "150523", area: "\u5f00\u9c81\u53bf", fatherID: "150500"}, {id: "392", areaID: "150524", area: "\u5e93\u4f26\u65d7", fatherID: "150500"}, {id: "393", areaID: "150525", area: "\u5948\u66fc\u65d7", fatherID: "150500"}, {
        id: "394",
        areaID: "150526",
        area: "\u624e\u9c81\u7279\u65d7",
        fatherID: "150500"
    }, {id: "395", areaID: "150581", area: "\u970d\u6797\u90ed\u52d2\u5e02", fatherID: "150500"}, {id: "396", areaID: "150602", area: "\u4e1c\u80dc\u533a", fatherID: "150600"}, {id: "397", areaID: "150621", area: "\u8fbe\u62c9\u7279\u65d7", fatherID: "150600"}, {id: "398", areaID: "150622", area: "\u51c6\u683c\u5c14\u65d7", fatherID: "150600"}, {id: "399", areaID: "150623", area: "\u9102\u6258\u514b\u524d\u65d7", fatherID: "150600"}, {id: "400", areaID: "150624", area: "\u9102\u6258\u514b\u65d7", fatherID: "150600"}, {id: "401", areaID: "150625", area: "\u676d\u9526\u65d7", fatherID: "150600"}, {id: "402", areaID: "150626", area: "\u4e4c\u5ba1\u65d7", fatherID: "150600"}, {id: "403", areaID: "150627", area: "\u4f0a\u91d1\u970d\u6d1b\u65d7", fatherID: "150600"}, {
        id: "404",
        areaID: "150701",
        area: "\u5e02\u8f96\u533a",
        fatherID: "150700"
    }, {id: "405", areaID: "150702", area: "\u6d77\u62c9\u5c14\u533a", fatherID: "150700"}, {id: "406", areaID: "150721", area: "\u963f\u8363\u65d7", fatherID: "150700"}, {id: "407", areaID: "150722", area: "\u83ab\u529b\u8fbe\u74e6\u8fbe\u65a1\u5c14\u65cf\u81ea\u6cbb\u65d7", fatherID: "150700"}, {id: "408", areaID: "150723", area: "\u9102\u4f26\u6625\u81ea\u6cbb\u65d7", fatherID: "150700"}, {id: "409", areaID: "150724", area: "\u9102\u6e29\u514b\u65cf\u81ea\u6cbb\u65d7", fatherID: "150700"}, {id: "410", areaID: "150725", area: "\u9648\u5df4\u5c14\u864e\u65d7", fatherID: "150700"}, {id: "411", areaID: "150726", area: "\u65b0\u5df4\u5c14\u864e\u5de6\u65d7", fatherID: "150700"}, {id: "412", areaID: "150727", area: "\u65b0\u5df4\u5c14\u864e\u53f3\u65d7", fatherID: "150700"}, {
        id: "413",
        areaID: "150781",
        area: "\u6ee1\u6d32\u91cc\u5e02",
        fatherID: "150700"
    }, {id: "414", areaID: "150782", area: "\u7259\u514b\u77f3\u5e02", fatherID: "150700"}, {id: "415", areaID: "150783", area: "\u624e\u5170\u5c6f\u5e02", fatherID: "150700"}, {id: "416", areaID: "150784", area: "\u989d\u5c14\u53e4\u7eb3\u5e02", fatherID: "150700"}, {id: "417", areaID: "150785", area: "\u6839\u6cb3\u5e02", fatherID: "150700"}, {id: "418", areaID: "150801", area: "\u5e02\u8f96\u533a", fatherID: "150800"}, {id: "419", areaID: "150802", area: "\u4e34\u6cb3\u533a", fatherID: "150800"}, {id: "420", areaID: "150821", area: "\u4e94\u539f\u53bf", fatherID: "150800"}, {id: "421", areaID: "150822", area: "\u78f4\u53e3\u53bf", fatherID: "150800"}, {id: "422", areaID: "150823", area: "\u4e4c\u62c9\u7279\u524d\u65d7", fatherID: "150800"}, {
        id: "423",
        areaID: "150824",
        area: "\u4e4c\u62c9\u7279\u4e2d\u65d7",
        fatherID: "150800"
    }, {id: "424", areaID: "150825", area: "\u4e4c\u62c9\u7279\u540e\u65d7", fatherID: "150800"}, {id: "425", areaID: "150826", area: "\u676d\u9526\u540e\u65d7", fatherID: "150800"}, {id: "426", areaID: "150901", area: "\u5e02\u8f96\u533a", fatherID: "150900"}, {id: "427", areaID: "150902", area: "\u96c6\u5b81\u533a", fatherID: "150900"}, {id: "428", areaID: "150921", area: "\u5353\u8d44\u53bf", fatherID: "150900"}, {id: "429", areaID: "150922", area: "\u5316\u5fb7\u53bf", fatherID: "150900"}, {id: "430", areaID: "150923", area: "\u5546\u90fd\u53bf", fatherID: "150900"}, {id: "431", areaID: "150924", area: "\u5174\u548c\u53bf", fatherID: "150900"}, {id: "432", areaID: "150925", area: "\u51c9\u57ce\u53bf", fatherID: "150900"}, {
        id: "433",
        areaID: "150926",
        area: "\u5bdf\u54c8\u5c14\u53f3\u7ffc\u524d\u65d7",
        fatherID: "150900"
    }, {id: "434", areaID: "150927", area: "\u5bdf\u54c8\u5c14\u53f3\u7ffc\u4e2d\u65d7", fatherID: "150900"}, {id: "435", areaID: "150928", area: "\u5bdf\u54c8\u5c14\u53f3\u7ffc\u540e\u65d7", fatherID: "150900"}, {id: "436", areaID: "150929", area: "\u56db\u5b50\u738b\u65d7", fatherID: "150900"}, {id: "437", areaID: "150981", area: "\u4e30\u9547\u5e02", fatherID: "150900"}, {id: "438", areaID: "152201", area: "\u4e4c\u5170\u6d69\u7279\u5e02", fatherID: "152200"}, {id: "439", areaID: "152202", area: "\u963f\u5c14\u5c71\u5e02", fatherID: "152200"}, {id: "440", areaID: "152221", area: "\u79d1\u5c14\u6c81\u53f3\u7ffc\u524d\u65d7", fatherID: "152200"}, {id: "441", areaID: "152222", area: "\u79d1\u5c14\u6c81\u53f3\u7ffc\u4e2d\u65d7", fatherID: "152200"}, {
        id: "442",
        areaID: "152223",
        area: "\u624e\u8d49\u7279\u65d7",
        fatherID: "152200"
    }, {id: "443", areaID: "152224", area: "\u7a81\u6cc9\u53bf", fatherID: "152200"}, {id: "444", areaID: "152501", area: "\u4e8c\u8fde\u6d69\u7279\u5e02", fatherID: "152500"}, {id: "445", areaID: "152502", area: "\u9521\u6797\u6d69\u7279\u5e02", fatherID: "152500"}, {id: "446", areaID: "152522", area: "\u963f\u5df4\u560e\u65d7", fatherID: "152500"}, {id: "447", areaID: "152523", area: "\u82cf\u5c3c\u7279\u5de6\u65d7", fatherID: "152500"}, {id: "448", areaID: "152524", area: "\u82cf\u5c3c\u7279\u53f3\u65d7", fatherID: "152500"}, {id: "449", areaID: "152525", area: "\u4e1c\u4e4c\u73e0\u7a46\u6c81\u65d7", fatherID: "152500"}, {id: "450", areaID: "152526", area: "\u897f\u4e4c\u73e0\u7a46\u6c81\u65d7", fatherID: "152500"}, {
        id: "451",
        areaID: "152527",
        area: "\u592a\u4ec6\u5bfa\u65d7",
        fatherID: "152500"
    }, {id: "452", areaID: "152528", area: "\u9576\u9ec4\u65d7", fatherID: "152500"}, {id: "453", areaID: "152529", area: "\u6b63\u9576\u767d\u65d7", fatherID: "152500"}, {id: "454", areaID: "152530", area: "\u6b63\u84dd\u65d7", fatherID: "152500"}, {id: "455", areaID: "152531", area: "\u591a\u4f26\u53bf", fatherID: "152500"}, {id: "456", areaID: "152921", area: "\u963f\u62c9\u5584\u5de6\u65d7", fatherID: "152900"}, {id: "457", areaID: "152922", area: "\u963f\u62c9\u5584\u53f3\u65d7", fatherID: "152900"}, {id: "458", areaID: "152923", area: "\u989d\u6d4e\u7eb3\u65d7", fatherID: "152900"}, {id: "459", areaID: "210101", area: "\u5e02\u8f96\u533a", fatherID: "210100"}, {id: "460", areaID: "210102", area: "\u548c\u5e73\u533a", fatherID: "210100"}, {
        id: "461",
        areaID: "210103",
        area: "\u6c88\u6cb3\u533a",
        fatherID: "210100"
    }, {id: "462", areaID: "210104", area: "\u5927\u4e1c\u533a", fatherID: "210100"}, {id: "463", areaID: "210105", area: "\u7687\u59d1\u533a", fatherID: "210100"}, {id: "464", areaID: "210106", area: "\u94c1\u897f\u533a", fatherID: "210100"}, {id: "465", areaID: "210111", area: "\u82cf\u5bb6\u5c6f\u533a", fatherID: "210100"}, {id: "466", areaID: "210112", area: "\u4e1c\u9675\u533a", fatherID: "210100"}, {id: "467", areaID: "210113", area: "\u65b0\u57ce\u5b50\u533a", fatherID: "210100"}, {id: "468", areaID: "210114", area: "\u4e8e\u6d2a\u533a", fatherID: "210100"}, {id: "469", areaID: "210122", area: "\u8fbd\u4e2d\u53bf", fatherID: "210100"}, {id: "470", areaID: "210123", area: "\u5eb7\u5e73\u53bf", fatherID: "210100"}, {
        id: "471",
        areaID: "210124",
        area: "\u6cd5\u5e93\u53bf",
        fatherID: "210100"
    }, {id: "472", areaID: "210181", area: "\u65b0\u6c11\u5e02", fatherID: "210100"}, {id: "473", areaID: "210201", area: "\u5e02\u8f96\u533a", fatherID: "210200"}, {id: "474", areaID: "210202", area: "\u4e2d\u5c71\u533a", fatherID: "210200"}, {id: "475", areaID: "210203", area: "\u897f\u5c97\u533a", fatherID: "210200"}, {id: "476", areaID: "210204", area: "\u6c99\u6cb3\u53e3\u533a", fatherID: "210200"}, {id: "477", areaID: "210211", area: "\u7518\u4e95\u5b50\u533a", fatherID: "210200"}, {id: "478", areaID: "210212", area: "\u65c5\u987a\u53e3\u533a", fatherID: "210200"}, {id: "479", areaID: "210213", area: "\u91d1\u5dde\u533a", fatherID: "210200"}, {id: "480", areaID: "210224", area: "\u957f\u6d77\u53bf", fatherID: "210200"}, {
        id: "481",
        areaID: "210281",
        area: "\u74e6\u623f\u5e97\u5e02",
        fatherID: "210200"
    }, {id: "482", areaID: "210282", area: "\u666e\u5170\u5e97\u5e02", fatherID: "210200"}, {id: "483", areaID: "210283", area: "\u5e84\u6cb3\u5e02", fatherID: "210200"}, {id: "484", areaID: "210301", area: "\u5e02\u8f96\u533a", fatherID: "210300"}, {id: "485", areaID: "210302", area: "\u94c1\u4e1c\u533a", fatherID: "210300"}, {id: "486", areaID: "210303", area: "\u94c1\u897f\u533a", fatherID: "210300"}, {id: "487", areaID: "210304", area: "\u7acb\u5c71\u533a", fatherID: "210300"}, {id: "488", areaID: "210311", area: "\u5343\u5c71\u533a", fatherID: "210300"}, {id: "489", areaID: "210321", area: "\u53f0\u5b89\u53bf", fatherID: "210300"}, {id: "490", areaID: "210323", area: "\u5cab\u5ca9\u6ee1\u65cf\u81ea\u6cbb\u53bf", fatherID: "210300"}, {
        id: "491",
        areaID: "210381",
        area: "\u6d77\u57ce\u5e02",
        fatherID: "210300"
    }, {id: "492", areaID: "210401", area: "\u5e02\u8f96\u533a", fatherID: "210400"}, {id: "493", areaID: "210402", area: "\u65b0\u629a\u533a", fatherID: "210400"}, {id: "494", areaID: "210403", area: "\u4e1c\u6d32\u533a", fatherID: "210400"}, {id: "495", areaID: "210404", area: "\u671b\u82b1\u533a", fatherID: "210400"}, {id: "496", areaID: "210411", area: "\u987a\u57ce\u533a", fatherID: "210400"}, {id: "497", areaID: "210421", area: "\u629a\u987a\u53bf", fatherID: "210400"}, {id: "498", areaID: "210422", area: "\u65b0\u5bbe\u6ee1\u65cf\u81ea\u6cbb\u53bf", fatherID: "210400"}, {id: "499", areaID: "210423", area: "\u6e05\u539f\u6ee1\u65cf\u81ea\u6cbb\u53bf", fatherID: "210400"}, {id: "500", areaID: "210501", area: "\u5e02\u8f96\u533a", fatherID: "210500"}, {
        id: "501",
        areaID: "210502",
        area: "\u5e73\u5c71\u533a",
        fatherID: "210500"
    }, {id: "502", areaID: "210503", area: "\u6eaa\u6e56\u533a", fatherID: "210500"}, {id: "503", areaID: "210504", area: "\u660e\u5c71\u533a", fatherID: "210500"}, {id: "504", areaID: "210505", area: "\u5357\u82ac\u533a", fatherID: "210500"}, {id: "505", areaID: "210521", area: "\u672c\u6eaa\u6ee1\u65cf\u81ea\u6cbb\u53bf", fatherID: "210500"}, {id: "506", areaID: "210522", area: "\u6853\u4ec1\u6ee1\u65cf\u81ea\u6cbb\u53bf", fatherID: "210500"}, {id: "507", areaID: "210601", area: "\u5e02\u8f96\u533a", fatherID: "210600"}, {id: "508", areaID: "210602", area: "\u5143\u5b9d\u533a", fatherID: "210600"}, {id: "509", areaID: "210603", area: "\u632f\u5174\u533a", fatherID: "210600"}, {id: "510", areaID: "210604", area: "\u632f\u5b89\u533a", fatherID: "210600"}, {
        id: "511",
        areaID: "210624",
        area: "\u5bbd\u7538\u6ee1\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "210600"
    }, {id: "512", areaID: "210681", area: "\u4e1c\u6e2f\u5e02", fatherID: "210600"}, {id: "513", areaID: "210682", area: "\u51e4\u57ce\u5e02", fatherID: "210600"}, {id: "514", areaID: "210701", area: "\u5e02\u8f96\u533a", fatherID: "210700"}, {id: "515", areaID: "210702", area: "\u53e4\u5854\u533a", fatherID: "210700"}, {id: "516", areaID: "210703", area: "\u51cc\u6cb3\u533a", fatherID: "210700"}, {id: "517", areaID: "210711", area: "\u592a\u548c\u533a", fatherID: "210700"}, {id: "518", areaID: "210726", area: "\u9ed1\u5c71\u53bf", fatherID: "210700"}, {id: "519", areaID: "210727", area: "\u4e49\u3000\u53bf", fatherID: "210700"}, {id: "520", areaID: "210781", area: "\u51cc\u6d77\u5e02", fatherID: "210700"}, {
        id: "521",
        areaID: "210782",
        area: "\u5317\u5b81\u5e02",
        fatherID: "210700"
    }, {id: "522", areaID: "210801", area: "\u5e02\u8f96\u533a", fatherID: "210800"}, {id: "523", areaID: "210802", area: "\u7ad9\u524d\u533a", fatherID: "210800"}, {id: "524", areaID: "210803", area: "\u897f\u5e02\u533a", fatherID: "210800"}, {id: "525", areaID: "210804", area: "\u9c85\u9c7c\u5708\u533a", fatherID: "210800"}, {id: "526", areaID: "210811", area: "\u8001\u8fb9\u533a", fatherID: "210800"}, {id: "527", areaID: "210881", area: "\u76d6\u5dde\u5e02", fatherID: "210800"}, {id: "528", areaID: "210882", area: "\u5927\u77f3\u6865\u5e02", fatherID: "210800"}, {id: "529", areaID: "210901", area: "\u5e02\u8f96\u533a", fatherID: "210900"}, {id: "530", areaID: "210902", area: "\u6d77\u5dde\u533a", fatherID: "210900"}, {
        id: "531",
        areaID: "210903",
        area: "\u65b0\u90b1\u533a",
        fatherID: "210900"
    }, {id: "532", areaID: "210904", area: "\u592a\u5e73\u533a", fatherID: "210900"}, {id: "533", areaID: "210905", area: "\u6e05\u6cb3\u95e8\u533a", fatherID: "210900"}, {id: "534", areaID: "210911", area: "\u7ec6\u6cb3\u533a", fatherID: "210900"}, {id: "535", areaID: "210921", area: "\u961c\u65b0\u8499\u53e4\u65cf\u81ea\u6cbb\u53bf", fatherID: "210900"}, {id: "536", areaID: "210922", area: "\u5f70\u6b66\u53bf", fatherID: "210900"}, {id: "537", areaID: "211001", area: "\u5e02\u8f96\u533a", fatherID: "211000"}, {id: "538", areaID: "211002", area: "\u767d\u5854\u533a", fatherID: "211000"}, {id: "539", areaID: "211003", area: "\u6587\u5723\u533a", fatherID: "211000"}, {id: "540", areaID: "211004", area: "\u5b8f\u4f1f\u533a", fatherID: "211000"}, {
        id: "541",
        areaID: "211005",
        area: "\u5f13\u957f\u5cad\u533a",
        fatherID: "211000"
    }, {id: "542", areaID: "211011", area: "\u592a\u5b50\u6cb3\u533a", fatherID: "211000"}, {id: "543", areaID: "211021", area: "\u8fbd\u9633\u53bf", fatherID: "211000"}, {id: "544", areaID: "211081", area: "\u706f\u5854\u5e02", fatherID: "211000"}, {id: "545", areaID: "211101", area: "\u5e02\u8f96\u533a", fatherID: "211100"}, {id: "546", areaID: "211102", area: "\u53cc\u53f0\u5b50\u533a", fatherID: "211100"}, {id: "547", areaID: "211103", area: "\u5174\u9686\u53f0\u533a", fatherID: "211100"}, {id: "548", areaID: "211121", area: "\u5927\u6d3c\u53bf", fatherID: "211100"}, {id: "549", areaID: "211122", area: "\u76d8\u5c71\u53bf", fatherID: "211100"}, {id: "550", areaID: "211201", area: "\u5e02\u8f96\u533a", fatherID: "211200"}, {
        id: "551",
        areaID: "211202",
        area: "\u94f6\u5dde\u533a",
        fatherID: "211200"
    }, {id: "552", areaID: "211204", area: "\u6e05\u6cb3\u533a", fatherID: "211200"}, {id: "553", areaID: "211221", area: "\u94c1\u5cad\u53bf", fatherID: "211200"}, {id: "554", areaID: "211223", area: "\u897f\u4e30\u53bf", fatherID: "211200"}, {id: "555", areaID: "211224", area: "\u660c\u56fe\u53bf", fatherID: "211200"}, {id: "556", areaID: "211281", area: "\u8c03\u5175\u5c71\u5e02", fatherID: "211200"}, {id: "557", areaID: "211282", area: "\u5f00\u539f\u5e02", fatherID: "211200"}, {id: "558", areaID: "211301", area: "\u5e02\u8f96\u533a", fatherID: "211300"}, {id: "559", areaID: "211302", area: "\u53cc\u5854\u533a", fatherID: "211300"}, {id: "560", areaID: "211303", area: "\u9f99\u57ce\u533a", fatherID: "211300"}, {
        id: "561",
        areaID: "211321",
        area: "\u671d\u9633\u53bf",
        fatherID: "211300"
    }, {id: "562", areaID: "211322", area: "\u5efa\u5e73\u53bf", fatherID: "211300"}, {id: "563", areaID: "211324", area: "\u5580\u5587\u6c81\u5de6\u7ffc\u8499\u53e4\u65cf\u81ea\u6cbb\u53bf", fatherID: "211300"}, {id: "564", areaID: "211381", area: "\u5317\u7968\u5e02", fatherID: "211300"}, {id: "565", areaID: "211382", area: "\u51cc\u6e90\u5e02", fatherID: "211300"}, {id: "566", areaID: "211401", area: "\u5e02\u8f96\u533a", fatherID: "211400"}, {id: "567", areaID: "211402", area: "\u8fde\u5c71\u533a", fatherID: "211400"}, {id: "568", areaID: "211403", area: "\u9f99\u6e2f\u533a", fatherID: "211400"}, {id: "569", areaID: "211404", area: "\u5357\u7968\u533a", fatherID: "211400"}, {id: "570", areaID: "211421", area: "\u7ee5\u4e2d\u53bf", fatherID: "211400"}, {
        id: "571",
        areaID: "211422",
        area: "\u5efa\u660c\u53bf",
        fatherID: "211400"
    }, {id: "572", areaID: "211481", area: "\u5174\u57ce\u5e02", fatherID: "211400"}, {id: "573", areaID: "220101", area: "\u5e02\u8f96\u533a", fatherID: "220100"}, {id: "574", areaID: "220102", area: "\u5357\u5173\u533a", fatherID: "220100"}, {id: "575", areaID: "220103", area: "\u5bbd\u57ce\u533a", fatherID: "220100"}, {id: "576", areaID: "220104", area: "\u671d\u9633\u533a", fatherID: "220100"}, {id: "577", areaID: "220105", area: "\u4e8c\u9053\u533a", fatherID: "220100"}, {id: "578", areaID: "220106", area: "\u7eff\u56ed\u533a", fatherID: "220100"}, {id: "579", areaID: "220112", area: "\u53cc\u9633\u533a", fatherID: "220100"}, {id: "580", areaID: "220122", area: "\u519c\u5b89\u53bf", fatherID: "220100"}, {
        id: "581",
        areaID: "220181",
        area: "\u4e5d\u53f0\u5e02",
        fatherID: "220100"
    }, {id: "582", areaID: "220182", area: "\u6986\u6811\u5e02", fatherID: "220100"}, {id: "583", areaID: "220183", area: "\u5fb7\u60e0\u5e02", fatherID: "220100"}, {id: "584", areaID: "220201", area: "\u5e02\u8f96\u533a", fatherID: "220200"}, {id: "585", areaID: "220202", area: "\u660c\u9091\u533a", fatherID: "220200"}, {id: "586", areaID: "220203", area: "\u9f99\u6f6d\u533a", fatherID: "220200"}, {id: "587", areaID: "220204", area: "\u8239\u8425\u533a", fatherID: "220200"}, {id: "588", areaID: "220211", area: "\u4e30\u6ee1\u533a", fatherID: "220200"}, {id: "589", areaID: "220221", area: "\u6c38\u5409\u53bf", fatherID: "220200"}, {id: "590", areaID: "220281", area: "\u86df\u6cb3\u5e02", fatherID: "220200"}, {
        id: "591",
        areaID: "220282",
        area: "\u6866\u7538\u5e02",
        fatherID: "220200"
    }, {id: "592", areaID: "220283", area: "\u8212\u5170\u5e02", fatherID: "220200"}, {id: "593", areaID: "220284", area: "\u78d0\u77f3\u5e02", fatherID: "220200"}, {id: "594", areaID: "220301", area: "\u5e02\u8f96\u533a", fatherID: "220300"}, {id: "595", areaID: "220302", area: "\u94c1\u897f\u533a", fatherID: "220300"}, {id: "596", areaID: "220303", area: "\u94c1\u4e1c\u533a", fatherID: "220300"}, {id: "597", areaID: "220322", area: "\u68a8\u6811\u53bf", fatherID: "220300"}, {id: "598", areaID: "220323", area: "\u4f0a\u901a\u6ee1\u65cf\u81ea\u6cbb\u53bf", fatherID: "220300"}, {id: "599", areaID: "220381", area: "\u516c\u4e3b\u5cad\u5e02", fatherID: "220300"}, {id: "600", areaID: "220382", area: "\u53cc\u8fbd\u5e02", fatherID: "220300"}, {
        id: "601",
        areaID: "220401",
        area: "\u5e02\u8f96\u533a",
        fatherID: "220400"
    }, {id: "602", areaID: "220402", area: "\u9f99\u5c71\u533a", fatherID: "220400"}, {id: "603", areaID: "220403", area: "\u897f\u5b89\u533a", fatherID: "220400"}, {id: "604", areaID: "220421", area: "\u4e1c\u4e30\u53bf", fatherID: "220400"}, {id: "605", areaID: "220422", area: "\u4e1c\u8fbd\u53bf", fatherID: "220400"}, {id: "606", areaID: "220501", area: "\u5e02\u8f96\u533a", fatherID: "220500"}, {id: "607", areaID: "220502", area: "\u4e1c\u660c\u533a", fatherID: "220500"}, {id: "608", areaID: "220503", area: "\u4e8c\u9053\u6c5f\u533a", fatherID: "220500"}, {id: "609", areaID: "220521", area: "\u901a\u5316\u53bf", fatherID: "220500"}, {id: "610", areaID: "220523", area: "\u8f89\u5357\u53bf", fatherID: "220500"}, {
        id: "611",
        areaID: "220524",
        area: "\u67f3\u6cb3\u53bf",
        fatherID: "220500"
    }, {id: "612", areaID: "220581", area: "\u6885\u6cb3\u53e3\u5e02", fatherID: "220500"}, {id: "613", areaID: "220582", area: "\u96c6\u5b89\u5e02", fatherID: "220500"}, {id: "614", areaID: "220601", area: "\u5e02\u8f96\u533a", fatherID: "220600"}, {id: "615", areaID: "220602", area: "\u516b\u9053\u6c5f\u533a", fatherID: "220600"}, {id: "616", areaID: "220621", area: "\u629a\u677e\u53bf", fatherID: "220600"}, {id: "617", areaID: "220622", area: "\u9756\u5b87\u53bf", fatherID: "220600"}, {id: "618", areaID: "220623", area: "\u957f\u767d\u671d\u9c9c\u65cf\u81ea\u6cbb\u53bf", fatherID: "220600"}, {id: "619", areaID: "220625", area: "\u6c5f\u6e90\u53bf", fatherID: "220600"}, {id: "620", areaID: "220681", area: "\u4e34\u6c5f\u5e02", fatherID: "220600"}, {
        id: "621",
        areaID: "220701",
        area: "\u5e02\u8f96\u533a",
        fatherID: "220700"
    }, {id: "622", areaID: "220702", area: "\u5b81\u6c5f\u533a", fatherID: "220700"}, {id: "623", areaID: "220721", area: "\u524d\u90ed\u5c14\u7f57\u65af\u8499\u53e4\u65cf\u81ea\u6cbb\u53bf", fatherID: "220700"}, {id: "624", areaID: "220722", area: "\u957f\u5cad\u53bf", fatherID: "220700"}, {id: "625", areaID: "220723", area: "\u4e7e\u5b89\u53bf", fatherID: "220700"}, {id: "626", areaID: "220724", area: "\u6276\u4f59\u53bf", fatherID: "220700"}, {id: "627", areaID: "220801", area: "\u5e02\u8f96\u533a", fatherID: "220800"}, {id: "628", areaID: "220802", area: "\u6d2e\u5317\u533a", fatherID: "220800"}, {id: "629", areaID: "220821", area: "\u9547\u8d49\u53bf", fatherID: "220800"}, {id: "630", areaID: "220822", area: "\u901a\u6986\u53bf", fatherID: "220800"}, {
        id: "631",
        areaID: "220881",
        area: "\u6d2e\u5357\u5e02",
        fatherID: "220800"
    }, {id: "632", areaID: "220882", area: "\u5927\u5b89\u5e02", fatherID: "220800"}, {id: "633", areaID: "222401", area: "\u5ef6\u5409\u5e02", fatherID: "222400"}, {id: "634", areaID: "222402", area: "\u56fe\u4eec\u5e02", fatherID: "222400"}, {id: "635", areaID: "222403", area: "\u6566\u5316\u5e02", fatherID: "222400"}, {id: "636", areaID: "222404", area: "\u73f2\u6625\u5e02", fatherID: "222400"}, {id: "637", areaID: "222405", area: "\u9f99\u4e95\u5e02", fatherID: "222400"}, {id: "638", areaID: "222406", area: "\u548c\u9f99\u5e02", fatherID: "222400"}, {id: "639", areaID: "222424", area: "\u6c6a\u6e05\u53bf", fatherID: "222400"}, {id: "640", areaID: "222426", area: "\u5b89\u56fe\u53bf", fatherID: "222400"}, {
        id: "641",
        areaID: "230101",
        area: "\u5e02\u8f96\u533a",
        fatherID: "230100"
    }, {id: "642", areaID: "230102", area: "\u9053\u91cc\u533a", fatherID: "230100"}, {id: "643", areaID: "230103", area: "\u5357\u5c97\u533a", fatherID: "230100"}, {id: "644", areaID: "230104", area: "\u9053\u5916\u533a", fatherID: "230100"}, {id: "645", areaID: "230106", area: "\u9999\u574a\u533a", fatherID: "230100"}, {id: "646", areaID: "230107", area: "\u52a8\u529b\u533a", fatherID: "230100"}, {id: "647", areaID: "230108", area: "\u5e73\u623f\u533a", fatherID: "230100"}, {id: "648", areaID: "230109", area: "\u677e\u5317\u533a", fatherID: "230100"}, {id: "649", areaID: "230111", area: "\u547c\u5170\u533a", fatherID: "230100"}, {id: "650", areaID: "230123", area: "\u4f9d\u5170\u53bf", fatherID: "230100"}, {
        id: "651",
        areaID: "230124",
        area: "\u65b9\u6b63\u53bf",
        fatherID: "230100"
    }, {id: "652", areaID: "230125", area: "\u5bbe\u3000\u53bf", fatherID: "230100"}, {id: "653", areaID: "230126", area: "\u5df4\u5f66\u53bf", fatherID: "230100"}, {id: "654", areaID: "230127", area: "\u6728\u5170\u53bf", fatherID: "230100"}, {id: "655", areaID: "230128", area: "\u901a\u6cb3\u53bf", fatherID: "230100"}, {id: "656", areaID: "230129", area: "\u5ef6\u5bff\u53bf", fatherID: "230100"}, {id: "657", areaID: "230181", area: "\u963f\u57ce\u5e02", fatherID: "230100"}, {id: "658", areaID: "230182", area: "\u53cc\u57ce\u5e02", fatherID: "230100"}, {id: "659", areaID: "230183", area: "\u5c1a\u5fd7\u5e02", fatherID: "230100"}, {id: "660", areaID: "230184", area: "\u4e94\u5e38\u5e02", fatherID: "230100"}, {
        id: "661",
        areaID: "230201",
        area: "\u5e02\u8f96\u533a",
        fatherID: "230200"
    }, {id: "662", areaID: "230202", area: "\u9f99\u6c99\u533a", fatherID: "230200"}, {id: "663", areaID: "230203", area: "\u5efa\u534e\u533a", fatherID: "230200"}, {id: "664", areaID: "230204", area: "\u94c1\u950b\u533a", fatherID: "230200"}, {id: "665", areaID: "230205", area: "\u6602\u6602\u6eaa\u533a", fatherID: "230200"}, {id: "666", areaID: "230206", area: "\u5bcc\u62c9\u5c14\u57fa\u533a", fatherID: "230200"}, {id: "667", areaID: "230207", area: "\u78be\u5b50\u5c71\u533a", fatherID: "230200"}, {id: "668", areaID: "230208", area: "\u6885\u91cc\u65af\u8fbe\u65a1\u5c14\u65cf\u533a", fatherID: "230200"}, {id: "669", areaID: "230221", area: "\u9f99\u6c5f\u53bf", fatherID: "230200"}, {id: "670", areaID: "230223", area: "\u4f9d\u5b89\u53bf", fatherID: "230200"}, {
        id: "671",
        areaID: "230224",
        area: "\u6cf0\u6765\u53bf",
        fatherID: "230200"
    }, {id: "672", areaID: "230225", area: "\u7518\u5357\u53bf", fatherID: "230200"}, {id: "673", areaID: "230227", area: "\u5bcc\u88d5\u53bf", fatherID: "230200"}, {id: "674", areaID: "230229", area: "\u514b\u5c71\u53bf", fatherID: "230200"}, {id: "675", areaID: "230230", area: "\u514b\u4e1c\u53bf", fatherID: "230200"}, {id: "676", areaID: "230231", area: "\u62dc\u6cc9\u53bf", fatherID: "230200"}, {id: "677", areaID: "230281", area: "\u8bb7\u6cb3\u5e02", fatherID: "230200"}, {id: "678", areaID: "230301", area: "\u5e02\u8f96\u533a", fatherID: "230300"}, {id: "679", areaID: "230302", area: "\u9e21\u51a0\u533a", fatherID: "230300"}, {id: "680", areaID: "230303", area: "\u6052\u5c71\u533a", fatherID: "230300"}, {
        id: "681",
        areaID: "230304",
        area: "\u6ef4\u9053\u533a",
        fatherID: "230300"
    }, {id: "682", areaID: "230305", area: "\u68a8\u6811\u533a", fatherID: "230300"}, {id: "683", areaID: "230306", area: "\u57ce\u5b50\u6cb3\u533a", fatherID: "230300"}, {id: "684", areaID: "230307", area: "\u9ebb\u5c71\u533a", fatherID: "230300"}, {id: "685", areaID: "230321", area: "\u9e21\u4e1c\u53bf", fatherID: "230300"}, {id: "686", areaID: "230381", area: "\u864e\u6797\u5e02", fatherID: "230300"}, {id: "687", areaID: "230382", area: "\u5bc6\u5c71\u5e02", fatherID: "230300"}, {id: "688", areaID: "230401", area: "\u5e02\u8f96\u533a", fatherID: "230400"}, {id: "689", areaID: "230402", area: "\u5411\u9633\u533a", fatherID: "230400"}, {id: "690", areaID: "230403", area: "\u5de5\u519c\u533a", fatherID: "230400"}, {
        id: "691",
        areaID: "230404",
        area: "\u5357\u5c71\u533a",
        fatherID: "230400"
    }, {id: "692", areaID: "230405", area: "\u5174\u5b89\u533a", fatherID: "230400"}, {id: "693", areaID: "230406", area: "\u4e1c\u5c71\u533a", fatherID: "230400"}, {id: "694", areaID: "230407", area: "\u5174\u5c71\u533a", fatherID: "230400"}, {id: "695", areaID: "230421", area: "\u841d\u5317\u53bf", fatherID: "230400"}, {id: "696", areaID: "230422", area: "\u7ee5\u6ee8\u53bf", fatherID: "230400"}, {id: "697", areaID: "230501", area: "\u5e02\u8f96\u533a", fatherID: "230500"}, {id: "698", areaID: "230502", area: "\u5c16\u5c71\u533a", fatherID: "230500"}, {id: "699", areaID: "230503", area: "\u5cad\u4e1c\u533a", fatherID: "230500"}, {id: "700", areaID: "230505", area: "\u56db\u65b9\u53f0\u533a", fatherID: "230500"}, {
        id: "701",
        areaID: "230506",
        area: "\u5b9d\u5c71\u533a",
        fatherID: "230500"
    }, {id: "702", areaID: "230521", area: "\u96c6\u8d24\u53bf", fatherID: "230500"}, {id: "703", areaID: "230522", area: "\u53cb\u8c0a\u53bf", fatherID: "230500"}, {id: "704", areaID: "230523", area: "\u5b9d\u6e05\u53bf", fatherID: "230500"}, {id: "705", areaID: "230524", area: "\u9976\u6cb3\u53bf", fatherID: "230500"}, {id: "706", areaID: "230601", area: "\u5e02\u8f96\u533a", fatherID: "230600"}, {id: "707", areaID: "230602", area: "\u8428\u5c14\u56fe\u533a", fatherID: "230600"}, {id: "708", areaID: "230603", area: "\u9f99\u51e4\u533a", fatherID: "230600"}, {id: "709", areaID: "230604", area: "\u8ba9\u80e1\u8def\u533a", fatherID: "230600"}, {id: "710", areaID: "230605", area: "\u7ea2\u5c97\u533a", fatherID: "230600"}, {
        id: "711",
        areaID: "230606",
        area: "\u5927\u540c\u533a",
        fatherID: "230600"
    }, {id: "712", areaID: "230621", area: "\u8087\u5dde\u53bf", fatherID: "230600"}, {id: "713", areaID: "230622", area: "\u8087\u6e90\u53bf", fatherID: "230600"}, {id: "714", areaID: "230623", area: "\u6797\u7538\u53bf", fatherID: "230600"}, {id: "715", areaID: "230624", area: "\u675c\u5c14\u4f2f\u7279\u8499\u53e4\u65cf\u81ea\u6cbb\u53bf", fatherID: "230600"}, {id: "716", areaID: "230701", area: "\u5e02\u8f96\u533a", fatherID: "230700"}, {id: "717", areaID: "230702", area: "\u4f0a\u6625\u533a", fatherID: "230700"}, {id: "718", areaID: "230703", area: "\u5357\u5c94\u533a", fatherID: "230700"}, {id: "719", areaID: "230704", area: "\u53cb\u597d\u533a", fatherID: "230700"}, {id: "720", areaID: "230705", area: "\u897f\u6797\u533a", fatherID: "230700"}, {
        id: "721",
        areaID: "230706",
        area: "\u7fe0\u5ce6\u533a",
        fatherID: "230700"
    }, {id: "722", areaID: "230707", area: "\u65b0\u9752\u533a", fatherID: "230700"}, {id: "723", areaID: "230708", area: "\u7f8e\u6eaa\u533a", fatherID: "230700"}, {id: "724", areaID: "230709", area: "\u91d1\u5c71\u5c6f\u533a", fatherID: "230700"}, {id: "725", areaID: "230710", area: "\u4e94\u8425\u533a", fatherID: "230700"}, {id: "726", areaID: "230711", area: "\u4e4c\u9a6c\u6cb3\u533a", fatherID: "230700"}, {id: "727", areaID: "230712", area: "\u6c64\u65fa\u6cb3\u533a", fatherID: "230700"}, {id: "728", areaID: "230713", area: "\u5e26\u5cad\u533a", fatherID: "230700"}, {id: "729", areaID: "230714", area: "\u4e4c\u4f0a\u5cad\u533a", fatherID: "230700"}, {id: "730", areaID: "230715", area: "\u7ea2\u661f\u533a", fatherID: "230700"}, {
        id: "731",
        areaID: "230716",
        area: "\u4e0a\u7518\u5cad\u533a",
        fatherID: "230700"
    }, {id: "732", areaID: "230722", area: "\u5609\u836b\u53bf", fatherID: "230700"}, {id: "733", areaID: "230781", area: "\u94c1\u529b\u5e02", fatherID: "230700"}, {id: "734", areaID: "230801", area: "\u5e02\u8f96\u533a", fatherID: "230800"}, {id: "735", areaID: "230802", area: "\u6c38\u7ea2\u533a", fatherID: "230800"}, {id: "736", areaID: "230803", area: "\u5411\u9633\u533a", fatherID: "230800"}, {id: "737", areaID: "230804", area: "\u524d\u8fdb\u533a", fatherID: "230800"}, {id: "738", areaID: "230805", area: "\u4e1c\u98ce\u533a", fatherID: "230800"}, {id: "739", areaID: "230811", area: "\u90ca\u3000\u533a", fatherID: "230800"}, {id: "740", areaID: "230822", area: "\u6866\u5357\u53bf", fatherID: "230800"}, {
        id: "741",
        areaID: "230826",
        area: "\u6866\u5ddd\u53bf",
        fatherID: "230800"
    }, {id: "742", areaID: "230828", area: "\u6c64\u539f\u53bf", fatherID: "230800"}, {id: "743", areaID: "230833", area: "\u629a\u8fdc\u53bf", fatherID: "230800"}, {id: "744", areaID: "230881", area: "\u540c\u6c5f\u5e02", fatherID: "230800"}, {id: "745", areaID: "230882", area: "\u5bcc\u9526\u5e02", fatherID: "230800"}, {id: "746", areaID: "230901", area: "\u5e02\u8f96\u533a", fatherID: "230900"}, {id: "747", areaID: "230902", area: "\u65b0\u5174\u533a", fatherID: "230900"}, {id: "748", areaID: "230903", area: "\u6843\u5c71\u533a", fatherID: "230900"}, {id: "749", areaID: "230904", area: "\u8304\u5b50\u6cb3\u533a", fatherID: "230900"}, {id: "750", areaID: "230921", area: "\u52c3\u5229\u53bf", fatherID: "230900"}, {
        id: "751",
        areaID: "231001",
        area: "\u5e02\u8f96\u533a",
        fatherID: "231000"
    }, {id: "752", areaID: "231002", area: "\u4e1c\u5b89\u533a", fatherID: "231000"}, {id: "753", areaID: "231003", area: "\u9633\u660e\u533a", fatherID: "231000"}, {id: "754", areaID: "231004", area: "\u7231\u6c11\u533a", fatherID: "231000"}, {id: "755", areaID: "231005", area: "\u897f\u5b89\u533a", fatherID: "231000"}, {id: "756", areaID: "231024", area: "\u4e1c\u5b81\u53bf", fatherID: "231000"}, {id: "757", areaID: "231025", area: "\u6797\u53e3\u53bf", fatherID: "231000"}, {id: "758", areaID: "231081", area: "\u7ee5\u82ac\u6cb3\u5e02", fatherID: "231000"}, {id: "759", areaID: "231083", area: "\u6d77\u6797\u5e02", fatherID: "231000"}, {id: "760", areaID: "231084", area: "\u5b81\u5b89\u5e02", fatherID: "231000"}, {
        id: "761",
        areaID: "231085",
        area: "\u7a46\u68f1\u5e02",
        fatherID: "231000"
    }, {id: "762", areaID: "231101", area: "\u5e02\u8f96\u533a", fatherID: "231100"}, {id: "763", areaID: "231102", area: "\u7231\u8f89\u533a", fatherID: "231100"}, {id: "764", areaID: "231121", area: "\u5ae9\u6c5f\u53bf", fatherID: "231100"}, {id: "765", areaID: "231123", area: "\u900a\u514b\u53bf", fatherID: "231100"}, {id: "766", areaID: "231124", area: "\u5b59\u5434\u53bf", fatherID: "231100"}, {id: "767", areaID: "231181", area: "\u5317\u5b89\u5e02", fatherID: "231100"}, {id: "768", areaID: "231182", area: "\u4e94\u5927\u8fde\u6c60\u5e02", fatherID: "231100"}, {id: "769", areaID: "231201", area: "\u5e02\u8f96\u533a", fatherID: "231200"}, {id: "770", areaID: "231202", area: "\u5317\u6797\u533a", fatherID: "231200"}, {
        id: "771",
        areaID: "231221",
        area: "\u671b\u594e\u53bf",
        fatherID: "231200"
    }, {id: "772", areaID: "231222", area: "\u5170\u897f\u53bf", fatherID: "231200"}, {id: "773", areaID: "231223", area: "\u9752\u5188\u53bf", fatherID: "231200"}, {id: "774", areaID: "231224", area: "\u5e86\u5b89\u53bf", fatherID: "231200"}, {id: "775", areaID: "231225", area: "\u660e\u6c34\u53bf", fatherID: "231200"}, {id: "776", areaID: "231226", area: "\u7ee5\u68f1\u53bf", fatherID: "231200"}, {id: "777", areaID: "231281", area: "\u5b89\u8fbe\u5e02", fatherID: "231200"}, {id: "778", areaID: "231282", area: "\u8087\u4e1c\u5e02", fatherID: "231200"}, {id: "779", areaID: "231283", area: "\u6d77\u4f26\u5e02", fatherID: "231200"}, {id: "780", areaID: "232721", area: "\u547c\u739b\u53bf", fatherID: "232700"}, {
        id: "781",
        areaID: "232722",
        area: "\u5854\u6cb3\u53bf",
        fatherID: "232700"
    }, {id: "782", areaID: "232723", area: "\u6f20\u6cb3\u53bf", fatherID: "232700"}, {id: "783", areaID: "310101", area: "\u9ec4\u6d66\u533a", fatherID: "310100"}, {id: "784", areaID: "310103", area: "\u5362\u6e7e\u533a", fatherID: "310100"}, {id: "785", areaID: "310104", area: "\u5f90\u6c47\u533a", fatherID: "310100"}, {id: "786", areaID: "310105", area: "\u957f\u5b81\u533a", fatherID: "310100"}, {id: "787", areaID: "310106", area: "\u9759\u5b89\u533a", fatherID: "310100"}, {id: "788", areaID: "310107", area: "\u666e\u9640\u533a", fatherID: "310100"}, {id: "789", areaID: "310108", area: "\u95f8\u5317\u533a", fatherID: "310100"}, {id: "790", areaID: "310109", area: "\u8679\u53e3\u533a", fatherID: "310100"}, {
        id: "791",
        areaID: "310110",
        area: "\u6768\u6d66\u533a",
        fatherID: "310100"
    }, {id: "792", areaID: "310112", area: "\u95f5\u884c\u533a", fatherID: "310100"}, {id: "793", areaID: "310113", area: "\u5b9d\u5c71\u533a", fatherID: "310100"}, {id: "794", areaID: "310114", area: "\u5609\u5b9a\u533a", fatherID: "310100"}, {id: "795", areaID: "310115", area: "\u6d66\u4e1c\u65b0\u533a", fatherID: "310100"}, {id: "796", areaID: "310116", area: "\u91d1\u5c71\u533a", fatherID: "310100"}, {id: "797", areaID: "310117", area: "\u677e\u6c5f\u533a", fatherID: "310100"}, {id: "798", areaID: "310118", area: "\u9752\u6d66\u533a", fatherID: "310100"}, {id: "799", areaID: "310119", area: "\u5357\u6c47\u533a", fatherID: "310100"}, {id: "800", areaID: "310120", area: "\u5949\u8d24\u533a", fatherID: "310100"}, {
        id: "801",
        areaID: "310230",
        area: "\u5d07\u660e\u53bf",
        fatherID: "310200"
    }, {id: "802", areaID: "320101", area: "\u5e02\u8f96\u533a", fatherID: "320100"}, {id: "803", areaID: "320102", area: "\u7384\u6b66\u533a", fatherID: "320100"}, {id: "804", areaID: "320103", area: "\u767d\u4e0b\u533a", fatherID: "320100"}, {id: "805", areaID: "320104", area: "\u79e6\u6dee\u533a", fatherID: "320100"}, {id: "806", areaID: "320105", area: "\u5efa\u90ba\u533a", fatherID: "320100"}, {id: "807", areaID: "320106", area: "\u9f13\u697c\u533a", fatherID: "320100"}, {id: "808", areaID: "320107", area: "\u4e0b\u5173\u533a", fatherID: "320100"}, {id: "809", areaID: "320111", area: "\u6d66\u53e3\u533a", fatherID: "320100"}, {id: "810", areaID: "320113", area: "\u6816\u971e\u533a", fatherID: "320100"}, {
        id: "811",
        areaID: "320114",
        area: "\u96e8\u82b1\u53f0\u533a",
        fatherID: "320100"
    }, {id: "812", areaID: "320115", area: "\u6c5f\u5b81\u533a", fatherID: "320100"}, {id: "813", areaID: "320116", area: "\u516d\u5408\u533a", fatherID: "320100"}, {id: "814", areaID: "320124", area: "\u6ea7\u6c34\u53bf", fatherID: "320100"}, {id: "815", areaID: "320125", area: "\u9ad8\u6df3\u53bf", fatherID: "320100"}, {id: "816", areaID: "320201", area: "\u5e02\u8f96\u533a", fatherID: "320200"}, {id: "817", areaID: "320202", area: "\u5d07\u5b89\u533a", fatherID: "320200"}, {id: "818", areaID: "320203", area: "\u5357\u957f\u533a", fatherID: "320200"}, {id: "819", areaID: "320204", area: "\u5317\u5858\u533a", fatherID: "320200"}, {id: "820", areaID: "320205", area: "\u9521\u5c71\u533a", fatherID: "320200"}, {
        id: "821",
        areaID: "320206",
        area: "\u60e0\u5c71\u533a",
        fatherID: "320200"
    }, {id: "822", areaID: "320211", area: "\u6ee8\u6e56\u533a", fatherID: "320200"}, {id: "823", areaID: "320281", area: "\u6c5f\u9634\u5e02", fatherID: "320200"}, {id: "824", areaID: "320282", area: "\u5b9c\u5174\u5e02", fatherID: "320200"}, {id: "825", areaID: "320301", area: "\u5e02\u8f96\u533a", fatherID: "320300"}, {id: "826", areaID: "320302", area: "\u9f13\u697c\u533a", fatherID: "320300"}, {id: "827", areaID: "320303", area: "\u4e91\u9f99\u533a", fatherID: "320300"}, {id: "828", areaID: "320304", area: "\u4e5d\u91cc\u533a", fatherID: "320300"}, {id: "829", areaID: "320305", area: "\u8d3e\u6c6a\u533a", fatherID: "320300"}, {id: "830", areaID: "320311", area: "\u6cc9\u5c71\u533a", fatherID: "320300"}, {
        id: "831",
        areaID: "320321",
        area: "\u4e30\u3000\u53bf",
        fatherID: "320300"
    }, {id: "832", areaID: "320322", area: "\u6c9b\u3000\u53bf", fatherID: "320300"}, {id: "833", areaID: "320323", area: "\u94dc\u5c71\u53bf", fatherID: "320300"}, {id: "834", areaID: "320324", area: "\u7762\u5b81\u53bf", fatherID: "320300"}, {id: "835", areaID: "320381", area: "\u65b0\u6c82\u5e02", fatherID: "320300"}, {id: "836", areaID: "320382", area: "\u90b3\u5dde\u5e02", fatherID: "320300"}, {id: "837", areaID: "320401", area: "\u5e02\u8f96\u533a", fatherID: "320400"}, {id: "838", areaID: "320402", area: "\u5929\u5b81\u533a", fatherID: "320400"}, {id: "839", areaID: "320404", area: "\u949f\u697c\u533a", fatherID: "320400"}, {id: "840", areaID: "320405", area: "\u621a\u5885\u5830\u533a", fatherID: "320400"}, {
        id: "841",
        areaID: "320411",
        area: "\u65b0\u5317\u533a",
        fatherID: "320400"
    }, {id: "842", areaID: "320412", area: "\u6b66\u8fdb\u533a", fatherID: "320400"}, {id: "843", areaID: "320481", area: "\u6ea7\u9633\u5e02", fatherID: "320400"}, {id: "844", areaID: "320482", area: "\u91d1\u575b\u5e02", fatherID: "320400"}, {id: "845", areaID: "320501", area: "\u5e02\u8f96\u533a", fatherID: "320500"}, {id: "846", areaID: "320502", area: "\u6ca7\u6d6a\u533a", fatherID: "320500"}, {id: "847", areaID: "320503", area: "\u5e73\u6c5f\u533a", fatherID: "320500"}, {id: "848", areaID: "320504", area: "\u91d1\u960a\u533a", fatherID: "320500"}, {id: "849", areaID: "320505", area: "\u864e\u4e18\u533a", fatherID: "320500"}, {id: "850", areaID: "320506", area: "\u5434\u4e2d\u533a", fatherID: "320500"}, {
        id: "851",
        areaID: "320507",
        area: "\u76f8\u57ce\u533a",
        fatherID: "320500"
    }, {id: "852", areaID: "320581", area: "\u5e38\u719f\u5e02", fatherID: "320500"}, {id: "853", areaID: "320582", area: "\u5f20\u5bb6\u6e2f\u5e02", fatherID: "320500"}, {id: "854", areaID: "320583", area: "\u6606\u5c71\u5e02", fatherID: "320500"}, {id: "855", areaID: "320584", area: "\u5434\u6c5f\u5e02", fatherID: "320500"}, {id: "856", areaID: "320585", area: "\u592a\u4ed3\u5e02", fatherID: "320500"}, {id: "857", areaID: "320601", area: "\u5e02\u8f96\u533a", fatherID: "320600"}, {id: "858", areaID: "320602", area: "\u5d07\u5ddd\u533a", fatherID: "320600"}, {id: "859", areaID: "320611", area: "\u6e2f\u95f8\u533a", fatherID: "320600"}, {id: "860", areaID: "320621", area: "\u6d77\u5b89\u53bf", fatherID: "320600"}, {
        id: "861",
        areaID: "320623",
        area: "\u5982\u4e1c\u53bf",
        fatherID: "320600"
    }, {id: "862", areaID: "320681", area: "\u542f\u4e1c\u5e02", fatherID: "320600"}, {id: "863", areaID: "320682", area: "\u5982\u768b\u5e02", fatherID: "320600"}, {id: "864", areaID: "320683", area: "\u901a\u5dde\u5e02", fatherID: "320600"}, {id: "865", areaID: "320684", area: "\u6d77\u95e8\u5e02", fatherID: "320600"}, {id: "866", areaID: "320701", area: "\u5e02\u8f96\u533a", fatherID: "320700"}, {id: "867", areaID: "320703", area: "\u8fde\u4e91\u533a", fatherID: "320700"}, {id: "868", areaID: "320705", area: "\u65b0\u6d66\u533a", fatherID: "320700"}, {id: "869", areaID: "320706", area: "\u6d77\u5dde\u533a", fatherID: "320700"}, {id: "870", areaID: "320721", area: "\u8d63\u6986\u53bf", fatherID: "320700"}, {
        id: "871",
        areaID: "320722",
        area: "\u4e1c\u6d77\u53bf",
        fatherID: "320700"
    }, {id: "872", areaID: "320723", area: "\u704c\u4e91\u53bf", fatherID: "320700"}, {id: "873", areaID: "320724", area: "\u704c\u5357\u53bf", fatherID: "320700"}, {id: "874", areaID: "320801", area: "\u5e02\u8f96\u533a", fatherID: "320800"}, {id: "875", areaID: "320802", area: "\u6e05\u6cb3\u533a", fatherID: "320800"}, {id: "876", areaID: "320803", area: "\u695a\u5dde\u533a", fatherID: "320800"}, {id: "877", areaID: "320804", area: "\u6dee\u9634\u533a", fatherID: "320800"}, {id: "878", areaID: "320811", area: "\u6e05\u6d66\u533a", fatherID: "320800"}, {id: "879", areaID: "320826", area: "\u6d9f\u6c34\u53bf", fatherID: "320800"}, {id: "880", areaID: "320829", area: "\u6d2a\u6cfd\u53bf", fatherID: "320800"}, {
        id: "881",
        areaID: "320830",
        area: "\u76f1\u7719\u53bf",
        fatherID: "320800"
    }, {id: "882", areaID: "320831", area: "\u91d1\u6e56\u53bf", fatherID: "320800"}, {id: "883", areaID: "320901", area: "\u5e02\u8f96\u533a", fatherID: "320900"}, {id: "884", areaID: "320902", area: "\u4ead\u6e56\u533a", fatherID: "320900"}, {id: "885", areaID: "320903", area: "\u76d0\u90fd\u533a", fatherID: "320900"}, {id: "886", areaID: "320921", area: "\u54cd\u6c34\u53bf", fatherID: "320900"}, {id: "887", areaID: "320922", area: "\u6ee8\u6d77\u53bf", fatherID: "320900"}, {id: "888", areaID: "320923", area: "\u961c\u5b81\u53bf", fatherID: "320900"}, {id: "889", areaID: "320924", area: "\u5c04\u9633\u53bf", fatherID: "320900"}, {id: "890", areaID: "320925", area: "\u5efa\u6e56\u53bf", fatherID: "320900"}, {
        id: "891",
        areaID: "320981",
        area: "\u4e1c\u53f0\u5e02",
        fatherID: "320900"
    }, {id: "892", areaID: "320982", area: "\u5927\u4e30\u5e02", fatherID: "320900"}, {id: "893", areaID: "321001", area: "\u5e02\u8f96\u533a", fatherID: "321000"}, {id: "894", areaID: "321002", area: "\u5e7f\u9675\u533a", fatherID: "321000"}, {id: "895", areaID: "321003", area: "\u9097\u6c5f\u533a", fatherID: "321000"}, {id: "896", areaID: "321011", area: "\u90ca\u3000\u533a", fatherID: "321000"}, {id: "897", areaID: "321023", area: "\u5b9d\u5e94\u53bf", fatherID: "321000"}, {id: "898", areaID: "321081", area: "\u4eea\u5f81\u5e02", fatherID: "321000"}, {id: "899", areaID: "321084", area: "\u9ad8\u90ae\u5e02", fatherID: "321000"}, {id: "900", areaID: "321088", area: "\u6c5f\u90fd\u5e02", fatherID: "321000"}, {
        id: "901",
        areaID: "321101",
        area: "\u5e02\u8f96\u533a",
        fatherID: "321100"
    }, {id: "902", areaID: "321102", area: "\u4eac\u53e3\u533a", fatherID: "321100"}, {id: "903", areaID: "321111", area: "\u6da6\u5dde\u533a", fatherID: "321100"}, {id: "904", areaID: "321112", area: "\u4e39\u5f92\u533a", fatherID: "321100"}, {id: "905", areaID: "321181", area: "\u4e39\u9633\u5e02", fatherID: "321100"}, {id: "906", areaID: "321182", area: "\u626c\u4e2d\u5e02", fatherID: "321100"}, {id: "907", areaID: "321183", area: "\u53e5\u5bb9\u5e02", fatherID: "321100"}, {id: "908", areaID: "321201", area: "\u5e02\u8f96\u533a", fatherID: "321200"}, {id: "909", areaID: "321202", area: "\u6d77\u9675\u533a", fatherID: "321200"}, {id: "910", areaID: "321203", area: "\u9ad8\u6e2f\u533a", fatherID: "321200"}, {
        id: "911",
        areaID: "321281",
        area: "\u5174\u5316\u5e02",
        fatherID: "321200"
    }, {id: "912", areaID: "321282", area: "\u9756\u6c5f\u5e02", fatherID: "321200"}, {id: "913", areaID: "321283", area: "\u6cf0\u5174\u5e02", fatherID: "321200"}, {id: "914", areaID: "321284", area: "\u59dc\u5830\u5e02", fatherID: "321200"}, {id: "915", areaID: "321301", area: "\u5e02\u8f96\u533a", fatherID: "321300"}, {id: "916", areaID: "321302", area: "\u5bbf\u57ce\u533a", fatherID: "321300"}, {id: "917", areaID: "321311", area: "\u5bbf\u8c6b\u533a", fatherID: "321300"}, {id: "918", areaID: "321322", area: "\u6cad\u9633\u53bf", fatherID: "321300"}, {id: "919", areaID: "321323", area: "\u6cd7\u9633\u53bf", fatherID: "321300"}, {id: "920", areaID: "321324", area: "\u6cd7\u6d2a\u53bf", fatherID: "321300"}, {
        id: "921",
        areaID: "330101",
        area: "\u5e02\u8f96\u533a",
        fatherID: "330100"
    }, {id: "922", areaID: "330102", area: "\u4e0a\u57ce\u533a", fatherID: "330100"}, {id: "923", areaID: "330103", area: "\u4e0b\u57ce\u533a", fatherID: "330100"}, {id: "924", areaID: "330104", area: "\u6c5f\u5e72\u533a", fatherID: "330100"}, {id: "925", areaID: "330105", area: "\u62f1\u5885\u533a", fatherID: "330100"}, {id: "926", areaID: "330106", area: "\u897f\u6e56\u533a", fatherID: "330100"}, {id: "927", areaID: "330108", area: "\u6ee8\u6c5f\u533a", fatherID: "330100"}, {id: "928", areaID: "330109", area: "\u8427\u5c71\u533a", fatherID: "330100"}, {id: "929", areaID: "330110", area: "\u4f59\u676d\u533a", fatherID: "330100"}, {id: "930", areaID: "330122", area: "\u6850\u5e90\u53bf", fatherID: "330100"}, {
        id: "931",
        areaID: "330127",
        area: "\u6df3\u5b89\u53bf",
        fatherID: "330100"
    }, {id: "932", areaID: "330182", area: "\u5efa\u5fb7\u5e02", fatherID: "330100"}, {id: "933", areaID: "330183", area: "\u5bcc\u9633\u5e02", fatherID: "330100"}, {id: "934", areaID: "330185", area: "\u4e34\u5b89\u5e02", fatherID: "330100"}, {id: "935", areaID: "330201", area: "\u5e02\u8f96\u533a", fatherID: "330200"}, {id: "936", areaID: "330203", area: "\u6d77\u66d9\u533a", fatherID: "330200"}, {id: "937", areaID: "330204", area: "\u6c5f\u4e1c\u533a", fatherID: "330200"}, {id: "938", areaID: "330205", area: "\u6c5f\u5317\u533a", fatherID: "330200"}, {id: "939", areaID: "330206", area: "\u5317\u4ed1\u533a", fatherID: "330200"}, {id: "940", areaID: "330211", area: "\u9547\u6d77\u533a", fatherID: "330200"}, {
        id: "941",
        areaID: "330212",
        area: "\u911e\u5dde\u533a",
        fatherID: "330200"
    }, {id: "942", areaID: "330225", area: "\u8c61\u5c71\u53bf", fatherID: "330200"}, {id: "943", areaID: "330226", area: "\u5b81\u6d77\u53bf", fatherID: "330200"}, {id: "944", areaID: "330281", area: "\u4f59\u59da\u5e02", fatherID: "330200"}, {id: "945", areaID: "330282", area: "\u6148\u6eaa\u5e02", fatherID: "330200"}, {id: "946", areaID: "330283", area: "\u5949\u5316\u5e02", fatherID: "330200"}, {id: "947", areaID: "330301", area: "\u5e02\u8f96\u533a", fatherID: "330300"}, {id: "948", areaID: "330302", area: "\u9e7f\u57ce\u533a", fatherID: "330300"}, {id: "949", areaID: "330303", area: "\u9f99\u6e7e\u533a", fatherID: "330300"}, {id: "950", areaID: "330304", area: "\u74ef\u6d77\u533a", fatherID: "330300"}, {
        id: "951",
        areaID: "330322",
        area: "\u6d1e\u5934\u53bf",
        fatherID: "330300"
    }, {id: "952", areaID: "330324", area: "\u6c38\u5609\u53bf", fatherID: "330300"}, {id: "953", areaID: "330326", area: "\u5e73\u9633\u53bf", fatherID: "330300"}, {id: "954", areaID: "330327", area: "\u82cd\u5357\u53bf", fatherID: "330300"}, {id: "955", areaID: "330328", area: "\u6587\u6210\u53bf", fatherID: "330300"}, {id: "956", areaID: "330329", area: "\u6cf0\u987a\u53bf", fatherID: "330300"}, {id: "957", areaID: "330381", area: "\u745e\u5b89\u5e02", fatherID: "330300"}, {id: "958", areaID: "330382", area: "\u4e50\u6e05\u5e02", fatherID: "330300"}, {id: "959", areaID: "330401", area: "\u5e02\u8f96\u533a", fatherID: "330400"}, {id: "960", areaID: "330402", area: "\u79c0\u57ce\u533a", fatherID: "330400"}, {
        id: "961",
        areaID: "330411",
        area: "\u79c0\u6d32\u533a",
        fatherID: "330400"
    }, {id: "962", areaID: "330421", area: "\u5609\u5584\u53bf", fatherID: "330400"}, {id: "963", areaID: "330424", area: "\u6d77\u76d0\u53bf", fatherID: "330400"}, {id: "964", areaID: "330481", area: "\u6d77\u5b81\u5e02", fatherID: "330400"}, {id: "965", areaID: "330482", area: "\u5e73\u6e56\u5e02", fatherID: "330400"}, {id: "966", areaID: "330483", area: "\u6850\u4e61\u5e02", fatherID: "330400"}, {id: "967", areaID: "330501", area: "\u5e02\u8f96\u533a", fatherID: "330500"}, {id: "968", areaID: "330502", area: "\u5434\u5174\u533a", fatherID: "330500"}, {id: "969", areaID: "330503", area: "\u5357\u6d54\u533a", fatherID: "330500"}, {id: "970", areaID: "330521", area: "\u5fb7\u6e05\u53bf", fatherID: "330500"}, {
        id: "971",
        areaID: "330522",
        area: "\u957f\u5174\u53bf",
        fatherID: "330500"
    }, {id: "972", areaID: "330523", area: "\u5b89\u5409\u53bf", fatherID: "330500"}, {id: "973", areaID: "330601", area: "\u5e02\u8f96\u533a", fatherID: "330600"}, {id: "974", areaID: "330602", area: "\u8d8a\u57ce\u533a", fatherID: "330600"}, {id: "975", areaID: "330621", area: "\u7ecd\u5174\u53bf", fatherID: "330600"}, {id: "976", areaID: "330624", area: "\u65b0\u660c\u53bf", fatherID: "330600"}, {id: "977", areaID: "330681", area: "\u8bf8\u66a8\u5e02", fatherID: "330600"}, {id: "978", areaID: "330682", area: "\u4e0a\u865e\u5e02", fatherID: "330600"}, {id: "979", areaID: "330683", area: "\u5d4a\u5dde\u5e02", fatherID: "330600"}, {id: "980", areaID: "330701", area: "\u5e02\u8f96\u533a", fatherID: "330700"}, {
        id: "981",
        areaID: "330702",
        area: "\u5a7a\u57ce\u533a",
        fatherID: "330700"
    }, {id: "982", areaID: "330703", area: "\u91d1\u4e1c\u533a", fatherID: "330700"}, {id: "983", areaID: "330723", area: "\u6b66\u4e49\u53bf", fatherID: "330700"}, {id: "984", areaID: "330726", area: "\u6d66\u6c5f\u53bf", fatherID: "330700"}, {id: "985", areaID: "330727", area: "\u78d0\u5b89\u53bf", fatherID: "330700"}, {id: "986", areaID: "330781", area: "\u5170\u6eaa\u5e02", fatherID: "330700"}, {id: "987", areaID: "330782", area: "\u4e49\u4e4c\u5e02", fatherID: "330700"}, {id: "988", areaID: "330783", area: "\u4e1c\u9633\u5e02", fatherID: "330700"}, {id: "989", areaID: "330784", area: "\u6c38\u5eb7\u5e02", fatherID: "330700"}, {id: "990", areaID: "330801", area: "\u5e02\u8f96\u533a", fatherID: "330800"}, {
        id: "991",
        areaID: "330802",
        area: "\u67ef\u57ce\u533a",
        fatherID: "330800"
    }, {id: "992", areaID: "330803", area: "\u8862\u6c5f\u533a", fatherID: "330800"}, {id: "993", areaID: "330822", area: "\u5e38\u5c71\u53bf", fatherID: "330800"}, {id: "994", areaID: "330824", area: "\u5f00\u5316\u53bf", fatherID: "330800"}, {id: "995", areaID: "330825", area: "\u9f99\u6e38\u53bf", fatherID: "330800"}, {id: "996", areaID: "330881", area: "\u6c5f\u5c71\u5e02", fatherID: "330800"}, {id: "997", areaID: "330901", area: "\u5e02\u8f96\u533a", fatherID: "330900"}, {id: "998", areaID: "330902", area: "\u5b9a\u6d77\u533a", fatherID: "330900"}, {id: "999", areaID: "330903", area: "\u666e\u9640\u533a", fatherID: "330900"}, {id: "1000", areaID: "330921", area: "\u5cb1\u5c71\u53bf", fatherID: "330900"}, {
        id: "1001",
        areaID: "330922",
        area: "\u5d4a\u6cd7\u53bf",
        fatherID: "330900"
    }, {id: "1002", areaID: "331001", area: "\u5e02\u8f96\u533a", fatherID: "331000"}, {id: "1003", areaID: "331002", area: "\u6912\u6c5f\u533a", fatherID: "331000"}, {id: "1004", areaID: "331003", area: "\u9ec4\u5ca9\u533a", fatherID: "331000"}, {id: "1005", areaID: "331004", area: "\u8def\u6865\u533a", fatherID: "331000"}, {id: "1006", areaID: "331021", area: "\u7389\u73af\u53bf", fatherID: "331000"}, {id: "1007", areaID: "331022", area: "\u4e09\u95e8\u53bf", fatherID: "331000"}, {id: "1008", areaID: "331023", area: "\u5929\u53f0\u53bf", fatherID: "331000"}, {id: "1009", areaID: "331024", area: "\u4ed9\u5c45\u53bf", fatherID: "331000"}, {id: "1010", areaID: "331081", area: "\u6e29\u5cad\u5e02", fatherID: "331000"}, {
        id: "1011",
        areaID: "331082",
        area: "\u4e34\u6d77\u5e02",
        fatherID: "331000"
    }, {id: "1012", areaID: "331101", area: "\u5e02\u8f96\u533a", fatherID: "331100"}, {id: "1013", areaID: "331102", area: "\u83b2\u90fd\u533a", fatherID: "331100"}, {id: "1014", areaID: "331121", area: "\u9752\u7530\u53bf", fatherID: "331100"}, {id: "1015", areaID: "331122", area: "\u7f19\u4e91\u53bf", fatherID: "331100"}, {id: "1016", areaID: "331123", area: "\u9042\u660c\u53bf", fatherID: "331100"}, {id: "1017", areaID: "331124", area: "\u677e\u9633\u53bf", fatherID: "331100"}, {id: "1018", areaID: "331125", area: "\u4e91\u548c\u53bf", fatherID: "331100"}, {id: "1019", areaID: "331126", area: "\u5e86\u5143\u53bf", fatherID: "331100"}, {id: "1020", areaID: "331127", area: "\u666f\u5b81\u7572\u65cf\u81ea\u6cbb\u53bf", fatherID: "331100"}, {
        id: "1021",
        areaID: "331181",
        area: "\u9f99\u6cc9\u5e02",
        fatherID: "331100"
    }, {id: "1022", areaID: "340101", area: "\u5e02\u8f96\u533a", fatherID: "340100"}, {id: "1023", areaID: "340102", area: "\u7476\u6d77\u533a", fatherID: "340100"}, {id: "1024", areaID: "340103", area: "\u5e90\u9633\u533a", fatherID: "340100"}, {id: "1025", areaID: "340104", area: "\u8700\u5c71\u533a", fatherID: "340100"}, {id: "1026", areaID: "340111", area: "\u5305\u6cb3\u533a", fatherID: "340100"}, {id: "1027", areaID: "340121", area: "\u957f\u4e30\u53bf", fatherID: "340100"}, {id: "1028", areaID: "340122", area: "\u80a5\u4e1c\u53bf", fatherID: "340100"}, {id: "1029", areaID: "340123", area: "\u80a5\u897f\u53bf", fatherID: "340100"}, {id: "1030", areaID: "340201", area: "\u5e02\u8f96\u533a", fatherID: "340200"}, {
        id: "1031",
        areaID: "340202",
        area: "\u955c\u6e56\u533a",
        fatherID: "340200"
    }, {id: "1032", areaID: "340203", area: "\u9a6c\u5858\u533a", fatherID: "340200"}, {id: "1033", areaID: "340204", area: "\u65b0\u829c\u533a", fatherID: "340200"}, {id: "1034", areaID: "340207", area: "\u9e20\u6c5f\u533a", fatherID: "340200"}, {id: "1035", areaID: "340221", area: "\u829c\u6e56\u53bf", fatherID: "340200"}, {id: "1036", areaID: "340222", area: "\u7e41\u660c\u53bf", fatherID: "340200"}, {id: "1037", areaID: "340223", area: "\u5357\u9675\u53bf", fatherID: "340200"}, {id: "1038", areaID: "340301", area: "\u5e02\u8f96\u533a", fatherID: "340300"}, {id: "1039", areaID: "340302", area: "\u9f99\u5b50\u6e56\u533a", fatherID: "340300"}, {id: "1040", areaID: "340303", area: "\u868c\u5c71\u533a", fatherID: "340300"}, {
        id: "1041",
        areaID: "340304",
        area: "\u79b9\u4f1a\u533a",
        fatherID: "340300"
    }, {id: "1042", areaID: "340311", area: "\u6dee\u4e0a\u533a", fatherID: "340300"}, {id: "1043", areaID: "340321", area: "\u6000\u8fdc\u53bf", fatherID: "340300"}, {id: "1044", areaID: "340322", area: "\u4e94\u6cb3\u53bf", fatherID: "340300"}, {id: "1045", areaID: "340323", area: "\u56fa\u9547\u53bf", fatherID: "340300"}, {id: "1046", areaID: "340401", area: "\u5e02\u8f96\u533a", fatherID: "340400"}, {id: "1047", areaID: "340402", area: "\u5927\u901a\u533a", fatherID: "340400"}, {id: "1048", areaID: "340403", area: "\u7530\u5bb6\u5eb5\u533a", fatherID: "340400"}, {id: "1049", areaID: "340404", area: "\u8c22\u5bb6\u96c6\u533a", fatherID: "340400"}, {id: "1050", areaID: "340405", area: "\u516b\u516c\u5c71\u533a", fatherID: "340400"}, {
        id: "1051",
        areaID: "340406",
        area: "\u6f58\u96c6\u533a",
        fatherID: "340400"
    }, {id: "1052", areaID: "340421", area: "\u51e4\u53f0\u53bf", fatherID: "340400"}, {id: "1053", areaID: "340501", area: "\u5e02\u8f96\u533a", fatherID: "340500"}, {id: "1054", areaID: "340502", area: "\u91d1\u5bb6\u5e84\u533a", fatherID: "340500"}, {id: "1055", areaID: "340503", area: "\u82b1\u5c71\u533a", fatherID: "340500"}, {id: "1056", areaID: "340504", area: "\u96e8\u5c71\u533a", fatherID: "340500"}, {id: "1057", areaID: "340521", area: "\u5f53\u6d82\u53bf", fatherID: "340500"}, {id: "1058", areaID: "340601", area: "\u5e02\u8f96\u533a", fatherID: "340600"}, {id: "1059", areaID: "340602", area: "\u675c\u96c6\u533a", fatherID: "340600"}, {id: "1060", areaID: "340603", area: "\u76f8\u5c71\u533a", fatherID: "340600"}, {
        id: "1061",
        areaID: "340604",
        area: "\u70c8\u5c71\u533a",
        fatherID: "340600"
    }, {id: "1062", areaID: "340621", area: "\u6fc9\u6eaa\u53bf", fatherID: "340600"}, {id: "1063", areaID: "340701", area: "\u5e02\u8f96\u533a", fatherID: "340700"}, {id: "1064", areaID: "340702", area: "\u94dc\u5b98\u5c71\u533a", fatherID: "340700"}, {id: "1065", areaID: "340703", area: "\u72ee\u5b50\u5c71\u533a", fatherID: "340700"}, {id: "1066", areaID: "340711", area: "\u90ca\u3000\u533a", fatherID: "340700"}, {id: "1067", areaID: "340721", area: "\u94dc\u9675\u53bf", fatherID: "340700"}, {id: "1068", areaID: "340801", area: "\u5e02\u8f96\u533a", fatherID: "340800"}, {id: "1069", areaID: "340802", area: "\u8fce\u6c5f\u533a", fatherID: "340800"}, {id: "1070", areaID: "340803", area: "\u5927\u89c2\u533a", fatherID: "340800"}, {
        id: "1071",
        areaID: "340811",
        area: "\u90ca\u3000\u533a",
        fatherID: "340800"
    }, {id: "1072", areaID: "340822", area: "\u6000\u5b81\u53bf", fatherID: "340800"}, {id: "1073", areaID: "340823", area: "\u679e\u9633\u53bf", fatherID: "340800"}, {id: "1074", areaID: "340824", area: "\u6f5c\u5c71\u53bf", fatherID: "340800"}, {id: "1075", areaID: "340825", area: "\u592a\u6e56\u53bf", fatherID: "340800"}, {id: "1076", areaID: "340826", area: "\u5bbf\u677e\u53bf", fatherID: "340800"}, {id: "1077", areaID: "340827", area: "\u671b\u6c5f\u53bf", fatherID: "340800"}, {id: "1078", areaID: "340828", area: "\u5cb3\u897f\u53bf", fatherID: "340800"}, {id: "1079", areaID: "340881", area: "\u6850\u57ce\u5e02", fatherID: "340800"}, {id: "1080", areaID: "341001", area: "\u5e02\u8f96\u533a", fatherID: "341000"}, {
        id: "1081",
        areaID: "341002",
        area: "\u5c6f\u6eaa\u533a",
        fatherID: "341000"
    }, {id: "1082", areaID: "341003", area: "\u9ec4\u5c71\u533a", fatherID: "341000"}, {id: "1083", areaID: "341004", area: "\u5fbd\u5dde\u533a", fatherID: "341000"}, {id: "1084", areaID: "341021", area: "\u6b59\u3000\u53bf", fatherID: "341000"}, {id: "1085", areaID: "341022", area: "\u4f11\u5b81\u53bf", fatherID: "341000"}, {id: "1086", areaID: "341023", area: "\u9edf\u3000\u53bf", fatherID: "341000"}, {id: "1087", areaID: "341024", area: "\u7941\u95e8\u53bf", fatherID: "341000"}, {id: "1088", areaID: "341101", area: "\u5e02\u8f96\u533a", fatherID: "341100"}, {id: "1089", areaID: "341102", area: "\u7405\u740a\u533a", fatherID: "341100"}, {id: "1090", areaID: "341103", area: "\u5357\u8c2f\u533a", fatherID: "341100"}, {
        id: "1091",
        areaID: "341122",
        area: "\u6765\u5b89\u53bf",
        fatherID: "341100"
    }, {id: "1092", areaID: "341124", area: "\u5168\u6912\u53bf", fatherID: "341100"}, {id: "1093", areaID: "341125", area: "\u5b9a\u8fdc\u53bf", fatherID: "341100"}, {id: "1094", areaID: "341126", area: "\u51e4\u9633\u53bf", fatherID: "341100"}, {id: "1095", areaID: "341181", area: "\u5929\u957f\u5e02", fatherID: "341100"}, {id: "1096", areaID: "341182", area: "\u660e\u5149\u5e02", fatherID: "341100"}, {id: "1097", areaID: "341201", area: "\u5e02\u8f96\u533a", fatherID: "341200"}, {id: "1098", areaID: "341202", area: "\u988d\u5dde\u533a", fatherID: "341200"}, {id: "1099", areaID: "341203", area: "\u988d\u4e1c\u533a", fatherID: "341200"}, {id: "1100", areaID: "341204", area: "\u988d\u6cc9\u533a", fatherID: "341200"}, {
        id: "1101",
        areaID: "341221",
        area: "\u4e34\u6cc9\u53bf",
        fatherID: "341200"
    }, {id: "1102", areaID: "341222", area: "\u592a\u548c\u53bf", fatherID: "341200"}, {id: "1103", areaID: "341225", area: "\u961c\u5357\u53bf", fatherID: "341200"}, {id: "1104", areaID: "341226", area: "\u988d\u4e0a\u53bf", fatherID: "341200"}, {id: "1105", areaID: "341282", area: "\u754c\u9996\u5e02", fatherID: "341200"}, {id: "1106", areaID: "341301", area: "\u5e02\u8f96\u533a", fatherID: "341300"}, {id: "1107", areaID: "341302", area: "\u5889\u6865\u533a", fatherID: "341300"}, {id: "1108", areaID: "341321", area: "\u7800\u5c71\u53bf", fatherID: "341300"}, {id: "1109", areaID: "341322", area: "\u8427\u3000\u53bf", fatherID: "341300"}, {id: "1110", areaID: "341323", area: "\u7075\u74a7\u53bf", fatherID: "341300"}, {
        id: "1111",
        areaID: "341324",
        area: "\u6cd7\u3000\u53bf",
        fatherID: "341300"
    }, {id: "1112", areaID: "341401", area: "\u5e02\u8f96\u533a", fatherID: "341400"}, {id: "1113", areaID: "341402", area: "\u5c45\u5de2\u533a", fatherID: "341400"}, {id: "1114", areaID: "341421", area: "\u5e90\u6c5f\u53bf", fatherID: "341400"}, {id: "1115", areaID: "341422", area: "\u65e0\u4e3a\u53bf", fatherID: "341400"}, {id: "1116", areaID: "341423", area: "\u542b\u5c71\u53bf", fatherID: "341400"}, {id: "1117", areaID: "341424", area: "\u548c\u3000\u53bf", fatherID: "341400"}, {id: "1118", areaID: "341501", area: "\u5e02\u8f96\u533a", fatherID: "341500"}, {id: "1119", areaID: "341502", area: "\u91d1\u5b89\u533a", fatherID: "341500"}, {id: "1120", areaID: "341503", area: "\u88d5\u5b89\u533a", fatherID: "341500"}, {
        id: "1121",
        areaID: "341521",
        area: "\u5bff\u3000\u53bf",
        fatherID: "341500"
    }, {id: "1122", areaID: "341522", area: "\u970d\u90b1\u53bf", fatherID: "341500"}, {id: "1123", areaID: "341523", area: "\u8212\u57ce\u53bf", fatherID: "341500"}, {id: "1124", areaID: "341524", area: "\u91d1\u5be8\u53bf", fatherID: "341500"}, {id: "1125", areaID: "341525", area: "\u970d\u5c71\u53bf", fatherID: "341500"}, {id: "1126", areaID: "341601", area: "\u5e02\u8f96\u533a", fatherID: "341600"}, {id: "1127", areaID: "341602", area: "\u8c2f\u57ce\u533a", fatherID: "341600"}, {id: "1128", areaID: "341621", area: "\u6da1\u9633\u53bf", fatherID: "341600"}, {id: "1129", areaID: "341622", area: "\u8499\u57ce\u53bf", fatherID: "341600"}, {id: "1130", areaID: "341623", area: "\u5229\u8f9b\u53bf", fatherID: "341600"}, {
        id: "1131",
        areaID: "341701",
        area: "\u5e02\u8f96\u533a",
        fatherID: "341700"
    }, {id: "1132", areaID: "341702", area: "\u8d35\u6c60\u533a", fatherID: "341700"}, {id: "1133", areaID: "341721", area: "\u4e1c\u81f3\u53bf", fatherID: "341700"}, {id: "1134", areaID: "341722", area: "\u77f3\u53f0\u53bf", fatherID: "341700"}, {id: "1135", areaID: "341723", area: "\u9752\u9633\u53bf", fatherID: "341700"}, {id: "1136", areaID: "341801", area: "\u5e02\u8f96\u533a", fatherID: "341800"}, {id: "1137", areaID: "341802", area: "\u5ba3\u5dde\u533a", fatherID: "341800"}, {id: "1138", areaID: "341821", area: "\u90ce\u6eaa\u53bf", fatherID: "341800"}, {id: "1139", areaID: "341822", area: "\u5e7f\u5fb7\u53bf", fatherID: "341800"}, {id: "1140", areaID: "341823", area: "\u6cfe\u3000\u53bf", fatherID: "341800"}, {
        id: "1141",
        areaID: "341824",
        area: "\u7ee9\u6eaa\u53bf",
        fatherID: "341800"
    }, {id: "1142", areaID: "341825", area: "\u65cc\u5fb7\u53bf", fatherID: "341800"}, {id: "1143", areaID: "341881", area: "\u5b81\u56fd\u5e02", fatherID: "341800"}, {id: "1144", areaID: "350101", area: "\u5e02\u8f96\u533a", fatherID: "350100"}, {id: "1145", areaID: "350102", area: "\u9f13\u697c\u533a", fatherID: "350100"}, {id: "1146", areaID: "350103", area: "\u53f0\u6c5f\u533a", fatherID: "350100"}, {id: "1147", areaID: "350104", area: "\u4ed3\u5c71\u533a", fatherID: "350100"}, {id: "1148", areaID: "350105", area: "\u9a6c\u5c3e\u533a", fatherID: "350100"}, {id: "1149", areaID: "350111", area: "\u664b\u5b89\u533a", fatherID: "350100"}, {id: "1150", areaID: "350121", area: "\u95fd\u4faf\u53bf", fatherID: "350100"}, {
        id: "1151",
        areaID: "350122",
        area: "\u8fde\u6c5f\u53bf",
        fatherID: "350100"
    }, {id: "1152", areaID: "350123", area: "\u7f57\u6e90\u53bf", fatherID: "350100"}, {id: "1153", areaID: "350124", area: "\u95fd\u6e05\u53bf", fatherID: "350100"}, {id: "1154", areaID: "350125", area: "\u6c38\u6cf0\u53bf", fatherID: "350100"}, {id: "1155", areaID: "350128", area: "\u5e73\u6f6d\u53bf", fatherID: "350100"}, {id: "1156", areaID: "350181", area: "\u798f\u6e05\u5e02", fatherID: "350100"}, {id: "1157", areaID: "350182", area: "\u957f\u4e50\u5e02", fatherID: "350100"}, {id: "1158", areaID: "350201", area: "\u5e02\u8f96\u533a", fatherID: "350200"}, {id: "1159", areaID: "350203", area: "\u601d\u660e\u533a", fatherID: "350200"}, {id: "1160", areaID: "350205", area: "\u6d77\u6ca7\u533a", fatherID: "350200"}, {
        id: "1161",
        areaID: "350206",
        area: "\u6e56\u91cc\u533a",
        fatherID: "350200"
    }, {id: "1162", areaID: "350211", area: "\u96c6\u7f8e\u533a", fatherID: "350200"}, {id: "1163", areaID: "350212", area: "\u540c\u5b89\u533a", fatherID: "350200"}, {id: "1164", areaID: "350213", area: "\u7fd4\u5b89\u533a", fatherID: "350200"}, {id: "1165", areaID: "350301", area: "\u5e02\u8f96\u533a", fatherID: "350300"}, {id: "1166", areaID: "350302", area: "\u57ce\u53a2\u533a", fatherID: "350300"}, {id: "1167", areaID: "350303", area: "\u6db5\u6c5f\u533a", fatherID: "350300"}, {id: "1168", areaID: "350304", area: "\u8354\u57ce\u533a", fatherID: "350300"}, {id: "1169", areaID: "350305", area: "\u79c0\u5c7f\u533a", fatherID: "350300"}, {id: "1170", areaID: "350322", area: "\u4ed9\u6e38\u53bf", fatherID: "350300"}, {
        id: "1171",
        areaID: "350401",
        area: "\u5e02\u8f96\u533a",
        fatherID: "350400"
    }, {id: "1172", areaID: "350402", area: "\u6885\u5217\u533a", fatherID: "350400"}, {id: "1173", areaID: "350403", area: "\u4e09\u5143\u533a", fatherID: "350400"}, {id: "1174", areaID: "350421", area: "\u660e\u6eaa\u53bf", fatherID: "350400"}, {id: "1175", areaID: "350423", area: "\u6e05\u6d41\u53bf", fatherID: "350400"}, {id: "1176", areaID: "350424", area: "\u5b81\u5316\u53bf", fatherID: "350400"}, {id: "1177", areaID: "350425", area: "\u5927\u7530\u53bf", fatherID: "350400"}, {id: "1178", areaID: "350426", area: "\u5c24\u6eaa\u53bf", fatherID: "350400"}, {id: "1179", areaID: "350427", area: "\u6c99\u3000\u53bf", fatherID: "350400"}, {id: "1180", areaID: "350428", area: "\u5c06\u4e50\u53bf", fatherID: "350400"}, {
        id: "1181",
        areaID: "350429",
        area: "\u6cf0\u5b81\u53bf",
        fatherID: "350400"
    }, {id: "1182", areaID: "350430", area: "\u5efa\u5b81\u53bf", fatherID: "350400"}, {id: "1183", areaID: "350481", area: "\u6c38\u5b89\u5e02", fatherID: "350400"}, {id: "1184", areaID: "350501", area: "\u5e02\u8f96\u533a", fatherID: "350500"}, {id: "1185", areaID: "350502", area: "\u9ca4\u57ce\u533a", fatherID: "350500"}, {id: "1186", areaID: "350503", area: "\u4e30\u6cfd\u533a", fatherID: "350500"}, {id: "1187", areaID: "350504", area: "\u6d1b\u6c5f\u533a", fatherID: "350500"}, {id: "1188", areaID: "350505", area: "\u6cc9\u6e2f\u533a", fatherID: "350500"}, {id: "1189", areaID: "350521", area: "\u60e0\u5b89\u53bf", fatherID: "350500"}, {id: "1190", areaID: "350524", area: "\u5b89\u6eaa\u53bf", fatherID: "350500"}, {
        id: "1191",
        areaID: "350525",
        area: "\u6c38\u6625\u53bf",
        fatherID: "350500"
    }, {id: "1192", areaID: "350526", area: "\u5fb7\u5316\u53bf", fatherID: "350500"}, {id: "1193", areaID: "350527", area: "\u91d1\u95e8\u53bf", fatherID: "350500"}, {id: "1194", areaID: "350581", area: "\u77f3\u72ee\u5e02", fatherID: "350500"}, {id: "1195", areaID: "350582", area: "\u664b\u6c5f\u5e02", fatherID: "350500"}, {id: "1196", areaID: "350583", area: "\u5357\u5b89\u5e02", fatherID: "350500"}, {id: "1197", areaID: "350601", area: "\u5e02\u8f96\u533a", fatherID: "350600"}, {id: "1198", areaID: "350602", area: "\u8297\u57ce\u533a", fatherID: "350600"}, {id: "1199", areaID: "350603", area: "\u9f99\u6587\u533a", fatherID: "350600"}, {id: "1200", areaID: "350622", area: "\u4e91\u9704\u53bf", fatherID: "350600"}, {
        id: "1201",
        areaID: "350623",
        area: "\u6f33\u6d66\u53bf",
        fatherID: "350600"
    }, {id: "1202", areaID: "350624", area: "\u8bcf\u5b89\u53bf", fatherID: "350600"}, {id: "1203", areaID: "350625", area: "\u957f\u6cf0\u53bf", fatherID: "350600"}, {id: "1204", areaID: "350626", area: "\u4e1c\u5c71\u53bf", fatherID: "350600"}, {id: "1205", areaID: "350627", area: "\u5357\u9756\u53bf", fatherID: "350600"}, {id: "1206", areaID: "350628", area: "\u5e73\u548c\u53bf", fatherID: "350600"}, {id: "1207", areaID: "350629", area: "\u534e\u5b89\u53bf", fatherID: "350600"}, {id: "1208", areaID: "350681", area: "\u9f99\u6d77\u5e02", fatherID: "350600"}, {id: "1209", areaID: "350701", area: "\u5e02\u8f96\u533a", fatherID: "350700"}, {id: "1210", areaID: "350702", area: "\u5ef6\u5e73\u533a", fatherID: "350700"}, {
        id: "1211",
        areaID: "350721",
        area: "\u987a\u660c\u53bf",
        fatherID: "350700"
    }, {id: "1212", areaID: "350722", area: "\u6d66\u57ce\u53bf", fatherID: "350700"}, {id: "1213", areaID: "350723", area: "\u5149\u6cfd\u53bf", fatherID: "350700"}, {id: "1214", areaID: "350724", area: "\u677e\u6eaa\u53bf", fatherID: "350700"}, {id: "1215", areaID: "350725", area: "\u653f\u548c\u53bf", fatherID: "350700"}, {id: "1216", areaID: "350781", area: "\u90b5\u6b66\u5e02", fatherID: "350700"}, {id: "1217", areaID: "350782", area: "\u6b66\u5937\u5c71\u5e02", fatherID: "350700"}, {id: "1218", areaID: "350783", area: "\u5efa\u74ef\u5e02", fatherID: "350700"}, {id: "1219", areaID: "350784", area: "\u5efa\u9633\u5e02", fatherID: "350700"}, {id: "1220", areaID: "350801", area: "\u5e02\u8f96\u533a", fatherID: "350800"}, {
        id: "1221",
        areaID: "350802",
        area: "\u65b0\u7f57\u533a",
        fatherID: "350800"
    }, {id: "1222", areaID: "350821", area: "\u957f\u6c40\u53bf", fatherID: "350800"}, {id: "1223", areaID: "350822", area: "\u6c38\u5b9a\u53bf", fatherID: "350800"}, {id: "1224", areaID: "350823", area: "\u4e0a\u676d\u53bf", fatherID: "350800"}, {id: "1225", areaID: "350824", area: "\u6b66\u5e73\u53bf", fatherID: "350800"}, {id: "1226", areaID: "350825", area: "\u8fde\u57ce\u53bf", fatherID: "350800"}, {id: "1227", areaID: "350881", area: "\u6f33\u5e73\u5e02", fatherID: "350800"}, {id: "1228", areaID: "350901", area: "\u5e02\u8f96\u533a", fatherID: "350900"}, {id: "1229", areaID: "350902", area: "\u8549\u57ce\u533a", fatherID: "350900"}, {id: "1230", areaID: "350921", area: "\u971e\u6d66\u53bf", fatherID: "350900"}, {
        id: "1231",
        areaID: "350922",
        area: "\u53e4\u7530\u53bf",
        fatherID: "350900"
    }, {id: "1232", areaID: "350923", area: "\u5c4f\u5357\u53bf", fatherID: "350900"}, {id: "1233", areaID: "350924", area: "\u5bff\u5b81\u53bf", fatherID: "350900"}, {id: "1234", areaID: "350925", area: "\u5468\u5b81\u53bf", fatherID: "350900"}, {id: "1235", areaID: "350926", area: "\u67d8\u8363\u53bf", fatherID: "350900"}, {id: "1236", areaID: "350981", area: "\u798f\u5b89\u5e02", fatherID: "350900"}, {id: "1237", areaID: "350982", area: "\u798f\u9f0e\u5e02", fatherID: "350900"}, {id: "1238", areaID: "360101", area: "\u5e02\u8f96\u533a", fatherID: "360100"}, {id: "1239", areaID: "360102", area: "\u4e1c\u6e56\u533a", fatherID: "360100"}, {id: "1240", areaID: "360103", area: "\u897f\u6e56\u533a", fatherID: "360100"}, {
        id: "1241",
        areaID: "360104",
        area: "\u9752\u4e91\u8c31\u533a",
        fatherID: "360100"
    }, {id: "1242", areaID: "360105", area: "\u6e7e\u91cc\u533a", fatherID: "360100"}, {id: "1243", areaID: "360111", area: "\u9752\u5c71\u6e56\u533a", fatherID: "360100"}, {id: "1244", areaID: "360121", area: "\u5357\u660c\u53bf", fatherID: "360100"}, {id: "1245", areaID: "360122", area: "\u65b0\u5efa\u53bf", fatherID: "360100"}, {id: "1246", areaID: "360123", area: "\u5b89\u4e49\u53bf", fatherID: "360100"}, {id: "1247", areaID: "360124", area: "\u8fdb\u8d24\u53bf", fatherID: "360100"}, {id: "1248", areaID: "360201", area: "\u5e02\u8f96\u533a", fatherID: "360200"}, {id: "1249", areaID: "360202", area: "\u660c\u6c5f\u533a", fatherID: "360200"}, {id: "1250", areaID: "360203", area: "\u73e0\u5c71\u533a", fatherID: "360200"}, {
        id: "1251",
        areaID: "360222",
        area: "\u6d6e\u6881\u53bf",
        fatherID: "360200"
    }, {id: "1252", areaID: "360281", area: "\u4e50\u5e73\u5e02", fatherID: "360200"}, {id: "1253", areaID: "360301", area: "\u5e02\u8f96\u533a", fatherID: "360300"}, {id: "1254", areaID: "360302", area: "\u5b89\u6e90\u533a", fatherID: "360300"}, {id: "1255", areaID: "360313", area: "\u6e58\u4e1c\u533a", fatherID: "360300"}, {id: "1256", areaID: "360321", area: "\u83b2\u82b1\u53bf", fatherID: "360300"}, {id: "1257", areaID: "360322", area: "\u4e0a\u6817\u53bf", fatherID: "360300"}, {id: "1258", areaID: "360323", area: "\u82a6\u6eaa\u53bf", fatherID: "360300"}, {id: "1259", areaID: "360401", area: "\u5e02\u8f96\u533a", fatherID: "360400"}, {id: "1260", areaID: "360402", area: "\u5e90\u5c71\u533a", fatherID: "360400"}, {
        id: "1261",
        areaID: "360403",
        area: "\u6d54\u9633\u533a",
        fatherID: "360400"
    }, {id: "1262", areaID: "360421", area: "\u4e5d\u6c5f\u53bf", fatherID: "360400"}, {id: "1263", areaID: "360423", area: "\u6b66\u5b81\u53bf", fatherID: "360400"}, {id: "1264", areaID: "360424", area: "\u4fee\u6c34\u53bf", fatherID: "360400"}, {id: "1265", areaID: "360425", area: "\u6c38\u4fee\u53bf", fatherID: "360400"}, {id: "1266", areaID: "360426", area: "\u5fb7\u5b89\u53bf", fatherID: "360400"}, {id: "1267", areaID: "360427", area: "\u661f\u5b50\u53bf", fatherID: "360400"}, {id: "1268", areaID: "360428", area: "\u90fd\u660c\u53bf", fatherID: "360400"}, {id: "1269", areaID: "360429", area: "\u6e56\u53e3\u53bf", fatherID: "360400"}, {id: "1270", areaID: "360430", area: "\u5f6d\u6cfd\u53bf", fatherID: "360400"}, {
        id: "1271",
        areaID: "360481",
        area: "\u745e\u660c\u5e02",
        fatherID: "360400"
    }, {id: "1272", areaID: "360501", area: "\u5e02\u8f96\u533a", fatherID: "360500"}, {id: "1273", areaID: "360502", area: "\u6e1d\u6c34\u533a", fatherID: "360500"}, {id: "1274", areaID: "360521", area: "\u5206\u5b9c\u53bf", fatherID: "360500"}, {id: "1275", areaID: "360601", area: "\u5e02\u8f96\u533a", fatherID: "360600"}, {id: "1276", areaID: "360602", area: "\u6708\u6e56\u533a", fatherID: "360600"}, {id: "1277", areaID: "360622", area: "\u4f59\u6c5f\u53bf", fatherID: "360600"}, {id: "1278", areaID: "360681", area: "\u8d35\u6eaa\u5e02", fatherID: "360600"}, {id: "1279", areaID: "360701", area: "\u5e02\u8f96\u533a", fatherID: "360700"}, {id: "1280", areaID: "360702", area: "\u7ae0\u8d21\u533a", fatherID: "360700"}, {
        id: "1281",
        areaID: "360721",
        area: "\u8d63\u3000\u53bf",
        fatherID: "360700"
    }, {id: "1282", areaID: "360722", area: "\u4fe1\u4e30\u53bf", fatherID: "360700"}, {id: "1283", areaID: "360723", area: "\u5927\u4f59\u53bf", fatherID: "360700"}, {id: "1284", areaID: "360724", area: "\u4e0a\u72b9\u53bf", fatherID: "360700"}, {id: "1285", areaID: "360725", area: "\u5d07\u4e49\u53bf", fatherID: "360700"}, {id: "1286", areaID: "360726", area: "\u5b89\u8fdc\u53bf", fatherID: "360700"}, {id: "1287", areaID: "360727", area: "\u9f99\u5357\u53bf", fatherID: "360700"}, {id: "1288", areaID: "360728", area: "\u5b9a\u5357\u53bf", fatherID: "360700"}, {id: "1289", areaID: "360729", area: "\u5168\u5357\u53bf", fatherID: "360700"}, {id: "1290", areaID: "360730", area: "\u5b81\u90fd\u53bf", fatherID: "360700"}, {
        id: "1291",
        areaID: "360731",
        area: "\u4e8e\u90fd\u53bf",
        fatherID: "360700"
    }, {id: "1292", areaID: "360732", area: "\u5174\u56fd\u53bf", fatherID: "360700"}, {id: "1293", areaID: "360733", area: "\u4f1a\u660c\u53bf", fatherID: "360700"}, {id: "1294", areaID: "360734", area: "\u5bfb\u4e4c\u53bf", fatherID: "360700"}, {id: "1295", areaID: "360735", area: "\u77f3\u57ce\u53bf", fatherID: "360700"}, {id: "1296", areaID: "360781", area: "\u745e\u91d1\u5e02", fatherID: "360700"}, {id: "1297", areaID: "360782", area: "\u5357\u5eb7\u5e02", fatherID: "360700"}, {id: "1298", areaID: "360801", area: "\u5e02\u8f96\u533a", fatherID: "360800"}, {id: "1299", areaID: "360802", area: "\u5409\u5dde\u533a", fatherID: "360800"}, {id: "1300", areaID: "360803", area: "\u9752\u539f\u533a", fatherID: "360800"}, {
        id: "1301",
        areaID: "360821",
        area: "\u5409\u5b89\u53bf",
        fatherID: "360800"
    }, {id: "1302", areaID: "360822", area: "\u5409\u6c34\u53bf", fatherID: "360800"}, {id: "1303", areaID: "360823", area: "\u5ce1\u6c5f\u53bf", fatherID: "360800"}, {id: "1304", areaID: "360824", area: "\u65b0\u5e72\u53bf", fatherID: "360800"}, {id: "1305", areaID: "360825", area: "\u6c38\u4e30\u53bf", fatherID: "360800"}, {id: "1306", areaID: "360826", area: "\u6cf0\u548c\u53bf", fatherID: "360800"}, {id: "1307", areaID: "360827", area: "\u9042\u5ddd\u53bf", fatherID: "360800"}, {id: "1308", areaID: "360828", area: "\u4e07\u5b89\u53bf", fatherID: "360800"}, {id: "1309", areaID: "360829", area: "\u5b89\u798f\u53bf", fatherID: "360800"}, {id: "1310", areaID: "360830", area: "\u6c38\u65b0\u53bf", fatherID: "360800"}, {
        id: "1311",
        areaID: "360881",
        area: "\u4e95\u5188\u5c71\u5e02",
        fatherID: "360800"
    }, {id: "1312", areaID: "360901", area: "\u5e02\u8f96\u533a", fatherID: "360900"}, {id: "1313", areaID: "360902", area: "\u8881\u5dde\u533a", fatherID: "360900"}, {id: "1314", areaID: "360921", area: "\u5949\u65b0\u53bf", fatherID: "360900"}, {id: "1315", areaID: "360922", area: "\u4e07\u8f7d\u53bf", fatherID: "360900"}, {id: "1316", areaID: "360923", area: "\u4e0a\u9ad8\u53bf", fatherID: "360900"}, {id: "1317", areaID: "360924", area: "\u5b9c\u4e30\u53bf", fatherID: "360900"}, {id: "1318", areaID: "360925", area: "\u9756\u5b89\u53bf", fatherID: "360900"}, {id: "1319", areaID: "360926", area: "\u94dc\u9f13\u53bf", fatherID: "360900"}, {id: "1320", areaID: "360981", area: "\u4e30\u57ce\u5e02", fatherID: "360900"}, {
        id: "1321",
        areaID: "360982",
        area: "\u6a1f\u6811\u5e02",
        fatherID: "360900"
    }, {id: "1322", areaID: "360983", area: "\u9ad8\u5b89\u5e02", fatherID: "360900"}, {id: "1323", areaID: "361001", area: "\u5e02\u8f96\u533a", fatherID: "361000"}, {id: "1324", areaID: "361002", area: "\u4e34\u5ddd\u533a", fatherID: "361000"}, {id: "1325", areaID: "361021", area: "\u5357\u57ce\u53bf", fatherID: "361000"}, {id: "1326", areaID: "361022", area: "\u9ece\u5ddd\u53bf", fatherID: "361000"}, {id: "1327", areaID: "361023", area: "\u5357\u4e30\u53bf", fatherID: "361000"}, {id: "1328", areaID: "361024", area: "\u5d07\u4ec1\u53bf", fatherID: "361000"}, {id: "1329", areaID: "361025", area: "\u4e50\u5b89\u53bf", fatherID: "361000"}, {id: "1330", areaID: "361026", area: "\u5b9c\u9ec4\u53bf", fatherID: "361000"}, {
        id: "1331",
        areaID: "361027",
        area: "\u91d1\u6eaa\u53bf",
        fatherID: "361000"
    }, {id: "1332", areaID: "361028", area: "\u8d44\u6eaa\u53bf", fatherID: "361000"}, {id: "1333", areaID: "361029", area: "\u4e1c\u4e61\u53bf", fatherID: "361000"}, {id: "1334", areaID: "361030", area: "\u5e7f\u660c\u53bf", fatherID: "361000"}, {id: "1335", areaID: "361101", area: "\u5e02\u8f96\u533a", fatherID: "361100"}, {id: "1336", areaID: "361102", area: "\u4fe1\u5dde\u533a", fatherID: "361100"}, {id: "1337", areaID: "361121", area: "\u4e0a\u9976\u53bf", fatherID: "361100"}, {id: "1338", areaID: "361122", area: "\u5e7f\u4e30\u53bf", fatherID: "361100"}, {id: "1339", areaID: "361123", area: "\u7389\u5c71\u53bf", fatherID: "361100"}, {id: "1340", areaID: "361124", area: "\u94c5\u5c71\u53bf", fatherID: "361100"}, {
        id: "1341",
        areaID: "361125",
        area: "\u6a2a\u5cf0\u53bf",
        fatherID: "361100"
    }, {id: "1342", areaID: "361126", area: "\u5f0b\u9633\u53bf", fatherID: "361100"}, {id: "1343", areaID: "361127", area: "\u4f59\u5e72\u53bf", fatherID: "361100"}, {id: "1344", areaID: "361128", area: "\u9131\u9633\u53bf", fatherID: "361100"}, {id: "1345", areaID: "361129", area: "\u4e07\u5e74\u53bf", fatherID: "361100"}, {id: "1346", areaID: "361130", area: "\u5a7a\u6e90\u53bf", fatherID: "361100"}, {id: "1347", areaID: "361181", area: "\u5fb7\u5174\u5e02", fatherID: "361100"}, {id: "1348", areaID: "370101", area: "\u5e02\u8f96\u533a", fatherID: "370100"}, {id: "1349", areaID: "370102", area: "\u5386\u4e0b\u533a", fatherID: "370100"}, {id: "1350", areaID: "370103", area: "\u5e02\u4e2d\u533a", fatherID: "370100"}, {
        id: "1351",
        areaID: "370104",
        area: "\u69d0\u836b\u533a",
        fatherID: "370100"
    }, {id: "1352", areaID: "370105", area: "\u5929\u6865\u533a", fatherID: "370100"}, {id: "1353", areaID: "370112", area: "\u5386\u57ce\u533a", fatherID: "370100"}, {id: "1354", areaID: "370113", area: "\u957f\u6e05\u533a", fatherID: "370100"}, {id: "1355", areaID: "370124", area: "\u5e73\u9634\u53bf", fatherID: "370100"}, {id: "1356", areaID: "370125", area: "\u6d4e\u9633\u53bf", fatherID: "370100"}, {id: "1357", areaID: "370126", area: "\u5546\u6cb3\u53bf", fatherID: "370100"}, {id: "1358", areaID: "370181", area: "\u7ae0\u4e18\u5e02", fatherID: "370100"}, {id: "1359", areaID: "370201", area: "\u5e02\u8f96\u533a", fatherID: "370200"}, {id: "1360", areaID: "370202", area: "\u5e02\u5357\u533a", fatherID: "370200"}, {
        id: "1361",
        areaID: "370203",
        area: "\u5e02\u5317\u533a",
        fatherID: "370200"
    }, {id: "1362", areaID: "370205", area: "\u56db\u65b9\u533a", fatherID: "370200"}, {id: "1363", areaID: "370211", area: "\u9ec4\u5c9b\u533a", fatherID: "370200"}, {id: "1364", areaID: "370212", area: "\u5d02\u5c71\u533a", fatherID: "370200"}, {id: "1365", areaID: "370213", area: "\u674e\u6ca7\u533a", fatherID: "370200"}, {id: "1366", areaID: "370214", area: "\u57ce\u9633\u533a", fatherID: "370200"}, {id: "1367", areaID: "370281", area: "\u80f6\u5dde\u5e02", fatherID: "370200"}, {id: "1368", areaID: "370282", area: "\u5373\u58a8\u5e02", fatherID: "370200"}, {id: "1369", areaID: "370283", area: "\u5e73\u5ea6\u5e02", fatherID: "370200"}, {id: "1370", areaID: "370284", area: "\u80f6\u5357\u5e02", fatherID: "370200"}, {
        id: "1371",
        areaID: "370285",
        area: "\u83b1\u897f\u5e02",
        fatherID: "370200"
    }, {id: "1372", areaID: "370301", area: "\u5e02\u8f96\u533a", fatherID: "370300"}, {id: "1373", areaID: "370302", area: "\u6dc4\u5ddd\u533a", fatherID: "370300"}, {id: "1374", areaID: "370303", area: "\u5f20\u5e97\u533a", fatherID: "370300"}, {id: "1375", areaID: "370304", area: "\u535a\u5c71\u533a", fatherID: "370300"}, {id: "1376", areaID: "370305", area: "\u4e34\u6dc4\u533a", fatherID: "370300"}, {id: "1377", areaID: "370306", area: "\u5468\u6751\u533a", fatherID: "370300"}, {id: "1378", areaID: "370321", area: "\u6853\u53f0\u53bf", fatherID: "370300"}, {id: "1379", areaID: "370322", area: "\u9ad8\u9752\u53bf", fatherID: "370300"}, {id: "1380", areaID: "370323", area: "\u6c82\u6e90\u53bf", fatherID: "370300"}, {
        id: "1381",
        areaID: "370401",
        area: "\u5e02\u8f96\u533a",
        fatherID: "370400"
    }, {id: "1382", areaID: "370402", area: "\u5e02\u4e2d\u533a", fatherID: "370400"}, {id: "1383", areaID: "370403", area: "\u859b\u57ce\u533a", fatherID: "370400"}, {id: "1384", areaID: "370404", area: "\u5cc4\u57ce\u533a", fatherID: "370400"}, {id: "1385", areaID: "370405", area: "\u53f0\u513f\u5e84\u533a", fatherID: "370400"}, {id: "1386", areaID: "370406", area: "\u5c71\u4ead\u533a", fatherID: "370400"}, {id: "1387", areaID: "370481", area: "\u6ed5\u5dde\u5e02", fatherID: "370400"}, {id: "1388", areaID: "370501", area: "\u5e02\u8f96\u533a", fatherID: "370500"}, {id: "1389", areaID: "370502", area: "\u4e1c\u8425\u533a", fatherID: "370500"}, {id: "1390", areaID: "370503", area: "\u6cb3\u53e3\u533a", fatherID: "370500"}, {
        id: "1391",
        areaID: "370521",
        area: "\u57a6\u5229\u53bf",
        fatherID: "370500"
    }, {id: "1392", areaID: "370522", area: "\u5229\u6d25\u53bf", fatherID: "370500"}, {id: "1393", areaID: "370523", area: "\u5e7f\u9976\u53bf", fatherID: "370500"}, {id: "1394", areaID: "370601", area: "\u5e02\u8f96\u533a", fatherID: "370600"}, {id: "1395", areaID: "370602", area: "\u829d\u7f58\u533a", fatherID: "370600"}, {id: "1396", areaID: "370611", area: "\u798f\u5c71\u533a", fatherID: "370600"}, {id: "1397", areaID: "370612", area: "\u725f\u5e73\u533a", fatherID: "370600"}, {id: "1398", areaID: "370613", area: "\u83b1\u5c71\u533a", fatherID: "370600"}, {id: "1399", areaID: "370634", area: "\u957f\u5c9b\u53bf", fatherID: "370600"}, {id: "1400", areaID: "370681", area: "\u9f99\u53e3\u5e02", fatherID: "370600"}, {
        id: "1401",
        areaID: "370682",
        area: "\u83b1\u9633\u5e02",
        fatherID: "370600"
    }, {id: "1402", areaID: "370683", area: "\u83b1\u5dde\u5e02", fatherID: "370600"}, {id: "1403", areaID: "370684", area: "\u84ec\u83b1\u5e02", fatherID: "370600"}, {id: "1404", areaID: "370685", area: "\u62db\u8fdc\u5e02", fatherID: "370600"}, {id: "1405", areaID: "370686", area: "\u6816\u971e\u5e02", fatherID: "370600"}, {id: "1406", areaID: "370687", area: "\u6d77\u9633\u5e02", fatherID: "370600"}, {id: "1407", areaID: "370701", area: "\u5e02\u8f96\u533a", fatherID: "370700"}, {id: "1408", areaID: "370702", area: "\u6f4d\u57ce\u533a", fatherID: "370700"}, {id: "1409", areaID: "370703", area: "\u5bd2\u4ead\u533a", fatherID: "370700"}, {id: "1410", areaID: "370704", area: "\u574a\u5b50\u533a", fatherID: "370700"}, {
        id: "1411",
        areaID: "370705",
        area: "\u594e\u6587\u533a",
        fatherID: "370700"
    }, {id: "1412", areaID: "370724", area: "\u4e34\u6710\u53bf", fatherID: "370700"}, {id: "1413", areaID: "370725", area: "\u660c\u4e50\u53bf", fatherID: "370700"}, {id: "1414", areaID: "370781", area: "\u9752\u5dde\u5e02", fatherID: "370700"}, {id: "1415", areaID: "370782", area: "\u8bf8\u57ce\u5e02", fatherID: "370700"}, {id: "1416", areaID: "370783", area: "\u5bff\u5149\u5e02", fatherID: "370700"}, {id: "1417", areaID: "370784", area: "\u5b89\u4e18\u5e02", fatherID: "370700"}, {id: "1418", areaID: "370785", area: "\u9ad8\u5bc6\u5e02", fatherID: "370700"}, {id: "1419", areaID: "370786", area: "\u660c\u9091\u5e02", fatherID: "370700"}, {id: "1420", areaID: "370801", area: "\u5e02\u8f96\u533a", fatherID: "370800"}, {
        id: "1421",
        areaID: "370802",
        area: "\u5e02\u4e2d\u533a",
        fatherID: "370800"
    }, {id: "1422", areaID: "370811", area: "\u4efb\u57ce\u533a", fatherID: "370800"}, {id: "1423", areaID: "370826", area: "\u5fae\u5c71\u53bf", fatherID: "370800"}, {id: "1424", areaID: "370827", area: "\u9c7c\u53f0\u53bf", fatherID: "370800"}, {id: "1425", areaID: "370828", area: "\u91d1\u4e61\u53bf", fatherID: "370800"}, {id: "1426", areaID: "370829", area: "\u5609\u7965\u53bf", fatherID: "370800"}, {id: "1427", areaID: "370830", area: "\u6c76\u4e0a\u53bf", fatherID: "370800"}, {id: "1428", areaID: "370831", area: "\u6cd7\u6c34\u53bf", fatherID: "370800"}, {id: "1429", areaID: "370832", area: "\u6881\u5c71\u53bf", fatherID: "370800"}, {id: "1430", areaID: "370881", area: "\u66f2\u961c\u5e02", fatherID: "370800"}, {
        id: "1431",
        areaID: "370882",
        area: "\u5156\u5dde\u5e02",
        fatherID: "370800"
    }, {id: "1432", areaID: "370883", area: "\u90b9\u57ce\u5e02", fatherID: "370800"}, {id: "1433", areaID: "370901", area: "\u5e02\u8f96\u533a", fatherID: "370900"}, {id: "1434", areaID: "370902", area: "\u6cf0\u5c71\u533a", fatherID: "370900"}, {id: "1435", areaID: "370903", area: "\u5cb1\u5cb3\u533a", fatherID: "370900"}, {id: "1436", areaID: "370921", area: "\u5b81\u9633\u53bf", fatherID: "370900"}, {id: "1437", areaID: "370923", area: "\u4e1c\u5e73\u53bf", fatherID: "370900"}, {id: "1438", areaID: "370982", area: "\u65b0\u6cf0\u5e02", fatherID: "370900"}, {id: "1439", areaID: "370983", area: "\u80a5\u57ce\u5e02", fatherID: "370900"}, {id: "1440", areaID: "371001", area: "\u5e02\u8f96\u533a", fatherID: "371000"}, {
        id: "1441",
        areaID: "371002",
        area: "\u73af\u7fe0\u533a",
        fatherID: "371000"
    }, {id: "1442", areaID: "371081", area: "\u6587\u767b\u5e02", fatherID: "371000"}, {id: "1443", areaID: "371082", area: "\u8363\u6210\u5e02", fatherID: "371000"}, {id: "1444", areaID: "371083", area: "\u4e73\u5c71\u5e02", fatherID: "371000"}, {id: "1445", areaID: "371101", area: "\u5e02\u8f96\u533a", fatherID: "371100"}, {id: "1446", areaID: "371102", area: "\u4e1c\u6e2f\u533a", fatherID: "371100"}, {id: "1447", areaID: "371103", area: "\u5c9a\u5c71\u533a", fatherID: "371100"}, {id: "1448", areaID: "371121", area: "\u4e94\u83b2\u53bf", fatherID: "371100"}, {id: "1449", areaID: "371122", area: "\u8392\u3000\u53bf", fatherID: "371100"}, {id: "1450", areaID: "371201", area: "\u5e02\u8f96\u533a", fatherID: "371200"}, {
        id: "1451",
        areaID: "371202",
        area: "\u83b1\u57ce\u533a",
        fatherID: "371200"
    }, {id: "1452", areaID: "371203", area: "\u94a2\u57ce\u533a", fatherID: "371200"}, {id: "1453", areaID: "371301", area: "\u5e02\u8f96\u533a", fatherID: "371300"}, {id: "1454", areaID: "371302", area: "\u5170\u5c71\u533a", fatherID: "371300"}, {id: "1455", areaID: "371311", area: "\u7f57\u5e84\u533a", fatherID: "371300"}, {id: "1456", areaID: "371312", area: "\u6cb3\u4e1c\u533a", fatherID: "371300"}, {id: "1457", areaID: "371321", area: "\u6c82\u5357\u53bf", fatherID: "371300"}, {id: "1458", areaID: "371322", area: "\u90ef\u57ce\u53bf", fatherID: "371300"}, {id: "1459", areaID: "371323", area: "\u6c82\u6c34\u53bf", fatherID: "371300"}, {id: "1460", areaID: "371324", area: "\u82cd\u5c71\u53bf", fatherID: "371300"}, {
        id: "1461",
        areaID: "371325",
        area: "\u8d39\u3000\u53bf",
        fatherID: "371300"
    }, {id: "1462", areaID: "371326", area: "\u5e73\u9091\u53bf", fatherID: "371300"}, {id: "1463", areaID: "371327", area: "\u8392\u5357\u53bf", fatherID: "371300"}, {id: "1464", areaID: "371328", area: "\u8499\u9634\u53bf", fatherID: "371300"}, {id: "1465", areaID: "371329", area: "\u4e34\u6cad\u53bf", fatherID: "371300"}, {id: "1466", areaID: "371401", area: "\u5e02\u8f96\u533a", fatherID: "371400"}, {id: "1467", areaID: "371402", area: "\u5fb7\u57ce\u533a", fatherID: "371400"}, {id: "1468", areaID: "371421", area: "\u9675\u3000\u53bf", fatherID: "371400"}, {id: "1469", areaID: "371422", area: "\u5b81\u6d25\u53bf", fatherID: "371400"}, {id: "1470", areaID: "371423", area: "\u5e86\u4e91\u53bf", fatherID: "371400"}, {
        id: "1471",
        areaID: "371424",
        area: "\u4e34\u9091\u53bf",
        fatherID: "371400"
    }, {id: "1472", areaID: "371425", area: "\u9f50\u6cb3\u53bf", fatherID: "371400"}, {id: "1473", areaID: "371426", area: "\u5e73\u539f\u53bf", fatherID: "371400"}, {id: "1474", areaID: "371427", area: "\u590f\u6d25\u53bf", fatherID: "371400"}, {id: "1475", areaID: "371428", area: "\u6b66\u57ce\u53bf", fatherID: "371400"}, {id: "1476", areaID: "371481", area: "\u4e50\u9675\u5e02", fatherID: "371400"}, {id: "1477", areaID: "371482", area: "\u79b9\u57ce\u5e02", fatherID: "371400"}, {id: "1478", areaID: "371501", area: "\u5e02\u8f96\u533a", fatherID: "371500"}, {id: "1479", areaID: "371502", area: "\u4e1c\u660c\u5e9c\u533a", fatherID: "371500"}, {id: "1480", areaID: "371521", area: "\u9633\u8c37\u53bf", fatherID: "371500"}, {
        id: "1481",
        areaID: "371522",
        area: "\u8398\u3000\u53bf",
        fatherID: "371500"
    }, {id: "1482", areaID: "371523", area: "\u830c\u5e73\u53bf", fatherID: "371500"}, {id: "1483", areaID: "371524", area: "\u4e1c\u963f\u53bf", fatherID: "371500"}, {id: "1484", areaID: "371525", area: "\u51a0\u3000\u53bf", fatherID: "371500"}, {id: "1485", areaID: "371526", area: "\u9ad8\u5510\u53bf", fatherID: "371500"}, {id: "1486", areaID: "371581", area: "\u4e34\u6e05\u5e02", fatherID: "371500"}, {id: "1487", areaID: "371601", area: "\u5e02\u8f96\u533a", fatherID: "371600"}, {id: "1488", areaID: "371602", area: "\u6ee8\u57ce\u533a", fatherID: "371600"}, {id: "1489", areaID: "371621", area: "\u60e0\u6c11\u53bf", fatherID: "371600"}, {id: "1490", areaID: "371622", area: "\u9633\u4fe1\u53bf", fatherID: "371600"}, {
        id: "1491",
        areaID: "371623",
        area: "\u65e0\u68e3\u53bf",
        fatherID: "371600"
    }, {id: "1492", areaID: "371624", area: "\u6cbe\u5316\u53bf", fatherID: "371600"}, {id: "1493", areaID: "371625", area: "\u535a\u5174\u53bf", fatherID: "371600"}, {id: "1494", areaID: "371626", area: "\u90b9\u5e73\u53bf", fatherID: "371600"}, {id: "1495", areaID: "371701", area: "\u5e02\u8f96\u533a", fatherID: "371700"}, {id: "1496", areaID: "371702", area: "\u7261\u4e39\u533a", fatherID: "371700"}, {id: "1497", areaID: "371721", area: "\u66f9\u3000\u53bf", fatherID: "371700"}, {id: "1498", areaID: "371722", area: "\u5355\u3000\u53bf", fatherID: "371700"}, {id: "1499", areaID: "371723", area: "\u6210\u6b66\u53bf", fatherID: "371700"}, {id: "1500", areaID: "371724", area: "\u5de8\u91ce\u53bf", fatherID: "371700"}, {
        id: "1501",
        areaID: "371725",
        area: "\u90d3\u57ce\u53bf",
        fatherID: "371700"
    }, {id: "1502", areaID: "371726", area: "\u9104\u57ce\u53bf", fatherID: "371700"}, {id: "1503", areaID: "371727", area: "\u5b9a\u9676\u53bf", fatherID: "371700"}, {id: "1504", areaID: "371728", area: "\u4e1c\u660e\u53bf", fatherID: "371700"}, {id: "1505", areaID: "410101", area: "\u5e02\u8f96\u533a", fatherID: "410100"}, {id: "1506", areaID: "410102", area: "\u4e2d\u539f\u533a", fatherID: "410100"}, {id: "1507", areaID: "410103", area: "\u4e8c\u4e03\u533a", fatherID: "410100"}, {id: "1508", areaID: "410104", area: "\u7ba1\u57ce\u56de\u65cf\u533a", fatherID: "410100"}, {id: "1509", areaID: "410105", area: "\u91d1\u6c34\u533a", fatherID: "410100"}, {id: "1510", areaID: "410106", area: "\u4e0a\u8857\u533a", fatherID: "410100"}, {
        id: "1511",
        areaID: "410108",
        area: "\u9099\u5c71\u533a",
        fatherID: "410100"
    }, {id: "1512", areaID: "410122", area: "\u4e2d\u725f\u53bf", fatherID: "410100"}, {id: "1513", areaID: "410181", area: "\u5de9\u4e49\u5e02", fatherID: "410100"}, {id: "1514", areaID: "410182", area: "\u8365\u9633\u5e02", fatherID: "410100"}, {id: "1515", areaID: "410183", area: "\u65b0\u5bc6\u5e02", fatherID: "410100"}, {id: "1516", areaID: "410184", area: "\u65b0\u90d1\u5e02", fatherID: "410100"}, {id: "1517", areaID: "410185", area: "\u767b\u5c01\u5e02", fatherID: "410100"}, {id: "1518", areaID: "410201", area: "\u5e02\u8f96\u533a", fatherID: "410200"}, {id: "1519", areaID: "410202", area: "\u9f99\u4ead\u533a", fatherID: "410200"}, {id: "1520", areaID: "410203", area: "\u987a\u6cb3\u56de\u65cf\u533a", fatherID: "410200"}, {
        id: "1521",
        areaID: "410204",
        area: "\u9f13\u697c\u533a",
        fatherID: "410200"
    }, {id: "1522", areaID: "410205", area: "\u5357\u5173\u533a", fatherID: "410200"}, {id: "1523", areaID: "410211", area: "\u90ca\u3000\u533a", fatherID: "410200"}, {id: "1524", areaID: "410221", area: "\u675e\u3000\u53bf", fatherID: "410200"}, {id: "1525", areaID: "410222", area: "\u901a\u8bb8\u53bf", fatherID: "410200"}, {id: "1526", areaID: "410223", area: "\u5c09\u6c0f\u53bf", fatherID: "410200"}, {id: "1527", areaID: "410224", area: "\u5f00\u5c01\u53bf", fatherID: "410200"}, {id: "1528", areaID: "410225", area: "\u5170\u8003\u53bf", fatherID: "410200"}, {id: "1529", areaID: "410301", area: "\u5e02\u8f96\u533a", fatherID: "410300"}, {id: "1530", areaID: "410302", area: "\u8001\u57ce\u533a", fatherID: "410300"}, {
        id: "1531",
        areaID: "410303",
        area: "\u897f\u5de5\u533a",
        fatherID: "410300"
    }, {id: "1532", areaID: "410304", area: "\u5edb\u6cb3\u56de\u65cf\u533a", fatherID: "410300"}, {id: "1533", areaID: "410305", area: "\u6da7\u897f\u533a", fatherID: "410300"}, {id: "1534", areaID: "410306", area: "\u5409\u5229\u533a", fatherID: "410300"}, {id: "1535", areaID: "410307", area: "\u6d1b\u9f99\u533a", fatherID: "410300"}, {id: "1536", areaID: "410322", area: "\u5b5f\u6d25\u53bf", fatherID: "410300"}, {id: "1537", areaID: "410323", area: "\u65b0\u5b89\u53bf", fatherID: "410300"}, {id: "1538", areaID: "410324", area: "\u683e\u5ddd\u53bf", fatherID: "410300"}, {id: "1539", areaID: "410325", area: "\u5d69\u3000\u53bf", fatherID: "410300"}, {id: "1540", areaID: "410326", area: "\u6c5d\u9633\u53bf", fatherID: "410300"}, {
        id: "1541",
        areaID: "410327",
        area: "\u5b9c\u9633\u53bf",
        fatherID: "410300"
    }, {id: "1542", areaID: "410328", area: "\u6d1b\u5b81\u53bf", fatherID: "410300"}, {id: "1543", areaID: "410329", area: "\u4f0a\u5ddd\u53bf", fatherID: "410300"}, {id: "1544", areaID: "410381", area: "\u5043\u5e08\u5e02", fatherID: "410300"}, {id: "1545", areaID: "410401", area: "\u5e02\u8f96\u533a", fatherID: "410400"}, {id: "1546", areaID: "410402", area: "\u65b0\u534e\u533a", fatherID: "410400"}, {id: "1547", areaID: "410403", area: "\u536b\u4e1c\u533a", fatherID: "410400"}, {id: "1548", areaID: "410404", area: "\u77f3\u9f99\u533a", fatherID: "410400"}, {id: "1549", areaID: "410411", area: "\u6e5b\u6cb3\u533a", fatherID: "410400"}, {id: "1550", areaID: "410421", area: "\u5b9d\u4e30\u53bf", fatherID: "410400"}, {
        id: "1551",
        areaID: "410422",
        area: "\u53f6\u3000\u53bf",
        fatherID: "410400"
    }, {id: "1552", areaID: "410423", area: "\u9c81\u5c71\u53bf", fatherID: "410400"}, {id: "1553", areaID: "410425", area: "\u90cf\u3000\u53bf", fatherID: "410400"}, {id: "1554", areaID: "410481", area: "\u821e\u94a2\u5e02", fatherID: "410400"}, {id: "1555", areaID: "410482", area: "\u6c5d\u5dde\u5e02", fatherID: "410400"}, {id: "1556", areaID: "410501", area: "\u5e02\u8f96\u533a", fatherID: "410500"}, {id: "1557", areaID: "410502", area: "\u6587\u5cf0\u533a", fatherID: "410500"}, {id: "1558", areaID: "410503", area: "\u5317\u5173\u533a", fatherID: "410500"}, {id: "1559", areaID: "410505", area: "\u6bb7\u90fd\u533a", fatherID: "410500"}, {id: "1560", areaID: "410506", area: "\u9f99\u5b89\u533a", fatherID: "410500"}, {
        id: "1561",
        areaID: "410522",
        area: "\u5b89\u9633\u53bf",
        fatherID: "410500"
    }, {id: "1562", areaID: "410523", area: "\u6c64\u9634\u53bf", fatherID: "410500"}, {id: "1563", areaID: "410526", area: "\u6ed1\u3000\u53bf", fatherID: "410500"}, {id: "1564", areaID: "410527", area: "\u5185\u9ec4\u53bf", fatherID: "410500"}, {id: "1565", areaID: "410581", area: "\u6797\u5dde\u5e02", fatherID: "410500"}, {id: "1566", areaID: "410601", area: "\u5e02\u8f96\u533a", fatherID: "410600"}, {id: "1567", areaID: "410602", area: "\u9e64\u5c71\u533a", fatherID: "410600"}, {id: "1568", areaID: "410603", area: "\u5c71\u57ce\u533a", fatherID: "410600"}, {id: "1569", areaID: "410611", area: "\u6dc7\u6ee8\u533a", fatherID: "410600"}, {id: "1570", areaID: "410621", area: "\u6d5a\u3000\u53bf", fatherID: "410600"}, {
        id: "1571",
        areaID: "410622",
        area: "\u6dc7\u3000\u53bf",
        fatherID: "410600"
    }, {id: "1572", areaID: "410701", area: "\u5e02\u8f96\u533a", fatherID: "410700"}, {id: "1573", areaID: "410702", area: "\u7ea2\u65d7\u533a", fatherID: "410700"}, {id: "1574", areaID: "410703", area: "\u536b\u6ee8\u533a", fatherID: "410700"}, {id: "1575", areaID: "410704", area: "\u51e4\u6cc9\u533a", fatherID: "410700"}, {id: "1576", areaID: "410711", area: "\u7267\u91ce\u533a", fatherID: "410700"}, {id: "1577", areaID: "410721", area: "\u65b0\u4e61\u53bf", fatherID: "410700"}, {id: "1578", areaID: "410724", area: "\u83b7\u5609\u53bf", fatherID: "410700"}, {id: "1579", areaID: "410725", area: "\u539f\u9633\u53bf", fatherID: "410700"}, {id: "1580", areaID: "410726", area: "\u5ef6\u6d25\u53bf", fatherID: "410700"}, {
        id: "1581",
        areaID: "410727",
        area: "\u5c01\u4e18\u53bf",
        fatherID: "410700"
    }, {id: "1582", areaID: "410728", area: "\u957f\u57a3\u53bf", fatherID: "410700"}, {id: "1583", areaID: "410781", area: "\u536b\u8f89\u5e02", fatherID: "410700"}, {id: "1584", areaID: "410782", area: "\u8f89\u53bf\u5e02", fatherID: "410700"}, {id: "1585", areaID: "410801", area: "\u5e02\u8f96\u533a", fatherID: "410800"}, {id: "1586", areaID: "410802", area: "\u89e3\u653e\u533a", fatherID: "410800"}, {id: "1587", areaID: "410803", area: "\u4e2d\u7ad9\u533a", fatherID: "410800"}, {id: "1588", areaID: "410804", area: "\u9a6c\u6751\u533a", fatherID: "410800"}, {id: "1589", areaID: "410811", area: "\u5c71\u9633\u533a", fatherID: "410800"}, {id: "1590", areaID: "410821", area: "\u4fee\u6b66\u53bf", fatherID: "410800"}, {
        id: "1591",
        areaID: "410822",
        area: "\u535a\u7231\u53bf",
        fatherID: "410800"
    }, {id: "1592", areaID: "410823", area: "\u6b66\u965f\u53bf", fatherID: "410800"}, {id: "1593", areaID: "410825", area: "\u6e29\u3000\u53bf", fatherID: "410800"}, {id: "1594", areaID: "410881", area: "\u6d4e\u6e90\u5e02", fatherID: "410800"}, {id: "1595", areaID: "410882", area: "\u6c81\u9633\u5e02", fatherID: "410800"}, {id: "1596", areaID: "410883", area: "\u5b5f\u5dde\u5e02", fatherID: "410800"}, {id: "1597", areaID: "410901", area: "\u5e02\u8f96\u533a", fatherID: "410900"}, {id: "1598", areaID: "410902", area: "\u534e\u9f99\u533a", fatherID: "410900"}, {id: "1599", areaID: "410922", area: "\u6e05\u4e30\u53bf", fatherID: "410900"}, {id: "1600", areaID: "410923", area: "\u5357\u4e50\u53bf", fatherID: "410900"}, {
        id: "1601",
        areaID: "410926",
        area: "\u8303\u3000\u53bf",
        fatherID: "410900"
    }, {id: "1602", areaID: "410927", area: "\u53f0\u524d\u53bf", fatherID: "410900"}, {id: "1603", areaID: "410928", area: "\u6fee\u9633\u53bf", fatherID: "410900"}, {id: "1604", areaID: "411001", area: "\u5e02\u8f96\u533a", fatherID: "411000"}, {id: "1605", areaID: "411002", area: "\u9b4f\u90fd\u533a", fatherID: "411000"}, {id: "1606", areaID: "411023", area: "\u8bb8\u660c\u53bf", fatherID: "411000"}, {id: "1607", areaID: "411024", area: "\u9122\u9675\u53bf", fatherID: "411000"}, {id: "1608", areaID: "411025", area: "\u8944\u57ce\u53bf", fatherID: "411000"}, {id: "1609", areaID: "411081", area: "\u79b9\u5dde\u5e02", fatherID: "411000"}, {id: "1610", areaID: "411082", area: "\u957f\u845b\u5e02", fatherID: "411000"}, {
        id: "1611",
        areaID: "411101",
        area: "\u5e02\u8f96\u533a",
        fatherID: "411100"
    }, {id: "1612", areaID: "411102", area: "\u6e90\u6c47\u533a", fatherID: "411100"}, {id: "1613", areaID: "411103", area: "\u90fe\u57ce\u533a", fatherID: "411100"}, {id: "1614", areaID: "411104", area: "\u53ec\u9675\u533a", fatherID: "411100"}, {id: "1615", areaID: "411121", area: "\u821e\u9633\u53bf", fatherID: "411100"}, {id: "1616", areaID: "411122", area: "\u4e34\u988d\u53bf", fatherID: "411100"}, {id: "1617", areaID: "411201", area: "\u5e02\u8f96\u533a", fatherID: "411200"}, {id: "1618", areaID: "411202", area: "\u6e56\u6ee8\u533a", fatherID: "411200"}, {id: "1619", areaID: "411221", area: "\u6e11\u6c60\u53bf", fatherID: "411200"}, {id: "1620", areaID: "411222", area: "\u9655\u3000\u53bf", fatherID: "411200"}, {
        id: "1621",
        areaID: "411224",
        area: "\u5362\u6c0f\u53bf",
        fatherID: "411200"
    }, {id: "1622", areaID: "411281", area: "\u4e49\u9a6c\u5e02", fatherID: "411200"}, {id: "1623", areaID: "411282", area: "\u7075\u5b9d\u5e02", fatherID: "411200"}, {id: "1624", areaID: "411301", area: "\u5e02\u8f96\u533a", fatherID: "411300"}, {id: "1625", areaID: "411302", area: "\u5b9b\u57ce\u533a", fatherID: "411300"}, {id: "1626", areaID: "411303", area: "\u5367\u9f99\u533a", fatherID: "411300"}, {id: "1627", areaID: "411321", area: "\u5357\u53ec\u53bf", fatherID: "411300"}, {id: "1628", areaID: "411322", area: "\u65b9\u57ce\u53bf", fatherID: "411300"}, {id: "1629", areaID: "411323", area: "\u897f\u5ce1\u53bf", fatherID: "411300"}, {id: "1630", areaID: "411324", area: "\u9547\u5e73\u53bf", fatherID: "411300"}, {
        id: "1631",
        areaID: "411325",
        area: "\u5185\u4e61\u53bf",
        fatherID: "411300"
    }, {id: "1632", areaID: "411326", area: "\u6dc5\u5ddd\u53bf", fatherID: "411300"}, {id: "1633", areaID: "411327", area: "\u793e\u65d7\u53bf", fatherID: "411300"}, {id: "1634", areaID: "411328", area: "\u5510\u6cb3\u53bf", fatherID: "411300"}, {id: "1635", areaID: "411329", area: "\u65b0\u91ce\u53bf", fatherID: "411300"}, {id: "1636", areaID: "411330", area: "\u6850\u67cf\u53bf", fatherID: "411300"}, {id: "1637", areaID: "411381", area: "\u9093\u5dde\u5e02", fatherID: "411300"}, {id: "1638", areaID: "411401", area: "\u5e02\u8f96\u533a", fatherID: "411400"}, {id: "1639", areaID: "411402", area: "\u6881\u56ed\u533a", fatherID: "411400"}, {id: "1640", areaID: "411403", area: "\u7762\u9633\u533a", fatherID: "411400"}, {
        id: "1641",
        areaID: "411421",
        area: "\u6c11\u6743\u53bf",
        fatherID: "411400"
    }, {id: "1642", areaID: "411422", area: "\u7762\u3000\u53bf", fatherID: "411400"}, {id: "1643", areaID: "411423", area: "\u5b81\u9675\u53bf", fatherID: "411400"}, {id: "1644", areaID: "411424", area: "\u67d8\u57ce\u53bf", fatherID: "411400"}, {id: "1645", areaID: "411425", area: "\u865e\u57ce\u53bf", fatherID: "411400"}, {id: "1646", areaID: "411426", area: "\u590f\u9091\u53bf", fatherID: "411400"}, {id: "1647", areaID: "411481", area: "\u6c38\u57ce\u5e02", fatherID: "411400"}, {id: "1648", areaID: "411501", area: "\u5e02\u8f96\u533a", fatherID: "411500"}, {id: "1649", areaID: "411502", area: "\u5e08\u6cb3\u533a", fatherID: "411500"}, {id: "1650", areaID: "411503", area: "\u5e73\u6865\u533a", fatherID: "411500"}, {
        id: "1651",
        areaID: "411521",
        area: "\u7f57\u5c71\u53bf",
        fatherID: "411500"
    }, {id: "1652", areaID: "411522", area: "\u5149\u5c71\u53bf", fatherID: "411500"}, {id: "1653", areaID: "411523", area: "\u65b0\u3000\u53bf", fatherID: "411500"}, {id: "1654", areaID: "411524", area: "\u5546\u57ce\u53bf", fatherID: "411500"}, {id: "1655", areaID: "411525", area: "\u56fa\u59cb\u53bf", fatherID: "411500"}, {id: "1656", areaID: "411526", area: "\u6f62\u5ddd\u53bf", fatherID: "411500"}, {id: "1657", areaID: "411527", area: "\u6dee\u6ee8\u53bf", fatherID: "411500"}, {id: "1658", areaID: "411528", area: "\u606f\u3000\u53bf", fatherID: "411500"}, {id: "1659", areaID: "411601", area: "\u5e02\u8f96\u533a", fatherID: "411600"}, {id: "1660", areaID: "411602", area: "\u5ddd\u6c47\u533a", fatherID: "411600"}, {
        id: "1661",
        areaID: "411621",
        area: "\u6276\u6c9f\u53bf",
        fatherID: "411600"
    }, {id: "1662", areaID: "411622", area: "\u897f\u534e\u53bf", fatherID: "411600"}, {id: "1663", areaID: "411623", area: "\u5546\u6c34\u53bf", fatherID: "411600"}, {id: "1664", areaID: "411624", area: "\u6c88\u4e18\u53bf", fatherID: "411600"}, {id: "1665", areaID: "411625", area: "\u90f8\u57ce\u53bf", fatherID: "411600"}, {id: "1666", areaID: "411626", area: "\u6dee\u9633\u53bf", fatherID: "411600"}, {id: "1667", areaID: "411627", area: "\u592a\u5eb7\u53bf", fatherID: "411600"}, {id: "1668", areaID: "411628", area: "\u9e7f\u9091\u53bf", fatherID: "411600"}, {id: "1669", areaID: "411681", area: "\u9879\u57ce\u5e02", fatherID: "411600"}, {id: "1670", areaID: "411701", area: "\u5e02\u8f96\u533a", fatherID: "411700"}, {
        id: "1671",
        areaID: "411702",
        area: "\u9a7f\u57ce\u533a",
        fatherID: "411700"
    }, {id: "1672", areaID: "411721", area: "\u897f\u5e73\u53bf", fatherID: "411700"}, {id: "1673", areaID: "411722", area: "\u4e0a\u8521\u53bf", fatherID: "411700"}, {id: "1674", areaID: "411723", area: "\u5e73\u8206\u53bf", fatherID: "411700"}, {id: "1675", areaID: "411724", area: "\u6b63\u9633\u53bf", fatherID: "411700"}, {id: "1676", areaID: "411725", area: "\u786e\u5c71\u53bf", fatherID: "411700"}, {id: "1677", areaID: "411726", area: "\u6ccc\u9633\u53bf", fatherID: "411700"}, {id: "1678", areaID: "411727", area: "\u6c5d\u5357\u53bf", fatherID: "411700"}, {id: "1679", areaID: "411728", area: "\u9042\u5e73\u53bf", fatherID: "411700"}, {id: "1680", areaID: "411729", area: "\u65b0\u8521\u53bf", fatherID: "411700"}, {
        id: "1681",
        areaID: "420101",
        area: "\u5e02\u8f96\u533a",
        fatherID: "420100"
    }, {id: "1682", areaID: "420102", area: "\u6c5f\u5cb8\u533a", fatherID: "420100"}, {id: "1683", areaID: "420103", area: "\u6c5f\u6c49\u533a", fatherID: "420100"}, {id: "1684", areaID: "420104", area: "\u4e54\u53e3\u533a", fatherID: "420100"}, {id: "1685", areaID: "420105", area: "\u6c49\u9633\u533a", fatherID: "420100"}, {id: "1686", areaID: "420106", area: "\u6b66\u660c\u533a", fatherID: "420100"}, {id: "1687", areaID: "420107", area: "\u9752\u5c71\u533a", fatherID: "420100"}, {id: "1688", areaID: "420111", area: "\u6d2a\u5c71\u533a", fatherID: "420100"}, {id: "1689", areaID: "420112", area: "\u4e1c\u897f\u6e56\u533a", fatherID: "420100"}, {id: "1690", areaID: "420113", area: "\u6c49\u5357\u533a", fatherID: "420100"}, {
        id: "1691",
        areaID: "420114",
        area: "\u8521\u7538\u533a",
        fatherID: "420100"
    }, {id: "1692", areaID: "420115", area: "\u6c5f\u590f\u533a", fatherID: "420100"}, {id: "1693", areaID: "420116", area: "\u9ec4\u9642\u533a", fatherID: "420100"}, {id: "1694", areaID: "420117", area: "\u65b0\u6d32\u533a", fatherID: "420100"}, {id: "1695", areaID: "420201", area: "\u5e02\u8f96\u533a", fatherID: "420200"}, {id: "1696", areaID: "420202", area: "\u9ec4\u77f3\u6e2f\u533a", fatherID: "420200"}, {id: "1697", areaID: "420203", area: "\u897f\u585e\u5c71\u533a", fatherID: "420200"}, {id: "1698", areaID: "420204", area: "\u4e0b\u9646\u533a", fatherID: "420200"}, {id: "1699", areaID: "420205", area: "\u94c1\u5c71\u533a", fatherID: "420200"}, {id: "1700", areaID: "420222", area: "\u9633\u65b0\u53bf", fatherID: "420200"}, {
        id: "1701",
        areaID: "420281",
        area: "\u5927\u51b6\u5e02",
        fatherID: "420200"
    }, {id: "1702", areaID: "420301", area: "\u5e02\u8f96\u533a", fatherID: "420300"}, {id: "1703", areaID: "420302", area: "\u8305\u7bad\u533a", fatherID: "420300"}, {id: "1704", areaID: "420303", area: "\u5f20\u6e7e\u533a", fatherID: "420300"}, {id: "1705", areaID: "420321", area: "\u90e7\u3000\u53bf", fatherID: "420300"}, {id: "1706", areaID: "420322", area: "\u90e7\u897f\u53bf", fatherID: "420300"}, {id: "1707", areaID: "420323", area: "\u7af9\u5c71\u53bf", fatherID: "420300"}, {id: "1708", areaID: "420324", area: "\u7af9\u6eaa\u53bf", fatherID: "420300"}, {id: "1709", areaID: "420325", area: "\u623f\u3000\u53bf", fatherID: "420300"}, {id: "1710", areaID: "420381", area: "\u4e39\u6c5f\u53e3\u5e02", fatherID: "420300"}, {
        id: "1711",
        areaID: "420501",
        area: "\u5e02\u8f96\u533a",
        fatherID: "420500"
    }, {id: "1712", areaID: "420502", area: "\u897f\u9675\u533a", fatherID: "420500"}, {id: "1713", areaID: "420503", area: "\u4f0d\u5bb6\u5c97\u533a", fatherID: "420500"}, {id: "1714", areaID: "420504", area: "\u70b9\u519b\u533a", fatherID: "420500"}, {id: "1715", areaID: "420505", area: "\u7307\u4ead\u533a", fatherID: "420500"}, {id: "1716", areaID: "420506", area: "\u5937\u9675\u533a", fatherID: "420500"}, {id: "1717", areaID: "420525", area: "\u8fdc\u5b89\u53bf", fatherID: "420500"}, {id: "1718", areaID: "420526", area: "\u5174\u5c71\u53bf", fatherID: "420500"}, {id: "1719", areaID: "420527", area: "\u79ed\u5f52\u53bf", fatherID: "420500"}, {id: "1720", areaID: "420528", area: "\u957f\u9633\u571f\u5bb6\u65cf\u81ea\u6cbb\u53bf", fatherID: "420500"}, {
        id: "1721",
        areaID: "420529",
        area: "\u4e94\u5cf0\u571f\u5bb6\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "420500"
    }, {id: "1722", areaID: "420581", area: "\u5b9c\u90fd\u5e02", fatherID: "420500"}, {id: "1723", areaID: "420582", area: "\u5f53\u9633\u5e02", fatherID: "420500"}, {id: "1724", areaID: "420583", area: "\u679d\u6c5f\u5e02", fatherID: "420500"}, {id: "1725", areaID: "420601", area: "\u5e02\u8f96\u533a", fatherID: "420600"}, {id: "1726", areaID: "420602", area: "\u8944\u57ce\u533a", fatherID: "420600"}, {id: "1727", areaID: "420606", area: "\u6a0a\u57ce\u533a", fatherID: "420600"}, {id: "1728", areaID: "420607", area: "\u8944\u9633\u533a", fatherID: "420600"}, {id: "1729", areaID: "420624", area: "\u5357\u6f33\u53bf", fatherID: "420600"}, {id: "1730", areaID: "420625", area: "\u8c37\u57ce\u53bf", fatherID: "420600"}, {
        id: "1731",
        areaID: "420626",
        area: "\u4fdd\u5eb7\u53bf",
        fatherID: "420600"
    }, {id: "1732", areaID: "420682", area: "\u8001\u6cb3\u53e3\u5e02", fatherID: "420600"}, {id: "1733", areaID: "420683", area: "\u67a3\u9633\u5e02", fatherID: "420600"}, {id: "1734", areaID: "420684", area: "\u5b9c\u57ce\u5e02", fatherID: "420600"}, {id: "1735", areaID: "420701", area: "\u5e02\u8f96\u533a", fatherID: "420700"}, {id: "1736", areaID: "420702", area: "\u6881\u5b50\u6e56\u533a", fatherID: "420700"}, {id: "1737", areaID: "420703", area: "\u534e\u5bb9\u533a", fatherID: "420700"}, {id: "1738", areaID: "420704", area: "\u9102\u57ce\u533a", fatherID: "420700"}, {id: "1739", areaID: "420801", area: "\u5e02\u8f96\u533a", fatherID: "420800"}, {id: "1740", areaID: "420802", area: "\u4e1c\u5b9d\u533a", fatherID: "420800"}, {
        id: "1741",
        areaID: "420804",
        area: "\u6387\u5200\u533a",
        fatherID: "420800"
    }, {id: "1742", areaID: "420821", area: "\u4eac\u5c71\u53bf", fatherID: "420800"}, {id: "1743", areaID: "420822", area: "\u6c99\u6d0b\u53bf", fatherID: "420800"}, {id: "1744", areaID: "420881", area: "\u949f\u7965\u5e02", fatherID: "420800"}, {id: "1745", areaID: "420901", area: "\u5e02\u8f96\u533a", fatherID: "420900"}, {id: "1746", areaID: "420902", area: "\u5b5d\u5357\u533a", fatherID: "420900"}, {id: "1747", areaID: "420921", area: "\u5b5d\u660c\u53bf", fatherID: "420900"}, {id: "1748", areaID: "420922", area: "\u5927\u609f\u53bf", fatherID: "420900"}, {id: "1749", areaID: "420923", area: "\u4e91\u68a6\u53bf", fatherID: "420900"}, {id: "1750", areaID: "420981", area: "\u5e94\u57ce\u5e02", fatherID: "420900"}, {
        id: "1751",
        areaID: "420982",
        area: "\u5b89\u9646\u5e02",
        fatherID: "420900"
    }, {id: "1752", areaID: "420984", area: "\u6c49\u5ddd\u5e02", fatherID: "420900"}, {id: "1753", areaID: "421001", area: "\u5e02\u8f96\u533a", fatherID: "421000"}, {id: "1754", areaID: "421002", area: "\u6c99\u5e02\u533a", fatherID: "421000"}, {id: "1755", areaID: "421003", area: "\u8346\u5dde\u533a", fatherID: "421000"}, {id: "1756", areaID: "421022", area: "\u516c\u5b89\u53bf", fatherID: "421000"}, {id: "1757", areaID: "421023", area: "\u76d1\u5229\u53bf", fatherID: "421000"}, {id: "1758", areaID: "421024", area: "\u6c5f\u9675\u53bf", fatherID: "421000"}, {id: "1759", areaID: "421081", area: "\u77f3\u9996\u5e02", fatherID: "421000"}, {id: "1760", areaID: "421083", area: "\u6d2a\u6e56\u5e02", fatherID: "421000"}, {
        id: "1761",
        areaID: "421087",
        area: "\u677e\u6ecb\u5e02",
        fatherID: "421000"
    }, {id: "1762", areaID: "421101", area: "\u5e02\u8f96\u533a", fatherID: "421100"}, {id: "1763", areaID: "421102", area: "\u9ec4\u5dde\u533a", fatherID: "421100"}, {id: "1764", areaID: "421121", area: "\u56e2\u98ce\u53bf", fatherID: "421100"}, {id: "1765", areaID: "421122", area: "\u7ea2\u5b89\u53bf", fatherID: "421100"}, {id: "1766", areaID: "421123", area: "\u7f57\u7530\u53bf", fatherID: "421100"}, {id: "1767", areaID: "421124", area: "\u82f1\u5c71\u53bf", fatherID: "421100"}, {id: "1768", areaID: "421125", area: "\u6d60\u6c34\u53bf", fatherID: "421100"}, {id: "1769", areaID: "421126", area: "\u8572\u6625\u53bf", fatherID: "421100"}, {id: "1770", areaID: "421127", area: "\u9ec4\u6885\u53bf", fatherID: "421100"}, {
        id: "1771",
        areaID: "421181",
        area: "\u9ebb\u57ce\u5e02",
        fatherID: "421100"
    }, {id: "1772", areaID: "421182", area: "\u6b66\u7a74\u5e02", fatherID: "421100"}, {id: "1773", areaID: "421201", area: "\u5e02\u8f96\u533a", fatherID: "421200"}, {id: "1774", areaID: "421202", area: "\u54b8\u5b89\u533a", fatherID: "421200"}, {id: "1775", areaID: "421221", area: "\u5609\u9c7c\u53bf", fatherID: "421200"}, {id: "1776", areaID: "421222", area: "\u901a\u57ce\u53bf", fatherID: "421200"}, {id: "1777", areaID: "421223", area: "\u5d07\u9633\u53bf", fatherID: "421200"}, {id: "1778", areaID: "421224", area: "\u901a\u5c71\u53bf", fatherID: "421200"}, {id: "1779", areaID: "421281", area: "\u8d64\u58c1\u5e02", fatherID: "421200"}, {id: "1780", areaID: "421301", area: "\u5e02\u8f96\u533a", fatherID: "421300"}, {
        id: "1781",
        areaID: "421302",
        area: "\u66fe\u90fd\u533a",
        fatherID: "421300"
    }, {id: "1782", areaID: "421381", area: "\u5e7f\u6c34\u5e02", fatherID: "421300"}, {id: "1783", areaID: "422801", area: "\u6069\u65bd\u5e02", fatherID: "422800"}, {id: "1784", areaID: "422802", area: "\u5229\u5ddd\u5e02", fatherID: "422800"}, {id: "1785", areaID: "422822", area: "\u5efa\u59cb\u53bf", fatherID: "422800"}, {id: "1786", areaID: "422823", area: "\u5df4\u4e1c\u53bf", fatherID: "422800"}, {id: "1787", areaID: "422825", area: "\u5ba3\u6069\u53bf", fatherID: "422800"}, {id: "1788", areaID: "422826", area: "\u54b8\u4e30\u53bf", fatherID: "422800"}, {id: "1789", areaID: "422827", area: "\u6765\u51e4\u53bf", fatherID: "422800"}, {id: "1790", areaID: "422828", area: "\u9e64\u5cf0\u53bf", fatherID: "422800"}, {
        id: "1791",
        areaID: "429004",
        area: "\u4ed9\u6843\u5e02",
        fatherID: "429000"
    }, {id: "1792", areaID: "429005", area: "\u6f5c\u6c5f\u5e02", fatherID: "429000"}, {id: "1793", areaID: "429006", area: "\u5929\u95e8\u5e02", fatherID: "429000"}, {id: "1794", areaID: "429021", area: "\u795e\u519c\u67b6\u6797\u533a", fatherID: "429000"}, {id: "1795", areaID: "430101", area: "\u5e02\u8f96\u533a", fatherID: "430100"}, {id: "1796", areaID: "430102", area: "\u8299\u84c9\u533a", fatherID: "430100"}, {id: "1797", areaID: "430103", area: "\u5929\u5fc3\u533a", fatherID: "430100"}, {id: "1798", areaID: "430104", area: "\u5cb3\u9e93\u533a", fatherID: "430100"}, {id: "1799", areaID: "430105", area: "\u5f00\u798f\u533a", fatherID: "430100"}, {id: "1800", areaID: "430111", area: "\u96e8\u82b1\u533a", fatherID: "430100"}, {
        id: "1801",
        areaID: "430121",
        area: "\u957f\u6c99\u53bf",
        fatherID: "430100"
    }, {id: "1802", areaID: "430122", area: "\u671b\u57ce\u53bf", fatherID: "430100"}, {id: "1803", areaID: "430124", area: "\u5b81\u4e61\u53bf", fatherID: "430100"}, {id: "1804", areaID: "430181", area: "\u6d4f\u9633\u5e02", fatherID: "430100"}, {id: "1805", areaID: "430201", area: "\u5e02\u8f96\u533a", fatherID: "430200"}, {id: "1806", areaID: "430202", area: "\u8377\u5858\u533a", fatherID: "430200"}, {id: "1807", areaID: "430203", area: "\u82a6\u6dde\u533a", fatherID: "430200"}, {id: "1808", areaID: "430204", area: "\u77f3\u5cf0\u533a", fatherID: "430200"}, {id: "1809", areaID: "430211", area: "\u5929\u5143\u533a", fatherID: "430200"}, {id: "1810", areaID: "430221", area: "\u682a\u6d32\u53bf", fatherID: "430200"}, {
        id: "1811",
        areaID: "430223",
        area: "\u6538\u3000\u53bf",
        fatherID: "430200"
    }, {id: "1812", areaID: "430224", area: "\u8336\u9675\u53bf", fatherID: "430200"}, {id: "1813", areaID: "430225", area: "\u708e\u9675\u53bf", fatherID: "430200"}, {id: "1814", areaID: "430281", area: "\u91b4\u9675\u5e02", fatherID: "430200"}, {id: "1815", areaID: "430301", area: "\u5e02\u8f96\u533a", fatherID: "430300"}, {id: "1816", areaID: "430302", area: "\u96e8\u6e56\u533a", fatherID: "430300"}, {id: "1817", areaID: "430304", area: "\u5cb3\u5858\u533a", fatherID: "430300"}, {id: "1818", areaID: "430321", area: "\u6e58\u6f6d\u53bf", fatherID: "430300"}, {id: "1819", areaID: "430381", area: "\u6e58\u4e61\u5e02", fatherID: "430300"}, {id: "1820", areaID: "430382", area: "\u97f6\u5c71\u5e02", fatherID: "430300"}, {
        id: "1821",
        areaID: "430401",
        area: "\u5e02\u8f96\u533a",
        fatherID: "430400"
    }, {id: "1822", areaID: "430405", area: "\u73e0\u6656\u533a", fatherID: "430400"}, {id: "1823", areaID: "430406", area: "\u96c1\u5cf0\u533a", fatherID: "430400"}, {id: "1824", areaID: "430407", area: "\u77f3\u9f13\u533a", fatherID: "430400"}, {id: "1825", areaID: "430408", area: "\u84b8\u6e58\u533a", fatherID: "430400"}, {id: "1826", areaID: "430412", area: "\u5357\u5cb3\u533a", fatherID: "430400"}, {id: "1827", areaID: "430421", area: "\u8861\u9633\u53bf", fatherID: "430400"}, {id: "1828", areaID: "430422", area: "\u8861\u5357\u53bf", fatherID: "430400"}, {id: "1829", areaID: "430423", area: "\u8861\u5c71\u53bf", fatherID: "430400"}, {id: "1830", areaID: "430424", area: "\u8861\u4e1c\u53bf", fatherID: "430400"}, {
        id: "1831",
        areaID: "430426",
        area: "\u7941\u4e1c\u53bf",
        fatherID: "430400"
    }, {id: "1832", areaID: "430481", area: "\u8012\u9633\u5e02", fatherID: "430400"}, {id: "1833", areaID: "430482", area: "\u5e38\u5b81\u5e02", fatherID: "430400"}, {id: "1834", areaID: "430501", area: "\u5e02\u8f96\u533a", fatherID: "430500"}, {id: "1835", areaID: "430502", area: "\u53cc\u6e05\u533a", fatherID: "430500"}, {id: "1836", areaID: "430503", area: "\u5927\u7965\u533a", fatherID: "430500"}, {id: "1837", areaID: "430511", area: "\u5317\u5854\u533a", fatherID: "430500"}, {id: "1838", areaID: "430521", area: "\u90b5\u4e1c\u53bf", fatherID: "430500"}, {id: "1839", areaID: "430522", area: "\u65b0\u90b5\u53bf", fatherID: "430500"}, {id: "1840", areaID: "430523", area: "\u90b5\u9633\u53bf", fatherID: "430500"}, {
        id: "1841",
        areaID: "430524",
        area: "\u9686\u56de\u53bf",
        fatherID: "430500"
    }, {id: "1842", areaID: "430525", area: "\u6d1e\u53e3\u53bf", fatherID: "430500"}, {id: "1843", areaID: "430527", area: "\u7ee5\u5b81\u53bf", fatherID: "430500"}, {id: "1844", areaID: "430528", area: "\u65b0\u5b81\u53bf", fatherID: "430500"}, {id: "1845", areaID: "430529", area: "\u57ce\u6b65\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "430500"}, {id: "1846", areaID: "430581", area: "\u6b66\u5188\u5e02", fatherID: "430500"}, {id: "1847", areaID: "430601", area: "\u5e02\u8f96\u533a", fatherID: "430600"}, {id: "1848", areaID: "430602", area: "\u5cb3\u9633\u697c\u533a", fatherID: "430600"}, {id: "1849", areaID: "430603", area: "\u4e91\u6eaa\u533a", fatherID: "430600"}, {id: "1850", areaID: "430611", area: "\u541b\u5c71\u533a", fatherID: "430600"}, {
        id: "1851",
        areaID: "430621",
        area: "\u5cb3\u9633\u53bf",
        fatherID: "430600"
    }, {id: "1852", areaID: "430623", area: "\u534e\u5bb9\u53bf", fatherID: "430600"}, {id: "1853", areaID: "430624", area: "\u6e58\u9634\u53bf", fatherID: "430600"}, {id: "1854", areaID: "430626", area: "\u5e73\u6c5f\u53bf", fatherID: "430600"}, {id: "1855", areaID: "430681", area: "\u6c68\u7f57\u5e02", fatherID: "430600"}, {id: "1856", areaID: "430682", area: "\u4e34\u6e58\u5e02", fatherID: "430600"}, {id: "1857", areaID: "430701", area: "\u5e02\u8f96\u533a", fatherID: "430700"}, {id: "1858", areaID: "430702", area: "\u6b66\u9675\u533a", fatherID: "430700"}, {id: "1859", areaID: "430703", area: "\u9f0e\u57ce\u533a", fatherID: "430700"}, {id: "1860", areaID: "430721", area: "\u5b89\u4e61\u53bf", fatherID: "430700"}, {
        id: "1861",
        areaID: "430722",
        area: "\u6c49\u5bff\u53bf",
        fatherID: "430700"
    }, {id: "1862", areaID: "430723", area: "\u6fa7\u3000\u53bf", fatherID: "430700"}, {id: "1863", areaID: "430724", area: "\u4e34\u6fa7\u53bf", fatherID: "430700"}, {id: "1864", areaID: "430725", area: "\u6843\u6e90\u53bf", fatherID: "430700"}, {id: "1865", areaID: "430726", area: "\u77f3\u95e8\u53bf", fatherID: "430700"}, {id: "1866", areaID: "430781", area: "\u6d25\u5e02\u5e02", fatherID: "430700"}, {id: "1867", areaID: "430801", area: "\u5e02\u8f96\u533a", fatherID: "430800"}, {id: "1868", areaID: "430802", area: "\u6c38\u5b9a\u533a", fatherID: "430800"}, {id: "1869", areaID: "430811", area: "\u6b66\u9675\u6e90\u533a", fatherID: "430800"}, {id: "1870", areaID: "430821", area: "\u6148\u5229\u53bf", fatherID: "430800"}, {
        id: "1871",
        areaID: "430822",
        area: "\u6851\u690d\u53bf",
        fatherID: "430800"
    }, {id: "1872", areaID: "430901", area: "\u5e02\u8f96\u533a", fatherID: "430900"}, {id: "1873", areaID: "430902", area: "\u8d44\u9633\u533a", fatherID: "430900"}, {id: "1874", areaID: "430903", area: "\u8d6b\u5c71\u533a", fatherID: "430900"}, {id: "1875", areaID: "430921", area: "\u5357\u3000\u53bf", fatherID: "430900"}, {id: "1876", areaID: "430922", area: "\u6843\u6c5f\u53bf", fatherID: "430900"}, {id: "1877", areaID: "430923", area: "\u5b89\u5316\u53bf", fatherID: "430900"}, {id: "1878", areaID: "430981", area: "\u6c85\u6c5f\u5e02", fatherID: "430900"}, {id: "1879", areaID: "431001", area: "\u5e02\u8f96\u533a", fatherID: "431000"}, {id: "1880", areaID: "431002", area: "\u5317\u6e56\u533a", fatherID: "431000"}, {
        id: "1881",
        areaID: "431003",
        area: "\u82cf\u4ed9\u533a",
        fatherID: "431000"
    }, {id: "1882", areaID: "431021", area: "\u6842\u9633\u53bf", fatherID: "431000"}, {id: "1883", areaID: "431022", area: "\u5b9c\u7ae0\u53bf", fatherID: "431000"}, {id: "1884", areaID: "431023", area: "\u6c38\u5174\u53bf", fatherID: "431000"}, {id: "1885", areaID: "431024", area: "\u5609\u79be\u53bf", fatherID: "431000"}, {id: "1886", areaID: "431025", area: "\u4e34\u6b66\u53bf", fatherID: "431000"}, {id: "1887", areaID: "431026", area: "\u6c5d\u57ce\u53bf", fatherID: "431000"}, {id: "1888", areaID: "431027", area: "\u6842\u4e1c\u53bf", fatherID: "431000"}, {id: "1889", areaID: "431028", area: "\u5b89\u4ec1\u53bf", fatherID: "431000"}, {id: "1890", areaID: "431081", area: "\u8d44\u5174\u5e02", fatherID: "431000"}, {
        id: "1891",
        areaID: "431101",
        area: "\u5e02\u8f96\u533a",
        fatherID: "431100"
    }, {id: "1892", areaID: "431102", area: "\u829d\u5c71\u533a", fatherID: "431100"}, {id: "1893", areaID: "431103", area: "\u51b7\u6c34\u6ee9\u533a", fatherID: "431100"}, {id: "1894", areaID: "431121", area: "\u7941\u9633\u53bf", fatherID: "431100"}, {id: "1895", areaID: "431122", area: "\u4e1c\u5b89\u53bf", fatherID: "431100"}, {id: "1896", areaID: "431123", area: "\u53cc\u724c\u53bf", fatherID: "431100"}, {id: "1897", areaID: "431124", area: "\u9053\u3000\u53bf", fatherID: "431100"}, {id: "1898", areaID: "431125", area: "\u6c5f\u6c38\u53bf", fatherID: "431100"}, {id: "1899", areaID: "431126", area: "\u5b81\u8fdc\u53bf", fatherID: "431100"}, {id: "1900", areaID: "431127", area: "\u84dd\u5c71\u53bf", fatherID: "431100"}, {
        id: "1901",
        areaID: "431128",
        area: "\u65b0\u7530\u53bf",
        fatherID: "431100"
    }, {id: "1902", areaID: "431129", area: "\u6c5f\u534e\u7476\u65cf\u81ea\u6cbb\u53bf", fatherID: "431100"}, {id: "1903", areaID: "431201", area: "\u5e02\u8f96\u533a", fatherID: "431200"}, {id: "1904", areaID: "431202", area: "\u9e64\u57ce\u533a", fatherID: "431200"}, {id: "1905", areaID: "431221", area: "\u4e2d\u65b9\u53bf", fatherID: "431200"}, {id: "1906", areaID: "431222", area: "\u6c85\u9675\u53bf", fatherID: "431200"}, {id: "1907", areaID: "431223", area: "\u8fb0\u6eaa\u53bf", fatherID: "431200"}, {id: "1908", areaID: "431224", area: "\u6e86\u6d66\u53bf", fatherID: "431200"}, {id: "1909", areaID: "431225", area: "\u4f1a\u540c\u53bf", fatherID: "431200"}, {id: "1910", areaID: "431226", area: "\u9ebb\u9633\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "431200"}, {
        id: "1911",
        areaID: "431227",
        area: "\u65b0\u6643\u4f97\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "431200"
    }, {id: "1912", areaID: "431228", area: "\u82b7\u6c5f\u4f97\u65cf\u81ea\u6cbb\u53bf", fatherID: "431200"}, {id: "1913", areaID: "431229", area: "\u9756\u5dde\u82d7\u65cf\u4f97\u65cf\u81ea\u6cbb\u53bf", fatherID: "431200"}, {id: "1914", areaID: "431230", area: "\u901a\u9053\u4f97\u65cf\u81ea\u6cbb\u53bf", fatherID: "431200"}, {id: "1915", areaID: "431281", area: "\u6d2a\u6c5f\u5e02", fatherID: "431200"}, {id: "1916", areaID: "431301", area: "\u5e02\u8f96\u533a", fatherID: "431300"}, {id: "1917", areaID: "431302", area: "\u5a04\u661f\u533a", fatherID: "431300"}, {id: "1918", areaID: "431321", area: "\u53cc\u5cf0\u53bf", fatherID: "431300"}, {id: "1919", areaID: "431322", area: "\u65b0\u5316\u53bf", fatherID: "431300"}, {
        id: "1920",
        areaID: "431381",
        area: "\u51b7\u6c34\u6c5f\u5e02",
        fatherID: "431300"
    }, {id: "1921", areaID: "431382", area: "\u6d9f\u6e90\u5e02", fatherID: "431300"}, {id: "1922", areaID: "433101", area: "\u5409\u9996\u5e02", fatherID: "433100"}, {id: "1923", areaID: "433122", area: "\u6cf8\u6eaa\u53bf", fatherID: "433100"}, {id: "1924", areaID: "433123", area: "\u51e4\u51f0\u53bf", fatherID: "433100"}, {id: "1925", areaID: "433124", area: "\u82b1\u57a3\u53bf", fatherID: "433100"}, {id: "1926", areaID: "433125", area: "\u4fdd\u9756\u53bf", fatherID: "433100"}, {id: "1927", areaID: "433126", area: "\u53e4\u4e08\u53bf", fatherID: "433100"}, {id: "1928", areaID: "433127", area: "\u6c38\u987a\u53bf", fatherID: "433100"}, {id: "1929", areaID: "433130", area: "\u9f99\u5c71\u53bf", fatherID: "433100"}, {
        id: "1930",
        areaID: "440101",
        area: "\u5e02\u8f96\u533a",
        fatherID: "440100"
    }, {id: "1931", areaID: "440102", area: "\u4e1c\u5c71\u533a", fatherID: "440100"}, {id: "1932", areaID: "440103", area: "\u8354\u6e7e\u533a", fatherID: "440100"}, {id: "1933", areaID: "440104", area: "\u8d8a\u79c0\u533a", fatherID: "440100"}, {id: "1934", areaID: "440105", area: "\u6d77\u73e0\u533a", fatherID: "440100"}, {id: "1935", areaID: "440106", area: "\u5929\u6cb3\u533a", fatherID: "440100"}, {id: "1936", areaID: "440107", area: "\u82b3\u6751\u533a", fatherID: "440100"}, {id: "1937", areaID: "440111", area: "\u767d\u4e91\u533a", fatherID: "440100"}, {id: "1938", areaID: "440112", area: "\u9ec4\u57d4\u533a", fatherID: "440100"}, {id: "1939", areaID: "440113", area: "\u756a\u79ba\u533a", fatherID: "440100"}, {
        id: "1940",
        areaID: "440114",
        area: "\u82b1\u90fd\u533a",
        fatherID: "440100"
    }, {id: "1941", areaID: "440183", area: "\u589e\u57ce\u5e02", fatherID: "440100"}, {id: "1942", areaID: "440184", area: "\u4ece\u5316\u5e02", fatherID: "440100"}, {id: "1943", areaID: "440201", area: "\u5e02\u8f96\u533a", fatherID: "440200"}, {id: "1944", areaID: "440203", area: "\u6b66\u6c5f\u533a", fatherID: "440200"}, {id: "1945", areaID: "440204", area: "\u6d48\u6c5f\u533a", fatherID: "440200"}, {id: "1946", areaID: "440205", area: "\u66f2\u6c5f\u533a", fatherID: "440200"}, {id: "1947", areaID: "440222", area: "\u59cb\u5174\u53bf", fatherID: "440200"}, {id: "1948", areaID: "440224", area: "\u4ec1\u5316\u53bf", fatherID: "440200"}, {id: "1949", areaID: "440229", area: "\u7fc1\u6e90\u53bf", fatherID: "440200"}, {
        id: "1950",
        areaID: "440232",
        area: "\u4e73\u6e90\u7476\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "440200"
    }, {id: "1951", areaID: "440233", area: "\u65b0\u4e30\u53bf", fatherID: "440200"}, {id: "1952", areaID: "440281", area: "\u4e50\u660c\u5e02", fatherID: "440200"}, {id: "1953", areaID: "440282", area: "\u5357\u96c4\u5e02", fatherID: "440200"}, {id: "1954", areaID: "440301", area: "\u5e02\u8f96\u533a", fatherID: "440300"}, {id: "1955", areaID: "440303", area: "\u7f57\u6e56\u533a", fatherID: "440300"}, {id: "1956", areaID: "440304", area: "\u798f\u7530\u533a", fatherID: "440300"}, {id: "1957", areaID: "440305", area: "\u5357\u5c71\u533a", fatherID: "440300"}, {id: "1958", areaID: "440306", area: "\u5b9d\u5b89\u533a", fatherID: "440300"}, {id: "1959", areaID: "440307", area: "\u9f99\u5c97\u533a", fatherID: "440300"}, {
        id: "1960",
        areaID: "440308",
        area: "\u76d0\u7530\u533a",
        fatherID: "440300"
    }, {id: "1961", areaID: "440401", area: "\u5e02\u8f96\u533a", fatherID: "440400"}, {id: "1962", areaID: "440402", area: "\u9999\u6d32\u533a", fatherID: "440400"}, {id: "1963", areaID: "440403", area: "\u6597\u95e8\u533a", fatherID: "440400"}, {id: "1964", areaID: "440404", area: "\u91d1\u6e7e\u533a", fatherID: "440400"}, {id: "1965", areaID: "440501", area: "\u5e02\u8f96\u533a", fatherID: "440500"}, {id: "1966", areaID: "440507", area: "\u9f99\u6e56\u533a", fatherID: "440500"}, {id: "1967", areaID: "440511", area: "\u91d1\u5e73\u533a", fatherID: "440500"}, {id: "1968", areaID: "440512", area: "\u6fe0\u6c5f\u533a", fatherID: "440500"}, {id: "1969", areaID: "440513", area: "\u6f6e\u9633\u533a", fatherID: "440500"}, {
        id: "1970",
        areaID: "440514",
        area: "\u6f6e\u5357\u533a",
        fatherID: "440500"
    }, {id: "1971", areaID: "440515", area: "\u6f84\u6d77\u533a", fatherID: "440500"}, {id: "1972", areaID: "440523", area: "\u5357\u6fb3\u53bf", fatherID: "440500"}, {id: "1973", areaID: "440601", area: "\u5e02\u8f96\u533a", fatherID: "440600"}, {id: "1974", areaID: "440604", area: "\u7985\u57ce\u533a", fatherID: "440600"}, {id: "1975", areaID: "440605", area: "\u5357\u6d77\u533a", fatherID: "440600"}, {id: "1976", areaID: "440606", area: "\u987a\u5fb7\u533a", fatherID: "440600"}, {id: "1977", areaID: "440607", area: "\u4e09\u6c34\u533a", fatherID: "440600"}, {id: "1978", areaID: "440608", area: "\u9ad8\u660e\u533a", fatherID: "440600"}, {id: "1979", areaID: "440701", area: "\u5e02\u8f96\u533a", fatherID: "440700"}, {
        id: "1980",
        areaID: "440703",
        area: "\u84ec\u6c5f\u533a",
        fatherID: "440700"
    }, {id: "1981", areaID: "440704", area: "\u6c5f\u6d77\u533a", fatherID: "440700"}, {id: "1982", areaID: "440705", area: "\u65b0\u4f1a\u533a", fatherID: "440700"}, {id: "1983", areaID: "440781", area: "\u53f0\u5c71\u5e02", fatherID: "440700"}, {id: "1984", areaID: "440783", area: "\u5f00\u5e73\u5e02", fatherID: "440700"}, {id: "1985", areaID: "440784", area: "\u9e64\u5c71\u5e02", fatherID: "440700"}, {id: "1986", areaID: "440785", area: "\u6069\u5e73\u5e02", fatherID: "440700"}, {id: "1987", areaID: "440801", area: "\u5e02\u8f96\u533a", fatherID: "440800"}, {id: "1988", areaID: "440802", area: "\u8d64\u574e\u533a", fatherID: "440800"}, {id: "1989", areaID: "440803", area: "\u971e\u5c71\u533a", fatherID: "440800"}, {
        id: "1990",
        areaID: "440804",
        area: "\u5761\u5934\u533a",
        fatherID: "440800"
    }, {id: "1991", areaID: "440811", area: "\u9ebb\u7ae0\u533a", fatherID: "440800"}, {id: "1992", areaID: "440823", area: "\u9042\u6eaa\u53bf", fatherID: "440800"}, {id: "1993", areaID: "440825", area: "\u5f90\u95fb\u53bf", fatherID: "440800"}, {id: "1994", areaID: "440881", area: "\u5ec9\u6c5f\u5e02", fatherID: "440800"}, {id: "1995", areaID: "440882", area: "\u96f7\u5dde\u5e02", fatherID: "440800"}, {id: "1996", areaID: "440883", area: "\u5434\u5ddd\u5e02", fatherID: "440800"}, {id: "1997", areaID: "440901", area: "\u5e02\u8f96\u533a", fatherID: "440900"}, {id: "1998", areaID: "440902", area: "\u8302\u5357\u533a", fatherID: "440900"}, {id: "1999", areaID: "440903", area: "\u8302\u6e2f\u533a", fatherID: "440900"}, {
        id: "2000",
        areaID: "440923",
        area: "\u7535\u767d\u53bf",
        fatherID: "440900"
    }, {id: "2001", areaID: "440981", area: "\u9ad8\u5dde\u5e02", fatherID: "440900"}, {id: "2002", areaID: "440982", area: "\u5316\u5dde\u5e02", fatherID: "440900"}, {id: "2003", areaID: "440983", area: "\u4fe1\u5b9c\u5e02", fatherID: "440900"}, {id: "2004", areaID: "441201", area: "\u5e02\u8f96\u533a", fatherID: "441200"}, {id: "2005", areaID: "441202", area: "\u7aef\u5dde\u533a", fatherID: "441200"}, {id: "2006", areaID: "441203", area: "\u9f0e\u6e56\u533a", fatherID: "441200"}, {id: "2007", areaID: "441223", area: "\u5e7f\u5b81\u53bf", fatherID: "441200"}, {id: "2008", areaID: "441224", area: "\u6000\u96c6\u53bf", fatherID: "441200"}, {id: "2009", areaID: "441225", area: "\u5c01\u5f00\u53bf", fatherID: "441200"}, {
        id: "2010",
        areaID: "441226",
        area: "\u5fb7\u5e86\u53bf",
        fatherID: "441200"
    }, {id: "2011", areaID: "441283", area: "\u9ad8\u8981\u5e02", fatherID: "441200"}, {id: "2012", areaID: "441284", area: "\u56db\u4f1a\u5e02", fatherID: "441200"}, {id: "2013", areaID: "441301", area: "\u5e02\u8f96\u533a", fatherID: "441300"}, {id: "2014", areaID: "441302", area: "\u60e0\u57ce\u533a", fatherID: "441300"}, {id: "2015", areaID: "441303", area: "\u60e0\u9633\u533a", fatherID: "441300"}, {id: "2016", areaID: "441322", area: "\u535a\u7f57\u53bf", fatherID: "441300"}, {id: "2017", areaID: "441323", area: "\u60e0\u4e1c\u53bf", fatherID: "441300"}, {id: "2018", areaID: "441324", area: "\u9f99\u95e8\u53bf", fatherID: "441300"}, {id: "2019", areaID: "441401", area: "\u5e02\u8f96\u533a", fatherID: "441400"}, {
        id: "2020",
        areaID: "441402",
        area: "\u6885\u6c5f\u533a",
        fatherID: "441400"
    }, {id: "2021", areaID: "441421", area: "\u6885\u3000\u53bf", fatherID: "441400"}, {id: "2022", areaID: "441422", area: "\u5927\u57d4\u53bf", fatherID: "441400"}, {id: "2023", areaID: "441423", area: "\u4e30\u987a\u53bf", fatherID: "441400"}, {id: "2024", areaID: "441424", area: "\u4e94\u534e\u53bf", fatherID: "441400"}, {id: "2025", areaID: "441426", area: "\u5e73\u8fdc\u53bf", fatherID: "441400"}, {id: "2026", areaID: "441427", area: "\u8549\u5cad\u53bf", fatherID: "441400"}, {id: "2027", areaID: "441481", area: "\u5174\u5b81\u5e02", fatherID: "441400"}, {id: "2028", areaID: "441501", area: "\u5e02\u8f96\u533a", fatherID: "441500"}, {id: "2029", areaID: "441502", area: "\u57ce\u3000\u533a", fatherID: "441500"}, {
        id: "2030",
        areaID: "441521",
        area: "\u6d77\u4e30\u53bf",
        fatherID: "441500"
    }, {id: "2031", areaID: "441523", area: "\u9646\u6cb3\u53bf", fatherID: "441500"}, {id: "2032", areaID: "441581", area: "\u9646\u4e30\u5e02", fatherID: "441500"}, {id: "2033", areaID: "441601", area: "\u5e02\u8f96\u533a", fatherID: "441600"}, {id: "2034", areaID: "441602", area: "\u6e90\u57ce\u533a", fatherID: "441600"}, {id: "2035", areaID: "441621", area: "\u7d2b\u91d1\u53bf", fatherID: "441600"}, {id: "2036", areaID: "441622", area: "\u9f99\u5ddd\u53bf", fatherID: "441600"}, {id: "2037", areaID: "441623", area: "\u8fde\u5e73\u53bf", fatherID: "441600"}, {id: "2038", areaID: "441624", area: "\u548c\u5e73\u53bf", fatherID: "441600"}, {id: "2039", areaID: "441625", area: "\u4e1c\u6e90\u53bf", fatherID: "441600"}, {
        id: "2040",
        areaID: "441701",
        area: "\u5e02\u8f96\u533a",
        fatherID: "441700"
    }, {id: "2041", areaID: "441702", area: "\u6c5f\u57ce\u533a", fatherID: "441700"}, {id: "2042", areaID: "441721", area: "\u9633\u897f\u53bf", fatherID: "441700"}, {id: "2043", areaID: "441723", area: "\u9633\u4e1c\u53bf", fatherID: "441700"}, {id: "2044", areaID: "441781", area: "\u9633\u6625\u5e02", fatherID: "441700"}, {id: "2045", areaID: "441801", area: "\u5e02\u8f96\u533a", fatherID: "441800"}, {id: "2046", areaID: "441802", area: "\u6e05\u57ce\u533a", fatherID: "441800"}, {id: "2047", areaID: "441821", area: "\u4f5b\u5188\u53bf", fatherID: "441800"}, {id: "2048", areaID: "441823", area: "\u9633\u5c71\u53bf", fatherID: "441800"}, {id: "2049", areaID: "441825", area: "\u8fde\u5c71\u58ee\u65cf\u7476\u65cf\u81ea\u6cbb\u53bf", fatherID: "441800"}, {
        id: "2050",
        areaID: "441826",
        area: "\u8fde\u5357\u7476\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "441800"
    }, {id: "2051", areaID: "441827", area: "\u6e05\u65b0\u53bf", fatherID: "441800"}, {id: "2052", areaID: "441881", area: "\u82f1\u5fb7\u5e02", fatherID: "441800"}, {id: "2053", areaID: "441882", area: "\u8fde\u5dde\u5e02", fatherID: "441800"}, {id: "2054", areaID: "445101", area: "\u5e02\u8f96\u533a", fatherID: "445100"}, {id: "2055", areaID: "445102", area: "\u6e58\u6865\u533a", fatherID: "445100"}, {id: "2056", areaID: "445121", area: "\u6f6e\u5b89\u53bf", fatherID: "445100"}, {id: "2057", areaID: "445122", area: "\u9976\u5e73\u53bf", fatherID: "445100"}, {id: "2058", areaID: "445201", area: "\u5e02\u8f96\u533a", fatherID: "445200"}, {id: "2059", areaID: "445202", area: "\u6995\u57ce\u533a", fatherID: "445200"}, {
        id: "2060",
        areaID: "445221",
        area: "\u63ed\u4e1c\u53bf",
        fatherID: "445200"
    }, {id: "2061", areaID: "445222", area: "\u63ed\u897f\u53bf", fatherID: "445200"}, {id: "2062", areaID: "445224", area: "\u60e0\u6765\u53bf", fatherID: "445200"}, {id: "2063", areaID: "445281", area: "\u666e\u5b81\u5e02", fatherID: "445200"}, {id: "2064", areaID: "445301", area: "\u5e02\u8f96\u533a", fatherID: "445300"}, {id: "2065", areaID: "445302", area: "\u4e91\u57ce\u533a", fatherID: "445300"}, {id: "2066", areaID: "445321", area: "\u65b0\u5174\u53bf", fatherID: "445300"}, {id: "2067", areaID: "445322", area: "\u90c1\u5357\u53bf", fatherID: "445300"}, {id: "2068", areaID: "445323", area: "\u4e91\u5b89\u53bf", fatherID: "445300"}, {id: "2069", areaID: "445381", area: "\u7f57\u5b9a\u5e02", fatherID: "445300"}, {
        id: "2070",
        areaID: "450101",
        area: "\u5e02\u8f96\u533a",
        fatherID: "450100"
    }, {id: "2071", areaID: "450102", area: "\u5174\u5b81\u533a", fatherID: "450100"}, {id: "2072", areaID: "450103", area: "\u9752\u79c0\u533a", fatherID: "450100"}, {id: "2073", areaID: "450105", area: "\u6c5f\u5357\u533a", fatherID: "450100"}, {id: "2074", areaID: "450107", area: "\u897f\u4e61\u5858\u533a", fatherID: "450100"}, {id: "2075", areaID: "450108", area: "\u826f\u5e86\u533a", fatherID: "450100"}, {id: "2076", areaID: "450109", area: "\u9095\u5b81\u533a", fatherID: "450100"}, {id: "2077", areaID: "450122", area: "\u6b66\u9e23\u53bf", fatherID: "450100"}, {id: "2078", areaID: "450123", area: "\u9686\u5b89\u53bf", fatherID: "450100"}, {id: "2079", areaID: "450124", area: "\u9a6c\u5c71\u53bf", fatherID: "450100"}, {
        id: "2080",
        areaID: "450125",
        area: "\u4e0a\u6797\u53bf",
        fatherID: "450100"
    }, {id: "2081", areaID: "450126", area: "\u5bbe\u9633\u53bf", fatherID: "450100"}, {id: "2082", areaID: "450127", area: "\u6a2a\u3000\u53bf", fatherID: "450100"}, {id: "2083", areaID: "450201", area: "\u5e02\u8f96\u533a", fatherID: "450200"}, {id: "2084", areaID: "450202", area: "\u57ce\u4e2d\u533a", fatherID: "450200"}, {id: "2085", areaID: "450203", area: "\u9c7c\u5cf0\u533a", fatherID: "450200"}, {id: "2086", areaID: "450204", area: "\u67f3\u5357\u533a", fatherID: "450200"}, {id: "2087", areaID: "450205", area: "\u67f3\u5317\u533a", fatherID: "450200"}, {id: "2088", areaID: "450221", area: "\u67f3\u6c5f\u53bf", fatherID: "450200"}, {id: "2089", areaID: "450222", area: "\u67f3\u57ce\u53bf", fatherID: "450200"}, {
        id: "2090",
        areaID: "450223",
        area: "\u9e7f\u5be8\u53bf",
        fatherID: "450200"
    }, {id: "2091", areaID: "450224", area: "\u878d\u5b89\u53bf", fatherID: "450200"}, {id: "2092", areaID: "450225", area: "\u878d\u6c34\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "450200"}, {id: "2093", areaID: "450226", area: "\u4e09\u6c5f\u4f97\u65cf\u81ea\u6cbb\u53bf", fatherID: "450200"}, {id: "2094", areaID: "450301", area: "\u5e02\u8f96\u533a", fatherID: "450300"}, {id: "2095", areaID: "450302", area: "\u79c0\u5cf0\u533a", fatherID: "450300"}, {id: "2096", areaID: "450303", area: "\u53e0\u5f69\u533a", fatherID: "450300"}, {id: "2097", areaID: "450304", area: "\u8c61\u5c71\u533a", fatherID: "450300"}, {id: "2098", areaID: "450305", area: "\u4e03\u661f\u533a", fatherID: "450300"}, {id: "2099", areaID: "450311", area: "\u96c1\u5c71\u533a", fatherID: "450300"}, {
        id: "2100",
        areaID: "450321",
        area: "\u9633\u6714\u53bf",
        fatherID: "450300"
    }, {id: "2101", areaID: "450322", area: "\u4e34\u6842\u53bf", fatherID: "450300"}, {id: "2102", areaID: "450323", area: "\u7075\u5ddd\u53bf", fatherID: "450300"}, {id: "2103", areaID: "450324", area: "\u5168\u5dde\u53bf", fatherID: "450300"}, {id: "2104", areaID: "450325", area: "\u5174\u5b89\u53bf", fatherID: "450300"}, {id: "2105", areaID: "450326", area: "\u6c38\u798f\u53bf", fatherID: "450300"}, {id: "2106", areaID: "450327", area: "\u704c\u9633\u53bf", fatherID: "450300"}, {id: "2107", areaID: "450328", area: "\u9f99\u80dc\u5404\u65cf\u81ea\u6cbb\u53bf", fatherID: "450300"}, {id: "2108", areaID: "450329", area: "\u8d44\u6e90\u53bf", fatherID: "450300"}, {id: "2109", areaID: "450330", area: "\u5e73\u4e50\u53bf", fatherID: "450300"}, {
        id: "2110",
        areaID: "450331",
        area: "\u8354\u84b2\u53bf",
        fatherID: "450300"
    }, {id: "2111", areaID: "450332", area: "\u606d\u57ce\u7476\u65cf\u81ea\u6cbb\u53bf", fatherID: "450300"}, {id: "2112", areaID: "450401", area: "\u5e02\u8f96\u533a", fatherID: "450400"}, {id: "2113", areaID: "450403", area: "\u4e07\u79c0\u533a", fatherID: "450400"}, {id: "2114", areaID: "450404", area: "\u8776\u5c71\u533a", fatherID: "450400"}, {id: "2115", areaID: "450405", area: "\u957f\u6d32\u533a", fatherID: "450400"}, {id: "2116", areaID: "450421", area: "\u82cd\u68a7\u53bf", fatherID: "450400"}, {id: "2117", areaID: "450422", area: "\u85e4\u3000\u53bf", fatherID: "450400"}, {id: "2118", areaID: "450423", area: "\u8499\u5c71\u53bf", fatherID: "450400"}, {id: "2119", areaID: "450481", area: "\u5c91\u6eaa\u5e02", fatherID: "450400"}, {
        id: "2120",
        areaID: "450501",
        area: "\u5e02\u8f96\u533a",
        fatherID: "450500"
    }, {id: "2121", areaID: "450502", area: "\u6d77\u57ce\u533a", fatherID: "450500"}, {id: "2122", areaID: "450503", area: "\u94f6\u6d77\u533a", fatherID: "450500"}, {id: "2123", areaID: "450512", area: "\u94c1\u5c71\u6e2f\u533a", fatherID: "450500"}, {id: "2124", areaID: "450521", area: "\u5408\u6d66\u53bf", fatherID: "450500"}, {id: "2125", areaID: "450601", area: "\u5e02\u8f96\u533a", fatherID: "450600"}, {id: "2126", areaID: "450602", area: "\u6e2f\u53e3\u533a", fatherID: "450600"}, {id: "2127", areaID: "450603", area: "\u9632\u57ce\u533a", fatherID: "450600"}, {id: "2128", areaID: "450621", area: "\u4e0a\u601d\u53bf", fatherID: "450600"}, {id: "2129", areaID: "450681", area: "\u4e1c\u5174\u5e02", fatherID: "450600"}, {
        id: "2130",
        areaID: "450701",
        area: "\u5e02\u8f96\u533a",
        fatherID: "450700"
    }, {id: "2131", areaID: "450702", area: "\u94a6\u5357\u533a", fatherID: "450700"}, {id: "2132", areaID: "450703", area: "\u94a6\u5317\u533a", fatherID: "450700"}, {id: "2133", areaID: "450721", area: "\u7075\u5c71\u53bf", fatherID: "450700"}, {id: "2134", areaID: "450722", area: "\u6d66\u5317\u53bf", fatherID: "450700"}, {id: "2135", areaID: "450801", area: "\u5e02\u8f96\u533a", fatherID: "450800"}, {id: "2136", areaID: "450802", area: "\u6e2f\u5317\u533a", fatherID: "450800"}, {id: "2137", areaID: "450803", area: "\u6e2f\u5357\u533a", fatherID: "450800"}, {id: "2138", areaID: "450804", area: "\u8983\u5858\u533a", fatherID: "450800"}, {id: "2139", areaID: "450821", area: "\u5e73\u5357\u53bf", fatherID: "450800"}, {
        id: "2140",
        areaID: "450881",
        area: "\u6842\u5e73\u5e02",
        fatherID: "450800"
    }, {id: "2141", areaID: "450901", area: "\u5e02\u8f96\u533a", fatherID: "450900"}, {id: "2142", areaID: "450902", area: "\u7389\u5dde\u533a", fatherID: "450900"}, {id: "2143", areaID: "450921", area: "\u5bb9\u3000\u53bf", fatherID: "450900"}, {id: "2144", areaID: "450922", area: "\u9646\u5ddd\u53bf", fatherID: "450900"}, {id: "2145", areaID: "450923", area: "\u535a\u767d\u53bf", fatherID: "450900"}, {id: "2146", areaID: "450924", area: "\u5174\u4e1a\u53bf", fatherID: "450900"}, {id: "2147", areaID: "450981", area: "\u5317\u6d41\u5e02", fatherID: "450900"}, {id: "2148", areaID: "451001", area: "\u5e02\u8f96\u533a", fatherID: "451000"}, {id: "2149", areaID: "451002", area: "\u53f3\u6c5f\u533a", fatherID: "451000"}, {
        id: "2150",
        areaID: "451021",
        area: "\u7530\u9633\u53bf",
        fatherID: "451000"
    }, {id: "2151", areaID: "451022", area: "\u7530\u4e1c\u53bf", fatherID: "451000"}, {id: "2152", areaID: "451023", area: "\u5e73\u679c\u53bf", fatherID: "451000"}, {id: "2153", areaID: "451024", area: "\u5fb7\u4fdd\u53bf", fatherID: "451000"}, {id: "2154", areaID: "451025", area: "\u9756\u897f\u53bf", fatherID: "451000"}, {id: "2155", areaID: "451026", area: "\u90a3\u5761\u53bf", fatherID: "451000"}, {id: "2156", areaID: "451027", area: "\u51cc\u4e91\u53bf", fatherID: "451000"}, {id: "2157", areaID: "451028", area: "\u4e50\u4e1a\u53bf", fatherID: "451000"}, {id: "2158", areaID: "451029", area: "\u7530\u6797\u53bf", fatherID: "451000"}, {id: "2159", areaID: "451030", area: "\u897f\u6797\u53bf", fatherID: "451000"}, {
        id: "2160",
        areaID: "451031",
        area: "\u9686\u6797\u5404\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "451000"
    }, {id: "2161", areaID: "451101", area: "\u5e02\u8f96\u533a", fatherID: "451100"}, {id: "2162", areaID: "451102", area: "\u516b\u6b65\u533a", fatherID: "451100"}, {id: "2163", areaID: "451121", area: "\u662d\u5e73\u53bf", fatherID: "451100"}, {id: "2164", areaID: "451122", area: "\u949f\u5c71\u53bf", fatherID: "451100"}, {id: "2165", areaID: "451123", area: "\u5bcc\u5ddd\u7476\u65cf\u81ea\u6cbb\u53bf", fatherID: "451100"}, {id: "2166", areaID: "451201", area: "\u5e02\u8f96\u533a", fatherID: "451200"}, {id: "2167", areaID: "451202", area: "\u91d1\u57ce\u6c5f\u533a", fatherID: "451200"}, {id: "2168", areaID: "451221", area: "\u5357\u4e39\u53bf", fatherID: "451200"}, {id: "2169", areaID: "451222", area: "\u5929\u5ce8\u53bf", fatherID: "451200"}, {
        id: "2170",
        areaID: "451223",
        area: "\u51e4\u5c71\u53bf",
        fatherID: "451200"
    }, {id: "2171", areaID: "451224", area: "\u4e1c\u5170\u53bf", fatherID: "451200"}, {id: "2172", areaID: "451225", area: "\u7f57\u57ce\u4eeb\u4f6c\u65cf\u81ea\u6cbb\u53bf", fatherID: "451200"}, {id: "2173", areaID: "451226", area: "\u73af\u6c5f\u6bdb\u5357\u65cf\u81ea\u6cbb\u53bf", fatherID: "451200"}, {id: "2174", areaID: "451227", area: "\u5df4\u9a6c\u7476\u65cf\u81ea\u6cbb\u53bf", fatherID: "451200"}, {id: "2175", areaID: "451228", area: "\u90fd\u5b89\u7476\u65cf\u81ea\u6cbb\u53bf", fatherID: "451200"}, {id: "2176", areaID: "451229", area: "\u5927\u5316\u7476\u65cf\u81ea\u6cbb\u53bf", fatherID: "451200"}, {id: "2177", areaID: "451281", area: "\u5b9c\u5dde\u5e02", fatherID: "451200"}, {id: "2178", areaID: "451301", area: "\u5e02\u8f96\u533a", fatherID: "451300"}, {
        id: "2179",
        areaID: "451302",
        area: "\u5174\u5bbe\u533a",
        fatherID: "451300"
    }, {id: "2180", areaID: "451321", area: "\u5ffb\u57ce\u53bf", fatherID: "451300"}, {id: "2181", areaID: "451322", area: "\u8c61\u5dde\u53bf", fatherID: "451300"}, {id: "2182", areaID: "451323", area: "\u6b66\u5ba3\u53bf", fatherID: "451300"}, {id: "2183", areaID: "451324", area: "\u91d1\u79c0\u7476\u65cf\u81ea\u6cbb\u53bf", fatherID: "451300"}, {id: "2184", areaID: "451381", area: "\u5408\u5c71\u5e02", fatherID: "451300"}, {id: "2185", areaID: "451401", area: "\u5e02\u8f96\u533a", fatherID: "451400"}, {id: "2186", areaID: "451402", area: "\u6c5f\u6d32\u533a", fatherID: "451400"}, {id: "2187", areaID: "451421", area: "\u6276\u7ee5\u53bf", fatherID: "451400"}, {id: "2188", areaID: "451422", area: "\u5b81\u660e\u53bf", fatherID: "451400"}, {
        id: "2189",
        areaID: "451423",
        area: "\u9f99\u5dde\u53bf",
        fatherID: "451400"
    }, {id: "2190", areaID: "451424", area: "\u5927\u65b0\u53bf", fatherID: "451400"}, {id: "2191", areaID: "451425", area: "\u5929\u7b49\u53bf", fatherID: "451400"}, {id: "2192", areaID: "451481", area: "\u51ed\u7965\u5e02", fatherID: "451400"}, {id: "2193", areaID: "460101", area: "\u5e02\u8f96\u533a", fatherID: "460100"}, {id: "2194", areaID: "460105", area: "\u79c0\u82f1\u533a", fatherID: "460100"}, {id: "2195", areaID: "460106", area: "\u9f99\u534e\u533a", fatherID: "460100"}, {id: "2196", areaID: "460107", area: "\u743c\u5c71\u533a", fatherID: "460100"}, {id: "2197", areaID: "460108", area: "\u7f8e\u5170\u533a", fatherID: "460100"}, {id: "2198", areaID: "460201", area: "\u5e02\u8f96\u533a", fatherID: "460200"}, {
        id: "2199",
        areaID: "469001",
        area: "\u4e94\u6307\u5c71\u5e02",
        fatherID: "469000"
    }, {id: "2200", areaID: "469002", area: "\u743c\u6d77\u5e02", fatherID: "469000"}, {id: "2201", areaID: "469003", area: "\u510b\u5dde\u5e02", fatherID: "469000"}, {id: "2202", areaID: "469005", area: "\u6587\u660c\u5e02", fatherID: "469000"}, {id: "2203", areaID: "469006", area: "\u4e07\u5b81\u5e02", fatherID: "469000"}, {id: "2204", areaID: "469007", area: "\u4e1c\u65b9\u5e02", fatherID: "469000"}, {id: "2205", areaID: "469025", area: "\u5b9a\u5b89\u53bf", fatherID: "469000"}, {id: "2206", areaID: "469026", area: "\u5c6f\u660c\u53bf", fatherID: "469000"}, {id: "2207", areaID: "469027", area: "\u6f84\u8fc8\u53bf", fatherID: "469000"}, {id: "2208", areaID: "469028", area: "\u4e34\u9ad8\u53bf", fatherID: "469000"}, {
        id: "2209",
        areaID: "469030",
        area: "\u767d\u6c99\u9ece\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "469000"
    }, {id: "2210", areaID: "469031", area: "\u660c\u6c5f\u9ece\u65cf\u81ea\u6cbb\u53bf", fatherID: "469000"}, {id: "2211", areaID: "469033", area: "\u4e50\u4e1c\u9ece\u65cf\u81ea\u6cbb\u53bf", fatherID: "469000"}, {id: "2212", areaID: "469034", area: "\u9675\u6c34\u9ece\u65cf\u81ea\u6cbb\u53bf", fatherID: "469000"}, {id: "2213", areaID: "469035", area: "\u4fdd\u4ead\u9ece\u65cf\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "469000"}, {id: "2214", areaID: "469036", area: "\u743c\u4e2d\u9ece\u65cf\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "469000"}, {id: "2215", areaID: "469037", area: "\u897f\u6c99\u7fa4\u5c9b", fatherID: "469000"}, {id: "2216", areaID: "469038", area: "\u5357\u6c99\u7fa4\u5c9b", fatherID: "469000"}, {
        id: "2217",
        areaID: "469039",
        area: "\u4e2d\u6c99\u7fa4\u5c9b\u7684\u5c9b\u7901\u53ca\u5176\u6d77\u57df",
        fatherID: "469000"
    }, {id: "2218", areaID: "500101", area: "\u4e07\u5dde\u533a", fatherID: "500100"}, {id: "2219", areaID: "500102", area: "\u6daa\u9675\u533a", fatherID: "500100"}, {id: "2220", areaID: "500103", area: "\u6e1d\u4e2d\u533a", fatherID: "500100"}, {id: "2221", areaID: "500104", area: "\u5927\u6e21\u53e3\u533a", fatherID: "500100"}, {id: "2222", areaID: "500105", area: "\u6c5f\u5317\u533a", fatherID: "500100"}, {id: "2223", areaID: "500106", area: "\u6c99\u576a\u575d\u533a", fatherID: "500100"}, {id: "2224", areaID: "500107", area: "\u4e5d\u9f99\u5761\u533a", fatherID: "500100"}, {id: "2225", areaID: "500108", area: "\u5357\u5cb8\u533a", fatherID: "500100"}, {id: "2226", areaID: "500109", area: "\u5317\u789a\u533a", fatherID: "500100"}, {
        id: "2227",
        areaID: "500110",
        area: "\u4e07\u76db\u533a",
        fatherID: "500100"
    }, {id: "2228", areaID: "500111", area: "\u53cc\u6865\u533a", fatherID: "500100"}, {id: "2229", areaID: "500112", area: "\u6e1d\u5317\u533a", fatherID: "500100"}, {id: "2230", areaID: "500113", area: "\u5df4\u5357\u533a", fatherID: "500100"}, {id: "2231", areaID: "500114", area: "\u9ed4\u6c5f\u533a", fatherID: "500100"}, {id: "2232", areaID: "500115", area: "\u957f\u5bff\u533a", fatherID: "500100"}, {id: "2233", areaID: "500222", area: "\u7da6\u6c5f\u53bf", fatherID: "500200"}, {id: "2234", areaID: "500223", area: "\u6f7c\u5357\u53bf", fatherID: "500200"}, {id: "2235", areaID: "500224", area: "\u94dc\u6881\u53bf", fatherID: "500200"}, {id: "2236", areaID: "500225", area: "\u5927\u8db3\u53bf", fatherID: "500200"}, {
        id: "2237",
        areaID: "500226",
        area: "\u8363\u660c\u53bf",
        fatherID: "500200"
    }, {id: "2238", areaID: "500227", area: "\u74a7\u5c71\u53bf", fatherID: "500200"}, {id: "2239", areaID: "500228", area: "\u6881\u5e73\u53bf", fatherID: "500200"}, {id: "2240", areaID: "500229", area: "\u57ce\u53e3\u53bf", fatherID: "500200"}, {id: "2241", areaID: "500230", area: "\u4e30\u90fd\u53bf", fatherID: "500200"}, {id: "2242", areaID: "500231", area: "\u57ab\u6c5f\u53bf", fatherID: "500200"}, {id: "2243", areaID: "500232", area: "\u6b66\u9686\u53bf", fatherID: "500200"}, {id: "2244", areaID: "500233", area: "\u5fe0\u3000\u53bf", fatherID: "500200"}, {id: "2245", areaID: "500234", area: "\u5f00\u3000\u53bf", fatherID: "500200"}, {id: "2246", areaID: "500235", area: "\u4e91\u9633\u53bf", fatherID: "500200"}, {
        id: "2247",
        areaID: "500236",
        area: "\u5949\u8282\u53bf",
        fatherID: "500200"
    }, {id: "2248", areaID: "500237", area: "\u5deb\u5c71\u53bf", fatherID: "500200"}, {id: "2249", areaID: "500238", area: "\u5deb\u6eaa\u53bf", fatherID: "500200"}, {id: "2250", areaID: "500240", area: "\u77f3\u67f1\u571f\u5bb6\u65cf\u81ea\u6cbb\u53bf", fatherID: "500200"}, {id: "2251", areaID: "500241", area: "\u79c0\u5c71\u571f\u5bb6\u65cf\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "500200"}, {id: "2252", areaID: "500242", area: "\u9149\u9633\u571f\u5bb6\u65cf\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "500200"}, {id: "2253", areaID: "500243", area: "\u5f6d\u6c34\u82d7\u65cf\u571f\u5bb6\u65cf\u81ea\u6cbb\u53bf", fatherID: "500200"}, {id: "2254", areaID: "500381", area: "\u6c5f\u6d25\u5e02", fatherID: "500300"}, {
        id: "2255",
        areaID: "500382",
        area: "\u5408\u5ddd\u5e02",
        fatherID: "500300"
    }, {id: "2256", areaID: "500383", area: "\u6c38\u5ddd\u5e02", fatherID: "500300"}, {id: "2257", areaID: "500384", area: "\u5357\u5ddd\u5e02", fatherID: "500300"}, {id: "2258", areaID: "510101", area: "\u5e02\u8f96\u533a", fatherID: "510100"}, {id: "2259", areaID: "510104", area: "\u9526\u6c5f\u533a", fatherID: "510100"}, {id: "2260", areaID: "510105", area: "\u9752\u7f8a\u533a", fatherID: "510100"}, {id: "2261", areaID: "510106", area: "\u91d1\u725b\u533a", fatherID: "510100"}, {id: "2262", areaID: "510107", area: "\u6b66\u4faf\u533a", fatherID: "510100"}, {id: "2263", areaID: "510108", area: "\u6210\u534e\u533a", fatherID: "510100"}, {id: "2264", areaID: "510112", area: "\u9f99\u6cc9\u9a7f\u533a", fatherID: "510100"}, {
        id: "2265",
        areaID: "510113",
        area: "\u9752\u767d\u6c5f\u533a",
        fatherID: "510100"
    }, {id: "2266", areaID: "510114", area: "\u65b0\u90fd\u533a", fatherID: "510100"}, {id: "2267", areaID: "510115", area: "\u6e29\u6c5f\u533a", fatherID: "510100"}, {id: "2268", areaID: "510121", area: "\u91d1\u5802\u53bf", fatherID: "510100"}, {id: "2269", areaID: "510122", area: "\u53cc\u6d41\u53bf", fatherID: "510100"}, {id: "2270", areaID: "510124", area: "\u90eb\u3000\u53bf", fatherID: "510100"}, {id: "2271", areaID: "510129", area: "\u5927\u9091\u53bf", fatherID: "510100"}, {id: "2272", areaID: "510131", area: "\u84b2\u6c5f\u53bf", fatherID: "510100"}, {id: "2273", areaID: "510132", area: "\u65b0\u6d25\u53bf", fatherID: "510100"}, {id: "2274", areaID: "510181", area: "\u90fd\u6c5f\u5830\u5e02", fatherID: "510100"}, {
        id: "2275",
        areaID: "510182",
        area: "\u5f6d\u5dde\u5e02",
        fatherID: "510100"
    }, {id: "2276", areaID: "510183", area: "\u909b\u5d03\u5e02", fatherID: "510100"}, {id: "2277", areaID: "510184", area: "\u5d07\u5dde\u5e02", fatherID: "510100"}, {id: "2278", areaID: "510301", area: "\u5e02\u8f96\u533a", fatherID: "510300"}, {id: "2279", areaID: "510302", area: "\u81ea\u6d41\u4e95\u533a", fatherID: "510300"}, {id: "2280", areaID: "510303", area: "\u8d21\u4e95\u533a", fatherID: "510300"}, {id: "2281", areaID: "510304", area: "\u5927\u5b89\u533a", fatherID: "510300"}, {id: "2282", areaID: "510311", area: "\u6cbf\u6ee9\u533a", fatherID: "510300"}, {id: "2283", areaID: "510321", area: "\u8363\u3000\u53bf", fatherID: "510300"}, {id: "2284", areaID: "510322", area: "\u5bcc\u987a\u53bf", fatherID: "510300"}, {
        id: "2285",
        areaID: "510401",
        area: "\u5e02\u8f96\u533a",
        fatherID: "510400"
    }, {id: "2286", areaID: "510402", area: "\u4e1c\u3000\u533a", fatherID: "510400"}, {id: "2287", areaID: "510403", area: "\u897f\u3000\u533a", fatherID: "510400"}, {id: "2288", areaID: "510411", area: "\u4ec1\u548c\u533a", fatherID: "510400"}, {id: "2289", areaID: "510421", area: "\u7c73\u6613\u53bf", fatherID: "510400"}, {id: "2290", areaID: "510422", area: "\u76d0\u8fb9\u53bf", fatherID: "510400"}, {id: "2291", areaID: "510501", area: "\u5e02\u8f96\u533a", fatherID: "510500"}, {id: "2292", areaID: "510502", area: "\u6c5f\u9633\u533a", fatherID: "510500"}, {id: "2293", areaID: "510503", area: "\u7eb3\u6eaa\u533a", fatherID: "510500"}, {id: "2294", areaID: "510504", area: "\u9f99\u9a6c\u6f6d\u533a", fatherID: "510500"}, {
        id: "2295",
        areaID: "510521",
        area: "\u6cf8\u3000\u53bf",
        fatherID: "510500"
    }, {id: "2296", areaID: "510522", area: "\u5408\u6c5f\u53bf", fatherID: "510500"}, {id: "2297", areaID: "510524", area: "\u53d9\u6c38\u53bf", fatherID: "510500"}, {id: "2298", areaID: "510525", area: "\u53e4\u853a\u53bf", fatherID: "510500"}, {id: "2299", areaID: "510601", area: "\u5e02\u8f96\u533a", fatherID: "510600"}, {id: "2300", areaID: "510603", area: "\u65cc\u9633\u533a", fatherID: "510600"}, {id: "2301", areaID: "510623", area: "\u4e2d\u6c5f\u53bf", fatherID: "510600"}, {id: "2302", areaID: "510626", area: "\u7f57\u6c5f\u53bf", fatherID: "510600"}, {id: "2303", areaID: "510681", area: "\u5e7f\u6c49\u5e02", fatherID: "510600"}, {id: "2304", areaID: "510682", area: "\u4ec0\u90a1\u5e02", fatherID: "510600"}, {
        id: "2305",
        areaID: "510683",
        area: "\u7ef5\u7af9\u5e02",
        fatherID: "510600"
    }, {id: "2306", areaID: "510701", area: "\u5e02\u8f96\u533a", fatherID: "510700"}, {id: "2307", areaID: "510703", area: "\u6daa\u57ce\u533a", fatherID: "510700"}, {id: "2308", areaID: "510704", area: "\u6e38\u4ed9\u533a", fatherID: "510700"}, {id: "2309", areaID: "510722", area: "\u4e09\u53f0\u53bf", fatherID: "510700"}, {id: "2310", areaID: "510723", area: "\u76d0\u4ead\u53bf", fatherID: "510700"}, {id: "2311", areaID: "510724", area: "\u5b89\u3000\u53bf", fatherID: "510700"}, {id: "2312", areaID: "510725", area: "\u6893\u6f7c\u53bf", fatherID: "510700"}, {id: "2313", areaID: "510726", area: "\u5317\u5ddd\u7f8c\u65cf\u81ea\u6cbb\u53bf", fatherID: "510700"}, {id: "2314", areaID: "510727", area: "\u5e73\u6b66\u53bf", fatherID: "510700"}, {
        id: "2315",
        areaID: "510781",
        area: "\u6c5f\u6cb9\u5e02",
        fatherID: "510700"
    }, {id: "2316", areaID: "510801", area: "\u5e02\u8f96\u533a", fatherID: "510800"}, {id: "2317", areaID: "510802", area: "\u5e02\u4e2d\u533a", fatherID: "510800"}, {id: "2318", areaID: "510811", area: "\u5143\u575d\u533a", fatherID: "510800"}, {id: "2319", areaID: "510812", area: "\u671d\u5929\u533a", fatherID: "510800"}, {id: "2320", areaID: "510821", area: "\u65fa\u82cd\u53bf", fatherID: "510800"}, {id: "2321", areaID: "510822", area: "\u9752\u5ddd\u53bf", fatherID: "510800"}, {id: "2322", areaID: "510823", area: "\u5251\u9601\u53bf", fatherID: "510800"}, {id: "2323", areaID: "510824", area: "\u82cd\u6eaa\u53bf", fatherID: "510800"}, {id: "2324", areaID: "510901", area: "\u5e02\u8f96\u533a", fatherID: "510900"}, {
        id: "2325",
        areaID: "510903",
        area: "\u8239\u5c71\u533a",
        fatherID: "510900"
    }, {id: "2326", areaID: "510904", area: "\u5b89\u5c45\u533a", fatherID: "510900"}, {id: "2327", areaID: "510921", area: "\u84ec\u6eaa\u53bf", fatherID: "510900"}, {id: "2328", areaID: "510922", area: "\u5c04\u6d2a\u53bf", fatherID: "510900"}, {id: "2329", areaID: "510923", area: "\u5927\u82f1\u53bf", fatherID: "510900"}, {id: "2330", areaID: "511001", area: "\u5e02\u8f96\u533a", fatherID: "511000"}, {id: "2331", areaID: "511002", area: "\u5e02\u4e2d\u533a", fatherID: "511000"}, {id: "2332", areaID: "511011", area: "\u4e1c\u5174\u533a", fatherID: "511000"}, {id: "2333", areaID: "511024", area: "\u5a01\u8fdc\u53bf", fatherID: "511000"}, {id: "2334", areaID: "511025", area: "\u8d44\u4e2d\u53bf", fatherID: "511000"}, {
        id: "2335",
        areaID: "511028",
        area: "\u9686\u660c\u53bf",
        fatherID: "511000"
    }, {id: "2336", areaID: "511101", area: "\u5e02\u8f96\u533a", fatherID: "511100"}, {id: "2337", areaID: "511102", area: "\u5e02\u4e2d\u533a", fatherID: "511100"}, {id: "2338", areaID: "511111", area: "\u6c99\u6e7e\u533a", fatherID: "511100"}, {id: "2339", areaID: "511112", area: "\u4e94\u901a\u6865\u533a", fatherID: "511100"}, {id: "2340", areaID: "511113", area: "\u91d1\u53e3\u6cb3\u533a", fatherID: "511100"}, {id: "2341", areaID: "511123", area: "\u728d\u4e3a\u53bf", fatherID: "511100"}, {id: "2342", areaID: "511124", area: "\u4e95\u7814\u53bf", fatherID: "511100"}, {id: "2343", areaID: "511126", area: "\u5939\u6c5f\u53bf", fatherID: "511100"}, {id: "2344", areaID: "511129", area: "\u6c90\u5ddd\u53bf", fatherID: "511100"}, {
        id: "2345",
        areaID: "511132",
        area: "\u5ce8\u8fb9\u5f5d\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "511100"
    }, {id: "2346", areaID: "511133", area: "\u9a6c\u8fb9\u5f5d\u65cf\u81ea\u6cbb\u53bf", fatherID: "511100"}, {id: "2347", areaID: "511181", area: "\u5ce8\u7709\u5c71\u5e02", fatherID: "511100"}, {id: "2348", areaID: "511301", area: "\u5e02\u8f96\u533a", fatherID: "511300"}, {id: "2349", areaID: "511302", area: "\u987a\u5e86\u533a", fatherID: "511300"}, {id: "2350", areaID: "511303", area: "\u9ad8\u576a\u533a", fatherID: "511300"}, {id: "2351", areaID: "511304", area: "\u5609\u9675\u533a", fatherID: "511300"}, {id: "2352", areaID: "511321", area: "\u5357\u90e8\u53bf", fatherID: "511300"}, {id: "2353", areaID: "511322", area: "\u8425\u5c71\u53bf", fatherID: "511300"}, {id: "2354", areaID: "511323", area: "\u84ec\u5b89\u53bf", fatherID: "511300"}, {
        id: "2355",
        areaID: "511324",
        area: "\u4eea\u9647\u53bf",
        fatherID: "511300"
    }, {id: "2356", areaID: "511325", area: "\u897f\u5145\u53bf", fatherID: "511300"}, {id: "2357", areaID: "511381", area: "\u9606\u4e2d\u5e02", fatherID: "511300"}, {id: "2358", areaID: "511401", area: "\u5e02\u8f96\u533a", fatherID: "511400"}, {id: "2359", areaID: "511402", area: "\u4e1c\u5761\u533a", fatherID: "511400"}, {id: "2360", areaID: "511421", area: "\u4ec1\u5bff\u53bf", fatherID: "511400"}, {id: "2361", areaID: "511422", area: "\u5f6d\u5c71\u53bf", fatherID: "511400"}, {id: "2362", areaID: "511423", area: "\u6d2a\u96c5\u53bf", fatherID: "511400"}, {id: "2363", areaID: "511424", area: "\u4e39\u68f1\u53bf", fatherID: "511400"}, {id: "2364", areaID: "511425", area: "\u9752\u795e\u53bf", fatherID: "511400"}, {
        id: "2365",
        areaID: "511501",
        area: "\u5e02\u8f96\u533a",
        fatherID: "511500"
    }, {id: "2366", areaID: "511502", area: "\u7fe0\u5c4f\u533a", fatherID: "511500"}, {id: "2367", areaID: "511521", area: "\u5b9c\u5bbe\u53bf", fatherID: "511500"}, {id: "2368", areaID: "511522", area: "\u5357\u6eaa\u53bf", fatherID: "511500"}, {id: "2369", areaID: "511523", area: "\u6c5f\u5b89\u53bf", fatherID: "511500"}, {id: "2370", areaID: "511524", area: "\u957f\u5b81\u53bf", fatherID: "511500"}, {id: "2371", areaID: "511525", area: "\u9ad8\u3000\u53bf", fatherID: "511500"}, {id: "2372", areaID: "511526", area: "\u73d9\u3000\u53bf", fatherID: "511500"}, {id: "2373", areaID: "511527", area: "\u7b60\u8fde\u53bf", fatherID: "511500"}, {id: "2374", areaID: "511528", area: "\u5174\u6587\u53bf", fatherID: "511500"}, {
        id: "2375",
        areaID: "511529",
        area: "\u5c4f\u5c71\u53bf",
        fatherID: "511500"
    }, {id: "2376", areaID: "511601", area: "\u5e02\u8f96\u533a", fatherID: "511600"}, {id: "2377", areaID: "511602", area: "\u5e7f\u5b89\u533a", fatherID: "511600"}, {id: "2378", areaID: "511621", area: "\u5cb3\u6c60\u53bf", fatherID: "511600"}, {id: "2379", areaID: "511622", area: "\u6b66\u80dc\u53bf", fatherID: "511600"}, {id: "2380", areaID: "511623", area: "\u90bb\u6c34\u53bf", fatherID: "511600"}, {id: "2381", areaID: "511681", area: "\u534e\u83b9\u5e02", fatherID: "511600"}, {id: "2382", areaID: "511701", area: "\u5e02\u8f96\u533a", fatherID: "511700"}, {id: "2383", areaID: "511702", area: "\u901a\u5ddd\u533a", fatherID: "511700"}, {id: "2384", areaID: "511721", area: "\u8fbe\u3000\u53bf", fatherID: "511700"}, {
        id: "2385",
        areaID: "511722",
        area: "\u5ba3\u6c49\u53bf",
        fatherID: "511700"
    }, {id: "2386", areaID: "511723", area: "\u5f00\u6c5f\u53bf", fatherID: "511700"}, {id: "2387", areaID: "511724", area: "\u5927\u7af9\u53bf", fatherID: "511700"}, {id: "2388", areaID: "511725", area: "\u6e20\u3000\u53bf", fatherID: "511700"}, {id: "2389", areaID: "511781", area: "\u4e07\u6e90\u5e02", fatherID: "511700"}, {id: "2390", areaID: "511801", area: "\u5e02\u8f96\u533a", fatherID: "511800"}, {id: "2391", areaID: "511802", area: "\u96e8\u57ce\u533a", fatherID: "511800"}, {id: "2392", areaID: "511821", area: "\u540d\u5c71\u53bf", fatherID: "511800"}, {id: "2393", areaID: "511822", area: "\u8365\u7ecf\u53bf", fatherID: "511800"}, {id: "2394", areaID: "511823", area: "\u6c49\u6e90\u53bf", fatherID: "511800"}, {
        id: "2395",
        areaID: "511824",
        area: "\u77f3\u68c9\u53bf",
        fatherID: "511800"
    }, {id: "2396", areaID: "511825", area: "\u5929\u5168\u53bf", fatherID: "511800"}, {id: "2397", areaID: "511826", area: "\u82a6\u5c71\u53bf", fatherID: "511800"}, {id: "2398", areaID: "511827", area: "\u5b9d\u5174\u53bf", fatherID: "511800"}, {id: "2399", areaID: "511901", area: "\u5e02\u8f96\u533a", fatherID: "511900"}, {id: "2400", areaID: "511902", area: "\u5df4\u5dde\u533a", fatherID: "511900"}, {id: "2401", areaID: "511921", area: "\u901a\u6c5f\u53bf", fatherID: "511900"}, {id: "2402", areaID: "511922", area: "\u5357\u6c5f\u53bf", fatherID: "511900"}, {id: "2403", areaID: "511923", area: "\u5e73\u660c\u53bf", fatherID: "511900"}, {id: "2404", areaID: "512001", area: "\u5e02\u8f96\u533a", fatherID: "512000"}, {
        id: "2405",
        areaID: "512002",
        area: "\u96c1\u6c5f\u533a",
        fatherID: "512000"
    }, {id: "2406", areaID: "512021", area: "\u5b89\u5cb3\u53bf", fatherID: "512000"}, {id: "2407", areaID: "512022", area: "\u4e50\u81f3\u53bf", fatherID: "512000"}, {id: "2408", areaID: "512081", area: "\u7b80\u9633\u5e02", fatherID: "512000"}, {id: "2409", areaID: "513221", area: "\u6c76\u5ddd\u53bf", fatherID: "513200"}, {id: "2410", areaID: "513222", area: "\u7406\u3000\u53bf", fatherID: "513200"}, {id: "2411", areaID: "513223", area: "\u8302\u3000\u53bf", fatherID: "513200"}, {id: "2412", areaID: "513224", area: "\u677e\u6f58\u53bf", fatherID: "513200"}, {id: "2413", areaID: "513225", area: "\u4e5d\u5be8\u6c9f\u53bf", fatherID: "513200"}, {id: "2414", areaID: "513226", area: "\u91d1\u5ddd\u53bf", fatherID: "513200"}, {
        id: "2415",
        areaID: "513227",
        area: "\u5c0f\u91d1\u53bf",
        fatherID: "513200"
    }, {id: "2416", areaID: "513228", area: "\u9ed1\u6c34\u53bf", fatherID: "513200"}, {id: "2417", areaID: "513229", area: "\u9a6c\u5c14\u5eb7\u53bf", fatherID: "513200"}, {id: "2418", areaID: "513230", area: "\u58e4\u5858\u53bf", fatherID: "513200"}, {id: "2419", areaID: "513231", area: "\u963f\u575d\u53bf", fatherID: "513200"}, {id: "2420", areaID: "513232", area: "\u82e5\u5c14\u76d6\u53bf", fatherID: "513200"}, {id: "2421", areaID: "513233", area: "\u7ea2\u539f\u53bf", fatherID: "513200"}, {id: "2422", areaID: "513321", area: "\u5eb7\u5b9a\u53bf", fatherID: "513300"}, {id: "2423", areaID: "513322", area: "\u6cf8\u5b9a\u53bf", fatherID: "513300"}, {id: "2424", areaID: "513323", area: "\u4e39\u5df4\u53bf", fatherID: "513300"}, {
        id: "2425",
        areaID: "513324",
        area: "\u4e5d\u9f99\u53bf",
        fatherID: "513300"
    }, {id: "2426", areaID: "513325", area: "\u96c5\u6c5f\u53bf", fatherID: "513300"}, {id: "2427", areaID: "513326", area: "\u9053\u5b5a\u53bf", fatherID: "513300"}, {id: "2428", areaID: "513327", area: "\u7089\u970d\u53bf", fatherID: "513300"}, {id: "2429", areaID: "513328", area: "\u7518\u5b5c\u53bf", fatherID: "513300"}, {id: "2430", areaID: "513329", area: "\u65b0\u9f99\u53bf", fatherID: "513300"}, {id: "2431", areaID: "513330", area: "\u5fb7\u683c\u53bf", fatherID: "513300"}, {id: "2432", areaID: "513331", area: "\u767d\u7389\u53bf", fatherID: "513300"}, {id: "2433", areaID: "513332", area: "\u77f3\u6e20\u53bf", fatherID: "513300"}, {id: "2434", areaID: "513333", area: "\u8272\u8fbe\u53bf", fatherID: "513300"}, {
        id: "2435",
        areaID: "513334",
        area: "\u7406\u5858\u53bf",
        fatherID: "513300"
    }, {id: "2436", areaID: "513335", area: "\u5df4\u5858\u53bf", fatherID: "513300"}, {id: "2437", areaID: "513336", area: "\u4e61\u57ce\u53bf", fatherID: "513300"}, {id: "2438", areaID: "513337", area: "\u7a3b\u57ce\u53bf", fatherID: "513300"}, {id: "2439", areaID: "513338", area: "\u5f97\u8363\u53bf", fatherID: "513300"}, {id: "2440", areaID: "513401", area: "\u897f\u660c\u5e02", fatherID: "513400"}, {id: "2441", areaID: "513422", area: "\u6728\u91cc\u85cf\u65cf\u81ea\u6cbb\u53bf", fatherID: "513400"}, {id: "2442", areaID: "513423", area: "\u76d0\u6e90\u53bf", fatherID: "513400"}, {id: "2443", areaID: "513424", area: "\u5fb7\u660c\u53bf", fatherID: "513400"}, {id: "2444", areaID: "513425", area: "\u4f1a\u7406\u53bf", fatherID: "513400"}, {
        id: "2445",
        areaID: "513426",
        area: "\u4f1a\u4e1c\u53bf",
        fatherID: "513400"
    }, {id: "2446", areaID: "513427", area: "\u5b81\u5357\u53bf", fatherID: "513400"}, {id: "2447", areaID: "513428", area: "\u666e\u683c\u53bf", fatherID: "513400"}, {id: "2448", areaID: "513429", area: "\u5e03\u62d6\u53bf", fatherID: "513400"}, {id: "2449", areaID: "513430", area: "\u91d1\u9633\u53bf", fatherID: "513400"}, {id: "2450", areaID: "513431", area: "\u662d\u89c9\u53bf", fatherID: "513400"}, {id: "2451", areaID: "513432", area: "\u559c\u5fb7\u53bf", fatherID: "513400"}, {id: "2452", areaID: "513433", area: "\u5195\u5b81\u53bf", fatherID: "513400"}, {id: "2453", areaID: "513434", area: "\u8d8a\u897f\u53bf", fatherID: "513400"}, {id: "2454", areaID: "513435", area: "\u7518\u6d1b\u53bf", fatherID: "513400"}, {
        id: "2455",
        areaID: "513436",
        area: "\u7f8e\u59d1\u53bf",
        fatherID: "513400"
    }, {id: "2456", areaID: "513437", area: "\u96f7\u6ce2\u53bf", fatherID: "513400"}, {id: "2457", areaID: "520101", area: "\u5e02\u8f96\u533a", fatherID: "520100"}, {id: "2458", areaID: "520102", area: "\u5357\u660e\u533a", fatherID: "520100"}, {id: "2459", areaID: "520103", area: "\u4e91\u5ca9\u533a", fatherID: "520100"}, {id: "2460", areaID: "520111", area: "\u82b1\u6eaa\u533a", fatherID: "520100"}, {id: "2461", areaID: "520112", area: "\u4e4c\u5f53\u533a", fatherID: "520100"}, {id: "2462", areaID: "520113", area: "\u767d\u4e91\u533a", fatherID: "520100"}, {id: "2463", areaID: "520114", area: "\u5c0f\u6cb3\u533a", fatherID: "520100"}, {id: "2464", areaID: "520121", area: "\u5f00\u9633\u53bf", fatherID: "520100"}, {
        id: "2465",
        areaID: "520122",
        area: "\u606f\u70fd\u53bf",
        fatherID: "520100"
    }, {id: "2466", areaID: "520123", area: "\u4fee\u6587\u53bf", fatherID: "520100"}, {id: "2467", areaID: "520181", area: "\u6e05\u9547\u5e02", fatherID: "520100"}, {id: "2468", areaID: "520201", area: "\u949f\u5c71\u533a", fatherID: "520200"}, {id: "2469", areaID: "520203", area: "\u516d\u679d\u7279\u533a", fatherID: "520200"}, {id: "2470", areaID: "520221", area: "\u6c34\u57ce\u53bf", fatherID: "520200"}, {id: "2471", areaID: "520222", area: "\u76d8\u3000\u53bf", fatherID: "520200"}, {id: "2472", areaID: "520301", area: "\u5e02\u8f96\u533a", fatherID: "520300"}, {id: "2473", areaID: "520302", area: "\u7ea2\u82b1\u5c97\u533a", fatherID: "520300"}, {id: "2474", areaID: "520303", area: "\u6c47\u5ddd\u533a", fatherID: "520300"}, {
        id: "2475",
        areaID: "520321",
        area: "\u9075\u4e49\u53bf",
        fatherID: "520300"
    }, {id: "2476", areaID: "520322", area: "\u6850\u6893\u53bf", fatherID: "520300"}, {id: "2477", areaID: "520323", area: "\u7ee5\u9633\u53bf", fatherID: "520300"}, {id: "2478", areaID: "520324", area: "\u6b63\u5b89\u53bf", fatherID: "520300"}, {id: "2479", areaID: "520325", area: "\u9053\u771f\u4ee1\u4f6c\u65cf\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "520300"}, {id: "2480", areaID: "520326", area: "\u52a1\u5ddd\u4ee1\u4f6c\u65cf\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "520300"}, {id: "2481", areaID: "520327", area: "\u51e4\u5188\u53bf", fatherID: "520300"}, {id: "2482", areaID: "520328", area: "\u6e44\u6f6d\u53bf", fatherID: "520300"}, {id: "2483", areaID: "520329", area: "\u4f59\u5e86\u53bf", fatherID: "520300"}, {
        id: "2484",
        areaID: "520330",
        area: "\u4e60\u6c34\u53bf",
        fatherID: "520300"
    }, {id: "2485", areaID: "520381", area: "\u8d64\u6c34\u5e02", fatherID: "520300"}, {id: "2486", areaID: "520382", area: "\u4ec1\u6000\u5e02", fatherID: "520300"}, {id: "2487", areaID: "520401", area: "\u5e02\u8f96\u533a", fatherID: "520400"}, {id: "2488", areaID: "520402", area: "\u897f\u79c0\u533a", fatherID: "520400"}, {id: "2489", areaID: "520421", area: "\u5e73\u575d\u53bf", fatherID: "520400"}, {id: "2490", areaID: "520422", area: "\u666e\u5b9a\u53bf", fatherID: "520400"}, {id: "2491", areaID: "520423", area: "\u9547\u5b81\u5e03\u4f9d\u65cf\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "520400"}, {id: "2492", areaID: "520424", area: "\u5173\u5cad\u5e03\u4f9d\u65cf\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "520400"}, {
        id: "2493",
        areaID: "520425",
        area: "\u7d2b\u4e91\u82d7\u65cf\u5e03\u4f9d\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "520400"
    }, {id: "2494", areaID: "522201", area: "\u94dc\u4ec1\u5e02", fatherID: "522200"}, {id: "2495", areaID: "522222", area: "\u6c5f\u53e3\u53bf", fatherID: "522200"}, {id: "2496", areaID: "522223", area: "\u7389\u5c4f\u4f97\u65cf\u81ea\u6cbb\u53bf", fatherID: "522200"}, {id: "2497", areaID: "522224", area: "\u77f3\u9621\u53bf", fatherID: "522200"}, {id: "2498", areaID: "522225", area: "\u601d\u5357\u53bf", fatherID: "522200"}, {id: "2499", areaID: "522226", area: "\u5370\u6c5f\u571f\u5bb6\u65cf\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "522200"}, {id: "2500", areaID: "522227", area: "\u5fb7\u6c5f\u53bf", fatherID: "522200"}, {id: "2501", areaID: "522228", area: "\u6cbf\u6cb3\u571f\u5bb6\u65cf\u81ea\u6cbb\u53bf", fatherID: "522200"}, {
        id: "2502",
        areaID: "522229",
        area: "\u677e\u6843\u82d7\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "522200"
    }, {id: "2503", areaID: "522230", area: "\u4e07\u5c71\u7279\u533a", fatherID: "522200"}, {id: "2504", areaID: "522301", area: "\u5174\u4e49\u5e02", fatherID: "522300"}, {id: "2505", areaID: "522322", area: "\u5174\u4ec1\u53bf", fatherID: "522300"}, {id: "2506", areaID: "522323", area: "\u666e\u5b89\u53bf", fatherID: "522300"}, {id: "2507", areaID: "522324", area: "\u6674\u9686\u53bf", fatherID: "522300"}, {id: "2508", areaID: "522325", area: "\u8d1e\u4e30\u53bf", fatherID: "522300"}, {id: "2509", areaID: "522326", area: "\u671b\u8c1f\u53bf", fatherID: "522300"}, {id: "2510", areaID: "522327", area: "\u518c\u4ea8\u53bf", fatherID: "522300"}, {id: "2511", areaID: "522328", area: "\u5b89\u9f99\u53bf", fatherID: "522300"}, {
        id: "2512",
        areaID: "522401",
        area: "\u6bd5\u8282\u5e02",
        fatherID: "522400"
    }, {id: "2513", areaID: "522422", area: "\u5927\u65b9\u53bf", fatherID: "522400"}, {id: "2514", areaID: "522423", area: "\u9ed4\u897f\u53bf", fatherID: "522400"}, {id: "2515", areaID: "522424", area: "\u91d1\u6c99\u53bf", fatherID: "522400"}, {id: "2516", areaID: "522425", area: "\u7ec7\u91d1\u53bf", fatherID: "522400"}, {id: "2517", areaID: "522426", area: "\u7eb3\u96cd\u53bf", fatherID: "522400"}, {id: "2518", areaID: "522427", area: "\u5a01\u5b81\u5f5d\u65cf\u56de\u65cf\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "522400"}, {id: "2519", areaID: "522428", area: "\u8d6b\u7ae0\u53bf", fatherID: "522400"}, {id: "2520", areaID: "522601", area: "\u51ef\u91cc\u5e02", fatherID: "522600"}, {id: "2521", areaID: "522622", area: "\u9ec4\u5e73\u53bf", fatherID: "522600"}, {
        id: "2522",
        areaID: "522623",
        area: "\u65bd\u79c9\u53bf",
        fatherID: "522600"
    }, {id: "2523", areaID: "522624", area: "\u4e09\u7a57\u53bf", fatherID: "522600"}, {id: "2524", areaID: "522625", area: "\u9547\u8fdc\u53bf", fatherID: "522600"}, {id: "2525", areaID: "522626", area: "\u5c91\u5de9\u53bf", fatherID: "522600"}, {id: "2526", areaID: "522627", area: "\u5929\u67f1\u53bf", fatherID: "522600"}, {id: "2527", areaID: "522628", area: "\u9526\u5c4f\u53bf", fatherID: "522600"}, {id: "2528", areaID: "522629", area: "\u5251\u6cb3\u53bf", fatherID: "522600"}, {id: "2529", areaID: "522630", area: "\u53f0\u6c5f\u53bf", fatherID: "522600"}, {id: "2530", areaID: "522631", area: "\u9ece\u5e73\u53bf", fatherID: "522600"}, {id: "2531", areaID: "522632", area: "\u6995\u6c5f\u53bf", fatherID: "522600"}, {
        id: "2532",
        areaID: "522633",
        area: "\u4ece\u6c5f\u53bf",
        fatherID: "522600"
    }, {id: "2533", areaID: "522634", area: "\u96f7\u5c71\u53bf", fatherID: "522600"}, {id: "2534", areaID: "522635", area: "\u9ebb\u6c5f\u53bf", fatherID: "522600"}, {id: "2535", areaID: "522636", area: "\u4e39\u5be8\u53bf", fatherID: "522600"}, {id: "2536", areaID: "522701", area: "\u90fd\u5300\u5e02", fatherID: "522700"}, {id: "2537", areaID: "522702", area: "\u798f\u6cc9\u5e02", fatherID: "522700"}, {id: "2538", areaID: "522722", area: "\u8354\u6ce2\u53bf", fatherID: "522700"}, {id: "2539", areaID: "522723", area: "\u8d35\u5b9a\u53bf", fatherID: "522700"}, {id: "2540", areaID: "522725", area: "\u74ee\u5b89\u53bf", fatherID: "522700"}, {id: "2541", areaID: "522726", area: "\u72ec\u5c71\u53bf", fatherID: "522700"}, {
        id: "2542",
        areaID: "522727",
        area: "\u5e73\u5858\u53bf",
        fatherID: "522700"
    }, {id: "2543", areaID: "522728", area: "\u7f57\u7538\u53bf", fatherID: "522700"}, {id: "2544", areaID: "522729", area: "\u957f\u987a\u53bf", fatherID: "522700"}, {id: "2545", areaID: "522730", area: "\u9f99\u91cc\u53bf", fatherID: "522700"}, {id: "2546", areaID: "522731", area: "\u60e0\u6c34\u53bf", fatherID: "522700"}, {id: "2547", areaID: "522732", area: "\u4e09\u90fd\u6c34\u65cf\u81ea\u6cbb\u53bf", fatherID: "522700"}, {id: "2548", areaID: "530101", area: "\u5e02\u8f96\u533a", fatherID: "530100"}, {id: "2549", areaID: "530102", area: "\u4e94\u534e\u533a", fatherID: "530100"}, {id: "2550", areaID: "530103", area: "\u76d8\u9f99\u533a", fatherID: "530100"}, {id: "2551", areaID: "530111", area: "\u5b98\u6e21\u533a", fatherID: "530100"}, {
        id: "2552",
        areaID: "530112",
        area: "\u897f\u5c71\u533a",
        fatherID: "530100"
    }, {id: "2553", areaID: "530113", area: "\u4e1c\u5ddd\u533a", fatherID: "530100"}, {id: "2554", areaID: "530121", area: "\u5448\u8d21\u53bf", fatherID: "530100"}, {id: "2555", areaID: "530122", area: "\u664b\u5b81\u53bf", fatherID: "530100"}, {id: "2556", areaID: "530124", area: "\u5bcc\u6c11\u53bf", fatherID: "530100"}, {id: "2557", areaID: "530125", area: "\u5b9c\u826f\u53bf", fatherID: "530100"}, {id: "2558", areaID: "530126", area: "\u77f3\u6797\u5f5d\u65cf\u81ea\u6cbb\u53bf", fatherID: "530100"}, {id: "2559", areaID: "530127", area: "\u5d69\u660e\u53bf", fatherID: "530100"}, {id: "2560", areaID: "530128", area: "\u7984\u529d\u5f5d\u65cf\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "530100"}, {
        id: "2561",
        areaID: "530129",
        area: "\u5bfb\u7538\u56de\u65cf\u5f5d\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "530100"
    }, {id: "2562", areaID: "530181", area: "\u5b89\u5b81\u5e02", fatherID: "530100"}, {id: "2563", areaID: "530301", area: "\u5e02\u8f96\u533a", fatherID: "530300"}, {id: "2564", areaID: "530302", area: "\u9e92\u9e9f\u533a", fatherID: "530300"}, {id: "2565", areaID: "530321", area: "\u9a6c\u9f99\u53bf", fatherID: "530300"}, {id: "2566", areaID: "530322", area: "\u9646\u826f\u53bf", fatherID: "530300"}, {id: "2567", areaID: "530323", area: "\u5e08\u5b97\u53bf", fatherID: "530300"}, {id: "2568", areaID: "530324", area: "\u7f57\u5e73\u53bf", fatherID: "530300"}, {id: "2569", areaID: "530325", area: "\u5bcc\u6e90\u53bf", fatherID: "530300"}, {id: "2570", areaID: "530326", area: "\u4f1a\u6cfd\u53bf", fatherID: "530300"}, {
        id: "2571",
        areaID: "530328",
        area: "\u6cbe\u76ca\u53bf",
        fatherID: "530300"
    }, {id: "2572", areaID: "530381", area: "\u5ba3\u5a01\u5e02", fatherID: "530300"}, {id: "2573", areaID: "530401", area: "\u5e02\u8f96\u533a", fatherID: "530400"}, {id: "2574", areaID: "530402", area: "\u7ea2\u5854\u533a", fatherID: "530400"}, {id: "2575", areaID: "530421", area: "\u6c5f\u5ddd\u53bf", fatherID: "530400"}, {id: "2576", areaID: "530422", area: "\u6f84\u6c5f\u53bf", fatherID: "530400"}, {id: "2577", areaID: "530423", area: "\u901a\u6d77\u53bf", fatherID: "530400"}, {id: "2578", areaID: "530424", area: "\u534e\u5b81\u53bf", fatherID: "530400"}, {id: "2579", areaID: "530425", area: "\u6613\u95e8\u53bf", fatherID: "530400"}, {id: "2580", areaID: "530426", area: "\u5ce8\u5c71\u5f5d\u65cf\u81ea\u6cbb\u53bf", fatherID: "530400"}, {
        id: "2581",
        areaID: "530427",
        area: "\u65b0\u5e73\u5f5d\u65cf\u50a3\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "530400"
    }, {id: "2582", areaID: "530428", area: "\u5143\u6c5f\u54c8\u5c3c\u65cf\u5f5d\u65cf\u50a3\u65cf\u81ea\u6cbb\u53bf", fatherID: "530400"}, {id: "2583", areaID: "530501", area: "\u5e02\u8f96\u533a", fatherID: "530500"}, {id: "2584", areaID: "530502", area: "\u9686\u9633\u533a", fatherID: "530500"}, {id: "2585", areaID: "530521", area: "\u65bd\u7538\u53bf", fatherID: "530500"}, {id: "2586", areaID: "530522", area: "\u817e\u51b2\u53bf", fatherID: "530500"}, {id: "2587", areaID: "530523", area: "\u9f99\u9675\u53bf", fatherID: "530500"}, {id: "2588", areaID: "530524", area: "\u660c\u5b81\u53bf", fatherID: "530500"}, {id: "2589", areaID: "530601", area: "\u5e02\u8f96\u533a", fatherID: "530600"}, {id: "2590", areaID: "530602", area: "\u662d\u9633\u533a", fatherID: "530600"}, {
        id: "2591",
        areaID: "530621",
        area: "\u9c81\u7538\u53bf",
        fatherID: "530600"
    }, {id: "2592", areaID: "530622", area: "\u5de7\u5bb6\u53bf", fatherID: "530600"}, {id: "2593", areaID: "530623", area: "\u76d0\u6d25\u53bf", fatherID: "530600"}, {id: "2594", areaID: "530624", area: "\u5927\u5173\u53bf", fatherID: "530600"}, {id: "2595", areaID: "530625", area: "\u6c38\u5584\u53bf", fatherID: "530600"}, {id: "2596", areaID: "530626", area: "\u7ee5\u6c5f\u53bf", fatherID: "530600"}, {id: "2597", areaID: "530627", area: "\u9547\u96c4\u53bf", fatherID: "530600"}, {id: "2598", areaID: "530628", area: "\u5f5d\u826f\u53bf", fatherID: "530600"}, {id: "2599", areaID: "530629", area: "\u5a01\u4fe1\u53bf", fatherID: "530600"}, {id: "2600", areaID: "530630", area: "\u6c34\u5bcc\u53bf", fatherID: "530600"}, {
        id: "2601",
        areaID: "530701",
        area: "\u5e02\u8f96\u533a",
        fatherID: "530700"
    }, {id: "2602", areaID: "530702", area: "\u53e4\u57ce\u533a", fatherID: "530700"}, {id: "2603", areaID: "530721", area: "\u7389\u9f99\u7eb3\u897f\u65cf\u81ea\u6cbb\u53bf", fatherID: "530700"}, {id: "2604", areaID: "530722", area: "\u6c38\u80dc\u53bf", fatherID: "530700"}, {id: "2605", areaID: "530723", area: "\u534e\u576a\u53bf", fatherID: "530700"}, {id: "2606", areaID: "530724", area: "\u5b81\u8497\u5f5d\u65cf\u81ea\u6cbb\u53bf", fatherID: "530700"}, {id: "2607", areaID: "530801", area: "\u5e02\u8f96\u533a", fatherID: "530800"}, {id: "2608", areaID: "530802", area: "\u7fe0\u4e91\u533a", fatherID: "530800"}, {id: "2609", areaID: "530821", area: "\u666e\u6d31\u54c8\u5c3c\u65cf\u5f5d\u65cf\u81ea\u6cbb\u53bf", fatherID: "530800"}, {
        id: "2610",
        areaID: "530822",
        area: "\u58a8\u6c5f\u54c8\u5c3c\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "530800"
    }, {id: "2611", areaID: "530823", area: "\u666f\u4e1c\u5f5d\u65cf\u81ea\u6cbb\u53bf", fatherID: "530800"}, {id: "2612", areaID: "530824", area: "\u666f\u8c37\u50a3\u65cf\u5f5d\u65cf\u81ea\u6cbb\u53bf", fatherID: "530800"}, {id: "2613", areaID: "530825", area: "\u9547\u6c85\u5f5d\u65cf\u54c8\u5c3c\u65cf\u62c9\u795c\u65cf\u81ea\u6cbb\u53bf", fatherID: "530800"}, {id: "2614", areaID: "530826", area: "\u6c5f\u57ce\u54c8\u5c3c\u65cf\u5f5d\u65cf\u81ea\u6cbb\u53bf", fatherID: "530800"}, {id: "2615", areaID: "530827", area: "\u5b5f\u8fde\u50a3\u65cf\u62c9\u795c\u65cf\u4f64\u65cf\u81ea\u6cbb\u53bf", fatherID: "530800"}, {id: "2616", areaID: "530828", area: "\u6f9c\u6ca7\u62c9\u795c\u65cf\u81ea\u6cbb\u53bf", fatherID: "530800"}, {
        id: "2617",
        areaID: "530829",
        area: "\u897f\u76df\u4f64\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "530800"
    }, {id: "2618", areaID: "530901", area: "\u5e02\u8f96\u533a", fatherID: "530900"}, {id: "2619", areaID: "530902", area: "\u4e34\u7fd4\u533a", fatherID: "530900"}, {id: "2620", areaID: "530921", area: "\u51e4\u5e86\u53bf", fatherID: "530900"}, {id: "2621", areaID: "530922", area: "\u4e91\u3000\u53bf", fatherID: "530900"}, {id: "2622", areaID: "530923", area: "\u6c38\u5fb7\u53bf", fatherID: "530900"}, {id: "2623", areaID: "530924", area: "\u9547\u5eb7\u53bf", fatherID: "530900"}, {id: "2624", areaID: "530925", area: "\u53cc\u6c5f\u62c9\u795c\u65cf\u4f64\u65cf\u5e03\u6717\u65cf\u50a3\u65cf\u81ea\u6cbb\u53bf", fatherID: "530900"}, {id: "2625", areaID: "530926", area: "\u803f\u9a6c\u50a3\u65cf\u4f64\u65cf\u81ea\u6cbb\u53bf", fatherID: "530900"}, {
        id: "2626",
        areaID: "530927",
        area: "\u6ca7\u6e90\u4f64\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "530900"
    }, {id: "2627", areaID: "532301", area: "\u695a\u96c4\u5e02", fatherID: "532300"}, {id: "2628", areaID: "532322", area: "\u53cc\u67cf\u53bf", fatherID: "532300"}, {id: "2629", areaID: "532323", area: "\u725f\u5b9a\u53bf", fatherID: "532300"}, {id: "2630", areaID: "532324", area: "\u5357\u534e\u53bf", fatherID: "532300"}, {id: "2631", areaID: "532325", area: "\u59da\u5b89\u53bf", fatherID: "532300"}, {id: "2632", areaID: "532326", area: "\u5927\u59da\u53bf", fatherID: "532300"}, {id: "2633", areaID: "532327", area: "\u6c38\u4ec1\u53bf", fatherID: "532300"}, {id: "2634", areaID: "532328", area: "\u5143\u8c0b\u53bf", fatherID: "532300"}, {id: "2635", areaID: "532329", area: "\u6b66\u5b9a\u53bf", fatherID: "532300"}, {
        id: "2636",
        areaID: "532331",
        area: "\u7984\u4e30\u53bf",
        fatherID: "532300"
    }, {id: "2637", areaID: "532501", area: "\u4e2a\u65e7\u5e02", fatherID: "532500"}, {id: "2638", areaID: "532502", area: "\u5f00\u8fdc\u5e02", fatherID: "532500"}, {id: "2639", areaID: "532522", area: "\u8499\u81ea\u53bf", fatherID: "532500"}, {id: "2640", areaID: "532523", area: "\u5c4f\u8fb9\u82d7\u65cf\u81ea\u6cbb\u53bf", fatherID: "532500"}, {id: "2641", areaID: "532524", area: "\u5efa\u6c34\u53bf", fatherID: "532500"}, {id: "2642", areaID: "532525", area: "\u77f3\u5c4f\u53bf", fatherID: "532500"}, {id: "2643", areaID: "532526", area: "\u5f25\u52d2\u53bf", fatherID: "532500"}, {id: "2644", areaID: "532527", area: "\u6cf8\u897f\u53bf", fatherID: "532500"}, {id: "2645", areaID: "532528", area: "\u5143\u9633\u53bf", fatherID: "532500"}, {
        id: "2646",
        areaID: "532529",
        area: "\u7ea2\u6cb3\u53bf",
        fatherID: "532500"
    }, {id: "2647", areaID: "532530", area: "\u91d1\u5e73\u82d7\u65cf\u7476\u65cf\u50a3\u65cf\u81ea\u6cbb\u53bf", fatherID: "532500"}, {id: "2648", areaID: "532531", area: "\u7eff\u6625\u53bf", fatherID: "532500"}, {id: "2649", areaID: "532532", area: "\u6cb3\u53e3\u7476\u65cf\u81ea\u6cbb\u53bf", fatherID: "532500"}, {id: "2650", areaID: "532621", area: "\u6587\u5c71\u53bf", fatherID: "532600"}, {id: "2651", areaID: "532622", area: "\u781a\u5c71\u53bf", fatherID: "532600"}, {id: "2652", areaID: "532623", area: "\u897f\u7574\u53bf", fatherID: "532600"}, {id: "2653", areaID: "532624", area: "\u9ebb\u6817\u5761\u53bf", fatherID: "532600"}, {id: "2654", areaID: "532625", area: "\u9a6c\u5173\u53bf", fatherID: "532600"}, {
        id: "2655",
        areaID: "532626",
        area: "\u4e18\u5317\u53bf",
        fatherID: "532600"
    }, {id: "2656", areaID: "532627", area: "\u5e7f\u5357\u53bf", fatherID: "532600"}, {id: "2657", areaID: "532628", area: "\u5bcc\u5b81\u53bf", fatherID: "532600"}, {id: "2658", areaID: "532801", area: "\u666f\u6d2a\u5e02", fatherID: "532800"}, {id: "2659", areaID: "532822", area: "\u52d0\u6d77\u53bf", fatherID: "532800"}, {id: "2660", areaID: "532823", area: "\u52d0\u814a\u53bf", fatherID: "532800"}, {id: "2661", areaID: "532901", area: "\u5927\u7406\u5e02", fatherID: "532900"}, {id: "2662", areaID: "532922", area: "\u6f3e\u6fde\u5f5d\u65cf\u81ea\u6cbb\u53bf", fatherID: "532900"}, {id: "2663", areaID: "532923", area: "\u7965\u4e91\u53bf", fatherID: "532900"}, {id: "2664", areaID: "532924", area: "\u5bbe\u5ddd\u53bf", fatherID: "532900"}, {
        id: "2665",
        areaID: "532925",
        area: "\u5f25\u6e21\u53bf",
        fatherID: "532900"
    }, {id: "2666", areaID: "532926", area: "\u5357\u6da7\u5f5d\u65cf\u81ea\u6cbb\u53bf", fatherID: "532900"}, {id: "2667", areaID: "532927", area: "\u5dcd\u5c71\u5f5d\u65cf\u56de\u65cf\u81ea\u6cbb\u53bf", fatherID: "532900"}, {id: "2668", areaID: "532928", area: "\u6c38\u5e73\u53bf", fatherID: "532900"}, {id: "2669", areaID: "532929", area: "\u4e91\u9f99\u53bf", fatherID: "532900"}, {id: "2670", areaID: "532930", area: "\u6d31\u6e90\u53bf", fatherID: "532900"}, {id: "2671", areaID: "532931", area: "\u5251\u5ddd\u53bf", fatherID: "532900"}, {id: "2672", areaID: "532932", area: "\u9e64\u5e86\u53bf", fatherID: "532900"}, {id: "2673", areaID: "533102", area: "\u745e\u4e3d\u5e02", fatherID: "533100"}, {id: "2674", areaID: "533103", area: "\u6f5e\u897f\u5e02", fatherID: "533100"}, {
        id: "2675",
        areaID: "533122",
        area: "\u6881\u6cb3\u53bf",
        fatherID: "533100"
    }, {id: "2676", areaID: "533123", area: "\u76c8\u6c5f\u53bf", fatherID: "533100"}, {id: "2677", areaID: "533124", area: "\u9647\u5ddd\u53bf", fatherID: "533100"}, {id: "2678", areaID: "533321", area: "\u6cf8\u6c34\u53bf", fatherID: "533300"}, {id: "2679", areaID: "533323", area: "\u798f\u8d21\u53bf", fatherID: "533300"}, {id: "2680", areaID: "533324", area: "\u8d21\u5c71\u72ec\u9f99\u65cf\u6012\u65cf\u81ea\u6cbb\u53bf", fatherID: "533300"}, {id: "2681", areaID: "533325", area: "\u5170\u576a\u767d\u65cf\u666e\u7c73\u65cf\u81ea\u6cbb\u53bf", fatherID: "533300"}, {id: "2682", areaID: "533421", area: "\u9999\u683c\u91cc\u62c9\u53bf", fatherID: "533400"}, {id: "2683", areaID: "533422", area: "\u5fb7\u94a6\u53bf", fatherID: "533400"}, {
        id: "2684",
        areaID: "533423",
        area: "\u7ef4\u897f\u5088\u50f3\u65cf\u81ea\u6cbb\u53bf",
        fatherID: "533400"
    }, {id: "2685", areaID: "540101", area: "\u5e02\u8f96\u533a", fatherID: "540100"}, {id: "2686", areaID: "540102", area: "\u57ce\u5173\u533a", fatherID: "540100"}, {id: "2687", areaID: "540121", area: "\u6797\u5468\u53bf", fatherID: "540100"}, {id: "2688", areaID: "540122", area: "\u5f53\u96c4\u53bf", fatherID: "540100"}, {id: "2689", areaID: "540123", area: "\u5c3c\u6728\u53bf", fatherID: "540100"}, {id: "2690", areaID: "540124", area: "\u66f2\u6c34\u53bf", fatherID: "540100"}, {id: "2691", areaID: "540125", area: "\u5806\u9f99\u5fb7\u5e86\u53bf", fatherID: "540100"}, {id: "2692", areaID: "540126", area: "\u8fbe\u5b5c\u53bf", fatherID: "540100"}, {id: "2693", areaID: "540127", area: "\u58a8\u7af9\u5de5\u5361\u53bf", fatherID: "540100"}, {
        id: "2694",
        areaID: "542121",
        area: "\u660c\u90fd\u53bf",
        fatherID: "542100"
    }, {id: "2695", areaID: "542122", area: "\u6c5f\u8fbe\u53bf", fatherID: "542100"}, {id: "2696", areaID: "542123", area: "\u8d21\u89c9\u53bf", fatherID: "542100"}, {id: "2697", areaID: "542124", area: "\u7c7b\u4e4c\u9f50\u53bf", fatherID: "542100"}, {id: "2698", areaID: "542125", area: "\u4e01\u9752\u53bf", fatherID: "542100"}, {id: "2699", areaID: "542126", area: "\u5bdf\u96c5\u53bf", fatherID: "542100"}, {id: "2700", areaID: "542127", area: "\u516b\u5bbf\u53bf", fatherID: "542100"}, {id: "2701", areaID: "542128", area: "\u5de6\u8d21\u53bf", fatherID: "542100"}, {id: "2702", areaID: "542129", area: "\u8292\u5eb7\u53bf", fatherID: "542100"}, {id: "2703", areaID: "542132", area: "\u6d1b\u9686\u53bf", fatherID: "542100"}, {
        id: "2704",
        areaID: "542133",
        area: "\u8fb9\u575d\u53bf",
        fatherID: "542100"
    }, {id: "2705", areaID: "542221", area: "\u4e43\u4e1c\u53bf", fatherID: "542200"}, {id: "2706", areaID: "542222", area: "\u624e\u56ca\u53bf", fatherID: "542200"}, {id: "2707", areaID: "542223", area: "\u8d21\u560e\u53bf", fatherID: "542200"}, {id: "2708", areaID: "542224", area: "\u6851\u65e5\u53bf", fatherID: "542200"}, {id: "2709", areaID: "542225", area: "\u743c\u7ed3\u53bf", fatherID: "542200"}, {id: "2710", areaID: "542226", area: "\u66f2\u677e\u53bf", fatherID: "542200"}, {id: "2711", areaID: "542227", area: "\u63aa\u7f8e\u53bf", fatherID: "542200"}, {id: "2712", areaID: "542228", area: "\u6d1b\u624e\u53bf", fatherID: "542200"}, {id: "2713", areaID: "542229", area: "\u52a0\u67e5\u53bf", fatherID: "542200"}, {
        id: "2714",
        areaID: "542231",
        area: "\u9686\u5b50\u53bf",
        fatherID: "542200"
    }, {id: "2715", areaID: "542232", area: "\u9519\u90a3\u53bf", fatherID: "542200"}, {id: "2716", areaID: "542233", area: "\u6d6a\u5361\u5b50\u53bf", fatherID: "542200"}, {id: "2717", areaID: "542301", area: "\u65e5\u5580\u5219\u5e02", fatherID: "542300"}, {id: "2718", areaID: "542322", area: "\u5357\u6728\u6797\u53bf", fatherID: "542300"}, {id: "2719", areaID: "542323", area: "\u6c5f\u5b5c\u53bf", fatherID: "542300"}, {id: "2720", areaID: "542324", area: "\u5b9a\u65e5\u53bf", fatherID: "542300"}, {id: "2721", areaID: "542325", area: "\u8428\u8fe6\u53bf", fatherID: "542300"}, {id: "2722", areaID: "542326", area: "\u62c9\u5b5c\u53bf", fatherID: "542300"}, {id: "2723", areaID: "542327", area: "\u6602\u4ec1\u53bf", fatherID: "542300"}, {
        id: "2724",
        areaID: "542328",
        area: "\u8c22\u901a\u95e8\u53bf",
        fatherID: "542300"
    }, {id: "2725", areaID: "542329", area: "\u767d\u6717\u53bf", fatherID: "542300"}, {id: "2726", areaID: "542330", area: "\u4ec1\u5e03\u53bf", fatherID: "542300"}, {id: "2727", areaID: "542331", area: "\u5eb7\u9a6c\u53bf", fatherID: "542300"}, {id: "2728", areaID: "542332", area: "\u5b9a\u7ed3\u53bf", fatherID: "542300"}, {id: "2729", areaID: "542333", area: "\u4ef2\u5df4\u53bf", fatherID: "542300"}, {id: "2730", areaID: "542334", area: "\u4e9a\u4e1c\u53bf", fatherID: "542300"}, {id: "2731", areaID: "542335", area: "\u5409\u9686\u53bf", fatherID: "542300"}, {id: "2732", areaID: "542336", area: "\u8042\u62c9\u6728\u53bf", fatherID: "542300"}, {id: "2733", areaID: "542337", area: "\u8428\u560e\u53bf", fatherID: "542300"}, {
        id: "2734",
        areaID: "542338",
        area: "\u5c97\u5df4\u53bf",
        fatherID: "542300"
    }, {id: "2735", areaID: "542421", area: "\u90a3\u66f2\u53bf", fatherID: "542400"}, {id: "2736", areaID: "542422", area: "\u5609\u9ece\u53bf", fatherID: "542400"}, {id: "2737", areaID: "542423", area: "\u6bd4\u5982\u53bf", fatherID: "542400"}, {id: "2738", areaID: "542424", area: "\u8042\u8363\u53bf", fatherID: "542400"}, {id: "2739", areaID: "542425", area: "\u5b89\u591a\u53bf", fatherID: "542400"}, {id: "2740", areaID: "542426", area: "\u7533\u624e\u53bf", fatherID: "542400"}, {id: "2741", areaID: "542427", area: "\u7d22\u3000\u53bf", fatherID: "542400"}, {id: "2742", areaID: "542428", area: "\u73ed\u6208\u53bf", fatherID: "542400"}, {id: "2743", areaID: "542429", area: "\u5df4\u9752\u53bf", fatherID: "542400"}, {
        id: "2744",
        areaID: "542430",
        area: "\u5c3c\u739b\u53bf",
        fatherID: "542400"
    }, {id: "2745", areaID: "542521", area: "\u666e\u5170\u53bf", fatherID: "542500"}, {id: "2746", areaID: "542522", area: "\u672d\u8fbe\u53bf", fatherID: "542500"}, {id: "2747", areaID: "542523", area: "\u5676\u5c14\u53bf", fatherID: "542500"}, {id: "2748", areaID: "542524", area: "\u65e5\u571f\u53bf", fatherID: "542500"}, {id: "2749", areaID: "542525", area: "\u9769\u5409\u53bf", fatherID: "542500"}, {id: "2750", areaID: "542526", area: "\u6539\u5219\u53bf", fatherID: "542500"}, {id: "2751", areaID: "542527", area: "\u63aa\u52e4\u53bf", fatherID: "542500"}, {id: "2752", areaID: "542621", area: "\u6797\u829d\u53bf", fatherID: "542600"}, {id: "2753", areaID: "542622", area: "\u5de5\u5e03\u6c5f\u8fbe\u53bf", fatherID: "542600"}, {
        id: "2754",
        areaID: "542623",
        area: "\u7c73\u6797\u53bf",
        fatherID: "542600"
    }, {id: "2755", areaID: "542624", area: "\u58a8\u8131\u53bf", fatherID: "542600"}, {id: "2756", areaID: "542625", area: "\u6ce2\u5bc6\u53bf", fatherID: "542600"}, {id: "2757", areaID: "542626", area: "\u5bdf\u9685\u53bf", fatherID: "542600"}, {id: "2758", areaID: "542627", area: "\u6717\u3000\u53bf", fatherID: "542600"}, {id: "2759", areaID: "610101", area: "\u5e02\u8f96\u533a", fatherID: "610100"}, {id: "2760", areaID: "610102", area: "\u65b0\u57ce\u533a", fatherID: "610100"}, {id: "2761", areaID: "610103", area: "\u7891\u6797\u533a", fatherID: "610100"}, {id: "2762", areaID: "610104", area: "\u83b2\u6e56\u533a", fatherID: "610100"}, {id: "2763", areaID: "610111", area: "\u705e\u6865\u533a", fatherID: "610100"}, {
        id: "2764",
        areaID: "610112",
        area: "\u672a\u592e\u533a",
        fatherID: "610100"
    }, {id: "2765", areaID: "610113", area: "\u96c1\u5854\u533a", fatherID: "610100"}, {id: "2766", areaID: "610114", area: "\u960e\u826f\u533a", fatherID: "610100"}, {id: "2767", areaID: "610115", area: "\u4e34\u6f7c\u533a", fatherID: "610100"}, {id: "2768", areaID: "610116", area: "\u957f\u5b89\u533a", fatherID: "610100"}, {id: "2769", areaID: "610122", area: "\u84dd\u7530\u53bf", fatherID: "610100"}, {id: "2770", areaID: "610124", area: "\u5468\u81f3\u53bf", fatherID: "610100"}, {id: "2771", areaID: "610125", area: "\u6237\u3000\u53bf", fatherID: "610100"}, {id: "2772", areaID: "610126", area: "\u9ad8\u9675\u53bf", fatherID: "610100"}, {id: "2773", areaID: "610201", area: "\u5e02\u8f96\u533a", fatherID: "610200"}, {
        id: "2774",
        areaID: "610202",
        area: "\u738b\u76ca\u533a",
        fatherID: "610200"
    }, {id: "2775", areaID: "610203", area: "\u5370\u53f0\u533a", fatherID: "610200"}, {id: "2776", areaID: "610204", area: "\u8000\u5dde\u533a", fatherID: "610200"}, {id: "2777", areaID: "610222", area: "\u5b9c\u541b\u53bf", fatherID: "610200"}, {id: "2778", areaID: "610301", area: "\u5e02\u8f96\u533a", fatherID: "610300"}, {id: "2779", areaID: "610302", area: "\u6e2d\u6ee8\u533a", fatherID: "610300"}, {id: "2780", areaID: "610303", area: "\u91d1\u53f0\u533a", fatherID: "610300"}, {id: "2781", areaID: "610304", area: "\u9648\u4ed3\u533a", fatherID: "610300"}, {id: "2782", areaID: "610322", area: "\u51e4\u7fd4\u53bf", fatherID: "610300"}, {id: "2783", areaID: "610323", area: "\u5c90\u5c71\u53bf", fatherID: "610300"}, {
        id: "2784",
        areaID: "610324",
        area: "\u6276\u98ce\u53bf",
        fatherID: "610300"
    }, {id: "2785", areaID: "610326", area: "\u7709\u3000\u53bf", fatherID: "610300"}, {id: "2786", areaID: "610327", area: "\u9647\u3000\u53bf", fatherID: "610300"}, {id: "2787", areaID: "610328", area: "\u5343\u9633\u53bf", fatherID: "610300"}, {id: "2788", areaID: "610329", area: "\u9e9f\u6e38\u53bf", fatherID: "610300"}, {id: "2789", areaID: "610330", area: "\u51e4\u3000\u53bf", fatherID: "610300"}, {id: "2790", areaID: "610331", area: "\u592a\u767d\u53bf", fatherID: "610300"}, {id: "2791", areaID: "610401", area: "\u5e02\u8f96\u533a", fatherID: "610400"}, {id: "2792", areaID: "610402", area: "\u79e6\u90fd\u533a", fatherID: "610400"}, {id: "2793", areaID: "610403", area: "\u6768\u51cc\u533a", fatherID: "610400"}, {
        id: "2794",
        areaID: "610404",
        area: "\u6e2d\u57ce\u533a",
        fatherID: "610400"
    }, {id: "2795", areaID: "610422", area: "\u4e09\u539f\u53bf", fatherID: "610400"}, {id: "2796", areaID: "610423", area: "\u6cfe\u9633\u53bf", fatherID: "610400"}, {id: "2797", areaID: "610424", area: "\u4e7e\u3000\u53bf", fatherID: "610400"}, {id: "2798", areaID: "610425", area: "\u793c\u6cc9\u53bf", fatherID: "610400"}, {id: "2799", areaID: "610426", area: "\u6c38\u5bff\u53bf", fatherID: "610400"}, {id: "2800", areaID: "610427", area: "\u5f6c\u3000\u53bf", fatherID: "610400"}, {id: "2801", areaID: "610428", area: "\u957f\u6b66\u53bf", fatherID: "610400"}, {id: "2802", areaID: "610429", area: "\u65ec\u9091\u53bf", fatherID: "610400"}, {id: "2803", areaID: "610430", area: "\u6df3\u5316\u53bf", fatherID: "610400"}, {
        id: "2804",
        areaID: "610431",
        area: "\u6b66\u529f\u53bf",
        fatherID: "610400"
    }, {id: "2805", areaID: "610481", area: "\u5174\u5e73\u5e02", fatherID: "610400"}, {id: "2806", areaID: "610501", area: "\u5e02\u8f96\u533a", fatherID: "610500"}, {id: "2807", areaID: "610502", area: "\u4e34\u6e2d\u533a", fatherID: "610500"}, {id: "2808", areaID: "610521", area: "\u534e\u3000\u53bf", fatherID: "610500"}, {id: "2809", areaID: "610522", area: "\u6f7c\u5173\u53bf", fatherID: "610500"}, {id: "2810", areaID: "610523", area: "\u5927\u8354\u53bf", fatherID: "610500"}, {id: "2811", areaID: "610524", area: "\u5408\u9633\u53bf", fatherID: "610500"}, {id: "2812", areaID: "610525", area: "\u6f84\u57ce\u53bf", fatherID: "610500"}, {id: "2813", areaID: "610526", area: "\u84b2\u57ce\u53bf", fatherID: "610500"}, {
        id: "2814",
        areaID: "610527",
        area: "\u767d\u6c34\u53bf",
        fatherID: "610500"
    }, {id: "2815", areaID: "610528", area: "\u5bcc\u5e73\u53bf", fatherID: "610500"}, {id: "2816", areaID: "610581", area: "\u97e9\u57ce\u5e02", fatherID: "610500"}, {id: "2817", areaID: "610582", area: "\u534e\u9634\u5e02", fatherID: "610500"}, {id: "2818", areaID: "610601", area: "\u5e02\u8f96\u533a", fatherID: "610600"}, {id: "2819", areaID: "610602", area: "\u5b9d\u5854\u533a", fatherID: "610600"}, {id: "2820", areaID: "610621", area: "\u5ef6\u957f\u53bf", fatherID: "610600"}, {id: "2821", areaID: "610622", area: "\u5ef6\u5ddd\u53bf", fatherID: "610600"}, {id: "2822", areaID: "610623", area: "\u5b50\u957f\u53bf", fatherID: "610600"}, {id: "2823", areaID: "610624", area: "\u5b89\u585e\u53bf", fatherID: "610600"}, {
        id: "2824",
        areaID: "610625",
        area: "\u5fd7\u4e39\u53bf",
        fatherID: "610600"
    }, {id: "2825", areaID: "610626", area: "\u5434\u65d7\u53bf", fatherID: "610600"}, {id: "2826", areaID: "610627", area: "\u7518\u6cc9\u53bf", fatherID: "610600"}, {id: "2827", areaID: "610628", area: "\u5bcc\u3000\u53bf", fatherID: "610600"}, {id: "2828", areaID: "610629", area: "\u6d1b\u5ddd\u53bf", fatherID: "610600"}, {id: "2829", areaID: "610630", area: "\u5b9c\u5ddd\u53bf", fatherID: "610600"}, {id: "2830", areaID: "610631", area: "\u9ec4\u9f99\u53bf", fatherID: "610600"}, {id: "2831", areaID: "610632", area: "\u9ec4\u9675\u53bf", fatherID: "610600"}, {id: "2832", areaID: "610701", area: "\u5e02\u8f96\u533a", fatherID: "610700"}, {id: "2833", areaID: "610702", area: "\u6c49\u53f0\u533a", fatherID: "610700"}, {
        id: "2834",
        areaID: "610721",
        area: "\u5357\u90d1\u53bf",
        fatherID: "610700"
    }, {id: "2835", areaID: "610722", area: "\u57ce\u56fa\u53bf", fatherID: "610700"}, {id: "2836", areaID: "610723", area: "\u6d0b\u3000\u53bf", fatherID: "610700"}, {id: "2837", areaID: "610724", area: "\u897f\u4e61\u53bf", fatherID: "610700"}, {id: "2838", areaID: "610725", area: "\u52c9\u3000\u53bf", fatherID: "610700"}, {id: "2839", areaID: "610726", area: "\u5b81\u5f3a\u53bf", fatherID: "610700"}, {id: "2840", areaID: "610727", area: "\u7565\u9633\u53bf", fatherID: "610700"}, {id: "2841", areaID: "610728", area: "\u9547\u5df4\u53bf", fatherID: "610700"}, {id: "2842", areaID: "610729", area: "\u7559\u575d\u53bf", fatherID: "610700"}, {id: "2843", areaID: "610730", area: "\u4f5b\u576a\u53bf", fatherID: "610700"}, {
        id: "2844",
        areaID: "610801",
        area: "\u5e02\u8f96\u533a",
        fatherID: "610800"
    }, {id: "2845", areaID: "610802", area: "\u6986\u9633\u533a", fatherID: "610800"}, {id: "2846", areaID: "610821", area: "\u795e\u6728\u53bf", fatherID: "610800"}, {id: "2847", areaID: "610822", area: "\u5e9c\u8c37\u53bf", fatherID: "610800"}, {id: "2848", areaID: "610823", area: "\u6a2a\u5c71\u53bf", fatherID: "610800"}, {id: "2849", areaID: "610824", area: "\u9756\u8fb9\u53bf", fatherID: "610800"}, {id: "2850", areaID: "610825", area: "\u5b9a\u8fb9\u53bf", fatherID: "610800"}, {id: "2851", areaID: "610826", area: "\u7ee5\u5fb7\u53bf", fatherID: "610800"}, {id: "2852", areaID: "610827", area: "\u7c73\u8102\u53bf", fatherID: "610800"}, {id: "2853", areaID: "610828", area: "\u4f73\u3000\u53bf", fatherID: "610800"}, {
        id: "2854",
        areaID: "610829",
        area: "\u5434\u5821\u53bf",
        fatherID: "610800"
    }, {id: "2855", areaID: "610830", area: "\u6e05\u6da7\u53bf", fatherID: "610800"}, {id: "2856", areaID: "610831", area: "\u5b50\u6d32\u53bf", fatherID: "610800"}, {id: "2857", areaID: "610901", area: "\u5e02\u8f96\u533a", fatherID: "610900"}, {id: "2858", areaID: "610902", area: "\u6c49\u6ee8\u533a", fatherID: "610900"}, {id: "2859", areaID: "610921", area: "\u6c49\u9634\u53bf", fatherID: "610900"}, {id: "2860", areaID: "610922", area: "\u77f3\u6cc9\u53bf", fatherID: "610900"}, {id: "2861", areaID: "610923", area: "\u5b81\u9655\u53bf", fatherID: "610900"}, {id: "2862", areaID: "610924", area: "\u7d2b\u9633\u53bf", fatherID: "610900"}, {id: "2863", areaID: "610925", area: "\u5c9a\u768b\u53bf", fatherID: "610900"}, {
        id: "2864",
        areaID: "610926",
        area: "\u5e73\u5229\u53bf",
        fatherID: "610900"
    }, {id: "2865", areaID: "610927", area: "\u9547\u576a\u53bf", fatherID: "610900"}, {id: "2866", areaID: "610928", area: "\u65ec\u9633\u53bf", fatherID: "610900"}, {id: "2867", areaID: "610929", area: "\u767d\u6cb3\u53bf", fatherID: "610900"}, {id: "2868", areaID: "611001", area: "\u5e02\u8f96\u533a", fatherID: "611000"}, {id: "2869", areaID: "611002", area: "\u5546\u5dde\u533a", fatherID: "611000"}, {id: "2870", areaID: "611021", area: "\u6d1b\u5357\u53bf", fatherID: "611000"}, {id: "2871", areaID: "611022", area: "\u4e39\u51e4\u53bf", fatherID: "611000"}, {id: "2872", areaID: "611023", area: "\u5546\u5357\u53bf", fatherID: "611000"}, {id: "2873", areaID: "611024", area: "\u5c71\u9633\u53bf", fatherID: "611000"}, {
        id: "2874",
        areaID: "611025",
        area: "\u9547\u5b89\u53bf",
        fatherID: "611000"
    }, {id: "2875", areaID: "611026", area: "\u67de\u6c34\u53bf", fatherID: "611000"}, {id: "2876", areaID: "620101", area: "\u5e02\u8f96\u533a", fatherID: "620100"}, {id: "2877", areaID: "620102", area: "\u57ce\u5173\u533a", fatherID: "620100"}, {id: "2878", areaID: "620103", area: "\u4e03\u91cc\u6cb3\u533a", fatherID: "620100"}, {id: "2879", areaID: "620104", area: "\u897f\u56fa\u533a", fatherID: "620100"}, {id: "2880", areaID: "620105", area: "\u5b89\u5b81\u533a", fatherID: "620100"}, {id: "2881", areaID: "620111", area: "\u7ea2\u53e4\u533a", fatherID: "620100"}, {id: "2882", areaID: "620121", area: "\u6c38\u767b\u53bf", fatherID: "620100"}, {id: "2883", areaID: "620122", area: "\u768b\u5170\u53bf", fatherID: "620100"}, {
        id: "2884",
        areaID: "620123",
        area: "\u6986\u4e2d\u53bf",
        fatherID: "620100"
    }, {id: "2885", areaID: "620201", area: "\u5e02\u8f96\u533a", fatherID: "620200"}, {id: "2886", areaID: "620301", area: "\u5e02\u8f96\u533a", fatherID: "620300"}, {id: "2887", areaID: "620302", area: "\u91d1\u5ddd\u533a", fatherID: "620300"}, {id: "2888", areaID: "620321", area: "\u6c38\u660c\u53bf", fatherID: "620300"}, {id: "2889", areaID: "620401", area: "\u5e02\u8f96\u533a", fatherID: "620400"}, {id: "2890", areaID: "620402", area: "\u767d\u94f6\u533a", fatherID: "620400"}, {id: "2891", areaID: "620403", area: "\u5e73\u5ddd\u533a", fatherID: "620400"}, {id: "2892", areaID: "620421", area: "\u9756\u8fdc\u53bf", fatherID: "620400"}, {id: "2893", areaID: "620422", area: "\u4f1a\u5b81\u53bf", fatherID: "620400"}, {
        id: "2894",
        areaID: "620423",
        area: "\u666f\u6cf0\u53bf",
        fatherID: "620400"
    }, {id: "2895", areaID: "620501", area: "\u5e02\u8f96\u533a", fatherID: "620500"}, {id: "2896", areaID: "620502", area: "\u79e6\u57ce\u533a", fatherID: "620500"}, {id: "2897", areaID: "620503", area: "\u5317\u9053\u533a", fatherID: "620500"}, {id: "2898", areaID: "620521", area: "\u6e05\u6c34\u53bf", fatherID: "620500"}, {id: "2899", areaID: "620522", area: "\u79e6\u5b89\u53bf", fatherID: "620500"}, {id: "2900", areaID: "620523", area: "\u7518\u8c37\u53bf", fatherID: "620500"}, {id: "2901", areaID: "620524", area: "\u6b66\u5c71\u53bf", fatherID: "620500"}, {id: "2902", areaID: "620525", area: "\u5f20\u5bb6\u5ddd\u56de\u65cf\u81ea\u6cbb\u53bf", fatherID: "620500"}, {id: "2903", areaID: "620601", area: "\u5e02\u8f96\u533a", fatherID: "620600"}, {
        id: "2904",
        areaID: "620602",
        area: "\u51c9\u5dde\u533a",
        fatherID: "620600"
    }, {id: "2905", areaID: "620621", area: "\u6c11\u52e4\u53bf", fatherID: "620600"}, {id: "2906", areaID: "620622", area: "\u53e4\u6d6a\u53bf", fatherID: "620600"}, {id: "2907", areaID: "620623", area: "\u5929\u795d\u85cf\u65cf\u81ea\u6cbb\u53bf", fatherID: "620600"}, {id: "2908", areaID: "620701", area: "\u5e02\u8f96\u533a", fatherID: "620700"}, {id: "2909", areaID: "620702", area: "\u7518\u5dde\u533a", fatherID: "620700"}, {id: "2910", areaID: "620721", area: "\u8083\u5357\u88d5\u56fa\u65cf\u81ea\u6cbb\u53bf", fatherID: "620700"}, {id: "2911", areaID: "620722", area: "\u6c11\u4e50\u53bf", fatherID: "620700"}, {id: "2912", areaID: "620723", area: "\u4e34\u6cfd\u53bf", fatherID: "620700"}, {id: "2913", areaID: "620724", area: "\u9ad8\u53f0\u53bf", fatherID: "620700"}, {
        id: "2914",
        areaID: "620725",
        area: "\u5c71\u4e39\u53bf",
        fatherID: "620700"
    }, {id: "2915", areaID: "620801", area: "\u5e02\u8f96\u533a", fatherID: "620800"}, {id: "2916", areaID: "620802", area: "\u5d06\u5cd2\u533a", fatherID: "620800"}, {id: "2917", areaID: "620821", area: "\u6cfe\u5ddd\u53bf", fatherID: "620800"}, {id: "2918", areaID: "620822", area: "\u7075\u53f0\u53bf", fatherID: "620800"}, {id: "2919", areaID: "620823", area: "\u5d07\u4fe1\u53bf", fatherID: "620800"}, {id: "2920", areaID: "620824", area: "\u534e\u4ead\u53bf", fatherID: "620800"}, {id: "2921", areaID: "620825", area: "\u5e84\u6d6a\u53bf", fatherID: "620800"}, {id: "2922", areaID: "620826", area: "\u9759\u5b81\u53bf", fatherID: "620800"}, {id: "2923", areaID: "620901", area: "\u5e02\u8f96\u533a", fatherID: "620900"}, {
        id: "2924",
        areaID: "620902",
        area: "\u8083\u5dde\u533a",
        fatherID: "620900"
    }, {id: "2925", areaID: "620921", area: "\u91d1\u5854\u53bf", fatherID: "620900"}, {id: "2926", areaID: "620922", area: "\u5b89\u897f\u53bf", fatherID: "620900"}, {id: "2927", areaID: "620923", area: "\u8083\u5317\u8499\u53e4\u65cf\u81ea\u6cbb\u53bf", fatherID: "620900"}, {id: "2928", areaID: "620924", area: "\u963f\u514b\u585e\u54c8\u8428\u514b\u65cf\u81ea\u6cbb\u53bf", fatherID: "620900"}, {id: "2929", areaID: "620981", area: "\u7389\u95e8\u5e02", fatherID: "620900"}, {id: "2930", areaID: "620982", area: "\u6566\u714c\u5e02", fatherID: "620900"}, {id: "2931", areaID: "621001", area: "\u5e02\u8f96\u533a", fatherID: "621000"}, {id: "2932", areaID: "621002", area: "\u897f\u5cf0\u533a", fatherID: "621000"}, {
        id: "2933",
        areaID: "621021",
        area: "\u5e86\u57ce\u53bf",
        fatherID: "621000"
    }, {id: "2934", areaID: "621022", area: "\u73af\u3000\u53bf", fatherID: "621000"}, {id: "2935", areaID: "621023", area: "\u534e\u6c60\u53bf", fatherID: "621000"}, {id: "2936", areaID: "621024", area: "\u5408\u6c34\u53bf", fatherID: "621000"}, {id: "2937", areaID: "621025", area: "\u6b63\u5b81\u53bf", fatherID: "621000"}, {id: "2938", areaID: "621026", area: "\u5b81\u3000\u53bf", fatherID: "621000"}, {id: "2939", areaID: "621027", area: "\u9547\u539f\u53bf", fatherID: "621000"}, {id: "2940", areaID: "621101", area: "\u5e02\u8f96\u533a", fatherID: "621100"}, {id: "2941", areaID: "621102", area: "\u5b89\u5b9a\u533a", fatherID: "621100"}, {id: "2942", areaID: "621121", area: "\u901a\u6e2d\u53bf", fatherID: "621100"}, {
        id: "2943",
        areaID: "621122",
        area: "\u9647\u897f\u53bf",
        fatherID: "621100"
    }, {id: "2944", areaID: "621123", area: "\u6e2d\u6e90\u53bf", fatherID: "621100"}, {id: "2945", areaID: "621124", area: "\u4e34\u6d2e\u53bf", fatherID: "621100"}, {id: "2946", areaID: "621125", area: "\u6f33\u3000\u53bf", fatherID: "621100"}, {id: "2947", areaID: "621126", area: "\u5cb7\u3000\u53bf", fatherID: "621100"}, {id: "2948", areaID: "621201", area: "\u5e02\u8f96\u533a", fatherID: "621200"}, {id: "2949", areaID: "621202", area: "\u6b66\u90fd\u533a", fatherID: "621200"}, {id: "2950", areaID: "621221", area: "\u6210\u3000\u53bf", fatherID: "621200"}, {id: "2951", areaID: "621222", area: "\u6587\u3000\u53bf", fatherID: "621200"}, {id: "2952", areaID: "621223", area: "\u5b95\u660c\u53bf", fatherID: "621200"}, {
        id: "2953",
        areaID: "621224",
        area: "\u5eb7\u3000\u53bf",
        fatherID: "621200"
    }, {id: "2954", areaID: "621225", area: "\u897f\u548c\u53bf", fatherID: "621200"}, {id: "2955", areaID: "621226", area: "\u793c\u3000\u53bf", fatherID: "621200"}, {id: "2956", areaID: "621227", area: "\u5fbd\u3000\u53bf", fatherID: "621200"}, {id: "2957", areaID: "621228", area: "\u4e24\u5f53\u53bf", fatherID: "621200"}, {id: "2958", areaID: "622901", area: "\u4e34\u590f\u5e02", fatherID: "622900"}, {id: "2959", areaID: "622921", area: "\u4e34\u590f\u53bf", fatherID: "622900"}, {id: "2960", areaID: "622922", area: "\u5eb7\u4e50\u53bf", fatherID: "622900"}, {id: "2961", areaID: "622923", area: "\u6c38\u9756\u53bf", fatherID: "622900"}, {id: "2962", areaID: "622924", area: "\u5e7f\u6cb3\u53bf", fatherID: "622900"}, {
        id: "2963",
        areaID: "622925",
        area: "\u548c\u653f\u53bf",
        fatherID: "622900"
    }, {id: "2964", areaID: "622926", area: "\u4e1c\u4e61\u65cf\u81ea\u6cbb\u53bf", fatherID: "622900"}, {id: "2965", areaID: "622927", area: "\u79ef\u77f3\u5c71\u4fdd\u5b89\u65cf\u4e1c\u4e61\u65cf\u6492\u62c9\u65cf\u81ea\u6cbb\u53bf", fatherID: "622900"}, {id: "2966", areaID: "623001", area: "\u5408\u4f5c\u5e02", fatherID: "623000"}, {id: "2967", areaID: "623021", area: "\u4e34\u6f6d\u53bf", fatherID: "623000"}, {id: "2968", areaID: "623022", area: "\u5353\u5c3c\u53bf", fatherID: "623000"}, {id: "2969", areaID: "623023", area: "\u821f\u66f2\u53bf", fatherID: "623000"}, {id: "2970", areaID: "623024", area: "\u8fed\u90e8\u53bf", fatherID: "623000"}, {id: "2971", areaID: "623025", area: "\u739b\u66f2\u53bf", fatherID: "623000"}, {
        id: "2972",
        areaID: "623026",
        area: "\u788c\u66f2\u53bf",
        fatherID: "623000"
    }, {id: "2973", areaID: "623027", area: "\u590f\u6cb3\u53bf", fatherID: "623000"}, {id: "2974", areaID: "630101", area: "\u5e02\u8f96\u533a", fatherID: "630100"}, {id: "2975", areaID: "630102", area: "\u57ce\u4e1c\u533a", fatherID: "630100"}, {id: "2976", areaID: "630103", area: "\u57ce\u4e2d\u533a", fatherID: "630100"}, {id: "2977", areaID: "630104", area: "\u57ce\u897f\u533a", fatherID: "630100"}, {id: "2978", areaID: "630105", area: "\u57ce\u5317\u533a", fatherID: "630100"}, {id: "2979", areaID: "630121", area: "\u5927\u901a\u56de\u65cf\u571f\u65cf\u81ea\u6cbb\u53bf", fatherID: "630100"}, {id: "2980", areaID: "630122", area: "\u6e5f\u4e2d\u53bf", fatherID: "630100"}, {id: "2981", areaID: "630123", area: "\u6e5f\u6e90\u53bf", fatherID: "630100"}, {
        id: "2982",
        areaID: "632121",
        area: "\u5e73\u5b89\u53bf",
        fatherID: "632100"
    }, {id: "2983", areaID: "632122", area: "\u6c11\u548c\u56de\u65cf\u571f\u65cf\u81ea\u6cbb\u53bf", fatherID: "632100"}, {id: "2984", areaID: "632123", area: "\u4e50\u90fd\u53bf", fatherID: "632100"}, {id: "2985", areaID: "632126", area: "\u4e92\u52a9\u571f\u65cf\u81ea\u6cbb\u53bf", fatherID: "632100"}, {id: "2986", areaID: "632127", area: "\u5316\u9686\u56de\u65cf\u81ea\u6cbb\u53bf", fatherID: "632100"}, {id: "2987", areaID: "632128", area: "\u5faa\u5316\u6492\u62c9\u65cf\u81ea\u6cbb\u53bf", fatherID: "632100"}, {id: "2988", areaID: "632221", area: "\u95e8\u6e90\u56de\u65cf\u81ea\u6cbb\u53bf", fatherID: "632200"}, {id: "2989", areaID: "632222", area: "\u7941\u8fde\u53bf", fatherID: "632200"}, {id: "2990", areaID: "632223", area: "\u6d77\u664f\u53bf", fatherID: "632200"}, {
        id: "2991",
        areaID: "632224",
        area: "\u521a\u5bdf\u53bf",
        fatherID: "632200"
    }, {id: "2992", areaID: "632321", area: "\u540c\u4ec1\u53bf", fatherID: "632300"}, {id: "2993", areaID: "632322", area: "\u5c16\u624e\u53bf", fatherID: "632300"}, {id: "2994", areaID: "632323", area: "\u6cfd\u5e93\u53bf", fatherID: "632300"}, {id: "2995", areaID: "632324", area: "\u6cb3\u5357\u8499\u53e4\u65cf\u81ea\u6cbb\u53bf", fatherID: "632300"}, {id: "2996", areaID: "632521", area: "\u5171\u548c\u53bf", fatherID: "632500"}, {id: "2997", areaID: "632522", area: "\u540c\u5fb7\u53bf", fatherID: "632500"}, {id: "2998", areaID: "632523", area: "\u8d35\u5fb7\u53bf", fatherID: "632500"}, {id: "2999", areaID: "632524", area: "\u5174\u6d77\u53bf", fatherID: "632500"}, {id: "3000", areaID: "632525", area: "\u8d35\u5357\u53bf", fatherID: "632500"}, {
        id: "3001",
        areaID: "632621",
        area: "\u739b\u6c81\u53bf",
        fatherID: "632600"
    }, {id: "3002", areaID: "632622", area: "\u73ed\u739b\u53bf", fatherID: "632600"}, {id: "3003", areaID: "632623", area: "\u7518\u5fb7\u53bf", fatherID: "632600"}, {id: "3004", areaID: "632624", area: "\u8fbe\u65e5\u53bf", fatherID: "632600"}, {id: "3005", areaID: "632625", area: "\u4e45\u6cbb\u53bf", fatherID: "632600"}, {id: "3006", areaID: "632626", area: "\u739b\u591a\u53bf", fatherID: "632600"}, {id: "3007", areaID: "632721", area: "\u7389\u6811\u53bf", fatherID: "632700"}, {id: "3008", areaID: "632722", area: "\u6742\u591a\u53bf", fatherID: "632700"}, {id: "3009", areaID: "632723", area: "\u79f0\u591a\u53bf", fatherID: "632700"}, {id: "3010", areaID: "632724", area: "\u6cbb\u591a\u53bf", fatherID: "632700"}, {
        id: "3011",
        areaID: "632725",
        area: "\u56ca\u8c26\u53bf",
        fatherID: "632700"
    }, {id: "3012", areaID: "632726", area: "\u66f2\u9ebb\u83b1\u53bf", fatherID: "632700"}, {id: "3013", areaID: "632801", area: "\u683c\u5c14\u6728\u5e02", fatherID: "632800"}, {id: "3014", areaID: "632802", area: "\u5fb7\u4ee4\u54c8\u5e02", fatherID: "632800"}, {id: "3015", areaID: "632821", area: "\u4e4c\u5170\u53bf", fatherID: "632800"}, {id: "3016", areaID: "632822", area: "\u90fd\u5170\u53bf", fatherID: "632800"}, {id: "3017", areaID: "632823", area: "\u5929\u5cfb\u53bf", fatherID: "632800"}, {id: "3018", areaID: "640101", area: "\u5e02\u8f96\u533a", fatherID: "640100"}, {id: "3019", areaID: "640104", area: "\u5174\u5e86\u533a", fatherID: "640100"}, {id: "3020", areaID: "640105", area: "\u897f\u590f\u533a", fatherID: "640100"}, {
        id: "3021",
        areaID: "640106",
        area: "\u91d1\u51e4\u533a",
        fatherID: "640100"
    }, {id: "3022", areaID: "640121", area: "\u6c38\u5b81\u53bf", fatherID: "640100"}, {id: "3023", areaID: "640122", area: "\u8d3a\u5170\u53bf", fatherID: "640100"}, {id: "3024", areaID: "640181", area: "\u7075\u6b66\u5e02", fatherID: "640100"}, {id: "3025", areaID: "640201", area: "\u5e02\u8f96\u533a", fatherID: "640200"}, {id: "3026", areaID: "640202", area: "\u5927\u6b66\u53e3\u533a", fatherID: "640200"}, {id: "3027", areaID: "640205", area: "\u60e0\u519c\u533a", fatherID: "640200"}, {id: "3028", areaID: "640221", area: "\u5e73\u7f57\u53bf", fatherID: "640200"}, {id: "3029", areaID: "640301", area: "\u5e02\u8f96\u533a", fatherID: "640300"}, {id: "3030", areaID: "640302", area: "\u5229\u901a\u533a", fatherID: "640300"}, {
        id: "3031",
        areaID: "640323",
        area: "\u76d0\u6c60\u53bf",
        fatherID: "640300"
    }, {id: "3032", areaID: "640324", area: "\u540c\u5fc3\u53bf", fatherID: "640300"}, {id: "3033", areaID: "640381", area: "\u9752\u94dc\u5ce1\u5e02", fatherID: "640300"}, {id: "3034", areaID: "640401", area: "\u5e02\u8f96\u533a", fatherID: "640400"}, {id: "3035", areaID: "640402", area: "\u539f\u5dde\u533a", fatherID: "640400"}, {id: "3036", areaID: "640422", area: "\u897f\u5409\u53bf", fatherID: "640400"}, {id: "3037", areaID: "640423", area: "\u9686\u5fb7\u53bf", fatherID: "640400"}, {id: "3038", areaID: "640424", area: "\u6cfe\u6e90\u53bf", fatherID: "640400"}, {id: "3039", areaID: "640425", area: "\u5f6d\u9633\u53bf", fatherID: "640400"}, {id: "3040", areaID: "640501", area: "\u5e02\u8f96\u533a", fatherID: "640500"}, {
        id: "3041",
        areaID: "640502",
        area: "\u6c99\u5761\u5934\u533a",
        fatherID: "640500"
    }, {id: "3042", areaID: "640521", area: "\u4e2d\u5b81\u53bf", fatherID: "640500"}, {id: "3043", areaID: "640522", area: "\u6d77\u539f\u53bf", fatherID: "640500"}, {id: "3044", areaID: "650101", area: "\u5e02\u8f96\u533a", fatherID: "650100"}, {id: "3045", areaID: "650102", area: "\u5929\u5c71\u533a", fatherID: "650100"}, {id: "3046", areaID: "650103", area: "\u6c99\u4f9d\u5df4\u514b\u533a", fatherID: "650100"}, {id: "3047", areaID: "650104", area: "\u65b0\u5e02\u533a", fatherID: "650100"}, {id: "3048", areaID: "650105", area: "\u6c34\u78e8\u6c9f\u533a", fatherID: "650100"}, {id: "3049", areaID: "650106", area: "\u5934\u5c6f\u6cb3\u533a", fatherID: "650100"}, {id: "3050", areaID: "650107", area: "\u8fbe\u5742\u57ce\u533a", fatherID: "650100"}, {
        id: "3051",
        areaID: "650108",
        area: "\u4e1c\u5c71\u533a",
        fatherID: "650100"
    }, {id: "3052", areaID: "650121", area: "\u4e4c\u9c81\u6728\u9f50\u53bf", fatherID: "650100"}, {id: "3053", areaID: "650201", area: "\u5e02\u8f96\u533a", fatherID: "650200"}, {id: "3054", areaID: "650202", area: "\u72ec\u5c71\u5b50\u533a", fatherID: "650200"}, {id: "3055", areaID: "650203", area: "\u514b\u62c9\u739b\u4f9d\u533a", fatherID: "650200"}, {id: "3056", areaID: "650204", area: "\u767d\u78b1\u6ee9\u533a", fatherID: "650200"}, {id: "3057", areaID: "650205", area: "\u4e4c\u5c14\u79be\u533a", fatherID: "650200"}, {id: "3058", areaID: "652101", area: "\u5410\u9c81\u756a\u5e02", fatherID: "652100"}, {id: "3059", areaID: "652122", area: "\u912f\u5584\u53bf", fatherID: "652100"}, {id: "3060", areaID: "652123", area: "\u6258\u514b\u900a\u53bf", fatherID: "652100"}, {
        id: "3061",
        areaID: "652201",
        area: "\u54c8\u5bc6\u5e02",
        fatherID: "652200"
    }, {id: "3062", areaID: "652222", area: "\u5df4\u91cc\u5764\u54c8\u8428\u514b\u81ea\u6cbb\u53bf", fatherID: "652200"}, {id: "3063", areaID: "652223", area: "\u4f0a\u543e\u53bf", fatherID: "652200"}, {id: "3064", areaID: "652301", area: "\u660c\u5409\u5e02", fatherID: "652300"}, {id: "3065", areaID: "652302", area: "\u961c\u5eb7\u5e02", fatherID: "652300"}, {id: "3066", areaID: "652303", area: "\u7c73\u6cc9\u5e02", fatherID: "652300"}, {id: "3067", areaID: "652323", area: "\u547c\u56fe\u58c1\u53bf", fatherID: "652300"}, {id: "3068", areaID: "652324", area: "\u739b\u7eb3\u65af\u53bf", fatherID: "652300"}, {id: "3069", areaID: "652325", area: "\u5947\u53f0\u53bf", fatherID: "652300"}, {id: "3070", areaID: "652327", area: "\u5409\u6728\u8428\u5c14\u53bf", fatherID: "652300"}, {
        id: "3071",
        areaID: "652328",
        area: "\u6728\u5792\u54c8\u8428\u514b\u81ea\u6cbb\u53bf",
        fatherID: "652300"
    }, {id: "3072", areaID: "652701", area: "\u535a\u4e50\u5e02", fatherID: "652700"}, {id: "3073", areaID: "652722", area: "\u7cbe\u6cb3\u53bf", fatherID: "652700"}, {id: "3074", areaID: "652723", area: "\u6e29\u6cc9\u53bf", fatherID: "652700"}, {id: "3075", areaID: "652801", area: "\u5e93\u5c14\u52d2\u5e02", fatherID: "652800"}, {id: "3076", areaID: "652822", area: "\u8f6e\u53f0\u53bf", fatherID: "652800"}, {id: "3077", areaID: "652823", area: "\u5c09\u7281\u53bf", fatherID: "652800"}, {id: "3078", areaID: "652824", area: "\u82e5\u7f8c\u53bf", fatherID: "652800"}, {id: "3079", areaID: "652825", area: "\u4e14\u672b\u53bf", fatherID: "652800"}, {id: "3080", areaID: "652826", area: "\u7109\u8006\u56de\u65cf\u81ea\u6cbb\u53bf", fatherID: "652800"}, {
        id: "3081",
        areaID: "652827",
        area: "\u548c\u9759\u53bf",
        fatherID: "652800"
    }, {id: "3082", areaID: "652828", area: "\u548c\u7855\u53bf", fatherID: "652800"}, {id: "3083", areaID: "652829", area: "\u535a\u6e56\u53bf", fatherID: "652800"}, {id: "3084", areaID: "652901", area: "\u963f\u514b\u82cf\u5e02", fatherID: "652900"}, {id: "3085", areaID: "652922", area: "\u6e29\u5bbf\u53bf", fatherID: "652900"}, {id: "3086", areaID: "652923", area: "\u5e93\u8f66\u53bf", fatherID: "652900"}, {id: "3087", areaID: "652924", area: "\u6c99\u96c5\u53bf", fatherID: "652900"}, {id: "3088", areaID: "652925", area: "\u65b0\u548c\u53bf", fatherID: "652900"}, {id: "3089", areaID: "652926", area: "\u62dc\u57ce\u53bf", fatherID: "652900"}, {id: "3090", areaID: "652927", area: "\u4e4c\u4ec0\u53bf", fatherID: "652900"}, {
        id: "3091",
        areaID: "652928",
        area: "\u963f\u74e6\u63d0\u53bf",
        fatherID: "652900"
    }, {id: "3092", areaID: "652929", area: "\u67ef\u576a\u53bf", fatherID: "652900"}, {id: "3093", areaID: "653001", area: "\u963f\u56fe\u4ec0\u5e02", fatherID: "653000"}, {id: "3094", areaID: "653022", area: "\u963f\u514b\u9676\u53bf", fatherID: "653000"}, {id: "3095", areaID: "653023", area: "\u963f\u5408\u5947\u53bf", fatherID: "653000"}, {id: "3096", areaID: "653024", area: "\u4e4c\u6070\u53bf", fatherID: "653000"}, {id: "3097", areaID: "653101", area: "\u5580\u4ec0\u5e02", fatherID: "653100"}, {id: "3098", areaID: "653121", area: "\u758f\u9644\u53bf", fatherID: "653100"}, {id: "3099", areaID: "653122", area: "\u758f\u52d2\u53bf", fatherID: "653100"}, {id: "3100", areaID: "653123", area: "\u82f1\u5409\u6c99\u53bf", fatherID: "653100"}, {
        id: "3101",
        areaID: "653124",
        area: "\u6cfd\u666e\u53bf",
        fatherID: "653100"
    }, {id: "3102", areaID: "653125", area: "\u838e\u8f66\u53bf", fatherID: "653100"}, {id: "3103", areaID: "653126", area: "\u53f6\u57ce\u53bf", fatherID: "653100"}, {id: "3104", areaID: "653127", area: "\u9ea6\u76d6\u63d0\u53bf", fatherID: "653100"}, {id: "3105", areaID: "653128", area: "\u5cb3\u666e\u6e56\u53bf", fatherID: "653100"}, {id: "3106", areaID: "653129", area: "\u4f3d\u5e08\u53bf", fatherID: "653100"}, {id: "3107", areaID: "653130", area: "\u5df4\u695a\u53bf", fatherID: "653100"}, {id: "3108", areaID: "653131", area: "\u5854\u4ec0\u5e93\u5c14\u5e72\u5854\u5409\u514b\u81ea\u6cbb\u53bf", fatherID: "653100"}, {id: "3109", areaID: "653201", area: "\u548c\u7530\u5e02", fatherID: "653200"}, {id: "3110", areaID: "653221", area: "\u548c\u7530\u53bf", fatherID: "653200"}, {
        id: "3111",
        areaID: "653222",
        area: "\u58a8\u7389\u53bf",
        fatherID: "653200"
    }, {id: "3112", areaID: "653223", area: "\u76ae\u5c71\u53bf", fatherID: "653200"}, {id: "3113", areaID: "653224", area: "\u6d1b\u6d66\u53bf", fatherID: "653200"}, {id: "3114", areaID: "653225", area: "\u7b56\u52d2\u53bf", fatherID: "653200"}, {id: "3115", areaID: "653226", area: "\u4e8e\u7530\u53bf", fatherID: "653200"}, {id: "3116", areaID: "653227", area: "\u6c11\u4e30\u53bf", fatherID: "653200"}, {id: "3117", areaID: "654002", area: "\u4f0a\u5b81\u5e02", fatherID: "654000"}, {id: "3118", areaID: "654003", area: "\u594e\u5c6f\u5e02", fatherID: "654000"}, {id: "3119", areaID: "654021", area: "\u4f0a\u5b81\u53bf", fatherID: "654000"}, {id: "3120", areaID: "654022", area: "\u5bdf\u5e03\u67e5\u5c14\u9521\u4f2f\u81ea\u6cbb\u53bf", fatherID: "654000"}, {
        id: "3121",
        areaID: "654023",
        area: "\u970d\u57ce\u53bf",
        fatherID: "654000"
    }, {id: "3122", areaID: "654024", area: "\u5de9\u7559\u53bf", fatherID: "654000"}, {id: "3123", areaID: "654025", area: "\u65b0\u6e90\u53bf", fatherID: "654000"}, {id: "3124", areaID: "654026", area: "\u662d\u82cf\u53bf", fatherID: "654000"}, {id: "3125", areaID: "654027", area: "\u7279\u514b\u65af\u53bf", fatherID: "654000"}, {id: "3126", areaID: "654028", area: "\u5c3c\u52d2\u514b\u53bf", fatherID: "654000"}, {id: "3127", areaID: "654201", area: "\u5854\u57ce\u5e02", fatherID: "654200"}, {id: "3128", areaID: "654202", area: "\u4e4c\u82cf\u5e02", fatherID: "654200"}, {id: "3129", areaID: "654221", area: "\u989d\u654f\u53bf", fatherID: "654200"}, {id: "3130", areaID: "654223", area: "\u6c99\u6e7e\u53bf", fatherID: "654200"}, {
        id: "3131",
        areaID: "654224",
        area: "\u6258\u91cc\u53bf",
        fatherID: "654200"
    }, {id: "3132", areaID: "654225", area: "\u88d5\u6c11\u53bf", fatherID: "654200"}, {id: "3133", areaID: "654226", area: "\u548c\u5e03\u514b\u8d5b\u5c14\u8499\u53e4\u81ea\u6cbb\u53bf", fatherID: "654200"}, {id: "3134", areaID: "654301", area: "\u963f\u52d2\u6cf0\u5e02", fatherID: "654300"}, {id: "3135", areaID: "654321", area: "\u5e03\u5c14\u6d25\u53bf", fatherID: "654300"}, {id: "3136", areaID: "654322", area: "\u5bcc\u8574\u53bf", fatherID: "654300"}, {id: "3137", areaID: "654323", area: "\u798f\u6d77\u53bf", fatherID: "654300"}, {id: "3138", areaID: "654324", area: "\u54c8\u5df4\u6cb3\u53bf", fatherID: "654300"}, {id: "3139", areaID: "654325", area: "\u9752\u6cb3\u53bf", fatherID: "654300"}, {
        id: "3140",
        areaID: "654326",
        area: "\u5409\u6728\u4e43\u53bf",
        fatherID: "654300"
    }, {id: "3141", areaID: "659001", area: "\u77f3\u6cb3\u5b50\u5e02", fatherID: "659000"}, {id: "3142", areaID: "659002", area: "\u963f\u62c9\u5c14\u5e02", fatherID: "659000"}, {id: "3143", areaID: "659003", area: "\u56fe\u6728\u8212\u514b\u5e02", fatherID: "659000"}, {id: "3144", areaID: "659004", area: "\u4e94\u5bb6\u6e20\u5e02", fatherID: "659000"}];
    var obj = {};
    renderArea = function (items, vals) {
        if (!items.area)return;
        items.area.options.length = 0;
        items.area.options.add(new Option('区/县', ''));
        var op = items.city.options[items.city.options.selectedIndex];
        var pid = $(op).attr('pid');
        //选择地区
        if (pid) {
            $.each(area, function (i, val) {
                if (val.fatherID == pid) {
                    var opt = new Option(val.area, val.area);
                    items.area.options.add(opt);
                }
            });
        }
        if (vals.area && $(items.area).find('[value="' + vals.area + '"]').length == 1) {
            $(items.area).val(vals.area);
        }
    }
    renderCity = function (items, vals) {
        if (!items.city)return;
        items.city.options.length = 0;
        //添加标题
        items.city.options.add(new Option('市', ''));
        var op = items.province.options[items.province.options.selectedIndex];
        var pid = $(op).attr('pid');
        //选择省级
        if (pid) {
            $.each(city, function (i, val) {
                if (val.fatherID == pid) {
                    var opt = new Option(val.city, val.city);
                    $(opt).attr('pid', val.cityID);
                    items.city.options.add(opt);
                }
            });
        }

        if (vals.city && $(items.city).find('[value="' + vals.city + '"]').length == 1) {
            $(items.city).val(vals.city);
        }
        if (items.area) {
            $(items.city).on('change', function () {
                renderArea(items, vals);
            })
            $(items.city).trigger('change');
        }
    }
    obj.render = function (items, vals) {
        if (!items.province)return;
        items.province.options.length = 0;
        //添加标题
        items.province.options.add(new Option('省/直辖市', ''));
        $.each(province, function (i, val) {
            //添加列表元素
            var opt = new Option(val.province, val.province);
            $(opt).attr('pid', val.provinceID);
            items.province.options.add(opt);
        })
        if (vals.province) {
            $(items.province).val(vals.province);
        }
        //渲染城市
        if (items.city) {
            $(items.province).on('change', function () {
                renderCity(items, vals);
            })
            $(items.province).trigger('change');
        }
    }
    return obj;
})