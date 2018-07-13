<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1,user-scalable=no"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="grey"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="format-detection" content="telephone=no"/>
    <title>账单</title>
    <style>
        *{
            -webkit-touch-callout:none;
            -webkit-user-select:none;
            -khtml-user-select:none;
            -moz-user-select:none;
            -ms-user-select:none;
            user-select:none;
        }
        body {
            font-size: 14px;
        }
    </style>
</head>
<body>
    @if ($info)
        <div style="font-size: 18px;padding-top: 30px;text-align: center;">{{ $info }}</div>
    @else
        <div style="padding:10px;background: #f4f4f4;">
            <div style="color: gray;">最近30天的收支情况</div>
        </div>
        @foreach($bill as $data)
            <div style="padding:10px 0px;border-bottom: 1px solid #f4f4f4;">
                <table style="border: 0px;width: 100%;">
                    <tr>
                        <td style="width: 40px;">
                            @if ($data["business_type"] == "video")
                                <div style="background: cornsilk;border-radius: 18px;border: 1px solid darkmagenta;color: cadetblue;width: 32px;height: 32px;display:flex;"><div style="margin: auto;font-size: 22px;">V</div></div>
                            @else
                                <div style="background: cornsilk;border-radius: 18px;border: 1px solid darkmagenta;color: cadetblue;width: 32px;height: 32px;display:flex;"><div style="margin: auto;font-size: 22px;">￥</div></div>
                            @endif
                        </td>
                        <td>
                            @if ($data["status"] == "sq")
                                <div style="padding-top: 5px;">
                                    提现申请中
                                </div>
                            @else
                                <div style="font-size: 16px;width: 170px;height: 16px;overflow: hidden;padding: 5px 0;text-overflow: ellipsis;white-space: nowrap;">{{ $data["description"] }}</div>
                            @endif
                            <div style="color: grey;padding-top: 5px;">
                                @if (Carbon\Carbon::parse($data["created_at"])->isToday() == true)
                                    今天 {{ date("H:i",strtotime($data["created_at"])) }}
                                @elseif (Carbon\Carbon::parse($data["created_at"])->isYesterday() == true)
                                    昨天 {{ date("H:i",strtotime($data["created_at"])) }}
                                @else
                                    {{ date("Y-m-d H:i",strtotime($data["created_at"])) }}
                                @endif
                            </div>
                        </td>

                        <td style="width: 100px;">
                            <div style="text-align: right;padding: 5px 0;font-size: 16px;">
                            @if ($data["amount"] > 0)
                                <span style="color:red;font-weight: bolder;">+{{ $data["amount"] }}</span>
                            @else
                                <span style="font-weight: bolder;">{{ $data["amount"] }}</span>
                            @endif
                            @if ($data["currency"] == "diamond")
                                钻石
                            @else
                                点券
                            @endif
                            </div>
                            <div style="text-align: right;color: grey;">余额: {{ $data["balance"] }}</div>

                        </td>
                    </tr>
                </table>
            </div>
        @endforeach
    @endif
</body>
</html>
