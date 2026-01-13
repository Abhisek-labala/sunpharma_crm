@include('educator/head')
@include('educator/header')
<style>
    .card-body {
        padding: 1.5rem;
    }
    .table-responsive {
        margin-top: 20px;
    }
</style>

<div class="main-wrapper">
    {{-- Sidebar --}}
    @include('educator.Sidebar')
    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            <!-- Breadcrumb -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title">Attendance</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard.educator') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Attendance</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Breadcrumb -->

            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h4>Current Status: 
                                <span class="badge bg-{{ $todayAttendance ? 'success' : 'warning' }}">
                                    {{ $todayAttendance ? 'Marked (In Time: ' . \Carbon\Carbon::parse($todayAttendance->in_time)->format('h:i A') . ')' : 'Not Marked' }}
                                </span>
                            </h4>
                            @if($todayAttendance && !$todayAttendance->latitude)
                                <div class="alert alert-info mt-2" id="locationAlert">
                                    <i class="fa fa-map-marker"></i> Capturing your location... Please allow location access.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table id="attendanceTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>In Time</th>
                                    <th>Out Time</th>
                                    <th>IP Address</th>
                                    <th>Location</th>
                                    <th>State</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history as $record)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($record->date)->format('d-m-Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($record->in_time)->format('h:i A') }}</td>
                                    <td>{{ $record->out_time ? \Carbon\Carbon::parse($record->out_time)->format('h:i A') : '-' }}</td>
                                    <td>{{ $record->ip_address ?? '-' }}</td>
                                    <td>
                                        @if($record->address)
                                            {{ Str::limit($record->address, 50) }}
                                        @elseif($record->latitude)
                                            {{ $record->latitude }}, {{ $record->longitude }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>{{ $record->state ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@include('educator/footer')

<script>
$(document).ready(function() {
    $('#attendanceTable').DataTable({
        order: [[0, 'desc']]
    });

    @if($todayAttendance && !$todayAttendance->latitude)
        getLocation();
    @endif

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            toastr.error("Geolocation is not supported by this browser.");
            $('#locationAlert').removeClass('alert-info').addClass('alert-danger').text("Geolocation not supported.");
        }
    }

    function showPosition(position) {
        let lat = position.coords.latitude;
        let lng = position.coords.longitude;

        // Use Nominatim (OpenStreetMap) for reverse geocoding
        let url = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`;

        $.get(url, function(data) {
            let address = data.display_name;
            let state = data.address.state || '';
            
            // Fetch Public IP
            $.get('https://api.ipify.org?format=json', function(ipData) {
                updateAttendance(lat, lng, address, state, ipData.ip);
            }).fail(function() {
                updateAttendance(lat, lng, address, state, null);
            });
            
        }).fail(function() {
            $.get('https://api.ipify.org?format=json', function(ipData) {
                updateAttendance(lat, lng, 'Location captured (Address lookup failed)', '', ipData.ip);
            }).fail(function() {
                updateAttendance(lat, lng, 'Location captured (Address lookup failed)', '', null);
            });
        });
    }

    function updateAttendance(lat, lng, address, state, ip) {
        let data = {
            _token: "{{ csrf_token() }}",
            latitude: lat,
            longitude: lng,
            address: address,
            state: state
        };
        
        if (ip) {
            data.client_ip = ip;
        }

        $.ajax({
            url: "{{ route('educator.attendance.updateLocation') }}",
            type: "POST",
            data: data,
            success: function(response) {
                if(response.success) {
                    toastr.success("Location and IP updated successfully.");
                    $('#locationAlert').removeClass('alert-info').addClass('alert-success').text("Location Captured: " + address);
                    // Optional: Reload page to show in table
                     setTimeout(function(){ location.reload(); }, 2000);
                }
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                toastr.error("Failed to update location.");
            }
        });
    }

    function showError(error) {
        let msg = "";
        switch(error.code) {
            case error.PERMISSION_DENIED:
                msg = "User denied the request for Geolocation. Please enable location services.";
                break;
            case error.POSITION_UNAVAILABLE:
                msg = "Location information is unavailable.";
                break;
            case error.TIMEOUT:
                msg = "The request to get user location timed out.";
                break;
            case error.UNKNOWN_ERROR:
                msg = "An unknown error occurred.";
                break;
        }
        toastr.error(msg);
        $('#locationAlert').removeClass('alert-info').addClass('alert-danger').text(msg);
    }
});
</script>
