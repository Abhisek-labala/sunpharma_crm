<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EducatorController;
use App\Http\Controllers\FeedBackController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PmController;
use App\Http\Controllers\misController;
use App\Http\Controllers\digitalController;
use App\Http\Controllers\RmController;
use App\Http\Controllers\yogaController;
use App\Http\Controllers\EducatorAttendanceController;
use App\Http\Controllers\RmAttendanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login.Login');
});
Route::get('/rclogin', [AuthController::class, 'rmLogin'])->name('rmlogin');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/rclogin', [AuthController::class, 'rmloginpost'])->name('rmlogin.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/rclogout', [AuthController::class, 'rmlogout'])->name('rmlogout');
Route::middleware(['check.session'])->group(function () {
    // Protected routes go here
    Route::get('/private-file/{path}', [FileController::class, 'show'])
        ->where('path', '.*')
        ->name('private.file');
});
Route::middleware(['check.session', 'role:counsellor'])->group(function () {
    Route::get('/counsellor/dashboard', [DashboardController::class, 'educator'])->name('dashboard.educator');
    Route::get('counsellor/analytics', [EducatorController::class, 'analytics']);
    Route::prefix('charts')->group(function () {
        Route::get('monthly_counseling', [EducatorController::class, 'monthlyCounseling']);
        Route::get('gender_distribution', [EducatorController::class, 'genderDistribution']);
        Route::get('camp_distribution', [EducatorController::class, 'campDistribution']);
        Route::get('blood_pressure', [EducatorController::class, 'bloodPressure']);
        Route::get('obesity_metrics', [EducatorController::class, 'obesityMetrics']);
        Route::get('doctor_metrics', [EducatorController::class, 'doctorMetrics']);
        Route::get('doctornot_metrics', [EducatorController::class, 'doctorNotMetrics']);
    });
    Route::get('/counsellor/campinfo', [EducatorController::class, 'camp'])->name('campinfo');
    Route::get('/counsellor/get-doctors', [EducatorController::class, 'getDoctors']);
    Route::post('/counsellor/get-hcl-details', [EducatorController::class, 'getHCLDetails']);
    Route::post('/counsellor/start-camp', [EducatorController::class, 'startCamp']);
    Route::post('/counsellor/stop-camp', [EducatorController::class, 'stopCamp']);
    Route::post('/counsellor/executed', [EducatorController::class, 'executed']);
    Route::post('/counsellor/not-executed', [EducatorController::class, 'notExecuted']);
    Route::get('/counsellor/get-ongoing-camp', [EducatorController::class, 'getOngoingCamp']);
    Route::get('/counsellor/patientinfo', [PatientController::class, 'patientform']);
    Route::get('/counsellor/PatientList', [PatientController::class, 'patientlist']);
    Route::get('/counsellor/change-password', [ChangePasswordController::class, 'educatorchangepassword']);
    Route::post('/counsellor/change-password-post', [ChangePasswordController::class, 'educatorchangePasswordpost'])->name('educator.change-password-post');
    Route::prefix('common')->group(function () {
        Route::post('/get-educator-camp', [DashboardController::class, 'getEducatorCamp'])->name('common.getEducatorCamp');
        Route::post('/get-doctors-by-camp', [DashboardController::class, 'getDoctorsByCamp'])->name('common.getDoctorsByCamp');
        Route::post('/get-educator-patient-table', [DashboardController::class, 'getEducatorPatientTable'])->name('common.getEducatorPatientTable');
    });
    Route::get('/counsellor/patients/export', [DashboardController::class, 'downloadEducatorPatientExcel'])->name('educator.patients.export');
    
    // Attendance
    Route::get('/counsellor/attendance', [EducatorAttendanceController::class, 'index'])->name('educator.attendance.index');
    Route::post('/counsellor/attendance/location', [EducatorAttendanceController::class, 'updateLocation'])->name('educator.attendance.updateLocation');
    Route::post('/educator/attendance/mark-out', [EducatorAttendanceController::class, 'markOut'])->name('educator.attendance.markOut');

    Route::get('/counsellor/getHCPNames', [PatientController::class, 'gethcpnames']);
    Route::get('/counsellor/getMedicines', [PatientController::class, 'getMedicines']);
    Route::get('/counsellor/getCompetitors', [PatientController::class, 'getCompetitors']);
    Route::post('/counsellor/getHCLDetails', [PatientController::class, 'getHCLDetails']);
    Route::get('/counsellor/get-camp-id', [PatientController::class, 'getcampid']);
    Route::post('/counsellor/Patient-Inquiry-Post', [PatientController::class, 'createPatientInquiryPost']);
    Route::get('/counsellor/patientlist', [PatientController::class, 'getPatientList'])->name('educator.patientslist');
    Route::post('/counsellor/upload-documents', [EducatorController::class, 'uploadDocuments'])->name('educator.uploadDocuments');
    Route::get('/counsellor/educator-follow-up-form', [FeedBackController::class, 'followupFormeducator'])->name('educator.followupform');

    Route::get('/counsellor/max-day/{patientId}', [EducatorController::class, 'getMaxDay']);
    Route::get('/counsellor/day3-Followup-get/{patient_id}', [EducatorController::class, 'day3followupget'])->name('educator.day3followupget');
    Route::get('/counsellor/day7-Followup-get/{patient_id}', [EducatorController::class, 'day7followupget'])->name('educator.day7followupget');
    Route::get('/counsellor/day15-Followup-get/{patient_id}', [EducatorController::class, 'day15followupget'])->name('educator.day15followupget');
    Route::get('/counsellor/day30-Followup-get/{patient_id}', [EducatorController::class, 'day30followupget'])->name('educator.day30followupget');
    Route::get('/counsellor/day45-Followup-get/{patient_id}', [EducatorController::class, 'day45followupget'])->name('educator.day45followupget');
    Route::get('/counsellor/day60-Followup-get/{patient_id}', [EducatorController::class, 'day60followupget'])->name('educator.day60followupget');
    Route::get('/counsellor/day90-Followup-get/{patient_id}', [EducatorController::class, 'day90followupget'])->name('educator.day90followupget');
    Route::get('/counsellor/day120-Followup-get/{patient_id}', [EducatorController::class, 'day120followupget'])->name('educator.day120followupget');
    Route::get('/counsellor/day150-Followup-get/{patient_id}', [EducatorController::class, 'day150followupget'])->name('educator.day150followupget');
    Route::get('/counsellor/day180-Followup-get/{patient_id}', [EducatorController::class, 'day180followupget'])->name('educator.day180followupget');

});
Route::middleware(['check.session', 'role:digitalcounsellor'])->group(function () {
    Route::get('/dashboard/digitalcounsellor', [DashboardController::class, 'digitaleducator'])->name('dashboard.digitaleducator');
    
    // Attendance
    Route::get('/digitalcounsellor/attendance', [EducatorAttendanceController::class, 'index'])->name('digitaleducator.attendance.index');
    Route::post('/digitalcounsellor/attendance/location', [EducatorAttendanceController::class, 'updateLocation'])->name('digitaleducator.attendance.updateLocation');
    Route::post('/digitalcounsellor/attendance/mark-out', [EducatorAttendanceController::class, 'markOut'])->name('digitaleducator.attendance.markOut');

    Route::get('digital-patient-form', [digitalController::class, 'digitsalPatientInquary'])->name('digital.patient.form');
    Route::get('digital-Patient-List', [digitalController::class, 'digitalPatientList'])->name('digital.patient.list');
    Route::get('Digital-Educator-Dashboard', [digitalController::class, 'digitalEducatorDashboard'])->name('digital.educator.dashboard');
    Route::post('/digitalcounsellor/Patient-Inquiry-Post', [PatientController::class, 'DigitalcreatePatientInquiryPost']);
    Route::get('/digitalcounsellor/getHCPNames', [PatientController::class, 'gethcpnamesall']);
    Route::post('/digitalcounsellor/getHCLDetails', [PatientController::class, 'getHCLDetailsall']);
    Route::get('/digitalcounsellor/patientlist', [digitalController::class, 'getPatientList'])->name('digitaleducator.patientslist');
    Route::get('Digital-Counsellor-change-password', [ChangePasswordController::class, 'digitaleducatorchangePassword']);
    Route::post('/digitalcounsellor/change-password-post', [ChangePasswordController::class, 'educatorchangePasswordpost'])->name('digitaleducator.change-password-post');
    Route::get('/digitalcounsellor/counsellor-follow-up-form', [FeedBackController::class, 'followupForm'])->name('educator.followup-form');
    Route::post('/digitalcounsellor/day3-Followup-Create', [digitalController::class, 'day3followup'])->name('digitaleducator.day3followup');
    Route::post('/digitalcounsellor/day7-Followup-Create', [digitalController::class, 'day7followup'])->name('digitaleducator.day7followup');
    Route::post('/digitalcounsellor/day15-Followup-Create', [digitalController::class, 'day15followup'])->name('digitaleducator.day15followup');
    Route::post('/digitalcounsellor/day30-Followup-Create', [digitalController::class, 'day30followup'])->name('digitaleducator.day30followup');
    Route::post('/digitalcounsellor/day45-Followup-Create', [digitalController::class, 'day45followup'])->name('digitaleducator.day45followup');
    Route::post('/digitalcounsellor/day60-Followup-Create', [digitalController::class, 'day60followup'])->name('digitaleducator.day60followup');
    Route::post('/digitalcounsellor/day90-Followup-Create', [digitalController::class, 'day90followup'])->name('digitaleducator.day90followup');
    Route::post('/digitalcounsellor/day120-Followup-Create', [digitalController::class, 'day120followup'])->name('digitaleducator.day120followup');
    Route::post('/digitalcounsellor/day150-Followup-Create', [digitalController::class, 'day150followup'])->name('digitaleducator.day150followup');
    Route::post('/digitalcounsellor/day180-Followup-Create', [digitalController::class, 'day180followup'])->name('digitaleducator.day180followup');
    Route::post('/digitalcounsellor/day3-Followup-Update', [digitalController::class, 'day3followup']);
    Route::post('/digitalcounsellor/day7-Followup-Update', [digitalController::class, 'day7followup']);
    Route::post('/digitalcounsellor/day15-Followup-Update', [digitalController::class, 'day15followup']);
    Route::post('/digitalcounsellor/day30-Followup-Update', [digitalController::class, 'day30followup']);
    Route::post('/digitalcounsellor/day45-Followup-Update', [digitalController::class, 'day45followup']);
    Route::post('/digitalcounsellor/day60-Followup-Update', [digitalController::class, 'day60followup']);
    Route::post('/digitalcounsellor/day90-Followup-Update', [digitalController::class, 'day90followup']);
    Route::post('/digitalcounsellor/day120-Followup-Update', [digitalController::class, 'day120followup']);
    Route::post('/digitalcounsellor/day150-Followup-Update', [digitalController::class, 'day150followup']);
    Route::post('/digitalcounsellor/day180-Followup-Update', [digitalController::class, 'day180followup']);
    Route::get('/digitalcounsellor/max-day/{patientId}', [digitalController::class, 'getMaxDay']);
    Route::get('/digitalcounsellor/day3-Followup-get/{patient_id}', [digitalController::class, 'day3followupget'])->name('digitaleducator.day3followupget');
    Route::get('/digitalcounsellor/day7-Followup-get/{patient_id}', [digitalController::class, 'day7followupget'])->name('digitaleducator.day7followupget');
    Route::get('/digitalcounsellor/day15-Followup-get/{patient_id}', [digitalController::class, 'day15followupget'])->name('digitaleducator.day15followupget');
    Route::get('/digitalcounsellor/day30-Followup-get/{patient_id}', [digitalController::class, 'day30followupget'])->name('digitaleducator.day30followupget');
    Route::get('/digitalcounsellor/day45-Followup-get/{patient_id}', [digitalController::class, 'day45followupget'])->name('digitaleducator.day45followupget');
    Route::get('/digitalcounsellor/day60-Followup-get/{patient_id}', [digitalController::class, 'day60followupget'])->name('digitaleducator.day60followupget');
    Route::get('/digitalcounsellor/day90-Followup-get/{patient_id}', [digitalController::class, 'day90followupget'])->name('digitaleducator.day90followupget');
    Route::get('/digitalcounsellor/day120-Followup-get/{patient_id}', [digitalController::class, 'day120followupget'])->name('digitaleducator.day120followupget');
    Route::get('/digitalcounsellor/day150-Followup-get/{patient_id}', [digitalController::class, 'day150followupget'])->name('digitaleducator.day150followupget');
    Route::get('/digitalcounsellor/day180-Followup-get/{patient_id}', [digitalController::class, 'day180followupget'])->name('digitaleducator.day180followupget');
    Route::post('/get-digital-patient-table', [DashboardController::class, 'getpmPatientTable'])->name('common.getdigitaleduPatientTable');
    Route::prefix('common')->group(function () {
        Route::post('/get-camp-digi-detail-by-edu', [DashboardController::class, 'getCampbyeducator'])->name('common.getdigiCampbyeducator');
        Route::post('/get-zone-digi-detail', [DashboardController::class, 'getZones'])->name('common.getdigiZones');
        Route::post('/get-rm-detail-by-digi-zone', [DashboardController::class, 'getrmsbyzone'])->name('common.getrmsbydigizone');
        Route::post('/get-edu-detail-by-digi-rm', [DashboardController::class, 'getEducatorbyzoneandRm'])->name('common.getEducatorbydigizoneandRm');
        Route::post('/get-doctorsby-digi-camp', [DashboardController::class, 'getDoctorsByEdu'])->name('common.getDoctorsdigiByEdu');
    });
    Route::get('/digitalcounsellor/getMedicines', [PatientController::class, 'getMedicines']);
    Route::get('/digitalcounsellor/getCompetitors', [PatientController::class, 'getCompetitors']);
    Route::get('digital-Patient-report', [digitalController::class, 'digitalPatientReport']);
    Route::get('/digitalgeteducatorsname', [digitalController::class, 'getEducatorsName'])->name('digitalget.educators.name');
    Route::post('/Digital-Feedback-Details', [digitalController::class, 'getFeedbackDetails']);
    Route::get('/digital-feedback-report-excel', [digitalController::class, 'feedbackReportExcel'])->name('digital-feedback-report-excel');
});
Route::middleware(['check.session', 'role:nc'])->group(function () {
    Route::post('/getpatientdetails', [PmController::class, 'getpatientdetails'])->name('pm.getpatientdetails');
    Route::get('/nc/patients/export', [DashboardController::class, 'downloadpmPatientExcel'])->name('pm.patients.export');
    Route::get('/dashboard/nc', [DashboardController::class, 'pm'])->name('dashboard.pm');
    Route::post('/get-nc-patient-table', [DashboardController::class, 'getpmPatientTable'])->name('common.getpmPatientTable');
    Route::prefix('common')->group(function () {
        Route::post('/get-doctorsby-camp', [DashboardController::class, 'getDoctorsByEdu'])->name('common.getDoctorsByEdu');
        Route::post('/get-doctors-by-Edu', [DashboardController::class, 'getCampbyeducator'])->name('common.getCampbyeducator');
        Route::post('/get-zone-detail', [DashboardController::class, 'getZones'])->name('common.getZones');
        Route::post('/get-rm-detail-by-zone', [DashboardController::class, 'getrmsbyzone'])->name('common.getrmsbyzone');
        Route::post('/get-edu-detail-by-rm', [DashboardController::class, 'getEducatorbyzoneandRm'])->name('common.getEducatorbyzoneandRm');
    });
    Route::get('nc-Create-Educator', [PmController::class, 'pmcreateEducatorView']);
    Route::get('nc-Create-Hcp', [PmController::class, 'pmcreateHcpView']);
    Route::get('nc-Create-RM', [PmController::class, 'pmcreateRmView']);
    Route::get('nc-Create-DigitalEducator', [PmController::class, 'pmcreateDigitalEducatorView']);
    Route::post('nc-Delete-DigiEducator/{id}', [PmController::class, 'deleteDigiEducator'])->name('pm.deleteDigiEducator');
    Route::post('nc-Delete-Educator/{id}', [PmController::class, 'deleteEducator'])->name('pm.deleteEducator');
    Route::post('nc-Delete-Doctor/{id}', [PmController::class, 'deleteDoctor'])->name('pm.deleteDoctor');
    Route::post('nc-Delete-Rm/{id}', [PmController::class, 'deleterm'])->name('pm.deleterm');
    Route::post('nc-Create-Doctor-Post', [PmController::class, 'pmcreateDoctorPost']);
    Route::post('nc-Create-Educator-Post', [PmController::class, 'pmcreateEducatorPost']);
    Route::post('nc-Update-Educator-Post', [pmController::class, 'pmupdateEducatorPost']);
    Route::post('nc-Create-DigiEducator-Post', [PmController::class, 'pmcreateDigitalEducatorPost']);
    Route::post('nc-Update-DigiEducator-Post', [PmController::class, 'pmupdateDigitalEducatorPost']);
    Route::post('nc-Create-Rm-Post', [PmController::class, 'pmcreateRmPost']);
    Route::post('nc-Update-Rm-Post', [PmController::class, 'pmupdateRmPost']);
    Route::post('/get-state-detail', [PmController::class, 'getState'])->name('common.getState');
    Route::post('/get-city-detail', [PmController::class, 'getCity'])->name('common.getCity');
    Route::post('nc-Update-Doctor-Post', [PmController::class, 'pmupdateDoctorPost']);
    Route::get('nc-Assign-EDUCATOR', [PmController::class, 'assignEducatorView']);
    Route::post('nc-Assign-Educator-Post', [PmController::class, 'pmassignEducatorPost']);
    Route::get('nc-Assign-digital-educator-RM', [PmController::class, 'assigndigiEducatorView']);
    Route::post('nc-Assign-DigitalEducator-Post', [PmController::class, 'pmassignDigitalEducatorPost']);
    Route::get('nc-Assign-HCP', [PmController::class, 'assignHcpView']);
    Route::post('nc-Assign-Hcp-Post', [PmController::class, 'pmassignHcpPost']);
    Route::get('nc-Assign-DM', [PmController::class, 'assigndigital']);
    Route::post('nc-Get-Patients', [PmController::class, 'pmgetPatients']);
    Route::post('assign_digitaleducator_post', [PmController::class, 'assign_digitaleducator_post']);
    Route::get('nc-Get-Digital-Educators-patient', [PmController::class, 'getDigitalEducatorspatient']);
    Route::post('nc-Assign-Digital-Educator-patient', [PmController::class, 'assignDigitalEducatorpatient']);
    Route::get('/nc-Analytics', function () {
        return view('pm.analytics');
    });
    Route::prefix('Charts')->group(function () {
        Route::get('pmmonthly_counseling', [PmController::class, 'pmmonthlyCounseling']);
        Route::get('pmtop_educators', [PmController::class, 'pmtopeducators']);
        Route::get('pmnoteducator', [PmController::class, 'pmnoteducator']);
        Route::get('pmgender_distribution', [PmController::class, 'pmgenderDistribution']);
        Route::get('pmcamp_distribution', [PmController::class, 'pmcampDistribution']);
        Route::get('pmblood_pressure', [PmController::class, 'pmbloodPressure']);
        Route::get('pmobesity_metrics', [PmController::class, 'pmobesityMetrics']);
        Route::get('pmdoctorNotMetrics', [PmController::class, 'pmdoctorNotMetrics']);
    });
    Route::get('/nc-feedback', [PmController::class, 'pmfeedback']);
    Route::get('/nc-campreport', [PmController::class, 'pmcampReport']);
    Route::post('nc-Get-Educators', [PmController::class, 'getEducators']);
    Route::post('nc-Get-DigiEducators', [PmController::class, 'getDigitalEducators']);
    Route::post('nc-Get-Doctors', [PmController::class, 'getDoctors']);
    Route::post('nc-Get-Rm', [PmController::class, 'getrms']);
    Route::get('getEducatorsname', [PmController::class, 'getEducatorsname']);
    Route::get('getdigiEducatorsname', [PmController::class, 'getdigiEducatorsname']);
    Route::get('getrmsname', [PmController::class, 'getrmsname']);
    Route::get('getDoctorsname', [PmController::class, 'getDoctorsname']);
    Route::POST('nc-Get-Camp-Details', [PmController::class, 'getCampDetails']);
    Route::get('/nc-feedbackreport', [PmController::class, 'pmfeedbackReport']);
    Route::POST('nc-Feedback-Details', [PmController::class, 'getFeedbackDetails']);
    Route::get('/nc-feedback-report-excel', [PmController::class, 'feedbackReportExcel'])->name('pm-feedback-report-excel');
    Route::get('/get-educators-name', [PmController::class, 'getEducatorsName'])->name('get.educators.name');
    Route::get('/get-digi-educators-name', [PmController::class, 'getDigiEducatorsName'])->name('get.digi.educators.name');
    Route::get('nc-campreport_excel', [PmController::class, 'campReportExcel'])->name('pmcamp.report.excel');
    Route::get('/nc-daily-report/export', [PmController::class, 'downloadDailyReport'])->name('pmdaily.report.export');
    Route::get('nc-Get-Doctor/{id}', [PmController::class, 'getDoctorById']);
    Route::get('nc-medicine', [PmController::class, 'medicinepage']);
    Route::post('/nc-Get-Medicine', [PmController::class, 'getMedicine'])->name('medicine.get');
    Route::post('/nc-Create-Medicine-Post', [PmController::class, 'storemedicine'])->name('medicine.store');
    Route::post('/nc-Update-Medicine-Post', [PmController::class, 'updatemedicine'])->name('medicine.update');
    Route::post('/nc-Delete-Medicine/{id}', [PmController::class, 'deleteMedicine'])->name('medicine.delete');
    Route::post('nc-Get-Medicine-Headers', [PmController::class, 'getMedicineHeaders']);
    Route::get('nc-compitetor', [PmController::class, 'compitetorpage']);
    Route::post('/nc-Get-Compitetor', [PmController::class, 'getCompitetor'])->name('Compitetor.get');
    Route::post('/nc-Create-Compitetor-Post', [PmController::class, 'storeCompitetor'])->name('Compitetor.store');
    Route::post('/nc-Update-Compitetor-Post', [PmController::class, 'updateCompitetor'])->name('Compitetor.update');
    Route::post('/nc-Delete-Compitetor/{id}', [PmController::class, 'deleteCompitetor'])->name('Compitetor.delete');
    Route::get('/nc/patientlist', [PmController::class, 'getPatientList'])->name('nc.patientslist');
    Route::get('nc-Patient-List', [PmController::class, 'pmPatientList'])->name('nc.patient.list');
    Route::get('/nc/educator-follow-up-form', [FeedBackController::class, 'followupFormpm'])->name('nc.followup-form');

    Route::get('/nc/max-day/{patientId}', [PmController::class, 'getMaxDay']);
    Route::get('/nc/day3-Followup-get/{patient_id}', [PmController::class, 'day3followupget'])->name('nc.day3followupget');
    Route::get('/nc/day7-Followup-get/{patient_id}', [PmController::class, 'day7followupget'])->name('nc.day7followupget');
    Route::get('/nc/day15-Followup-get/{patient_id}', [PmController::class, 'day15followupget'])->name('nc.day15followupget');
    Route::get('/nc/day30-Followup-get/{patient_id}', [PmController::class, 'day30followupget'])->name('nc.day30followupget');
    Route::get('/nc/day45-Followup-get/{patient_id}', [PmController::class, 'day45followupget'])->name('nc.day45followupget');
    Route::get('/nc/day60-Followup-get/{patient_id}', [PmController::class, 'day60followupget'])->name('nc.day60followupget');
    Route::get('/nc/day90-Followup-get/{patient_id}', [PmController::class, 'day90followupget'])->name('nc.day90followupget');
    Route::get('/nc/day120-Followup-get/{patient_id}', [PmController::class, 'day120followupget'])->name('nc.day120followupget');
    Route::get('/nc/day150-Followup-get/{patient_id}', [PmController::class, 'day150followupget'])->name('nc.day150followupget');
    Route::get('/nc/day180-Followup-get/{patient_id}', [PmController::class, 'day180followupget'])->name('nc.day180followupget');
    Route::get('/nc/attendance-report', [PmController::class, 'attendanceReport'])->name('nc.attendance.report');
    Route::get('/nc/attendance-report/data', [PmController::class, 'getAttendanceReportData'])->name('nc.attendance.data');
    Route::get('/nc/attendance-report/export', [PmController::class, 'exportAttendanceReport'])->name('nc.attendance.export');


});
Route::middleware(['check.session', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', [DashboardController::class, 'mis'])->name('dashboard.mis');
    Route::post('/get-admin-patient-table', [DashboardController::class, 'getpmPatientTable'])->name('common.getmisPatientTable');
    Route::post('admin-get-doctors-by-Edu', [DashboardController::class, 'getCampbyeducator'])->name('common.misgetCampbyeducator');
    Route::post('admin-get-zone-detail', [DashboardController::class, 'getZones'])->name('common.misgetZones');
    Route::post('admin-get-rm-detail-by-zone', [DashboardController::class, 'getrmsbyzone'])->name('common.misgetrmsbyzone');
    Route::post('admin-get-edu-detail-by-rm', [DashboardController::class, 'getEducatorbyzoneandRm'])->name('common.misgetEducatorbyzoneandRm');
    Route::post('admin-get-doctorsby-camp', [DashboardController::class, 'getDoctorsByEdu'])->name('common.misgetDoctorsByEdu');
    Route::get('admin/patients/export', [DashboardController::class, 'downloadpmPatientExcel'])->name('mis.patients.export');
    Route::get('admin-Create-Counsellor', [misController::class, 'miscreateEducatorView']);
    Route::get('admin-Create-Doctor', [misController::class, 'miscreateHcpView']);
    Route::get('admin-Create-RC', [misController::class, 'miscreateRmView']);
    Route::get('admin-Create-DigitalCounsellor', [misController::class, 'miscreateDigitalEducatorView']);
    Route::get('admin-Get-Doctor/{id}', [misController::class, 'getDoctorById']);
    Route::get('admin-Assign-EDUCATOR', [misController::class, 'misassignEducatorView']);
    Route::post('admin-Assign-Educator-Post', [misController::class, 'misassignEducatorPost']);
    Route::get('admin-Assign-digital-educator-RM', [misController::class, 'assigndigiEducatorView']);
    Route::post('admin-Assign-Educator-Post', [misController::class, 'pmassignEducatorPost']);
    Route::get('admin-Assign-digital-educator-RM', [misController::class, 'misassigndigiEducatorView']);
    Route::post('admin-Assign-DigitalEducator-Post', [misController::class, 'pmassignDigitalEducatorPost']);
    Route::get('admin-Assign-digital-educator', [misController::class, 'misassigndigiEducatorView']);
    Route::get('admin-Assign-HCP', [misController::class, 'misassignHcpView']);
    Route::post('admin-Assign-Hcp-Post', [misController::class, 'pmassignHcpPost']);
    Route::get('admin-Assign-DM', [misController::class, 'misassigndigital']);
    Route::post('admin-assign_digitaleducator_post', [misController::class, 'misassign_digitaleducator_post']);
    Route::get('admingetdigiEducatorsname', [misController::class, 'getdigiEducatorsname'])->name('misgetdigiEducatorsname');
    Route::get('admingetrmsname', [misController::class, 'getrmsname']);
    Route::post('admin-Assign-DigitalEducator-Post', [misController::class, 'pmassignDigitalEducatorPost']);
     Route::get('/admin/attendance-report', [misController::class, 'attendanceReport'])->name('mis.attendance.report');
    Route::get('/admin/attendance-report/data', [misController::class, 'getAttendanceReportData'])->name('mis.attendance.data');
    Route::get('/admin/attendance-report/export', [misController::class, 'exportAttendanceReport'])->name('mis.attendance.export');
    Route::post('/adminget-state-detail', [misController::class, 'getState'])->name('common.misgetState');
    Route::post('admin-Delete-Educator/{id}', [misController::class, 'deleteEducator'])->name('mis.deleteEducator');
    Route::post('admin-Delete-DigiEducator/{id}', [misController::class, 'deleteDigiEducator'])->name('mis.deleteDigiEducator');
    Route::post('admin-Delete-Doctor/{id}', [misController::class, 'deleteDoctor'])->name('mis.deleteDoctor');
    Route::post('admin-Delete-Rm/{id}', [misController::class, 'deleterm'])->name('mis.deleterm');
    Route::post('admin-Create-Educator-Post', [misController::class, 'pmcreateEducatorPost']);
    Route::post('admin-Update-Educator-Post', [misController::class, 'pmupdateEducatorPost']);
    Route::post('admin-Create-Doctor-Post', [misController::class, 'pmcreateDoctorPost']);
    Route::post('admin-Update-Doctor-Post', [misController::class, 'pmupdateDoctorPost']);
    Route::post('admin-Create-DigiEducator-Post', [misController::class, 'pmcreateDigitalEducatorPost']);
    Route::post('admin-Update-DigiEducator-Post', [misController::class, 'pmupdateDigitalEducatorPost']);
    Route::post('admin-Create-Rm-Post', [misController::class, 'pmcreateRmPost']);
    Route::post('admin-Update-Rm-Post', [misController::class, 'pmupdateRmPost']);
    Route::post('admin-Get-Educators', [misController::class, 'getEducators']);
    Route::post('admin-Get-Educators', [misController::class, 'getEducators']);
    Route::post('admin-Get-DigiEducators', [misController::class, 'getDigitalEducators']);
    Route::post('admin-Get-Doctors', [misController::class, 'getDoctors']);
    Route::post('admin-Get-Rm', [misController::class, 'getrms']);
    Route::post('/adminget-city-detail', [misController::class, 'getCity'])->name('common.misgetCity');
    Route::POST('admin-Get-Camp-Details', [misController::class, 'getCampDetails']);
    Route::post('admin-Get-Patients', [misController::class, 'pmgetPatients']);
    Route::get('admingetDoctorsname', [misController::class, 'getDoctorsname']);
    Route::get('admingetEducatorsname', [misController::class, 'getEducatorsname'])->name('misgetEducatorsname');
    Route::get('admin-Get-Digital-Educators-patient', [misController::class, 'getDigitalEducatorspatient']);
    Route::post('admin-Assign-Digital-Educator-patient', [misController::class, 'assignDigitalEducatorpatient']);
    Route::get('/admin-feedback', [PmController::class, 'misfeedback']);
    Route::get('/admin-Analytics', function () {
        return view('mis.analytics');
    });
    Route::prefix('Charts')->group(function () {
        Route::get('adminmonthly_counseling', [misController::class, 'mismonthlyCounseling']);
        Route::get('adminstop_educators', [misController::class, 'mistopeducators']);
        Route::get('adminnoteducator', [misController::class, 'misnoteducator']);
        Route::get('admingender_distribution', [misController::class, 'misgenderDistribution']);
        Route::get('admincamp_distribution', [misController::class, 'miscampDistribution']);
        Route::get('adminblood_pressure', [misController::class, 'misbloodPressure']);
        Route::get('adminobesity_metrics', [misController::class, 'misobesityMetrics']);
        Route::get('admindoctorNotMetrics', [misController::class, 'misdoctorNotMetrics']);
    });
    Route::get('/admin-campreport', [misController::class, 'miscampReport']);
    Route::get('campreport_excel', [misController::class, 'campReportExcel'])->name('camp.report.excel');
    Route::get('/daily-report/export', [misController::class, 'downloadDailyReport'])->name('misdaily.report.export');
    Route::get('admin-medicine', [misController::class, 'medicinepage']);
    Route::post('/admin-Get-Medicine', [misController::class, 'getMedicine'])->name('mismedicine.get');
    Route::post('/admin-Create-Medicine-Post', [misController::class, 'storemedicine'])->name('mismedicine.store');
    Route::post('/admin-Update-Medicine-Post', [misController::class, 'updatemedicine'])->name('mismedicine.update');
    Route::post('/admin-Delete-Medicine/{id}', [misController::class, 'deleteMedicine'])->name('mismedicine.delete');
    Route::post('admin-Get-Medicine-Headers', [misController::class, 'getMedicineHeaders']);
    Route::get('admin-compitetor', [misController::class, 'compitetorpage']);
    Route::post('/admin-Get-Compitetor', [misController::class, 'getCompitetor'])->name('misCompitetor.get');
    Route::post('/admin-Create-Compitetor-Post', [misController::class, 'storeCompitetor'])->name('misCompitetor.store');
    Route::post('/admin-Update-Compitetor-Post', [misController::class, 'updateCompitetor'])->name('misCompitetor.update');
    Route::post('/admin-Delete-Compitetor/{id}', [misController::class, 'deleteCompitetor'])->name('misCompitetor.delete');
    Route::get('/admin/patientlist', [misController::class, 'getPatientList'])->name('admin.patientslist');
    Route::get('admin-Patient-List', [misController::class, 'misPatientList'])->name('mis.patient.list');
    Route::get('/admin/educator-follow-up-form', [FeedBackController::class, 'followupFormmis'])->name('mis.followupform');

    Route::get('/admin/max-day/{patientId}', [misController::class, 'getMaxDay']);
    Route::get('/admin/day3-Followup-get/{patient_id}', [misController::class, 'day3followupget'])->name('mis.day3followupget');
    Route::get('/admin/day7-Followup-get/{patient_id}', [misController::class, 'day7followupget'])->name('mis.day7followupget');
    Route::get('/admin/day15-Followup-get/{patient_id}', [misController::class, 'day15followupget'])->name('mis.day15followupget');
    Route::get('/admin/day30-Followup-get/{patient_id}', [misController::class, 'day30followupget'])->name('mis.day30followupget');
    Route::get('/admin/day45-Followup-get/{patient_id}', [misController::class, 'day45followupget'])->name('mis.day45followupget');
    Route::get('/admin/day60-Followup-get/{patient_id}', [misController::class, 'day60followupget'])->name('mis.day60followupget');
    Route::get('/admin/day90-Followup-get/{patient_id}', [misController::class, 'day90followupget'])->name('mis.day90followupget');
    Route::get('/admin/day120-Followup-get/{patient_id}', [misController::class, 'day120followupget'])->name('mis.day120followupget');
    Route::get('/admin/day150-Followup-get/{patient_id}', [misController::class, 'day150followupget'])->name('mis.day150followupget');
    Route::get('/admin/day180-Followup-get/{patient_id}', [misController::class, 'day180followupget'])->name('mis.day180followupget');
    Route::get('/admin-feedbackreport', [misController::class, 'misfeedbackReport']);
    Route::POST('admin-Feedback-Details', [misController::class, 'getFeedbackDetails']);
    Route::get('/admin-feedback-report-excel', [misController::class, 'feedbackReportExcel'])->name('admin-feedback-report-excel');


});

Route::middleware(['check.session'])->group(function () {
    Route::get('/rc/dashboard', [DashboardController::class, 'rm'])->name('dashboard.rm');
    Route::post('/get-rm-patient-table', [DashboardController::class, 'getrmPatientTable'])->name('common.getrmPatientTable');
    Route::prefix('common')->group(function () {
        Route::post('/get-doctorsbyrm-camp', [DashboardController::class, 'getDoctorsByEdu'])->name('common.getDoctorsByrmEdu');
        Route::post('/get-doctorsrm-by-Edu', [DashboardController::class, 'getCampbyeducator'])->name('common.getCampbyrmeducator');
        Route::post('/get-edu-detail-byrm-rm', [DashboardController::class, 'getEducatorbyRm'])->name('common.getEducatorbyrmzoneandRm');
        Route::post('/get-camp-detail-byrm-edu', [DashboardController::class, 'getCampbyeducator'])->name('common.getCampbyrmeducators');
    });
    Route::get('/rc/patients/export', [DashboardController::class, 'downloadrmPatientExcel'])->name('rm.patients.export');
    Route::get('/rc/analytics', [RmController::class, 'rmAnalytics'])->name('rm.analytics');
    Route::prefix('Charts/rc')->group(function () {
        Route::get('monthly_counseling', [RmController::class, 'rmmonthlyCounseling']);
        Route::get('top_educators', [RmController::class, 'rmtopeducators']);
        Route::get('brand_distribution', [RmController::class, 'rmbrandDistribution']);
        Route::get('camp_distribution', [RmController::class, 'rmcampDistribution']);
        Route::get('doc_metrics', [RmController::class, 'rmdocmetrics']);
        Route::get('docnot_metrics', [RmController::class, 'rmdoctorNotMetrics']);
    });
    Route::get('/rc/change-password', [ChangePasswordController::class, 'rmchangepassword'])->name('rm.change-password');
    Route::post('/rc/change-password-post', [ChangePasswordController::class, 'rmchangePasswordpost'])->name('rm.change-password-post');
    Route::get('/rc/patientlist', [RmController::class, 'getPatientpage'])->name('rm.patientlist');
    Route::get('/rc/patientdata', [RmController::class, 'getPatientdata'])->name('rm.patientdata');
    Route::post('/rc/reject-patient', [RmController::class, 'rejectPatient'])->name('rm.reject-patient');
    Route::post('/rc/approve-patient', [RmController::class, 'approvePatient'])->name('rm.approve-patient');

    // Attendance
    Route::get('/rc/attendance', [RmAttendanceController::class, 'index'])->name('rm.attendance.index');
    Route::post('/rm/attendance/location', [RmAttendanceController::class, 'updateLocation'])->name('rm.attendance.updateLocation');
    Route::post('/rm/attendance/mark-out', [RmAttendanceController::class, 'markOut'])->name('rm.attendance.markOut');

});

Route::middleware(['check.session', 'role:yogaeducator'])->group(function () {
    Route::get('/dashboard/yogaeducator', [DashboardController::class, 'yogaeducator'])->name('dashboard.yogaeducator');
    Route::prefix('common')->group(function () {
        Route::post('/get-camp-yoga-detail-by-edu', [DashboardController::class, 'getCampbyeducator'])->name('common.getyogaCampbyeducator');
        Route::post('/get-zone-yoga-detail', [DashboardController::class, 'getZones'])->name('common.getyogaZones');
        Route::post('/get-rm-detail-by-yoga-zone', [DashboardController::class, 'getrmsbyzone'])->name('common.getrmsbyyogazone');
        Route::post('/get-edu-detail-by-yoga-rm', [DashboardController::class, 'getEducatorbyzoneandRm'])->name('common.getEducatorbyyogazoneandRm');
        Route::post('/get-doctorsby-yoga-camp', [DashboardController::class, 'getDoctorsByEdu'])->name('common.getDoctorsyogaByEdu');
    });
    Route::post('/get-yoga-patient-table', [DashboardController::class, 'getpmPatientTable'])->name('common.getyogaeduPatientTable');
    Route::get('yoga-Patient-List', [yogaController::class, 'yogaPatientList'])->name('yoga.patientlist');
    Route::get('/yogaeducator/patientlist', [yogaController::class, 'getPatientList'])->name('yogaeducator.patientslist');
    Route::get('yoga-educator-change-password', [ChangePasswordController::class, 'yogaeducatorchangePassword'])->name('yoga.changepassword');
    Route::post('/yogaeducator/change-password-post', [ChangePasswordController::class, 'educatorchangePasswordpost'])->name('yogaeducator.change-password-post');
    Route::get('/yogaeducator/educator-follow-up-form', [FeedBackController::class, 'followupFormyoga'])->name('yoga.followupform');

    Route::get('/yogaeducator/max-day/{patientId}', [yogaController::class, 'getMaxDay']);
    Route::get('/yogaeducator/day7-Followup-get/{patient_id}', [yogaController::class, 'day7followupget'])->name('yogaeducator.day7followupget');
    Route::get('/yogaeducator/day45-Followup-get/{patient_id}', [yogaController::class, 'day45followupget'])->name('yogaeducator.day45followupget');
    Route::get('/yogaeducator/day90-Followup-get/{patient_id}', [yogaController::class, 'day90followupget'])->name('yogaeducator.day90followupget');
    Route::post('/yogaeducator/day7-Followup-Create', [yogaController::class, 'day7followup'])->name('yogaeducator.day7followup');
    Route::post('/yogaeducator/day45-Followup-Create', [yogaController::class, 'day45followup'])->name('yogaeducator.day45followup');
    Route::post('/yogaeducator/day90-Followup-Create', [yogaController::class, 'day90followup'])->name('yogaeducator.day90followup');
});
