<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Id card</title>
    <style>
        .id-card {width: 324px;height: 200px;display: inline-block;border: 1px solid #000;border-radius: 8px;margin: 0 5px 7px 0;}.card-header {display: inline-block;width: 314.52px;padding: 7px 5px 3px 5px;font-size: 13px;height: 29px;border-bottom: 1px solid #989898;}.logo {display: inherit;height: 80%;}.logo>img {display: inherit;height: auto;height: 90%;}.title {display: inherit;font-weight: 600;font-size: 14px;margin-left: 9px;vertical-align: top;margin-top: 0px;line-height: 15px;text-align: left;width: 65%;white-space: nowrap;overflow: hidden !important;text-overflow: ellipsis;}.data-table {font-size: 14px;}.data-table, tr, td {border-collapse: collapse;width: 100%;}.data-table>tbody>tr>td {border: 1px solid #969696;padding: 2px 4px;}.data-table>tbody>tr>.col-1 {width: 116px;border-top: 0;border-left: 0;}.data-table>tbody>tr>.col-1>.heading {font-weight: 600;}.data-table>tbody>tr>.col-2 {width: calc(100% - 116px);border-top: 0;border-right: 0;max-width: 180px;text-overflow: ellipsis;white-space: nowrap;overflow: hidden !important;}.data-table>tbody>tr>.col-2>.data {letter-spacing: 0.5px;}.identity-section {display: inline-block;vertical-align: top;}.identity-section>.qr-code {display: inherit;vertical-align: inherit;width: 22%;}.identity-section>.qr-code img {width: 100%;padding: 1px;border-radius: 10px;margin-top: 0px;}.identity-section>.details {display: inherit;vertical-align: inherit;width: calc(100% - 45.5%);padding: 0 0px;font-size: 12px;margin: 0 0 0 -4px;}.identity-section>.details>table {padding: 0 0px;font-size: 12px;margin-top: 8px;width: 100%;height: 18%;max-height: 18%;min-height: 18%;text-align: left;position: relative;}.identity-section>.photo {text-align: center;display: inherit;vertical-align: inherit;padding: 2px 8px 0px 0px;width: 20%;float: right;}.identity-section>.photo>img {width: 100%;height: 68px;}.brand-section {display: block;position: relative;text-align: center;font-size: 10px;font-family: arial;margin-top: 6px;letter-spacing: .6;margin-right: 9px;border-top: 1px solid #c5c5c5;margin-left: 5px;padding: 5px 0px 0 0;border-radius: 0;}.brand-section>img {width: 26%;}span.heading {font-weight: 600;}
    </style>
</head>
<body>
    @foreach($employees as $emp)
    <div class="id-card">
        <div class="card-header">
            <div class="logo">
                <img src="https://storage.googleapis.com/ytpl/truein/prod/Yugstar404/21593842553e9c59a310246205082268b4b1ab85e76.png" alt="">
            </div>
            <div class="title">
                <span>ID Card for Contract Employee </span><br>
                <span>Project: {{@$emp->work->site->name}}</span>
            </div>
        </div>
        <div class="card-body">
            <table class="data-table">
                <tbody>
                    <tr>
                        <td class="col-1">
                            <span class="heading"> Contractor Agency </span>
                        </td>
                        <td class="col-2"><span class="data"> {{@$emp->work->site->name}}</span></td>
                    </tr>
                    <tr>
                        <td class="col-1"><span class="heading"> Person Name </span></td>
                        <td class="col-2"><span class="data"> {{@$emp->name}} </span></td>
                    </tr>
                    <tr>
                        <td class="col-1"><span class="heading"> Department </span></td>
                        <td class="col-2"><span class="data">{{@$emp->work->department->name}} </span></td>
                    </tr>
                    <tr>
                        <td class="col-1"><span class="heading"> Govt. ID. </span></td>
                        <td class="col-2">
                            <span class="data"> : {{@$emp->id}} </span>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="identity-section">
                <div class="qr-code">
                    <img src="https://storage.googleapis.com/ytpl/truein/prod/NinjaTe389/compress561aa5c5de279f03021a4462bee5760d.png" alt="">
                </div>
                <div class="details">
                    <table>
                        <tbody>
                            <tr>
                                <td style="width: 42%; vertical-align: top;"> <span class="heading">Designation: {{@$emp->work->designation->name}}</span>
                                </td>
                                <td
                                    style="display: -webkit-box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;overflow: hidden;text-overflow: ellipsis;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="brand-section">
                        <span class="brand"> Powered By </span>
                        <img src="https://dashboard.truein.com/staff/assets/images/truein/Truein_final.png" alt="">
                    </div>
                </div>
                <div class="photo">
                    @if($emp->image != "")
                    <?php
                        $url = URL::to('/').'/storage/profile/'.''.$emp->image
                    ?>
                    <img src="{{$url}}"  alt="">
                    @else
                        <img src="https://dashboard.truein.com/staff/assets/staff_imgs/default-img.png"  alt="">
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
    @endforeach
</body>
<script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
       window.print();
    });
</script>
</html>