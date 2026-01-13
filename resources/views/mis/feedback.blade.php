{{-- Include Header --}}
@include('mis.header')

<!-- Main Wrapper -->
<div class="main-wrapper">

    <!-- Sidebar -->
    @include('mis.Sidebar')
    <!-- /Sidebar -->

    <!-- Page Wrapper -->
    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">

            <!-- Page Header -->
            @include('mis.breadcum')
            <!-- /Page Header -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <table id="myTable" class="display">
                                <thead>
                                    <tr>
                                        <th>Sr</th>
                                        <th>Educator Name</th>
                                        <th>Digital Educator Name</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Age</th>
                                        <th>Height</th>
                                        <th>Weight</th>
                                        <th>Doctor Name</th>
                                        <th>Cipla Brand Prescribed</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $sr = 1; @endphp
                                    @foreach($EducatorPatientList as $PatientItem)
                                        @php
                                            $educator_name = $PatientItem['educator_name'];
                                            $digital_educator_name = $PatientItem['digital_educator_name'];
                                            $name = $PatientItem['patient_name'];
                                            $gender = $PatientItem['gender'];
                                            $age = $PatientItem['age'];
                                            $height = $PatientItem['height'];
                                            $weight = $PatientItem['weight'];
                                            $doctorName = $PatientItem['doctor_name'] ?? '';
                                            $brand = $PatientItem['brand'] ?? '';
                                            $date = $PatientItem['date'];
                                            $id = $PatientItem['id'];
                                        @endphp
                                        <tr>
                                            <td>{{ $sr }}</td>
                                            <td>{{ $educator_name }}</td>
                                            <td>{{ $digital_educator_name }}</td>
                                            <td>{{ $name }}</td>
                                            <td>{{ $gender }}</td>
                                            <td>{{ $age }}</td>
                                            <td>{{ $height }}</td>
                                            <td>{{ $weight }}</td>
                                            <td>{{ $doctorName }}</td>
                                            <td>{{ $brand }}</td>
                                            <td>{{ $date }}</td>
                                            <td>
                                                <button class="btn btn-success" onclick="openform({{ $id }})">
                                                    View Form
                                                </button>
                                            </td>
                                        </tr>
                                        @php $sr++; @endphp
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- /Main Wrapper -->

{{-- Include Footer --}}
@include('mis.footer')

<script>
     window.openForm = function (patientId) {
        window.location.href = '/mis/educator-follow-up-form?patient_id=' + patientId;
    };
</script>
