<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\Backend\{
    CkEditorController,
    ConferenceController,
    MemberTypeController,
    MemberTypePriceController,
    ConferenceRegistrationController,
    AdminController,
    SubmissionController,
    AuthorController,
    WorkshopController,
    WorkshopRegistrationController,
    WorkshopTrainerController,
    HallController,
    ScheduleController,
    HotelController,
    CommitteeController,
    CommitteeMemberController,
    SponsorCategoryController,
    SponsorController,
    SponsorInvitationController,
    BackgroundController,
    SignatureController,
    CertificateController,
    NamePrefixController,
    SubScheduleController,
    FAQController,
    NoticeController,
    DownloadController,
    ContentController,
    ScientificSessionController,
    ScientificSessionCategoryController,
    DesignationController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes(['register' => false]);

Route::controller(FrontController::class)->name('front.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/speakers', 'speakers')->name('speakers');
    Route::get('/news-notice', 'notice')->name('notice');
    Route::get('/news-notice-detail/{slug}', 'noticeDetail')->name('noticeDetail');
    Route::get('/committee/{slug}', 'committee')->name('committee');
    Route::get('/abstract-guidelines', 'abstractGuidelines')->name('abstractGuidelines');
    Route::post('/get-member-types', 'getMemberTypes')->name('getMemberTypes');
    Route::post('/register-submit', 'registerSubmit')->name('registerSubmit');
    Route::get('/accommodation', 'accommodation')->name('accommodation');
    Route::get('/accommodation/{slug}', 'accommodationInner')->name('accommodationInner');
    Route::get('/workshop-detail/{slug}', 'workshopDetail')->name('workshopDetail');
    Route::get('/scientific-session', 'scientificSession')->name('scientificSession');
    Route::get('/search-scientific-sessions', 'search')->name('scientificSession.search');
    Route::get('/scientific-session-test', 'scientificSessionTest')->name('scientificSessionTest');
    Route::get('/export-pdf/{hall_id}/{date}', 'exportPdf')->name('export.pdf');
    Route::get('/message', 'message')->name('message');
});

//==================================== Backend Start ====================================
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('/cms/view/{status}/participants', [HomeController::class, 'viewParticipants'])->name('home.viewParticipants');
    Route::get('/cms/workshop-registrations/{slug}', [HomeController::class, 'workshopRegistrations'])->name('home.workshopRegistrations');
    Route::get('/cms/submissions/{type}', [HomeController::class, 'submission'])->name('home.submission');
    Route::get('/cms/edit-profile', [HomeController::class, 'editProfile'])->name('home.editProfile');
    Route::get('/cms/edit-profile-by-admin/{id}', [HomeController::class, 'editProfileByAdmin'])->name('home.editProfileByAdmin');
    Route::patch('/cms/edit-profile-update', [HomeController::class, 'editProfileUpdate'])->name('home.editProfileUpdate');
    Route::get('/cms/conference-duplicate-registrations', [HomeController::class, 'conferenceDuplicateRegistration'])->name('home.conferenceDuplicateRegistration');
    Route::get('/cms/conference-duplicate-datas/{council_number}', [HomeController::class, 'conferenceDuplicateDatas'])->name('home.conferenceDuplicateDatas');
    Route::get('/cms/view/attendance-status', [HomeController::class, 'viewAttendanceStatus'])->name('home.viewAttendanceStatus');
    Route::get('/cms/view/status-details/{day}/{type}/{status}', [HomeController::class, 'viewAttendanceLunchDetail'])->name('home.viewAttendanceLunchDetail');
    Route::get('/cms/view/later-participants/{times}', [HomeController::class, 'viewLaterParticipants'])->name('home.viewLaterParticipants');
    Route::get('/cms/view/generate-later-participants-pass/{times}', [HomeController::class, 'generateLaterRegistrantPass'])->name('home.generateLaterRegistrantPass');
    Route::get('/cms/conference/open-portal/{slug}', [HomeController::class, 'index'])->name('conference.openConferencePortal');

    // ==================================== main admin start ====================================
    // Route::middleware('admin')->group(function () {
    Route::prefix('/cms')->group(function () {
        // conference routes
        Route::resource('/conference', ConferenceController::class)->except('show', 'destroy');
        Route::post('/conference/view-data', [ConferenceController::class, 'show'])->name('conference.show');
        Route::get('/conference/submission-setting', [ConferenceController::class, 'submissionSetting'])->name('conference.submissionSetting');
        Route::post('/conference/submission-setting-submit', [ConferenceController::class, 'submissionSettingSubmit'])->name('conference.submissionSettingSubmit');

        // conference registration routes for admin
        Route::controller(ConferenceRegistrationController::class)->name('conferenceRegistration.')->prefix('/conference/registration')->group(function () {
            Route::get('/participants/{type}', 'participants')->name('participants');
            Route::get('update-regisration-id', 'updatRegistrationId')->name('updatRegistrationId');
            Route::post('/verify-registrant', 'verifyForm')->name('verifyForm');
            Route::post('/verify-registrant-submit', 'verifyRegistrant')->name('verifyRegistrant');
            Route::get('/registration-or-invitation', 'registrationByAdmin')->name('byAdmin');
            Route::post('/registration-or-invitation-submit', 'registrationByAdminSubmit')->name('byAdminSubmit');
            Route::get('/change-featured-status/{conference_registration}', 'changeFeatured')->name('changeFeatured');
            Route::post('/send-correction-mail-form', 'sendCorrectionMailForm')->name('sendCorrectionMailForm');
            Route::post('/send-correction-mail-submit', 'sendCorrectionMailSubmit')->name('sendCorrectionMailSubmit');
            Route::post('/fetch-user-data', 'fetchUserData')->name('fetchUserData');
            Route::post('/edit-attendees-number', 'editAttendeesNumber')->name('editAttendeesNumber');
            Route::post('/edit-attendees-number-submit', 'editAttendeesNumberSubmit')->name('editAttendeesNumberSubmit');
            Route::post('/add-role', 'addRole')->name('addRole');
            Route::post('/add-role-submit', 'addRoleSubmit')->name('addRoleSubmit');
            Route::get('/registration-in-exceptional-case', 'registerExceptionalCase')->name('registerExceptionalCase');
            Route::post('/registration-in-exceptional-case-submit', 'registerExceptionalCaseSubmit')->name('registerExceptionalCaseSubmit');
            Route::post('/convert-to-speaker-by-admin', 'convertToSpeakerbyAdmin')->name('convertToSpeakerbyAdmin');
            Route::post('/add-payment-voucher', 'addPaymentVoucher')->name('addPaymentVoucher');
            Route::post('/add-payment-voucher-submit', 'addPaymentVoucherSubmit')->name('addPaymentVoucherSubmit');
            Route::get('/get-member-type', 'getDelegateType')->name('getDelegateType');
        });

        // membertype routes
        Route::resource('/member-type', MemberTypeController::class)->except('show', 'destroy');
        Route::get('/member-type-price', [MemberTypePriceController::class, 'index'])->name('member-type-price.index');
        Route::post('/member-type-price-submit', [MemberTypePriceController::class, 'update'])->name('member-type-price.update');
    });
    // });
    // ==================================== main admin end ====================================

    // conference registration routes for users
    Route::resource('/dash/conference-registration', ConferenceRegistrationController::class)->except('show');
    Route::controller(ConferenceRegistrationController::class)->name('conference-registration.')->prefix('/dash/conference-registration')->group(function () {
        Route::post('/view-data', 'show')->name('show');
        Route::post('/update-conference-registation', 'updateRegistration')->name('updateRegistration');
        // Route::get('/sendRecipt', 'sendRecipt')->name('sendRecipt');
        Route::get('/register', 'register')->name('register');
        Route::get('/export/{type}', 'exportExcel')->name('exportExcel');
        Route::get('/excel/indias', 'exportIndian')->name('exportIndian');
        Route::post('/submit-data', 'submitData')->name('submitData');
        Route::get('/convert-to-speaker', 'convertToSpeaker')->name('convertToSpeaker');
        Route::post('/convert-to-speaker-submit', 'convertToSpeakerSubmit')->name('convertToSpeakerSubmit');
        Route::get('/generate-pass/{type}', 'generatePass')->name('generatePass');
        Route::post('/take-attendance', 'takeAttendance')->name('takeAttendance');
        Route::post('/take-meal', 'takeMeal')->name('takeMeal');
        Route::get('/generate-certificate/{id}', 'generateCertificate')->name('generateCertificate');
        Route::get('/generate-individual-pass/{conferenceRegistration}', 'generateIndividualPass')->name('generateIndividualPass');
        Route::post('/choose-registrant-type', 'chooseRegistrantType')->name('chooseRegistrantType');
        Route::post('/online-payment', 'onlinePayment')->name('onlinePayment');
        Route::get('/international-payment-result/success-process', 'internationalPaymentResultSuccessProcess')->name('internationalPaymentResultSuccessProcess');
        Route::get('/international-payment-result/success', 'internationalPaymentResultSuccess')->name('internationalPaymentResultSuccess');
        Route::post('/online-payment-submit', 'onlinePaymentSubmit')->name('submit');
        Route::get('/international-payment-result/fail', 'internationalPaymentResultFail')->name('internationalPaymentResultFail');
        Route::get('/international-payment-result/cancel', 'internationalPaymentResultCancel')->name('internationalPaymentResultCancel');
        Route::get('/international-payment-result/backend', 'internationalPaymentResultBackend')->name('internationalPaymentResultBackend');
        Route::post('/fone-pay', 'fonePay')->name('fonePay');
        Route::get('/fone-pay/success', 'fonePaySuccess')->name('fonePaySuccess');
        Route::post('/convert-usd-to-inr', 'convertUsdToInr')->name('convertUsdToInr');
    });
    Route::get('/participant/profile/{token}', [ConferenceRegistrationController::class, 'participantProfile']);

    // admins (scientific committee & experts) route
    Route::resource('/cms/admin', AdminController::class)->except('show', 'destroy');
    Route::post('/cms/reset-admin-password', [AdminController::class, 'resetPassword'])->name('admin.resetPassword');
    Route::get('/cms/signed-up-users', [AdminController::class, 'signedUpUsersList'])->name('admin.signedUpUsersList');
    Route::post('/cms/make-expert', [AdminController::class, 'makeExpert'])->name('admin.makeExpert');
    Route::get('/cms/change-faculty-status/{id}', [AdminController::class, 'changeFacultyStatus'])->name('admin.changeFacultyStatus');
    Route::get('/cms/excel-export-for-signed-up-users', [AdminController::class, 'excelExport'])->name('admin.excelExport');
    Route::post('/cms/invite-user-for-conference', [AdminController::class, 'inviteUserForConference'])->name('admin.inviteUserForConference');
    Route::post('/cms/invite-user-for-conference-submit', [AdminController::class, 'inviteUserForConferenceSubmit'])->name('admin.inviteUserForConferenceSubmit');
    Route::post('/cms/passDesgination', [AdminController::class, 'passDesgination'])->name('admin.passDesgination');
    Route::post('/cms/passDesgination-submit', [AdminController::class, 'passDesginationSubmit'])->name('admin.passDesginationSubmit');

    // submissions route
    Route::resource('/cms/submission', SubmissionController::class)->except('show');
    Route::controller(SubmissionController::class)->name('submission.')->prefix('/dash/submission')->group(function () {
        Route::post('/forward-to-expert-form', 'expertForwardForm')->name('expertForwardForm');
        Route::get('/create', 'create')->name('test');
        Route::post('/forward-to-expert', 'expertForward')->name('expertForward');
        Route::post('/decide-reqeust-form', 'decideRequestForm')->name('decideRequestForm');
        Route::post('/decide-reqeust', 'decideRequest')->name('decideRequest');
        Route::get('/view-discussion/{id}', 'viewDiscussion')->name('viewDiscussion');
        Route::post('/committee-comment-form', 'committeeCommentForm')->name('committeeCommentForm');
        Route::post('/submit-committee-comment', 'submitComment')->name('submitComment');
        Route::get('/abstract-word-export/{id}', 'wordExport')->name('wordExport');
        Route::post('/cms/view-details', 'viewData')->name('viewData');
        Route::post('/bulk-abstract-word-export', 'bulkWordExport')->name('bulkWordExport');

        Route::get('exportExcel', 'exportExcel')->name('exportExcel');
    });

    // authors route
    Route::controller(AuthorController::class)->prefix('/cms/author')->name('author.')->group(function () {
        Route::get('/{id}', 'index')->name('index');
        Route::post('/form', 'form')->name('form');
        Route::post('/old-author', 'oldAuthor')->name('oldAuthor');
        Route::post('/store', 'store')->name('store');
        Route::any('/update/{author}', 'update')->name('update');
        Route::delete('/destroy/{author}', 'destroy')->name('destroy');
    });

    // workshop routes
    Route::resource('/cms/workshop', WorkshopController::class)->except('show');
    Route::controller(WorkshopController::class)->name('workshop.')->prefix('/cms/workshop')->group(function () {
        Route::post('/view-data', [WorkshopController::class, 'show'])->name('show');
        Route::post('/allocate-price-form', [WorkshopController::class, 'allocatePriceForm'])->name('allocatePriceForm');
        Route::post('/allocate-price-submit', [WorkshopController::class, 'allocatePriceSubmit'])->name('allocatePriceSubmit');
        Route::post('/send-bulk-mail-form', [WorkshopController::class, 'sendBulkMailForm'])->name('sendBulkMailForm');
        Route::post('/send-bulk-mail', [WorkshopController::class, 'sendBulkMail'])->name('sendBulkMail');
        // for applied
        Route::get('/requested', [WorkshopController::class, 'requested'])->name('requested');
        Route::post('/make-decision-form', [WorkshopController::class, 'makeDecisionForm'])->name('makeDecisionForm');
        Route::post('/decide-workshop-request', [WorkshopController::class, 'decideRequest'])->name('decideRequest');
        Route::get('/discussions/{slug}', [WorkshopController::class, 'discussions'])->name('discussions');
    });

    // workshop trainers routes
    Route::controller(WorkshopTrainerController::class)->prefix('cms/workshop-trainers/')->name('workshop-trainer.')->group(function () {
        Route::get('{slug}', 'index')->name('index');
        Route::get('create/{slug}', 'create')->name('create');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{slug}/{trainer}', 'edit')->name('edit');
        Route::any('update/{trainer}', 'update')->name('update');
        Route::get('destroy/{trainer}', 'destroy')->name('destroy');
        Route::get('applied/{slug}', 'applied')->name('applied');
    });

    // workshop registration routes
    Route::resource('/cms/workshop-registration', WorkshopRegistrationController::class)->except('show', 'create');
    Route::controller(WorkshopRegistrationController::class)->name('workshop-registration.')->prefix('/dash/workshop-registration')->group(function () {
        Route::get('/create/{slug}', 'create')->name('create');
        Route::get('/registrants/{slug}', 'registrants')->name('registrants');
        Route::post('/verify-form', 'verifyForm')->name('verifyForm');
        Route::post('/verify', 'verify')->name('verify');
        Route::get('/excel-export/{id}', 'excelExport')->name('excelExport');
        Route::get('/fone-pay/{id}/{price}', 'fonePay')->name('fonePay');
        Route::get('/fone-pay-success', 'fonePaySuccess')->name('fonePaySuccess');
        Route::post('/submit-data', 'submitData')->name('submitData');
        Route::get('/registration-or-invitation', 'registrationByAdmin')->name('byAdmin');
        Route::post('/registration-or-invitation-submit', 'registrationByAdminSubmit')->name('byAdminSubmit');
        Route::get('/generate-certificate/{id}', 'generateCertificate')->name('generateCertificate');
        Route::get('/generate-pass/{id}', 'generatePass')->name('generatePass');
        Route::get('/generate-individual-pass/{workshopRegistration}', 'generateIndividualPass')->name('generateIndividualPass');
        Route::post('/take-attendance', 'takeAttendance')->name('takeAttendance');
        Route::get('/create-international/{id}/{price}', 'createInternational')->name('createInternational');
        Route::get('/international-payment-result/success-process', 'internationalPaymentResultSuccessProcess')->name('internationalPaymentResultSuccessProcess');
        Route::get('/international-payment-result/success', 'internationalPaymentResultSuccess')->name('internationalPaymentResultSuccess');
        Route::post('/online-payment-submit', 'onlinePaymentSubmit')->name('submit');
        Route::get('/international-payment-result/fail', 'internationalPaymentResultFail')->name('internationalPaymentResultFail');
        Route::get('/international-payment-result/cancel', 'internationalPaymentResultCancel')->name('internationalPaymentResultCancel');
        Route::get('/international-payment-result/backend', 'internationalPaymentResultBackend')->name('internationalPaymentResultBackend');
        Route::get('/registration-for-signed-up-users', 'registrationForSignedUpUsers')->name('forSignedUpUsers');
        Route::post('/registration-for-signed-up-users-submit', 'registrationForSignedUpUsersSubmit')->name('forSignedUpUsersSubmit');
        // Route::get('/sendRecipt', 'sendRecipt')->name('sendRecipt');
    });
    Route::get('/workshop-participant/profile/{token}', [WorkshopRegistrationController::class, 'participantProfile']);

    // routes for schedule & sub-schdules
    Route::resource('/cms/hall', HallController::class)->except('show');
    Route::resource('/cms/schedule', ScheduleController::class)->except('show');
    Route::controller(SubScheduleController::class)->name('sub-schedule.')->prefix('/cms/sub-schedule')->group(function () {
        Route::get('/get-data/{slug}', 'index')->name('index');
        Route::get('/create/{slug}', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{subSchedule}', 'edit')->name('edit');
        Route::match(['put', 'patch'], '/update/{subSchedule}', 'update')->name('update');
        Route::delete('/destroy/{subSchedule}', 'destroy')->name('destroy');
    });

    // accomodation routes
    Route::resource('/cms/hotel', HotelController::class)->except('show');
    Route::get('/cms/hotel/{hotel}/image/{img}', [HotelController::class, 'deleteImage'])->name('hotel.image.delete');
    Route::get('/cms/hotel/change-status/{hotel}', [HotelController::class, 'changeStatus'])->name('hotel.changeStatus');

    // committee & committee members route
    Route::resource('/cms/committee', CommitteeController::class)->except('show');
    Route::get('status-payment', [CommitteeController::class, 'paymentStatus'])->name('committeStatus.payment');
    Route::get('/cms/committee-members/{slug}', [CommitteeMemberController::class, 'index'])->name('committeeMember.index');
    Route::get('/cms/committee-members/create/{slug}', [CommitteeMemberController::class, 'create'])->name('committeeMember.create');
    Route::post('/cms/committee-members/store', [CommitteeMemberController::class, 'store'])->name('committeeMember.store');
    Route::get('/cms/committee-members/edit/{committee_member}', [CommitteeMemberController::class, 'edit'])->name('committeeMember.edit');
    Route::match(['put', 'patch'], '/cms/committee-members/update/{committee_member}', [CommitteeMemberController::class, 'update'])->name('committeeMember.update');
    Route::delete('/cms/committee-members/destroy/{committee_member}', [CommitteeMemberController::class, 'destroy'])->name('committeeMember.destroy');
    Route::get('/cms/committee-members/change-featured/{committee_member}', [CommitteeMemberController::class, 'changeFeatured'])->name('committeeMember.changeFeatured');
    Route::post('/cms/committee-members/submit-data', [CommitteeMemberController::class, 'submitData'])->name('committeeMember.submitData');

    // sponsors route
    Route::resource('/cms/sponsor-category', SponsorCategoryController::class)->except('show');
    Route::resource('/cms/sponsor', SponsorController::class)->except('show');
    Route::get('/cms/sponsor/change-status/{sponsor}', [SponsorController::class, 'changeStatus'])->name('sponsor.changeStatus');
    Route::resource('/cms/sponsor-invitation', SponsorInvitationController::class)->except('show');
    Route::post('/cms/sponsor/invite-for-conference-form', [SponsorController::class, 'inviteForConferenceForm'])->name('sponsor.inviteForConferenceForm');
    Route::post('/cms/sponsor/invite-for-conference', [SponsorController::class, 'inviteForConference'])->name('sponsor.inviteForConference');
    Route::get('/cms/sponsor/generate-pass', [SponsorController::class, 'generatePass'])->name('sponsor.generatePass');
    Route::get('/sponsor/profile/{token}', [SponsorController::class, 'sponsorProfile']);
    Route::get('/sponsor/take-dinner/{id}/{day}/{type}', [SponsorController::class, 'takeDinner'])->name('sponsor.takeDinner');
    Route::post('/sponsor/add-participant', [SponsorController::class, 'addParticipant'])->name('sponsor.addParticipant');
    Route::post('/sponsor/add-participant-submit', [SponsorController::class, 'addParticipantSubmit'])->name('sponsor.addParticipantSubmit');

    // certificate routes
    Route::resource('/cms/background', BackgroundController::class)->except('show');
    Route::resource('/cms/signature', SignatureController::class)->except('show');
    Route::get('/cms/certificate', [CertificateController::class, 'index'])->name('certificate.index');
    Route::get('/cms/certificate-generate', [CertificateController::class, 'generate'])->name('certificate.generate');
    Route::get('/cms/certificate-generate-individual/{id}', [CertificateController::class, 'generateIndividual'])->name('certificate.generateIndividual');

    // name prefix routes
    Route::resource('/cms/name-prefix', NamePrefixController::class)->except('show');

    // faq's route
    Route::resource('/cms/faq', FAQController::class)->except('show');

    // downloads route
    Route::resource('/cms/download', DownloadController::class)->except('show');
    Route::get('/cms/download/change-featured/{download}', [DownloadController::class, 'changeFeatured'])->name('download.changeFeatured');

    // downloads route
    Route::resource('/cms/content', ContentController::class)->except('show');

    // scientific session route
    Route::resource('/cms/scientific-session-category', ScientificSessionCategoryController::class)->except('show');
    Route::resource('/cms/scientific-session', ScientificSessionController::class)->except('show');
    Route::post('/scientific-session/view-data', [ScientificSessionController::class, 'show'])->name('scientific-session.show');
    Route::get('/scientific-session/export-excel', [ScientificSessionController::class, 'exportExcel'])->name('scientific-session.exportExcel');

    // notice route
    Route::resource('/cms/notice', NoticeController::class)->except('show');
    Route::post('/cms/notice/view-data', [NoticeController::class, 'show'])->name('notice.show');
    Route::get('/cms/notice/change-featured/{notice}', [NoticeController::class, 'changeFeatured'])->name('notice.changeFeatured');

    // designations route
    Route::resource('/cms/designation', DesignationController::class)->except('show');
    Route::get('/cms/designation/order', [DesignationController::class, 'order'])->name('designation.order');
    Route::post('/cms/designation/order-submit', [DesignationController::class, 'orderSubmit'])->name('designation.orderSubmit');

    Route::post('/ckeditor/file-upload', [CkEditorController::class, 'ckEditorUpload'])->name('ckeditor.fileUpload');
});
Route::post('/send-pass-email', [ConferenceRegistrationController::class, 'sendPassEmail']);
