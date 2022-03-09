<div class="container p-0">
    <div class="row ">
        <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 pl-md-0">&nbsp;</div>
        <div class="col-sm-12 col-md-12 col-lg-8 col-xl-8 pl-md-0">
            <div class="align-items-center">
                <div class="card card-with-shadow border-0 h-100" style="text-align: center;">
                    <div class="card-header p-primary bg-transparent">
                        <h1 class="card-title m-0">Water Meter Reading</h1>
                    </div>
                    <div class="card-body align-items-center">
                        <p> <span style="font-weight: 600;">House Lot</span> : {{ $house_lot ? $house_lot->house_lot_num : 'N/A' }}</p>
                        <p> <span style="font-weight: 600;">Branch</span> : {{ $branch ? $branch->name : 'N/A' }}</p>
                        <p> <span style="font-weight: 600;">S/N</span> : {{ $house_lot ? $house_lot->serial_num : 'N/A' }}</p>
                        <p> <span style="font-weight: 600;">Current reading</span> : {{ $water_reading->current_reading }}</p>
                        <p> <span style="font-weight: 600;">Last Reading</span> : {{ $water_reading->last_reading ?? 'not available' }}</p>
                        <p> 
                            <span style="font-weight: 600;">Usage</span> : {{ $water_reading->current_reading - $water_reading->last_reading }}
                        </p>
                        <p> <span style="font-weight: 600;">Date Submitted</span> : {{ \Carbon\Carbon::parse($water_reading->created_at)->format('Y/m/d h:i A') }}</p>
                        <p> <span style="font-weight: 600;">Image</span> </p>
                        <p> <img src="{{ public_path('/storage/images/meter_readings/' .$water_reading->image) }}" alt="not available"></p>
                        
                        <p> <span style="font-weight: 600;">Remark</span> : {{ $water_reading->remark ?? 'not available' }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-12 col-lg-2 col-xl-2 pl-md-0">&nbsp;</div>
    </div>
</div>