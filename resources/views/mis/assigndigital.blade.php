{{-- resources/views/pm/your_view.blade.php --}}

@include('mis.header')

<div class="main-wrapper">

    {{-- Sidebar --}}
    @include('mis.Sidebar');

    {{-- Page Wrapper --}}
    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">

            {{-- Page Header --}}
            @include('mis.breadcum')

            {{-- Alerts --}}


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <table id="myTable1"  class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>id</th>
                                        <th>Educator Name</th>

                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Weight</th>
                                        <th>Height</th>
                                        <th>Doctor Name</th>
                                        <th>Date</th>
                                        <th>Digital Educator</th>
                                    </tr>
                                </thead>

                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

@include('mis.footer')
<script>

$(document).ready(function () {
$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});
    if ($.fn.DataTable.isDataTable('#myTable1')) {
    $('#myTable1').DataTable().clear().destroy();
}

    // Initialize DataTable with server-side processing
    $('#myTable1').DataTable({
        dom: 'Bfrtip',
        buttons: [],
        processing: true,
        serverSide: true,
        responsive: true,
        scrollX: true,
        ajax: {
            url: "{{ url('admin-Get-Patients') }}",   // <-- create this route in Laravel
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: function (d) {
                return JSON.stringify({
                    draw: d.draw,
                    start: d.start,
                    length: d.length,
                    search: {
                        value: d.search.value
                    },
                    order: d.order,
                    columns: d.columns
                });
            },
            dataSrc: function (json) {
                if (!json || json.error) {
                    console.error(json?.error || 'Empty response');
                    return [];
                }
                return json.data;
            }
        },
        columns: [
            { data: 'sl_no' },
            { data: 'uuid' , visible: false },              // Sr (serial no / patient id)
            { data: 'educator_name' },   // Educator Name
            { data: 'patient_name' },            // Patient Name
            { data: 'gender' },          // Gender
            { data: 'age' },             // Age
            { data: 'weight' },          // Weight
            { data: 'height' },          // Height
            { data: 'doctor_name' },     // Doctor Name
            { data: 'date' },            // Date
           {
    data: 'digital_educator',
    render: function (data, type, row) {
        if (data === "N/A") {
            return `
                <div>
                  <select class="form-select form-select-sm digital-educator-select" data-uuid="${row.uuid}">
                    <option value="">Loading...</option>
                  </select>
                  <button class="btn btn-sm btn-primary mt-1 assign-inline-btn" data-uuid="${row.uuid}">Assign</button>
                </div>
            `;
        }
        return data;
    }
} // Digital Educator
        ],
        error: function (xhr, error, thrown) {
            console.error('DataTables error:', error, thrown);
            $('#myTable1').DataTable().clear().draw();
        }
    });
});
$('#myTable1').on('draw.dt', function () {
    // Fetch educators list once per draw
    $.ajax({
        url: 'admin-Get-Digital-Educators-patient',
        type: 'GET',
        success: function (res) {
            $('.digital-educator-select').each(function () {
                let uuid = $(this).data('uuid');
                if ($(this).find('option').length <= 1) { // only "Loading..." exists
                    let options = '<option value="">Select Educator</option>';
                    $.each(res, function (i, e) {
                        options += `<option value="${e.id}">${e.full_name}</option>`;
                    });
                    $(this).html(options);
                }
            });
        }
    });
});
$(document).on('click', '.assign-inline-btn', function () {
    let uuid = $(this).data('uuid');
    let select = $(`.digital-educator-select[data-uuid="${uuid}"]`);
    let educatorId = select.val();

    if (!educatorId) {
        toastr.error("Please select a digital educator.");
        return;
    }

    $.ajax({
        url: 'admin-Assign-Digital-Educator-patient',
        type: 'POST',
        data: {
            uuid: uuid,
            digital_educator_id: educatorId,
            _token: '{{ csrf_token() }}'
        },
        success: function () {
            $('#myTable1').DataTable().ajax.reload(null, false);
        },
        error: function () {
            toastr.error("Error assigning digital educator.");
        }
    });
});


 // function openform(id) {
    //     window.location.href = '{{ url("Digital-educator-follow-up-form") }}?patient_id=' + id;
    // }
</script>






