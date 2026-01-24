@include('educator.head')

<div class="main-wrapper">
    @include('educator.header')
    @include('educator.Sidebar')

    <script src="{{asset('js/jquery.min.js')}}"></script>
    <style>
        .mandatory {
            color: red;
            font-weight: bold;
        }
    </style>

    <div class="page-wrapper" style="min-height: 653px;">
        <div class="content container-fluid">
            @include('educator.breadcum')

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
                                    <!-- Populate list properly from backend in future -->
                                    <option value="Brand A">Brand A</option>
                                    <option value="Brand B">Brand B</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Competitor Brand Prescribed <span class='mandatory'>*</span></label>
                                <select class="form-select form-control" name="competitor_brand" id="competitor_brand" required>
                                    <option value="">--Select--</option>
                                    <option value="Competitor A">Competitor A</option>
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

                        <div class="mt-4 clearfix">
                             <a href="{{ route('educator.patient.step3', ['uuid' => $uuid]) }}" class="btn btn-secondary float-left"><i class="fa fa-arrow-left"></i> Back</a>
                            <button type="button" class="btn btn-primary float-right btn-next" onclick="submitFinal()">Submit <i class="fa fa-check"></i></button>
                        </div>
                    </div>
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
                alert('Please select a valid image file (JPEG, JPG, PNG, or WEBP)');
                input.value = '';
                return;
            }

            // Validate file size (max 5MB)
            if (file.size > 5 * 1024 * 1024) {
                alert('File size must be less than 5MB');
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
        getBrands();
        getCompetitors();
    });

    function getBrands() {
        $.ajax({
            url: "{{ url('counsellor/getMedicines') }}",
            type: "GET", 
            success: function(response) {
                let options = '<option value="">--Select--</option>';
                if(response.data) {
                    response.data.forEach(function(item) {
                        // Updated key based on JSON response: medicine_name
                        options += `<option value="${item.medicine_name}">${item.medicine_name} - ${item.medicine_header}</option>`;
                    });
                }
                $('#brand_prescribed').html(options);
            }
        });
    }

    function getCompetitors() {
        $.ajax({
            url: "{{ url('counsellor/getCompetitors') }}",
            type: "GET",
            success: function(response) {
                let options = '<option value="">--Select--</option>';
                 if(response.data) {
                    response.data.forEach(function(item) {
                        // Updated key based on JSON response: compitetor_name
                        options += `<option value="${item.compitetor_name}">${item.compitetor_name}</option>`;
                    });
                }
                $('#competitor_brand').html(options);
            }
        });
    }

    async function compressImage(file, maxWidth = 1024, quality = 0.7) {
        return new Promise((resolve, reject) => {
            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = event => {
                const img = new Image();
                img.src = event.target.result;
                img.onload = () => {
                    const canvas = document.createElement('canvas');
                    let width = img.width;
                    let height = img.height;

                    if (width > maxWidth) {
                        height = Math.round((height * maxWidth) / width);
                        width = maxWidth;
                    }

                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);
                    canvas.toBlob(blob => {
                        if (!blob) {
                            reject(new Error('Canvas is empty'));
                            return;
                        }
                        resolve(blob);
                    }, 'image/webp', quality);
                };
                img.onerror = error => reject(error);
            };
            reader.onerror = error => reject(error);
        });
    }

    async function submitFinal() {
        const brand = $('#brand_prescribed').val();
         // Basic Validation check
        if (!brand) {
            toastr.error('Please fill mandatory fields');
            return;
        }

        const btn = $('.btn-next');
        btn.prop('disabled', true).html('Submitting... <i class="fa fa-spinner fa-spin"></i>');

        const form = document.getElementById('step4Form');
        const formData = new FormData(form);
        
        // Handle compression for Prescription File
        const presInput = document.getElementById('prescription_file');
        if (presInput && presInput.files[0]) {
            try {
                // tostr info to let user know we are processing
                toastr.info('Compressing prescription image...');
                const compressedPres = await compressImage(presInput.files[0]);
                // Replace the file in FormData with the compressed blob
                // We keep the original name but change extension to .webp since we encode as webp
                let newName = presInput.files[0].name.split('.').slice(0, -1).join('.') + '.webp';
                formData.set('prescription_file', compressedPres, newName);
            } catch (e) {
                console.error("Prescription compression failed, sending original", e);
            }
        }

        // Handle compression for Consent Form
        const conInput = document.getElementById('consent_form');
        if (conInput && conInput.files[0]) {
             try {
                toastr.info('Compressing consent image...');
                const compressedCon = await compressImage(conInput.files[0]);
                 let newName = conInput.files[0].name.split('.').slice(0, -1).join('.') + '.webp';
                formData.set('consent_form', compressedCon, newName);
            } catch (e) {
                console.error("Consent compression failed, sending original", e);
            }
        }
        
        try {
            const response = await fetch("{{ url('counsellor/Patient-Inquiry-Post') }}", {
                method: 'POST',
                body: formData,
                headers: {
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            
            if (result.success) {
                toastr.success('Patient Saved Successfully!');
                // Delay redirect to show the toast message
                setTimeout(function() {
                    window.location.href = "{{ url('counsellor/patientlist') }}";
                }, 1500);
            } else {
                toastr.error('Error: ' + result.message);
                btn.prop('disabled', false).html('Submit <i class="fa fa-check"></i>');
            }
        } catch (error) {
            console.error(error);
            toastr.error('An error occurred while submitting the form. (Request might be too large)');
            btn.prop('disabled', false).html('Submit <i class="fa fa-check"></i>');
        }
    }
</script>
@include('educator.footer')
