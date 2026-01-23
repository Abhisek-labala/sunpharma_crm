@include('digitaleducator.head')

<div class="main-wrapper">
    @include('digitaleducator.header')
     <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />
    <style>
        .select2-container { z-index: 1051 !important; }
        .select2-search__field { width: 100% !important; }
        .select2-container--default .select2-selection--multiple { min-height: 38px; padding: 5px; }
        .mandatory { color: red; font-weight: bold; }
        .error-border { border: 2px solid red !important; }
    </style>

    @include('digitaleducator.Sidebar')

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/select2.min.js')}}"></script>
    <script src="{{asset('js/toastr.min.js')}}"></script>

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            @include('digitaleducator.breadcum')

            <form id="step4Form" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="patient_uuid" value="{{ $uuid }}">

                <!-- Step 4: Brand Details -->
                <div class="card mb-4">
                    <div class="card-header thembutton text-white">
                        <h5 class="mb-0">Brand Details (Step 4/4)</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label d-block">Any SunPharma brand has been Prescribed? <span class='mandatory'>*</span></label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sunpharma_prescribed" id="sp_yes" value="Yes" required>
                                    <label class="form-check-label" for="sp_yes">YES</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="sunpharma_prescribed" id="sp_no" value="No">
                                    <label class="form-check-label" for="sp_no">NO</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Brand Prescribed <span class='mandatory'>*</span></label>
                                <select class="form-select form-control" name="brand_prescribed" id="brand_prescribed" required>
                                    <option value="">--Select--</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Competitor Brand Prescribed <span class='mandatory'>*</span></label>
                                <select class="form-select form-control" name="competitor_brand" id="competitor_brand" required>
                                    <option value="">--Select--</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">If the Prescription is available. Please Upload. <span class='mandatory'>*</span></label>
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control" name="prescription_file" id="prescription_file" accept="image/jpeg,image/jpg,image/png,image/webp" onchange="previewImage(this, 'prescription_preview')">
                                </div>
                                <div id="prescription_preview" class="mt-2"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Upload Patient Consent Form <span class='mandatory'>*</span></label>
                                <div class="d-flex align-items-center">
                                    <input type="file" class="form-control" name="consent_form" id="consent_form" accept="image/jpeg,image/jpg,image/png,image/webp" required onchange="previewImage(this, 'consent_preview')">
                                </div>
                                <div id="consent_preview" class="mt-2"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('digital.patient.step3', ['uuid' => $uuid]) }}" class="btn btn-secondary">Previous</a>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    .preview-container {
        position: relative;
        display: inline-block;
        margin-right: 10px;
    }
    .preview-image {
        max-width: 150px;
        max-height: 150px;
        border: 2px solid #ddd;
        border-radius: 4px;
        padding: 5px;
    }
    .remove-preview {
        position: absolute;
        top: -8px;
        right: -8px;
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        cursor: pointer;
        font-size: 14px;
        line-height: 1;
    }
    .remove-preview:hover {
        background: #c82333;
    }
</style>

<script>
    function previewImage(input, previewId) {
        const previewContainer = document.getElementById(previewId);
        previewContainer.innerHTML = ''; // Clear existing preview

        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                toastr.error('Please select a valid image file (JPEG, JPG, PNG, or WEBP)');
                input.value = '';
                return;
            }

            // Validate file size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                toastr.error('File size must be less than 5MB');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const container = document.createElement('div');
                container.className = 'preview-container';
                
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'preview-image';
                
                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '&times;';
                removeBtn.className = 'remove-preview';
                removeBtn.type = 'button';
                removeBtn.onclick = function() {
                    previewContainer.innerHTML = '';
                    input.value = '';
                };
                
                container.appendChild(img);
                container.appendChild(removeBtn);
                previewContainer.appendChild(container);
            };
            reader.readAsDataURL(file);
        }
    }
    $(document).ready(function() {
        $('.select2').select2({
             placeholder: "-- Select --"
        });

        // Load Medicines
        $.ajax({
            url: "{{ url('digitalcounsellor/getMedicines') }}",
            type: "GET",
            success: function(response) {
                if(response.data) {
                    var html = ''; // Keep default option? Select2 might override
                    $.each(response.data, function(key, value) {
                        html += '<option value="' + value.medicine_name + '">' + value.medicine_name + ' - ' + value.medicine_header+ '</option>';
                    });
                    $('#brand_prescribed').append(html);
                }
            }
        });

        // Load Competitors
        $.ajax({
            url: "{{ url('digitalcounsellor/getCompetitors') }}",
            type: "GET",
            success: function(response) {
                if(response.data) {
                    var html = '';
                    $.each(response.data, function(key, value) {
                        html += '<option value="' + value.compitetor_name + '">' + value.compitetor_name + '</option>';
                    });
                    $('#competitor_brand').append(html);
                }
            }
        });
    });

    $('#step4Form').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $('#submitBtn').prop('disabled', true).text('Submitting...');

        $.ajax({
            url: "{{ route('digital.patient.save.step4') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if(response.success) {
                    toastr.success('Patient Inquiry Submitted Successfully!');
                    setTimeout(function() {
                        window.location.href = "{{ url('dashboard/digitalcounsellor') }}";
                    }, 2000);
                } else {
                    toastr.error('Error: ' + response.message);
                    $('#submitBtn').prop('disabled', false).text('Submit');
                }
            },
            error: function(xhr) {
                var msg = 'Error submitting form';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                toastr.error(msg);
                $('#submitBtn').prop('disabled', false).text('Submit');
            }
        });
    });
</script>
