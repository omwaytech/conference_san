@extends('layouts.front')

<!-- jsPDF & html2canvas -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

@section('content')
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=keyboard_arrow_down" />

    <div class="single-case-studies-bread-crumb-area area-2 pt--20 pb--40" style="border-top:#9699AF 1px solid;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12"> 
                    <div class="breadcrumb-inner">
                        <div class="pagimation">
                            <a href="{{ route('front.index') }}">Home</a><i class="fa-regular fa-chevron-right"></i>

                            <a href="#" class="current">Scientific Sessions
                            </a>
                        </div>
                        <h2 class="title split-collab" style="font-size:50px; font-weight:none;">Scientific Sessions
                            </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="rts-section-gapBottom rts-blog-area-one">
        <div class="container">

            <div class="row g-48 mt--0 justify-content-sm-center justify-content-md-start">
                <div class="block_1">
                    <div class="schedule-warp">
                        <div class="col-lg-12">
                            <div class="accordion-faq-area-border-bottom-style style-four">
                                <div class="accordion" id="accordionExamples">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-0">
                                            <button class="accordion-button " type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse-0" aria-expanded="true"
                                                aria-controls="collapse-0">
                                                <div style="font-size:20px">
                                                    Day 1
                                                </div>
                                                <div class="d-flex align-items-center ms-auto">
                                                    <span class="session-time">
                                                        2025-04-04
                                                    </span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse-0" class="accordion-collapse collapse show"
                                            aria-labelledby="heading-0" data-bs-parent="#accordionExamples">
                                            <div class="accordion-body">
                                                <ul class="nav nav-tabs" role="tablist" id="hallTabs">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="tab-0-0" data-bs-toggle="tab"
                                                            href="#content-0-0" role="tab" aria-controls="content-0-0"
                                                            aria-selected="true">
                                                            Common Hall
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link " id="tab-0-1" data-bs-toggle="tab"
                                                            href="#content-0-1" role="tab" aria-controls="content-0-1"
                                                            aria-selected="false">
                                                            Hall A
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link " id="tab-0-2" data-bs-toggle="tab"
                                                            href="#content-0-2" role="tab" aria-controls="content-0-2"
                                                            aria-selected="false">
                                                            Hall B
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="tab-0-3" data-bs-toggle="tab"
                                                            href="#content-0-3" role="tab" aria-controls="content-0-3"
                                                            aria-selected="false">
                                                            Hall C
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="tab-0-4" data-bs-toggle="tab"
                                                            href="#content-0-4" role="tab" aria-controls="content-0-4"
                                                            aria-selected="false">
                                                            Hall D
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="tab-0-5" data-bs-toggle="tab"
                                                            href="#content-0-5" role="tab" aria-controls="content-0-5"
                                                            aria-selected="false">
                                                            Hall E
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="tab-0-6" data-bs-toggle="tab"
                                                            href="#content-0-6" role="tab" aria-controls="content-0-6"
                                                            aria-selected="false">
                                                            Lobby
                                                        </a>
                                                    </li>

                                                </ul>
                                                <div class="tab-content mt-3">
                                                    <div class="tab-pane fade show active" id="content-0-0"
                                                        role="tabpanel" aria-labelledby="tab-0-0">
                                                        <div class="tab-content">
                                                            <div class="tab-pane fade show active" id="content-0-0"
                                                                role="tabpanel" aria-labelledby="tab-0-0">
                                                                <div class="accordion mt-3" id="innerAccordion-0-0">
                                                                    <!-- Inaugural Session -->
                                                                    <div class="accordion-item collapsed">
                                                                        <h2 class="accordion-header"
                                                                            id="inaugural-session">
                                                                            <button
                                                                                class="collapsed d-flex justify-content-between align-items-center"
                                                                                type="button" data-bs-toggle="collapse"
                                                                                data-bs-target="#inaugural-collapse"
                                                                                aria-expanded="true"
                                                                                aria-controls="inaugural-collapse">
                                                                                <div class="title-text">
                                                                                    INAUGURAL SESSION <br />
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex align-items-center ms-auto">
                                                                                    <span class="session-time">
                                                                                        8:00 AM to 10:10 AM
                                                                                    </span>
                                                                                    <span
                                                                                        class="material-symbols-outlined">
                                                                                        keyboard_arrow_down
                                                                                    </span>
                                                                                </div>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="inaugural-collapse"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="inaugural-session"
                                                                            data-bs-parent="#innerAccordion-0-0">
                                                                            <div class="accordion-body">
                                                                                <ul>
                                                                                    <li><b>8:00 AM to 8:30 AM</b> -
                                                                                        Registration</li>
                                                                                    <li><b>8:30 AM to 9:30 AM</b> -
                                                                                        Inauguration</li>
                                                                                    <li><b>9:30 AM to 10:00 AM</b> -
                                                                                        Prof. Dr. Roshana Amatya Oration
                                                                                    </li>
                                                                                    <li><b>10:00 AM to 10:10 AM</b> -
                                                                                        Break</li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="accordion-item collapsed">
                                                                        <h2 class="accordion-header"
                                                                            id="thematic-session">
                                                                            <button
                                                                                class="collapsed d-flex justify-content-between align-items-center"
                                                                                type="button" data-bs-toggle="collapse"
                                                                                data-bs-target="#thematic-collapse"
                                                                                aria-expanded="true"
                                                                                aria-controls="thematic-collapse">
                                                                                <div class="title-text">
                                                                                    THEMATIC SESSION <br />
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex align-items-center ms-auto">
                                                                                    <span class="session-time">
                                                                                        10:10 AM to 11:25 AM
                                                                                    </span>
                                                                                    <span
                                                                                        class="material-symbols-outlined">
                                                                                        keyboard_arrow_down
                                                                                    </span>
                                                                                </div>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="thematic-collapse"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="thematic-session"
                                                                            data-bs-parent="#innerAccordion-0-0">
                                                                            <div class="accordion-body">
                                                                                <ul>
                                                                                    <li><b>10:10 AM to 10:35 AM</b> -
                                                                                        Evolution of Pediatric
                                                                                        Anesthesia as I See
                                                                                        It<br /><small><i>Masao
                                                                                                Yamashita</i></small></li>
                                                                                    <li><b>10:35 AM to 11:00 AM</b> -
                                                                                        Resilience for Healthcare
                                                                                        Providers<br /><small><i>Gregory
                                                                                                Hammer</i></small></li>
                                                                                    <li><b>11:00 AM to 11:25 AM</b> -
                                                                                        Pediatric Anesthesia: Challenges
                                                                                        and Opportunities for
                                                                                        Nepal<br /><small><i>Balkrishna
                                                                                                Bhattarai</i></small>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Keynote Address -->
                                                                    <div class="accordion-item collapsed">
                                                                        <h2 class="accordion-header" id="keynote-address">
                                                                            <button
                                                                                class="collapsed d-flex justify-content-between align-items-center"
                                                                                type="button" data-bs-toggle="collapse"
                                                                                data-bs-target="#keynote-collapse"
                                                                                aria-expanded="true"
                                                                                aria-controls="keynote-collapse">
                                                                                <div class="title-text">
                                                                                    KEYNOTE ADDRESS <br />
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex align-items-center ms-auto">
                                                                                    <span class="session-time">
                                                                                        11:25 AM to 11:55 AM
                                                                                    </span>
                                                                                    <span
                                                                                        class="material-symbols-outlined">
                                                                                        keyboard_arrow_down
                                                                                    </span>
                                                                                </div>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="keynote-collapse"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="keynote-address"
                                                                            data-bs-parent="#innerAccordion-0-0">
                                                                            <div class="accordion-body">
                                                                                <ul>
                                                                                    <li><b>11:25 AM to 11:55 AM</b> -
                                                                                        Regional Anesthesia in Children:
                                                                                        My Journey Over 50 Years
                                                                                        <br /><small><i>Adrian
                                                                                                Bosenberg</i></small></li>

                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="accordion-item collapsed">
                                                                        <h2 class="accordion-header" id="int-aspa">
                                                                            <button
                                                                                class="collapsed d-flex justify-content-between align-items-center"
                                                                                type="button" data-bs-toggle="collapse"
                                                                                data-bs-target="#int-aspa-collapse"
                                                                                aria-expanded="true"
                                                                                aria-controls="int-aspa">
                                                                                <div class="title-text">
                                                                                    Introduction to ASPA 2026 <br />
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex align-items-center ms-auto">
                                                                                    <span class="session-time">
                                                                                        11:55 AM to 12:05 PM
                                                                                    </span>
                                                                                    <span
                                                                                        class="material-symbols-outlined">
                                                                                        keyboard_arrow_down
                                                                                    </span>
                                                                                </div>
                                                                            </button>
                                                                        </h2>
                                                                        <div id="int-aspa-collapse"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="int-aspa"
                                                                            data-bs-parent="#innerAccordion-0-0">
                                                                            <div class="accordion-body">
                                                                                <ul>
                                                                                    <li><b>11:55 AM to 12:05 PM</b>
                                                                                        <br /><small><i>Ekta Rai</i></small>
                                                                                    </li>

                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="content-0-1" role="tabpanel"
                                                        aria-labelledby="tab-0-1">
                                                        <div class="accordion mt-3" id="innerAccordion-0-1">

                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-2">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-2"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-2">
                                                                        <div class="title-text ">
                                                                            BRAIN DRAIN <br />Moderators:
                                                                            <small><i>Balkrishna Bhattarai, Murli
                                                                                    Aluvalia</i></small>
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                13:00 PM to 13:30 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-2"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-2"
                                                                    data-bs-parent="#innerAccordion-0-0">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li><b>13:00 PM to 13:15 PM </b> - Impact of
                                                                                anesthesia on pediatric neurodevelopment
                                                                                –Have we put this to rest? <br />
                                                                                <small><i>Andrew Davidson</i></small>
                                                                            </li>

                                                                            <li><b>13:15 PM to 13:30 PM </b> - Burnouts
                                                                                in a
                                                                                demanding field like pediatric
                                                                                anesthesia <br /><small><i>Elsa Varghese
                                                                                    </i></small></li>
                                                                        </ul>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-3">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-3"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-3">
                                                                        <div class="title-text">
                                                                            BRAIN DRAIN <br />Moderators:
                                                                            <small><i>Murli Aluvalia, Josephine
                                                                                    Tan</i></small>
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                13:30 PM to 15:00 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-3"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-3"
                                                                    data-bs-parent="#innerAccordion-0-0">
                                                                    <div class="accordion-body">

                                                                        <ul>
                                                                            <li><b>13:30 PM to 14:00 PM </b> - THE GREAT
                                                                                ANESTHESIA DEBATE I <br />
                                                                                Fast track – Either you like it or you
                                                                                don’t! <br />
                                                                                1. Fast track way to go! <br />
                                                                                <small><i>Kriti Puri</i></small><br />
                                                                                2. Beware!! nature takes its course
                                                                                <br />
                                                                                <small><i> Amrita Rath</i></small>
                                                                            </li>
                                                                            <li><b>14:00 PM to 14:30 PM </b> - THE GREAT
                                                                                ANESTHESIA DEBATE II <br />
                                                                                Sedation Vs General Anaesthesia for a
                                                                                sick infant in IR suite<br />
                                                                                Sedation is the way to go ! <br />
                                                                                <small><i>Vivian Yuen</i></small><br />
                                                                                Definitely General Anaesthesia <br />
                                                                                <small><i>Joy Luat Inciong</i></small>
                                                                            </li>
                                                                            <li><b>14:30 PM to 14:45 PM </b> -
                                                                                Radiotherapy in
                                                                                Children – More than what Meets the Eye
                                                                                <br />
                                                                                <small><i>Agnes Ng </i></small>
                                                                            </li>
                                                                            <li><b>14:45 PM to 15:00 PM </b> - Q & A
                                                                            </li>
                                                                        </ul>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-4">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-4"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-4">
                                                                        <div class="title-text">

                                                                            ADVANCEMENTS AND CHALLENGES IN PEDIATRIC
                                                                            SEDATION, <br />Moderators:
                                                                            <small><i>Rebecca Jacob, Reshma
                                                                                    Shrestha</i></small>
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                15:00 PM to 16: 15 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-4"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-4"
                                                                    data-bs-parent="#innerAccordion-0-0">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li><b>15:00 PM to 15:15 PM </b> - Exploring
                                                                                the
                                                                                benefits and risks: Navigating pediatric
                                                                                sedation outcomes<br />
                                                                                <small><i>Keira Mason</i></small>
                                                                            </li>
                                                                            <li><b>15:15 PM to 15:30 PM </b> - TCI in
                                                                                pediatric
                                                                                sedation: Is it worth while ?<br />
                                                                                <small><i>Vivian Yuen</i></small>
                                                                            </li>
                                                                            <li><b>15:30 PM to 15:45 PM </b> - Building
                                                                                a
                                                                                seamless sedation service : Strategies
                                                                                for success<br />
                                                                                <small><i>Ekta Rai</i></small>
                                                                            </li>
                                                                            <li><b>15:45 PM to 16:00 PM </b> - Beyond
                                                                                Propofol :
                                                                                Unlocking the potential of
                                                                                dexmedetomidine for pediatric
                                                                                sedation<br />
                                                                                <small><i>Keira Mason</i></small>
                                                                            </li>
                                                                            <li><b>1600 PM to 16:15 PM </b> - Q & A
                                                                            </li>
                                                                        </ul>

                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade " id="content-0-2" role="tabpanel"
                                                        aria-labelledby="tab-0-2">
                                                        <div class="accordion mt-3" id="innerAccordion-0-2">


                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-5">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-5"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-5">
                                                                        <div class="title-text">
                                                                            ANESTHESIA RECIPES FOR COMPLEX MEDICAL
                                                                            CONDITIONS <br />Moderators: <small>
                                                                                <i>Navindra
                                                                                    Raj Bista, Suneerat
                                                                                    Kongsayreepong</i></small>
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                13:00 PM to 15:00 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-5"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-5"
                                                                    data-bs-parent="#innerAccordion-0-2">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li><b>13:00 PM to 13:15 PM </b> - The best
                                                                                for the
                                                                                brain- Anesthesia for
                                                                                Neurosurgeries<br />
                                                                                Ventriculoperitoneal shunts – 5 things
                                                                                that bother an anesthesiologist<br />
                                                                                <small><i>Hee-Soo Kim</i></small>
                                                                            </li>
                                                                            <li><b>13:15 PM to 13:30 PM </b> -
                                                                                Meningomyelocele<br />
                                                                                <small><i>Benjamin Daniel Valera
                                                                                    </i></small>
                                                                            </li>
                                                                            <li> <b>13: 30 PM to 13: 45 PM </b> -
                                                                                Anesthesia for
                                                                                Posterior Fossa Surgery <br />
                                                                                <small><i>Pichaya Waitayawinyu
                                                                                    </i></small>
                                                                            </li>
                                                                            <li><b>13:45 PM to 14:00 PM </b> - Q & A
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-6">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-6"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-6">
                                                                        <div class="title-text">

                                                                            ANESTHESIA RECIPES FOR COMPLEX MEDICAL
                                                                            CONDITIONS <br />Moderators:
                                                                            <small><i>Jijian Zheng,
                                                                                    Prabhat Ranjan Baral</i></small>
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                14:00 PM to 15:15 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-6"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-6"
                                                                    data-bs-parent="#innerAccordion-0-2">
                                                                    <div class="accordion-body">

                                                                        <ul>
                                                                            <li><b>14:00 PM to 14:15 PM </b> -
                                                                                Anesthesia
                                                                                for cleft lips and palate – worth
                                                                                celebrating ! (CLAPS)<br />
                                                                                Preoperative optimization – How and
                                                                                Why?<br />
                                                                                <small><i>Ina Ismiarti Shariffuddin
                                                                                    </i></small>
                                                                            </li>
                                                                            <li><b>14:15 PM to 14:30 PM </b> - Airway
                                                                                Considerations in Cleft Lip and
                                                                                Palate Surgeries<br />
                                                                                <small><i>Vibhavari Naik
                                                                                    </i></small>
                                                                            </li>
                                                                            <li><b>14:30 PM to 14:45 PM </b> -
                                                                                Comprehensive anesthesia care for
                                                                                cleft palate surgeries – from OR
                                                                                ergonomics to
                                                                                postoperative pain relief<br />
                                                                                <small><i>Shemila Abbasi
                                                                                    </i></small>
                                                                            </li>
                                                                            <li><b>14:45 PM to 15:00 PM </b> -
                                                                                Complications
                                                                                of Cleft Lip and Palate
                                                                                Surgeries<br />
                                                                                <small><i>Angelina Gapay
                                                                                    </i></small>
                                                                            </li>
                                                                            <li><b>15:00 PM to 15:15 PM </b> - Q & A
                                                                            </li>
                                                                        </ul>

                                                                    </div>
                                                                </div>
                                                            </div>



                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-8">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-8"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-8">
                                                                        <div class="title-text">
                                                                            OUCH-LESS SUMMIT Challenging Pain Cases In
                                                                            Children<br />
                                                                            Moderators: <small><i>Duenpen Horatanaruang,
                                                                                    Renu
                                                                                    Gurung</i></small></div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                15:00 PM to 16:15 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-8"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-8"
                                                                    data-bs-parent="#innerAccordion-0-4">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li><b>15:15 PM to 15:30 PM </b> - Sedation
                                                                                and Analgesia
                                                                                Techniques for Critically Ill
                                                                                Neonates<br />
                                                                                <small><i>Teddy Fabila</i></small>
                                                                            </li>
                                                                            <li><b>15:30 PM to 15:45 PM </b> - Oncology
                                                                                patient with High
                                                                                Opioid Requirement Coming for a
                                                                                Procedure<br />
                                                                                <small><i>Anuradha Sudhir</i></small>
                                                                            </li>
                                                                            <li><b>15:45 PM to 16:00 PM </b> -
                                                                                Challenges of Transitioning
                                                                                Pediatric Chronic Pain Patients to
                                                                                Adults
                                                                                Institution<br />
                                                                                <small><i>Kathrina Isabel
                                                                                        Epino</i></small>
                                                                            </li>
                                                                            <li><b>16:00 PM to 16:15 PM </b> -
                                                                                Postoperative Pain Management
                                                                                in Children – Newer Insights <br />
                                                                                <small><i>Ayuko Igarashi</i></small>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="content-0-3" role="tabpanel"
                                                        aria-labelledby="tab-0-3">
                                                        <div class="accordion mt-3" id="innerAccordion-0-3">
                                                            <!-- Pain Session -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-9">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-9"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-9">
                                                                        <div class="title-text">
                                                                            <b>Pain Session</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">13:00 PM to 14:30
                                                                                PM</span>
                                                                            <span
                                                                                class="material-symbols-outlined">keyboard_arrow_down</span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-9"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-9"
                                                                    data-bs-parent="#innerAccordion-0-3">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li><b>13:00 PM – 13:15 PM</b> - Necessity
                                                                                is the mother of Invention: Preliminary
                                                                                Report on Pain Management in Children
                                                                                with Pancreatitis In India<br />
                                                                                <small><i>Anuradha Ganigara</i></small>
                                                                            </li>
                                                                            <li><b>13:15 PM – 13:30 PM</b> - Vertebral
                                                                                Augmentation for Spinal Fracture: One
                                                                                Year Experience<br />
                                                                                Choosing the right premedication by
                                                                                age<br />
                                                                                <small><i>Jay Prakash Thakur</i></small>
                                                                            </li>
                                                                            <li><b>13:30 PM – 13:45 PM</b> - Recent
                                                                                Trends in Inter-fascial plane blocks for
                                                                                thoracic surgeries<br />
                                                                                <small><i>Reena</i></small>
                                                                            </li>
                                                                            <li><b>13:45 PM – 14:00 PM</b> - Safety
                                                                                practice guidelines for chronic pain
                                                                                interventions: local perspective<br />
                                                                                <small><i>Ninadini Shrestha</i></small>
                                                                            </li>
                                                                            <li><b>14:00 PM – 14:15 PM</b> - The
                                                                                complexities of complex regional pain
                                                                                syndrome<br />
                                                                                <small><i>Prabhat Rawal</i></small>
                                                                            </li>
                                                                            <li><b>14:15 PM – 14:30 PM</b> - Q and A
                                                                            </li>
                                                                            <li>Break</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Cardiothoracic Anesthesia Session -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-10">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-10"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-10">
                                                                        <div class="title-text">
                                                                            <b>Cardiothoracic Anesthesia
                                                                                Session</b>
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">14:45 PM to 16:15
                                                                                PM</span>
                                                                            <span
                                                                                class="material-symbols-outlined">keyboard_arrow_down</span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-10"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-10"
                                                                    data-bs-parent="#innerAccordion-0-3">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li><b>14:45 PM – 15:00 PM</b> - Anesthesia
                                                                                for Heart Transplant<br />
                                                                                <small><i>Muralidhar Kanchi</i></small>
                                                                            </li>
                                                                            <li><b>15:00 PM – 15:15 PM</b> - Managing
                                                                                patients with LV diastolic
                                                                                dysfunction<br />
                                                                                <small><i>Sundar Negi</i></small>
                                                                            </li>
                                                                            <li><b>15:15 PM – 15:30 PM</b> - Managing
                                                                                patients with cardiac implant
                                                                                devices<br />
                                                                                <small><i>Krishna Prasad Gourav
                                                                                        Kalla</i></small>
                                                                            </li>
                                                                            <li><b>15:30 PM – 15:45 PM</b> - Anaesthetic
                                                                                challenges in Minimally Invasive Cardiac
                                                                                Surgery<br />
                                                                                <small><i>Rabin Baidya</i></small>
                                                                            </li>
                                                                            <li><b>15:45 PM – 16:00 PM</b> -
                                                                                Perioperative TEE for noncardiac
                                                                                surgeries<br />
                                                                                <small><i>Smriti Mahaju</i></small>
                                                                            </li>
                                                                            <li><b>16:00 PM – 16:15 PM</b> - Anesthesia
                                                                                for rupture of sinus of valsalva<br />
                                                                                <small><i>Kanchan Prakash
                                                                                        Poudyal</i></small>
                                                                            </li>
                                                                            <li><b>16:00 PM – 16:15 PM</b> - Q and A
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="content-0-4" role="tabpanel"
                                                        aria-labelledby="tab-0-4">
                                                        <div class="accordion mt-3" id="innerAccordion-0-4">

                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header"
                                                                    id="session-regional-anesthesia">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-regional-anesthesia"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-regional-anesthesia">
                                                                        <div class="title-text">
                                                                            <b>Regional Anesthesia Session</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">13:00 PM to 14:30
                                                                                PM</span>
                                                                            <span
                                                                                class="material-symbols-outlined">keyboard_arrow_down</span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-regional-anesthesia"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-regional-anesthesia"
                                                                    data-bs-parent="#innerAccordion-0-4">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li><b>13:00 PM – 13:15 PM</b> - Regional
                                                                                Anesthesia: History, Myth and
                                                                                Facts<br />
                                                                                <small><i>Navin Pokharel</i></small>
                                                                            </li>
                                                                            <li><b>13:15 PM – 13:30 PM</b> - Exploring
                                                                                Pandora’s box: Use of anticoagulants in
                                                                                RA<br />
                                                                                <small><i>Jeevan Tamang</i></small>
                                                                            </li>
                                                                            <li><b>13:30 PM – 13:45 PM</b> - The role of
                                                                                RA in reducing opioid use<br />
                                                                                <small><i>Deepak Kumar Yadav</i></small>
                                                                            </li>
                                                                            <li><b>13:45 PM – 14:00 PM</b> - Epidural
                                                                                analgesia vs Paravertebral vs ESP block:
                                                                                What is the current understanding<br />
                                                                                <small><i>Ravi Wankhede</i></small>
                                                                            </li>
                                                                            <li><b>14:00 PM – 14:15 PM</b> - USG
                                                                                guidance for Nerve blocks: Principles
                                                                                and Practical implication<br />
                                                                                <small><i>Neetish Kafle</i></small>
                                                                            </li>
                                                                            <li><b>14:15 PM – 14:30 PM</b> - Q and A
                                                                            </li>
                                                                            <li>Break</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header"
                                                                    id="session-obstetric-anesthesia">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-obstetric-anesthesia"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-obstetric-anesthesia">
                                                                        <div class="title-text">
                                                                            <b>Obstetric Anesthesia Session</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">14:45 PM to 16:30
                                                                                PM</span>
                                                                            <span
                                                                                class="material-symbols-outlined">keyboard_arrow_down</span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-obstetric-anesthesia"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-obstetric-anesthesia"
                                                                    data-bs-parent="#innerAccordion-0-4">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li><b>14:45 PM – 15:00 PM</b> -
                                                                                Cutting-edge labor analgesia: Best
                                                                                practices for anticoagulated parturient
                                                                                during childbirth<br />
                                                                                <small><i>Nitin Choudhary</i></small>
                                                                            </li>
                                                                            <li><b>15:00 PM – 15:15 PM</b> -
                                                                                Preoperative anxiety and sociocultural
                                                                                factors in women undergoing cesarean
                                                                                section<br />
                                                                                <small><i>Manju Maharjan</i></small>
                                                                            </li>
                                                                            <li><b>15:15 PM – 15:30 PM</b> - Elective
                                                                                Caesarean Section of a Patient with
                                                                                Renal Transplant Under Spinal
                                                                                Anesthesia<br />
                                                                                <small><i>Joshan Lal
                                                                                        Bajracharya</i></small>
                                                                            </li>
                                                                            <li><b>15:30 PM – 15:40 PM</b> - Q and A
                                                                            </li>
                                                                            <li><b>15:40 PM – 16:30 PM</b> - Panel
                                                                                Discussion: Cardiac disease in
                                                                                pregnancy. A Multidisciplinary approach
                                                                                to care<br />
                                                                                <b>Moderator: Tara Gurung</b><br />
                                                                                <b>Panelists:</b><br />
                                                                                Babu Raja Shrestha, Daisy Sangraula,
                                                                                Chandra Mani Paudel, Rosina Manandhar
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="content-0-5" role="tabpanel"
                                                        aria-labelledby="tab-0-5">
                                                        <div class="accordion mt-3" id="innerAccordion-0-5">
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-9">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-9"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-9">
                                                                        <div class="title-text">
                                                                            <b>Patient Safety Session</b> <br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                13:00 PM to 14:45 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-9"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-9"
                                                                    data-bs-parent="#innerAccordion-0-5">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li><b>13:00 PM – 13:15 PM</b> - Anesthesia
                                                                                Safety Foundation – Clinical Pearls
                                                                                <br />
                                                                                <small><i>Carl Gutierrez</i></small>
                                                                            </li>
                                                                            <li><b>13:15 PM – 13:30 PM</b> - Medication
                                                                                safety and emergency intervention in
                                                                                pediatric anesthesia: A case of
                                                                                incorrect remifentanil bolus
                                                                                administration<br />
                                                                                <small><i>Duygu Kara</i></small>
                                                                            </li>
                                                                            <li><b>13:30 PM – 13:45 PM</b> -
                                                                                Intraoperative awareness in anesthesia
                                                                                <br />
                                                                                <small><i>Gurjeet Khurana</i></small>
                                                                            </li>
                                                                            <li><b>13:45 PM – 13:55 PM</b> - Q and
                                                                                A<br />
                                                                            </li>
                                                                            <li><b>13:55 PM – 14:45 PM</b> - Panel
                                                                                Discussion: Psychological safety of
                                                                                anesthesiologists and its impact on
                                                                                patient safety<br />
                                                                                <b>Moderator:</b> Dr. Jyoti KC Khatri
                                                                                <br />
                                                                                <b>Panelists:</b> Apurba Sharma, Subhash
                                                                                P. Acharya, Manjusha M. Shah, Tanvir
                                                                                Samra
                                                                            </li>
                                                                            <li>Break</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-10">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-10"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-10">
                                                                        <div class="title-text">
                                                                            <b>Onco-Anaesthesia Session 1</b> <br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                14:55 PM to 16:30 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-10"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-10"
                                                                    data-bs-parent="#innerAccordion-0-5">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li><b>14:55 PM – 15:10 PM</b> -
                                                                                Oncoanesthesia – Is it the need of the
                                                                                hour? <br />
                                                                                <small><i>Rajiv Chawla</i></small>
                                                                            </li>
                                                                            {{-- <li><b>15:00 PM – 15:15 PM</b> -
                                                                                Preoperative anxiety and sociocultural
                                                                                factors in women undergoing cesarean
                                                                                section <br />
                                                                                <small><i>Manju Maharjan</i></small>
                                                                            </li> --}}
                                                                            <li><b>15:10 PM – 15:25 PM</b> -
                                                                                Perioperative management of CRS HIPEC
                                                                                <br />
                                                                                <small><i>Vaishali
                                                                                        Waindeskar</i></small>
                                                                            </li>
                                                                            <li><b>15:25 PM – 15:35 PM</b> - Q and A
                                                                                <br /><br />
                                                                            </li>
                                                                            <li><b>15:35 PM – 16:30 PM</b> - Panel
                                                                                Discussion: A rare case of Parathyroid
                                                                                Carcinoma<br />
                                                                                <b>Moderator:</b> Abiya Pradhan <br />
                                                                                <b>Panelists:</b> Mona Sharma, Arogya
                                                                                Kandel, Madindra Basnet, Nitesh Goel
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="content-0-6" role="tabpanel"
                                                        aria-labelledby="tab-0-6">
                                                        <div class="accordion mt-3" id="innerAccordion-0-6">
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-1">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-1"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-1">
                                                                        <div class="title-text">
                                                                            <b>National Resident Poster Session 1</b>
                                                                            <br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                13:30 PM to 14:10 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-1"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-1"
                                                                    data-bs-parent="#innerAccordion-0-6">
                                                                    <div class="accordion-body">
                                                                        <div class="screen-title">
                                                                            <p class="td-fs-14px">Screen 1</p>
                                                                            <ul>
                                                                                <li><b>13:30 PM – 13:40 PM</b> -
                                                                                    Anesthetic Management of a
                                                                                    3-Year-Old Child with Occipital
                                                                                    Epidural Hematoma and Niemann-Pick
                                                                                    Disease: A Multisystem Challenge in
                                                                                    Emergency Neurosurgery <br />
                                                                                    <small><i>Sudarshan
                                                                                            Acharya</i></small>
                                                                                </li>
                                                                                <li><b>13:40 PM – 13:50 PM</b> -
                                                                                    Anesthetic Challenges in a Pediatric
                                                                                    Patient with Follicular Neoplasm and
                                                                                    Congenital Hypothyroidism Undergoing
                                                                                    Left Hemithyroidectomy: A Case
                                                                                    Report<br />
                                                                                    <small><i>Umesh Kumar
                                                                                            Yadav</i></small>
                                                                                </li>
                                                                                <li><b>13:50 PM – 14:00 PM</b> - Use of
                                                                                    Rocuronium and Sugammadex in the
                                                                                    Anesthetic Management for
                                                                                    Laparoscopic Cholecystectomy in a
                                                                                    Patient with Transverse Myelitis: A
                                                                                    Case Report <br />
                                                                                    <small><i>Bikram
                                                                                            Lamichhane</i></small>
                                                                                </li>
                                                                                <li><b>14:00 PM – 14:10 PM</b> - Airway
                                                                                    Management in a 6-Year-Old Child
                                                                                    with Obstructive Sleep Apnea
                                                                                    Secondary to Bilateral
                                                                                    Temporomandibular Joint (TMJ)
                                                                                    Ankylosis: A Case Report <br />
                                                                                    <small><i>Pawan Rai</i></small>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="screen-title">
                                                                            <p>Screen 2</p>
                                                                            <ul>
                                                                                <li><b>13:30 PM – 13:40 PM</b> -
                                                                                    Postoperative Myocardial Infarction
                                                                                    in Patients with Type II Diabetes
                                                                                    Mellitus <br />
                                                                                    <small><i>Gyabina
                                                                                            Maharjan</i></small>
                                                                                </li>
                                                                                <li><b>13:40 PM – 13:50 PM</b> -
                                                                                    Navigation Guided Brain Abscess
                                                                                    Drainage in a Patient with
                                                                                    Uncorrected Tetralogy of
                                                                                    Fallot<br />
                                                                                    <small><i>Suyash Ghimire</i></small>
                                                                                </li>
                                                                                <li><b>13:50 PM – 14:00 PM</b> -
                                                                                    Suspected Case of Malignant
                                                                                    Hyperthermia in a 6-Year-Old Child
                                                                                    Planned for Bilateral Tonsillectomy
                                                                                    <br />
                                                                                    <small><i>Niva Shrestha</i></small>
                                                                                </li>
                                                                                <li><b>14:00 PM – 14:10 PM</b> -
                                                                                    Utilisation of Resources in a Case
                                                                                    of Difficult Intubation <br />
                                                                                    <small><i>Reshma
                                                                                            Shrestha</i></small>
                                                                                </li>
                                                                            </ul>
                                                                        </div>

                                                                        <div class="screen-title">
                                                                            <p>Screen 3</p>
                                                                            <ul>
                                                                                <li><b>13:30 PM – 13:40 PM</b> -
                                                                                    Challenges in Neuraxial Anesthesia
                                                                                    in an 84-Year-Old Female with Neck
                                                                                    of Femur Fracture and Severe
                                                                                    Kyphosis <br />
                                                                                    <small><i>Kristina
                                                                                            Bhattarai</i></small>
                                                                                </li>
                                                                                <li><b>13:40 PM – 13:50 PM</b> -
                                                                                    Emergency Surgery in a Neonate with
                                                                                    Rectal Perforation and Airway
                                                                                    Challenges Faced<br />
                                                                                    <small><i>Ashish Dahal</i></small>
                                                                                </li>
                                                                                <li><b>13:50 PM – 14:00 PM</b> -
                                                                                    Anesthetic Considerations: Radical
                                                                                    Nephrectomy for RCC in CKD-V with
                                                                                    Cardiac Dysarrythmia <br />
                                                                                    <small><i>Aakriti Singh</i></small>
                                                                                </li>
                                                                                <li><b>14:00 PM – 14:10 PM</b> - Wide
                                                                                    Local Excision with Modified Radical
                                                                                    Neck Dissection and Reconstruction
                                                                                    of Poorly Differentiated Ca of
                                                                                    Dorsum of Nose with Neck Metastasis
                                                                                    in a Patient with Xeroderma
                                                                                    Pigmentosa <br />
                                                                                    <small><i>Kyoko Singh</i></small>
                                                                                </li>
                                                                            </ul>
                                                                        </div>

                                                                        <!-- Screen 4 -->
                                                                        <div class="screen-title">
                                                                            <p>Screen 4</p>
                                                                            <ul>
                                                                                <li><b>13:30 PM – 13:40 PM</b> -
                                                                                    Hemodynamic Monitoring in Major
                                                                                    Neonatal Surgeries <br />
                                                                                    <small><i>Ayush
                                                                                            Karmacharya</i></small>
                                                                                </li>
                                                                                <li><b>13:40 PM – 13:50 PM</b> -
                                                                                    Bronchoscopic Guided Tracheostomy in
                                                                                    a Patient with Tracheal Stenosis
                                                                                    Under Sedation. <br />
                                                                                    <small><i>Sidiya
                                                                                            Dallakoti</i></small>
                                                                                </li>
                                                                                <li><b>13:50 PM – 14:00 PM</b> -
                                                                                    Anesthetic Management and Surgical
                                                                                    Intervention in Adolescent
                                                                                    Idiopathic Scoliosis <br />
                                                                                    <small><i>Sudip Aryal</i></small>
                                                                                </li>
                                                                                <li><b>14:00 PM – 14:10 PM</b> -
                                                                                    Intrathecal Catheter Placement for
                                                                                    Labour Analgesia in a Patient with
                                                                                    Accidental Dural Puncture on
                                                                                    Epidural Catheterisation <br />
                                                                                    <small><i>Megha
                                                                                            Patrabansha</i></small>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Session 2 -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-2">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-2"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-2">
                                                                        <div class="title-text">
                                                                            <b>National Resident Poster Session 2</b>
                                                                            <br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                14:30 PM to 15:10 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-2"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-2"
                                                                    data-bs-parent="#innerAccordion-0-6">
                                                                    <div class="accordion-body">

                                                                        <div class="screen-title">
                                                                            <p>Screen 1</p>
                                                                            <ul>
                                                                                <li><b>14:30 PM – 14:40 PM</b> -
                                                                                    Sugammadex<br />
                                                                                    <small><i>Sarita Ray</i></small>
                                                                                </li>
                                                                                <li><b>14:40 PM – 14:50 PM</b> - From
                                                                                    Fear to Fun: Virtual Reality’s Role
                                                                                    in Pediatric Anesthesia<br />
                                                                                    <small><i>Rikesh Baral</i></small>
                                                                                </li>
                                                                                <li><b>14:50 PM – 15:00 PM</b> -
                                                                                    Supraglottic Stenosis: A Rare Cause
                                                                                    of Difficult Airway and Its
                                                                                    Management <br />
                                                                                    <small><i>Lhakpa Tsering
                                                                                            Sherpa</i></small>
                                                                                </li>
                                                                                <li><b>15:00 PM – 15:10 PM</b> -
                                                                                    Cesarean Section in Pregnant Woman
                                                                                    with Corrected Tetralogy of Fallot
                                                                                    <br />
                                                                                    <small><i>Ashish Khadka</i></small>
                                                                                </li>
                                                                            </ul>
                                                                        </div>

                                                                        <div class="screen-title">
                                                                            <p>Screen 2</p>
                                                                            <ul>
                                                                                <li><b>14:30 PM – 14:40 PM</b> -
                                                                                    Retained Guide Wire Following
                                                                                    Dialysis Catheter Insertion;
                                                                                    Ultrasound Guided Localization and
                                                                                    Removal to the Rescue: A Case Report
                                                                                    <br />
                                                                                    <small><i>Stuti Shrestha</i></small>
                                                                                </li>
                                                                                <li><b>14:40 PM – 14:50 PM</b> -
                                                                                    Continuous Spinal Anesthesia for
                                                                                    Radical Cystectomy in a High-Risk
                                                                                    Elderly Patient <br />
                                                                                    <small><i>Sachin Subedi</i></small>
                                                                                </li>
                                                                                <li><b>14:50 PM – 15:00 PM</b> - A Case
                                                                                    of Muscular Dystrophy with Scoliosis
                                                                                    Scheduled for Emergency Open
                                                                                    Appendectomy <br />
                                                                                    <small><i>Aaditi Singh</i></small>
                                                                                </li>
                                                                                <li><b>15:00 PM – 15:10 PM</b> -
                                                                                    Managing Laryngospasm in a Pediatric
                                                                                    Patient Under General Anesthesia
                                                                                    <br />
                                                                                    <small><i>Pawan Shrestha</i></small>
                                                                                </li>
                                                                            </ul>
                                                                        </div>


                                                                        <div class="screen-title">
                                                                            <p>Screen 3</p>
                                                                            <ul>
                                                                                <li><b>14:30 PM – 14:40 PM</b> - Case of
                                                                                    Unusual Anatomical Difficult Airway
                                                                                    <br />
                                                                                    <small><i>Amit Yadav</i></small>
                                                                                </li>
                                                                                <li><b>14:40 PM – 14:50 PM</b> -
                                                                                    Considerations for General
                                                                                    Anesthesia in a Patient with
                                                                                    Duchenne Muscular Dystrophy <br />
                                                                                    <small><i>Sukhami
                                                                                            Shrestha</i></small>
                                                                                </li>
                                                                                <li><b>14:50 PM – 15:00 PM</b> -
                                                                                    Exploring Chewing Gum as a Natural
                                                                                    Remedy for Post Operative Nausea and
                                                                                    Vomiting: Case Series <br />
                                                                                    <small><i>Yuva Giri</i></small>
                                                                                </li>
                                                                                <li><b>15:00 PM – 15:10 PM</b> -
                                                                                    Elective Lower Segment Cesarean
                                                                                    Section in 30 Y/F with a Diagnosis
                                                                                    of G1P0 @38+4 Week of Gestation with
                                                                                    Chronic Hypertension with Takayasu
                                                                                    Arteritis <br />
                                                                                    <small><i>Susmita Thapa</i></small>
                                                                                </li>
                                                                            </ul>
                                                                        </div>

                                                                        <div class="screen-title">
                                                                            <p>Screen 4</p>
                                                                            <ul>
                                                                                <li><b>14:30 PM – 14:40 PM</b> -
                                                                                    Challenges for Subarachnoid Block in
                                                                                    a Patient with Klippel Feil
                                                                                    Syndrome: A Case Report <br />
                                                                                    <small><i>Shiwangi
                                                                                            Kashyap</i></small>
                                                                                </li>
                                                                                <li><b>14:40 PM – 14:50 PM</b> -
                                                                                    Pulmonary and Renal Complications
                                                                                    Due to COVID-19, Influenza and RSV
                                                                                    in Hospitalized Children and Young
                                                                                    Adults: A Comparative Analysis
                                                                                    <br />
                                                                                    <small><i>Bishes Khanal</i></small>
                                                                                </li>
                                                                                <li><b>14:50 PM – 15:00 PM</b> - A Case
                                                                                    of Vein of Galen Malformation with
                                                                                    Hydrocephalus for Ventriculo
                                                                                    Peritoneal Shunting <br />
                                                                                    <small><i>Aalekh Raj
                                                                                            Dahal</i></small>
                                                                                </li>
                                                                                <li><b>15:00 PM – 15:10 PM</b> -
                                                                                    Supraglottic Stenosis: A Rare Cause
                                                                                    of Difficult Airway and Its
                                                                                    Management <br />
                                                                                    <small><i>Ashish Subedi</i></small>
                                                                                </li>
                                                                                <li><b>15:10 PM – 15:20 PM</b> -
                                                                                    Anesthetic Challenges in Thymectomy
                                                                                    for Myasthenia Gravis <br />
                                                                                    <small><i>Ishwor Basnet</i></small>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Button to Export All Tabs as PDFs -->
                                                    {{-- <button class="btn btn-success mt-4" onclick="exportAllTabs()">Export All Tabs as PDF</button> --}}


                                                    <!-- <div class="tab-pane fade " id="content-0-3" role="tabpanel"
                      aria-labelledby="tab-0-3">
                      <div class="accordion mt-3" id="innerAccordion-0-3">
                      </div>
                     </div> -->

                                                    <!-- <div class="tab-pane fade " id="content-0-4" role="tabpanel"
                      aria-labelledby="tab-0-4">
                      <div class="accordion mt-3" id="innerAccordion-0-4">

                       <div class="accordion-item">
                        <h2 class="accordion-header" id="session-6">
                         <button
                          class=" collapsed d-flex justify-content-between align-items-center"
                          type="button" data-bs-toggle="collapse"
                          data-bs-target="#session-collapse-6"
                          aria-expanded="true"
                          aria-controls="session-collapse-6">
                          <div class="title-text">


                          </div>
                          <div class="d-flex align-items-center ms-auto">
                           <span class="session-time">
                            8:00am
                            (15 mins)
                           </span>
                           <span class="material-symbols-outlined">
                            keyboard_arrow_down
                           </span>
                          </div>
                         </button>
                        </h2>
                        <div id="session-collapse-6"
                         class="accordion-collapse collapse"
                         aria-labelledby="session-6"
                         data-bs-parent="#innerAccordion-0-4">
                         <div class="accordion-body">

                          <h6>Presenter</h6>
                          <ul>
                           <li>
                            Bashu Dev

                            Parajuli
                           </li>
                          </ul>

                         </div>
                        </div>
                       </div>
                      </div>
                     </div> -->
                                                    <!-- <div class="tab-pane fade " id="content-0-5" role="tabpanel"
                      aria-labelledby="tab-0-5">
                      <div class="accordion mt-3" id="innerAccordion-0-5">

                       <div class="accordion-item">
                        <h2 class="accordion-header" id="session-10">
                         <button
                          class=" collapsed d-flex justify-content-between align-items-center"
                          type="button" data-bs-toggle="collapse"
                          data-bs-target="#session-collapse-10"
                          aria-expanded="true"
                          aria-controls="session-collapse-10">
                          <div class="title-text">

                           Poster Presentation
                           (GENERAL PEDIATRIC (ASPA SESSIONS))
                          </div>
                          <div class="d-flex align-items-center ms-auto">
                           <span class="session-time">
                            6:00am
                            (20min)
                           </span>
                           <span class="material-symbols-outlined">
                            keyboard_arrow_down
                           </span>
                          </div>
                         </button>
                        </h2>
                        <div id="session-collapse-10"
                         class="accordion-collapse collapse"
                         aria-labelledby="session-10"
                         data-bs-parent="#innerAccordion-0-5">
                         <div class="accordion-body">

                          <h6>Presenter</h6>
                          <ul>
                           <li>
                            Shu Ying

                            Lee
                           </li>
                          </ul>

                         </div>
                        </div>
                       </div>

                       <div class="accordion-item">
                        <h2 class="accordion-header" id="session-9">
                         <button
                          class=" collapsed d-flex justify-content-between align-items-center"
                          type="button" data-bs-toggle="collapse"
                          data-bs-target="#session-collapse-9"
                          aria-expanded="true"
                          aria-controls="session-collapse-9">
                          <div class="title-text">

                           Poster Presentation
                           (RESIDENTS’ POSTER SESSION)
                          </div>
                          <div class="d-flex align-items-center ms-auto">
                           <span class="session-time">
                            2:00pm
                            (20min)
                           </span>
                           <span class="material-symbols-outlined">
                            keyboard_arrow_down
                           </span>
                          </div>
                         </button>
                        </h2>
                        <div id="session-collapse-9"
                         class="accordion-collapse collapse"
                         aria-labelledby="session-9"
                         data-bs-parent="#innerAccordion-0-5">
                         <div class="accordion-body">

                          <h6>Presenter</h6>
                          <ul>
                           <li>
                            Bishes

                            Khanal
                           </li>
                          </ul>

                         </div>
                        </div>
                       </div>
                      </div>
                     </div> -->
                                                    <div class="tab-pane fade" id="tab-0" role="tabpanel">
                                                        <div class="accordion" id="generalActivitiesAccordion">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-1">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-1"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-1">
                                                                        <div class="title-text">

                                                                            Registration &amp; Breakfast
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                7:30am
                                                                                (30 mins)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-21">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-21"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-21">
                                                                        <div class="title-text">

                                                                            Registration &amp; Breakfast
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                8:00am
                                                                                (30 minutes)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-22">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-22"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-22">
                                                                        <div class="title-text">

                                                                            Address by SAN President(Amir Babu
                                                                            Shrestha)
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                8:30am
                                                                                (15 minutes)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-23">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-23"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-23">
                                                                        <div class="title-text">

                                                                            Address by Founding President of ASPA (Agnes
                                                                            Ng)
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                8:45am
                                                                                (15 minutes)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-2">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-2"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-2">
                                                                        <div class="title-text">

                                                                            Welcome Address
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                9:00am
                                                                                (15 mins)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-24">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-24"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-24">
                                                                        <div class="title-text">

                                                                            Address and Formal Commencement of the
                                                                            Scientific Program by Scientific Chair(Anil
                                                                            Shrestha)
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                9:00am
                                                                                (15 minutes)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-3">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-3"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-3">
                                                                        <div class="title-text">

                                                                            Address by SAN President
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                9:15am
                                                                                (15 mins)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-25">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-25"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-25">
                                                                        <div class="title-text">

                                                                            INAUGURATION CEREMONY
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                9:15am
                                                                                (30 minutes)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-4">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-4"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-4">
                                                                        <div class="title-text">

                                                                            Address by ASPA President
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                9:30am
                                                                                (15 mins)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-5">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-5"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-5">
                                                                        <div class="title-text">

                                                                            INAUGURATION CEREMONY
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                9:45am
                                                                                (15 mins)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-26">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-26"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-26">
                                                                        <div class="title-text">

                                                                            THEMATIC SESSION Moderators: Shanta Sapkota,
                                                                            Rebecca Jacob
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                9:45am
                                                                                (5 minutes)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-27">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-27"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-27">
                                                                        <div class="title-text">

                                                                            Evolution of Pediatric Anesthesia as I see
                                                                            it (Masao Yamashita)
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                9:50am
                                                                                (15 minutes)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-28">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-28"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-28">
                                                                        <div class="title-text">

                                                                            Resilience for Healthcare Providers (Gregory
                                                                            Hammer)
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                10:05am
                                                                                (15 minutes)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-29">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-29"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-29">
                                                                        <div class="title-text">

                                                                            Pediatric Anesthesia: Challenges and
                                                                            Opportunities for Nepal (Balkrishna
                                                                            Bhattarai)
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                10:20am
                                                                                (15 minutes)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-30">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-30"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-30">
                                                                        <div class="title-text">

                                                                            Introduction to ASPA 2026 1035-1105 KEYNOTE
                                                                            ADDRESS Regional Anesthesia in Children: My
                                                                            Journey Over 50 Years (Adrian Bosenberg)
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                10:35am
                                                                                (30 minutes)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-31">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-31"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-31">
                                                                        <div class="title-text">

                                                                            BREAK
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                11:05am
                                                                                (15 minutes)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-32">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-32"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-32">
                                                                        <div class="title-text">

                                                                            Roshana Amatya Oration - Introduction
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                11:20am
                                                                                (10 minutes)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-33">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-33"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-33">
                                                                        <div class="title-text">

                                                                            Oration – Fauzia Khan
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                11:30am
                                                                                (30 minutes)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="generalActivity-34">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#generalActivityCollapse-34"
                                                                        aria-expanded="true"
                                                                        aria-controls="generalActivityCollapse-34">
                                                                        <div class="title-text">

                                                                            Lunch Break
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                12:00pm
                                                                                (1 hour)
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>


                        <div class="col-lg-12">
                            <div class="accordion-faq-area-border-bottom-style style-four">
                                <div class="accordion" id="baccordionExamples">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading-b0">
                                            <button class="accordion-button " type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse-b0" aria-expanded="true"
                                                aria-controls="collapse-b0">
                                                <div style="font-size: 20px">
                                                    Day 2
                                                </div>
                                                <div class="d-flex align-items-center ms-auto">
                                                    <span class="session-time">
                                                        2025-04-05
                                                    </span>
                                                </div>
                                            </button>
                                        </h2>
                                        <div id="collapse-b0" class="accordion-collapse collapse show"
                                            aria-labelledby="heading-b0" data-bs-parent="#baccordionExamples">
                                            <div class="accordion-body">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" id="tab-0-b0" data-bs-toggle="tab"
                                                            href="#content-0-b0" role="tab"
                                                            aria-controls="content-0-b0" aria-selected="true">
                                                            Hall A
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link " id="tab-0-b1" data-bs-toggle="tab"
                                                            href="#content-0-b1" role="tab"
                                                            aria-controls="content-0-b1" aria-selected="false">
                                                            Hall B
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="tab-0-b2" data-bs-toggle="tab"
                                                            href="#content-0-b2" role="tab"
                                                            aria-controls="content-0-b2" aria-selected="false">
                                                            Hall C
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="tab-0-b3" data-bs-toggle="tab"
                                                            href="#content-0-b3" role="tab"
                                                            aria-controls="content-0-b3" aria-selected="false">
                                                            Hall D
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="tab-0-b4" data-bs-toggle="tab"
                                                            href="#content-0-b4" role="tab"
                                                            aria-controls="content-0-b4" aria-selected="false">
                                                            Hall E
                                                        </a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" id="tab-0-b5" data-bs-toggle="tab"
                                                            href="#content-0-b5" role="tab"
                                                            aria-controls="content-0-b5" aria-selected="false">
                                                            Lobby
                                                        </a>
                                                    </li>

                                                </ul>
                                                <div class="tab-content mt-3">
                                                    <div class="tab-pane fade show active" id="content-0-b0"
                                                        role="tabpanel" aria-labelledby="tab-0-b0">
                                                        <div class="accordion mt-3" id="innerAccordion-0-0">

                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-75">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-75"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-75">
                                                                        <div class="title-text">
                                                                            Moderators:<br /><small><i>Shanta Sapkota,
                                                                                    Angelina Gapay</i></small>
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                08:30 AM to 09:00 AM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-75"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-75"
                                                                    data-bs-parent="#innerAccordion-0-0">
                                                                    <div class="accordion-body">

                                                                        <ul>
                                                                            <li>
                                                                                <b> 8:30 AM to 8:45 AM </b> - Prediction
                                                                                of
                                                                                Perioperative Adverse Events in
                                                                                Pediatric
                                                                                Anesthesia <br />

                                                                                <small><i>Jijian Zheng</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 8:45 AM to 9:00 AM </b> - Pediatric
                                                                                Anesthesia Beyond Science <br />
                                                                                <small><i>Rebecca Jacob</i></small>
                                                                            </li>
                                                                        </ul>


                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-60">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-60"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-60">
                                                                        <div class="title-text">

                                                                            SAFE AND SOUND Tailored anesthesia for
                                                                            Ophthalmic and ENT Surgeries <br />
                                                                            Moderators: <small><i> Sindhu Khatiwada,
                                                                                    Serpil
                                                                                    Ozgen</i></small>
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                9:00 AM to 10:30 AM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-60"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-60"
                                                                    data-bs-parent="#innerAccordion-0-0">
                                                                    <div class="accordion-body">

                                                                        <ul>
                                                                            <li>
                                                                                <b> 9:00 AM to 9:15 AM </b> - Guiding
                                                                                principles for anesthesia for ophthalmic
                                                                                surgeries <br />
                                                                                <small><i>Prakriti Pokhrel</i></small>
                                                                            </li>

                                                                            <li>
                                                                                <b> 9:15 AM to 9:30 AM </b> - Squint
                                                                                repair
                                                                                –Surgical field ooze <br />
                                                                                <small><i>Vrushali Ponde</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>9:30 AM to 9:45 AM</b> - From
                                                                                Extubation
                                                                                Failure to Tracheostomy: Do’s and
                                                                                Don’ts in a 3-Month-Old <br />
                                                                                <small><i>Duenpen
                                                                                        Horatanaruang</i></small>
                                                                            </li>
                                                                            <li>Turning Nightmare into Success</li>
                                                                            <li>
                                                                                <b>9:45 AM to 10:00 AM</b> - Tips for
                                                                                Adenoidectomy and Tonsillectomy in Obese
                                                                                Children <br />
                                                                                <small><i>Rakhee Goyal </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 10:00 AM to 10:15 AM </b> - Infant
                                                                                for
                                                                                cataract surgery – LMA or intubation?
                                                                                <br />

                                                                                <small><i>Rufinah Teo</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 10:15 AM to 10:30 AM </b> - Q&A ?
                                                                            </li>
                                                                        </ul>
                                                                        </ul>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-61">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-61"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-61">
                                                                        <div class="title-text">

                                                                            SMALL PATIENTS BIG PROCEDURES: Essentials
                                                                            for
                                                                            Cardiothoracic Anesthesia
                                                                            <br />Moderators:
                                                                            <small><i>Bishwas Pradhan, Agnes Ng
                                                                                </i></small>
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                10:30 AM to 12:00 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-61"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-61"
                                                                    data-bs-parent="#innerAccordion-0-0">
                                                                    <div class="accordion-body">

                                                                        <ul>

                                                                            <li>
                                                                                <b> 10:30 AM to 10:45 AM </b> - Safe
                                                                                Hands
                                                                                Steady Hearts: Principle of Cardiac
                                                                                Anesthesia in Kids<br />
                                                                                <small><i> Jin Tae Kim </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 10:45 AM to 11:00 AM </b> -
                                                                                Anesthesia
                                                                                for Complex Congenital Cardiac
                                                                                Surgeries:
                                                                                The Challenges!<br />
                                                                                <small><i> Arjun Gurung </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 11:00 AM to 11:15 AM </b> -
                                                                                Pain-free
                                                                                precision :Exploring analgesia options
                                                                                for
                                                                                cardiac and thoracic surgeries<br />
                                                                                <small><i> Karen Boretsky </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 11:15 AM to 11:30 AM </b> -
                                                                                Anesthetic
                                                                                Management of Thoracoscopic Esophageal
                                                                                Anastomosis in Neonates with Congenital
                                                                                Esophageal Atresia <br />
                                                                                <small><i> Fang Wang </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 11:30 AM to 11:45 AM </b> -
                                                                                Precision
                                                                                Anesthesia for Minimally Invasive
                                                                                Cardiac
                                                                                Surgeries <br />
                                                                                <small><i> Hang Nguyen </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 11:45 AM to 12:00 PM </b> - Q&A ?
                                                                                <br />
                                                                            </li>
                                                                            <li>Lunch Break</li>
                                                                        </ul>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-62">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-62"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-62">
                                                                        <div class="title-text">

                                                                            THE ULTIMATE REGIONAL ANESTHESIA
                                                                            MASTERCLASS:
                                                                            Techniques and Insights
                                                                            <br />
                                                                            Moderators:
                                                                            <small><i>Paul Kessler, Ninadini Shrestha
                                                                                </i></small>
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                13:00 PM to 15:45 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-62"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-62"
                                                                    data-bs-parent="#innerAccordion-0-0">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b> 13:00 PM to 13:15 PM </b> -
                                                                                Unlocking
                                                                                the Benefits and Basics of
                                                                                Regional Anesthesia in Children<br />
                                                                                <small><i> Noriko Miyazawa </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 13:15 PM to 13:30 PM </b> -
                                                                                Real-time
                                                                                Ultrasound Guidance and Epidural
                                                                                Stimulation
                                                                                for Thoracic Epidural Catheter Placement
                                                                                in
                                                                                Neonates and Young Infants: Benefits and
                                                                                Technical Considerations
                                                                                <br />
                                                                                <small><i> Manoj Karmakar
                                                                                    </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>13:30 PM to 13:50 PM </b> - Exploring
                                                                                Pediatric Regional Anesthesia: The
                                                                                Classic
                                                                                and the New<br />
                                                                                <small><i>Adrian Bosenberg
                                                                                    </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 13:50 PM to 14:05 PM </b> - Top 5
                                                                                must-know Extremity Blocks in Pediatric
                                                                                Anesthesia

                                                                                <br />
                                                                                <small><i> Karen Boretsky
                                                                                    </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 14:05 PM to 14:20 PM </b> - Trunk
                                                                                and
                                                                                Abdominal Blocks in Children: Precision
                                                                                Pain
                                                                                Relief for Young Patients
                                                                                <br />
                                                                                <small><i> Patcharee Sriswasdi
                                                                                    </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 14:20 PM to 14:30 PM </b> - Q & A
                                                                            </li>
                                                                            <li><b> 14:30 PM to 14:45 PM </b> - BREAK
                                                                                <br />
                                                                            </li>
                                                                            <li>
                                                                                <b>14:45 PM to 15:00 PM </b> - Even the
                                                                                best
                                                                                Tools Have Their Trials:
                                                                                Complications and Controversies in
                                                                                Regional
                                                                                Anesthesia <br />
                                                                                <small><i> Karen Boretsky </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>15:00 PM to 15:15 PM </b> - Beyond
                                                                                the
                                                                                OR: NORRA --Non-Operating Room Regional
                                                                                Anesthesia! <br />
                                                                                <small><i> Vrushali Ponde </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 15:15 PM to 15:30 PM </b> - Wrong
                                                                                Site
                                                                                Nerve Blocks: Lessons Learnt from
                                                                                RCAs and Progressive Prevention
                                                                                Strategies<br />
                                                                                <small><i> David Liston </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 15:30 PM to 15:45 PM </b> - Q&A ?
                                                                                <br />
                                                                            </li>
                                                                            <ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-63">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-63"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-63">
                                                                        <div class="title-text">

                                                                            POT POURRI I<br />
                                                                            Moderators:
                                                                            <small><i>Agnes Ng, Balkrishna Bhattarai
                                                                                </i></small>
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                15:45 PM to 16:45 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-63"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-63"
                                                                    data-bs-parent="#innerAccordion-0-0">
                                                                    <div class="accordion-body">

                                                                        <ul>
                                                                            <li>
                                                                                <b> 15:45 PM to 16:00 PM </b> - Scenario
                                                                                of
                                                                                Anesthesia in a Pediatric Hospital in
                                                                                Nepal
                                                                                <br />
                                                                                <small><i>Reshma Shrestha</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>16:00 PM to 16:15 PM </b> - Sedation
                                                                                of
                                                                                Pediatric Patients in Mongolia: Our
                                                                                Experience
                                                                                <br />
                                                                                <small><i> Undram Maisaikhan
                                                                                    </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 16:15 PM to 16:30 PM </b> -
                                                                                Anesthesia
                                                                                during Disasters : A tale of Nepalese
                                                                                Army
                                                                                <br />
                                                                                <small><i>Mallika Rayamajh</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 16:30 PM to 16:45 PM </b> - Cave
                                                                                Rescue:
                                                                                Science or A Miracle?
                                                                                <br />
                                                                                <small><i>Pornsak Phoncharoensomboon
                                                                                    </i></small>
                                                                            </li>
                                                                        </ul>


                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="content-0-b1" role="tabpanel"
                                                        aria-labelledby="tab-0-b1">
                                                        <div class="accordion mt-3" id="innerAccordion-0-1">

                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-88">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-88"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-88">
                                                                        <div class="title-text">

                                                                            PEDIATRIC ANESTHESIA UNVEILED -
                                                                            Core Principles for Specialized
                                                                            Care<br />Moderators: <small><i>Murli
                                                                                    Aluvalia,
                                                                                    Ravi Ram Shrestha </i></small>
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                8:30 AM to 10:45 AM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-88"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-88"
                                                                    data-bs-parent="#innerAccordion-0-1">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>8:30 AM to 8:45 AM</b> - Ready for
                                                                                Surgery: <br />
                                                                                Preoperative Optimization and Modern
                                                                                Fasting
                                                                                in Kids<br />
                                                                                <small><i>Sundaralingam
                                                                                        Premakrishna</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>8:45 AM to 9:00 AM</b> - Tailored
                                                                                tranquility: <br />
                                                                                Choosing the right premedication by age
                                                                                <br />
                                                                                <small><i> Parbesh Gyawali </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>9:00 AM to 9:15 AM </b> - Talking
                                                                                preop
                                                                                anxiety: <br />
                                                                                Are medications the only path?
                                                                                <br />
                                                                                <small><i> Gayatri Sashikumar
                                                                                    </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 9:15 AM to 9:30 AM </b> - Anesthesia
                                                                                Induction in Children:
                                                                                Diverse approaches for varied faces <br />
                                                                                <small><i>Karamehmet Yildiz</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>9:30 AM to 9:45 AM </b> - Mastering
                                                                                IV
                                                                                Cannulation:<br />
                                                                                Techniques and Challenges from Neonates
                                                                                to
                                                                                Kids
                                                                                <br />
                                                                                <small><i>Dilip Chavan</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>9:45 AM to 10:00 AM</b> - Intravenous
                                                                                Fluid in Children Made Simple <br />
                                                                                I could never get the calculations right
                                                                                !
                                                                                <br />
                                                                                <small><i> In-Kyung Song </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>10:00 AM to 10:15 AM</b> -
                                                                                Postoperative
                                                                                Nausea and Vomiting (PONV) in Pediatric
                                                                                Patients: <br />
                                                                                Prevention and Management
                                                                                Strategies<br />
                                                                                <small><i> Utsav Acharya </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 10:15 AM to 10:30 AM </b> - Has
                                                                                Sedline
                                                                                Changed the Way We Anesthetize Our
                                                                                Children?
                                                                                <br />
                                                                                <small><i> Muhammad Rafique
                                                                                    </i></small><br />
                                                                            </li>
                                                                            <li>
                                                                                <b> 10:30 AM to 10:45 AM </b> - Q&A ?
                                                                            </li>
                                                                        </ul>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-89">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-89"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-89">
                                                                        <div class="title-text">

                                                                            NORA
                                                                            (The Non-Operating Room Anesthesia) <br />
                                                                            Moderators:
                                                                            <small><i>Krishna Pokharel, Andi Ade Ramlan
                                                                                </i></small>
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                10:45 AM to 12:00 AM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-89"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-89"
                                                                    data-bs-parent="#innerAccordion-0-1">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>10:45 AM to 11:00 AM</b> - Use of
                                                                                Sedation and Anesthesia in MRI and CT
                                                                                <br />
                                                                                <small><i>Sadichhya Shah </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 11:00 AM to 11:15 AM </b> -
                                                                                Anesthesia
                                                                                and Analgesia in Pediatric Burns Unit
                                                                                <br />
                                                                                <small><i> Sapna Bathla </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 11:15 AM to 11:30 AM </b> -
                                                                                Anesthesia
                                                                                for Cath Lab Procedures <br />
                                                                                <small><i> Dilek Altun </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 11:30 AM to 11:45 AM </b> -
                                                                                Anesthesia
                                                                                in a Dentist’s Suite: <br />
                                                                                Should we or Should Not? <br />
                                                                                <small><i> Karamehmet Yildiz
                                                                                    </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 11:45 AM to 12:00 AM </b> -
                                                                                Anesthesia
                                                                                for Endoscopies
                                                                                <br />
                                                                                <small><i> Amrita Rath </i></small>
                                                                            </li>

                                                                            <li>Lunch Break</li>
                                                                        </ul>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-90">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-90"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-90">
                                                                        <div class="title-text">

                                                                            MASTERING THE MASTER - From Basics to
                                                                            Innovations in Pediatric Airway
                                                                            <br />
                                                                            Moderators:
                                                                            <small><i>Ritu Pradhan, Muhammad Rafique
                                                                                </i></small>
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                13:00 PM to 14:30 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-90"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-90"
                                                                    data-bs-parent="#innerAccordion-0-1">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b> 13:00 PM to 13:25 PM </b> - Clinical
                                                                                Implications of the Difference between
                                                                                pediatric and adult airway <br />
                                                                                <small><i> Josef Holzki </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 13:25 PM to 13:30 PM </b> - Q&A?
                                                                            </li>
                                                                            <li>
                                                                                <b> 13:30 PM to 13:45 PM </b> - Don’t
                                                                                have
                                                                                airway management gadgets: What Should I
                                                                                do?
                                                                                <br />
                                                                                Handling Difficult Airway in Resource
                                                                                Limited Settings
                                                                                Benefits and Technical
                                                                                Considerations<br />
                                                                                <small><i> Rudi Vitraludyiono
                                                                                    </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 13:45 PM to 14:00 PM </b> - Advanced
                                                                                Airway Devices: New Techniques and their
                                                                                Applications
                                                                                <br />
                                                                                <small><i> Dilip Chavan </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 14:00 PM to 14:15 PM </b> -
                                                                                Management
                                                                                of an Unexpected Difficult Airway <br />
                                                                                <small><i> Gregory Hammer
                                                                                    </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 14:15 PM to 14:30 PM </b> - Q&A ?
                                                                                <br />
                                                                            </li>
                                                                        </ul>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-91">
                                                                    <button
                                                                        class=" collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-91"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-91">
                                                                        <div class="title-text">

                                                                            POT POURRI II <br />
                                                                            Moderators:
                                                                            <small><i>Binita Acharya, Jin Tae Kim
                                                                                </i></small>
                                                                            <br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                14:30 PM to 16:30 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-91"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-91"
                                                                    data-bs-parent="#innerAccordion-0-1">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b> 14:30 PM to 14:45 PM </b> - Blood
                                                                                Pressure during Anesthesia <br />
                                                                                <small><i> Jurgen De Graaf </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 14:45 PM to 15:00 PM </b> - Enhanced
                                                                                Recovery After Surgery (ERAS) protocols
                                                                                in
                                                                                Pediatric Anesthesia
                                                                                <br />
                                                                                <small><i> Gozen Coskun</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>15:00 PM to 15:15 PM</b> - Q&A ?
                                                                                <br />
                                                                            </li>
                                                                            <li>
                                                                                <b> 15:15 PM to 15:30 PM </b> -
                                                                                Remifentanil
                                                                                : trough and crest<br />
                                                                                <small><i> Norifumi Kuratani
                                                                                    </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b> 15:30 PM to 15:45 PM </b> - What’s
                                                                                new
                                                                                in Opioid Analgesia <br />
                                                                                <small><i> Gregory Hammer
                                                                                    </i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>15:45 PM to 16:00 PM</b> - Rapid
                                                                                reverse
                                                                                : Sugammadex in Children- Is it a must ?
                                                                                <br />
                                                                                <small><i> Joy Luat Inciong</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>16:15 PM to 16:30 PM</b> - Q&A ?
                                                                                <br />
                                                                            </li>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="content-0-b2" role="tabpanel"
                                                        aria-labelledby="tab-0-b2">
                                                        <div class="accordion mt-3" id="innerAccordion-0-2">
                                                            <!-- Neuroanesthesia Session -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-94">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-94"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-94">
                                                                        <div class="title-text">
                                                                            <b>Neuroanesthesia Session</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                08:30 AM to 10:00 AM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-94"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-94"
                                                                    data-bs-parent="#innerAccordion-0-2">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>08:30 AM – 08:45 AM</b> - Enhanced
                                                                                recovery after surgery (ERAS) in
                                                                                neurosurgery<br />
                                                                                <small><i>Hemanshu Prabhakar</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>08:45 AM – 09:00 AM</b> - Processed
                                                                                electroencephalography (pEEG) in
                                                                                Neuroanesthesia practice<br />
                                                                                <small><i>Navindra Raj Bista</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>09:00 AM – 09:15 AM</b> -
                                                                                Endovascular Thrombectomy for acute
                                                                                ischemic stroke: An update on
                                                                                perioperative care<br />
                                                                                <small><i>Jie Tian</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>09:15 AM – 09:30 AM</b> - Cranial
                                                                                Ultrasound<br />
                                                                                <small><i>Ankur Luthra</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>09:30 AM – 09:45 AM</b> - Anesthesia
                                                                                for awake craniotomy<br />
                                                                                <small><i>Ashutosh Kaushal</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>09:45 AM – 10:00 AM</b> - Q and
                                                                                A<br />
                                                                            </li>
                                                                            <li>Break</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- GENERAL SESSON -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-95">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-95"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-95">
                                                                        <div class="title-text">
                                                                            <b>General Session</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                10:15 AM to 12:00 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-95"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-95"
                                                                    data-bs-parent="#innerAccordion-0-2">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>10:15 AM – 10:30 AM</b> - Clinical
                                                                                application of hypotensive predictive
                                                                                index (HPI) technology<br />
                                                                                <small><i>Prof. Cheng Li</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>10:30 AM – 10:45 AM</b> - Impact of
                                                                                Remimazolam on Emergence Delirium in
                                                                                Pediatric Patients Undergoing Surgery
                                                                                with General Anaesthesia: A Systematic
                                                                                Review with Meta-Analysis and trial
                                                                                sequential analysis<br />
                                                                                <small><i>Soumya Sarkar</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>10:45 AM – 11:00 AM</b> - A
                                                                                randomized controlled trial to compare
                                                                                blind endotracheal intubation with
                                                                                cuffed PVC tube and silicone wire
                                                                                reinforced tube through second
                                                                                generation laryngeal mask airway in
                                                                                children<br />
                                                                                <small><i>Prof. Garima
                                                                                        Agrawal</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>11:00 AM – 11:15 AM</b> - Combination
                                                                                of haloperidol and ondansetron is
                                                                                non-inferior to dexamethasone and
                                                                                ondansetron for prevention of
                                                                                post-operative nausea and vomiting in
                                                                                patients undergoing laparoscopic
                                                                                procedures: A randomised double blinded
                                                                                trial<br />
                                                                                <small><i>Karan Singla</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>11:15 AM – 11:30 AM</b> - Updates on
                                                                                perioperative allergic reaction<br />
                                                                                <small><i>Prof. Qianzi Yang</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>11:30 AM – 11:45 AM</b> - Green
                                                                                Anesthesia is Revolutionizing patient
                                                                                care: metabolic flow anesthesia in
                                                                                clinical routine<br />
                                                                                <small><i>Marie Luise
                                                                                        Ruebsams</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>11:45 AM – 12:00 PM</b> - Q and
                                                                                A<br />
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Critical Care Session 1 -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-92">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-92"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-92">
                                                                        <div class="title-text">
                                                                            <b>Critical Care Session 1</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                13:00 PM to 14:30 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-92"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-92"
                                                                    data-bs-parent="#innerAccordion-0-2">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>13:00 PM – 13:15 PM</b> - Role of
                                                                                Ultrasound for fluid management in ICU
                                                                                <br />
                                                                                <small><i>Pramesh Sunder
                                                                                        Shrestha</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>13:15 PM – 13:30 PM</b> - Lung
                                                                                Protective Ventilation in the OR – Are
                                                                                we there yet?<br />
                                                                                <small><i>Sabin Bhandari</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>13:30 PM – 13:35 PM</b> - Q and
                                                                                A<br />
                                                                            </li>
                                                                            <li>
                                                                                <b>13:35 PM – 14:30 PM</b> - Panel
                                                                                Discussion: Organ donation after Brain
                                                                                death – Challenges and way forward in
                                                                                LMIC’s<br />
                                                                                <b>Moderator:</b> Dr. Sachit
                                                                                Sharma<br />
                                                                                <b>Panelists:</b> Himanshu Prabhakar,
                                                                                Subhash P. Acharya, Pukar Chandra
                                                                                Shrestha
                                                                            </li>
                                                                            <li>Break</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Critical Care Session 2 -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-93">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-93"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-93">
                                                                        <div class="title-text">
                                                                            <b>Critical Care Session 2</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                14:40 PM to 16:30 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-93"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-93"
                                                                    data-bs-parent="#innerAccordion-0-2">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>14:40 PM – 14:55 PM</b> -
                                                                                Personalized PEEP in ARDS<br />
                                                                                <small><i>Vikas Saini</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>14:55 PM – 15:10 PM</b> - Blood
                                                                                Pressure targets in critically ill: MAP
                                                                                or SBP?<br />
                                                                                <small><i>Ankit Rimal</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>15:10 PM – 15:25 PM</b> - AI for
                                                                                Intensivist<br />
                                                                                <small><i>Ashmita Paudel</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>15:25 PM – 15:35 PM</b> - Q and
                                                                                A<br />
                                                                            </li>
                                                                            <li>
                                                                                <b>15:35 PM – 16:30 PM</b> - Pro-Con
                                                                                Debate: VeXus – Friend or foe<br />
                                                                                <small><i>Pro - Binit Karki , Con -
                                                                                        Ankit Agarwal</i></small>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="content-0-b3" role="tabpanel"
                                                        aria-labelledby="tab-0-b3">
                                                        <div class="accordion mt-3" id="innerAccordion-0-3">
                                                            <!-- Oncoanesthesia Session 2 -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-98">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-98"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-98">
                                                                        <div class="title-text">
                                                                            <b>Oncoanesthesia Session 2</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                08:30 AM to 10:15 AM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-98"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-98"
                                                                    data-bs-parent="#innerAccordion-0-3">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>08:30 AM – 08:45 AM</b> - Anesthesia
                                                                                and oncosurgical outcome<br />
                                                                                <small><i>Priyanka Sethi</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>08:45 AM – 09:00 AM</b> - Anesthetic
                                                                                strategies for super super obese patient
                                                                                during robotic gynecological surgery:
                                                                                first-hand experience<br />
                                                                                <small><i>Subi Regmi</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>09:00 AM – 09:15 AM</b> - Role of
                                                                                Nutrition in Cancer Patients<br />
                                                                                <small><i>Vishal Bhatnagar</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>09:15 AM – 09:30 AM</b> - The art of
                                                                                Anesthesia in awake craniotomy:
                                                                                Techniques and Challenges<br />
                                                                                <small><i>Nitesh Goel</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>09:30 AM – 09:45 AM</b> -
                                                                                Perioperative management and Anesthetic
                                                                                Considerations in Microvascular Free
                                                                                Tissue Transfer surgeries for Head and
                                                                                Neck Cancer<br />
                                                                                <small><i>Abiya Pradhan</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>09:45 AM – 10:00 AM</b> - Tiny eyes,
                                                                                big hurdles: Navigating anesthesia
                                                                                management in pediatric retinoblastoma
                                                                                for brachytherapy<br />
                                                                                <small><i>Sushmita Bairagi</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>10:00 AM – 10:15 AM</b> - Q and
                                                                                A<br />
                                                                            </li>
                                                                            <li>Break</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Pediatric Anesthesia Session -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-99">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-99"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-99">
                                                                        <div class="title-text">
                                                                            <b>Pediatric Anesthesia Session</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                10:30 AM to 12:15 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-99"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-99"
                                                                    data-bs-parent="#innerAccordion-0-3">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>10:30 AM – 10:45 AM</b> - Anesthesia
                                                                                Strategies for Managing Pediatric
                                                                                Mandibulofacial Dysostosis Guion-Almeida
                                                                                Type: A Case Report<br />
                                                                                <small><i>Serra Bayrakceken</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>10:45 AM – 11:00 AM</b> - Comparison
                                                                                of homemade 3D-Printed Videolaryngoscope
                                                                                and Miller laryngoscope in terms of
                                                                                intubation success in a pediatric
                                                                                manikin: A pilot study<br />
                                                                                <small><i>Duygu Kara</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>11:00 AM – 11:15 AM</b> - Pediatric
                                                                                Spinal Anesthesia – Tips and
                                                                                Tricks<br />
                                                                                <small><i>Anju Gupta</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>11:15 AM – 11:30 AM</b> - Artificial
                                                                                Intelligence Hallucinations and Their
                                                                                Impact on Safety in Pediatric
                                                                                Anesthesia<br />
                                                                                <small><i>Prakash Gyandev
                                                                                        Gondode</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>11:30 AM – 11:45 AM</b> - Neonate
                                                                                with Single ventricle for emergency
                                                                                colostomy – Anesthetic consideration and
                                                                                perioperative challenges<br />
                                                                                <small><i>Arti Rajput</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>11:45 AM – 12:00 PM</b> - Effect of
                                                                                Remimazolam on hemodynamics in children
                                                                                with congenital heart disease<br />
                                                                                <small><i>Hongyun Li</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>12:00 PM – 12:15 PM</b> - Q & A<br />
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- Airway Session -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-96">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-96"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-96">
                                                                        <div class="title-text">
                                                                            <b>Airway Session</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                13:00 PM to 14:45 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-96"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-96"
                                                                    data-bs-parent="#innerAccordion-0-3">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>13:00 PM – 13:15 PM</b> -
                                                                                Physiological Difficult Airway<br />
                                                                                <small><i>Balkrishna
                                                                                        Bhattarai</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>13:15 PM – 13:30 PM</b> - An insight
                                                                                in awake intubation<br />
                                                                                <small><i>Parul Jindal</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>13:30 PM – 13:45 PM</b> - HFNO during
                                                                                General Anesthesia<br />
                                                                                <small><i>Anju Gupta</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>13:45 PM – 14:00 PM</b> - Role of AI
                                                                                in airway management<br />
                                                                                <small><i>Elizabeth Joseph</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>14:00 PM – 14:15 PM</b> - Endless
                                                                                possibilities in airway management<br />
                                                                                <small><i>Krishna Pokharel</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>14:15 PM – 14:30 PM</b> - A
                                                                                prospective randomized controlled study
                                                                                to compare two supraglottic airway
                                                                                devices LMA-ProtectorTM and
                                                                                LMA-ProSealTM in anaesthetized
                                                                                patients<br />
                                                                                <small><i>Raksha Kundal</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>14:30 PM – 14:45 PM</b> - Q and
                                                                                A<br />
                                                                            </li>
                                                                            <li>Break</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Research and Education Session -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-97">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-97"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-97">
                                                                        <div class="title-text">
                                                                            <b>Research and Education Session</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                15:00 PM to 16:15 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-97"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-97"
                                                                    data-bs-parent="#innerAccordion-0-3">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>15:00 PM – 15:15 PM</b> - Metaverse
                                                                                versus in-person learning: impact on
                                                                                anesthesia education and student
                                                                                satisfaction<br />
                                                                                <small><i>Darunee
                                                                                        Sripadungkul</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>15:15 PM – 15:30 PM</b> - Vital
                                                                                Anaesthesia Simulation Training<br />
                                                                                <small><i>Ravi Ram Shrestha</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>15:30 PM – 15:45 PM</b> - Evidence
                                                                                generation in Regional Anaesthesiology
                                                                                and pain Management<br />
                                                                                <small><i>Pawan Kumar Hamal</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>15:45 PM – 16:00 PM</b> - Changing
                                                                                landscape of publication in
                                                                                anesthesiology Nepal<br />
                                                                                <small><i>Bidur Baral</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>16:00 PM – 16:15 PM</b> - Being a
                                                                                physician scientist<br />
                                                                                <small><i>Diptesh Aryal</i></small>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="content-0-b4" role="tabpanel"
                                                        aria-labelledby="tab-0-b4">
                                                        <div class="accordion mt-3" id="innerAccordion-0-4">

                                                            <!-- Resident Session -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-101">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-101"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-101">
                                                                        <div class="title-text">
                                                                            <b>International Resident Session</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                8:30 AM to 9:30 AM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-101"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-101"
                                                                    data-bs-parent="#innerAccordion-0-4">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>8:30 AM – 8:45 AM</b> - A
                                                                                        comparative study of Quadratus
                                                                                        Lumborum
                                                                                        block vs epidural for post-operative
                                                                                        analgesia in gynecological
                                                                                        malignancies<br />
                                                                                        <small><i>Anvi Gupta</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>8:45 AM – 9:00 AM</b> - Failed
                                                                                Tracheo-esophageal fistula repair in a
                                                                                5-year-old: opening Pandora’s box<br />
                                                                                <small><i>Achinthya Roopa
                                                                                        Arul</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>9:00 AM – 9:15 AM</b> - Efficacy of
                                                                                Calcium Gluconate in the Prevention of
                                                                                Uterine Atony During Lower Segmental
                                                                                Cesarean Section Delivery: A Randomized
                                                                                Controlled Trial<br />
                                                                                <small><i>Soumya Ranjan
                                                                                        Sahoo</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>9:15 AM – 9:30 AM</b> - Debunking
                                                                                Myths and Patient Education About
                                                                                Complex Regional Pain Syndrome Using
                                                                                Popular Generative Artificial
                                                                                Intelligence Chatbots<br />
                                                                                <small><i>Asmita Gautam</i></small>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <!-- Resident Session 2 -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-103">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-103"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-103">
                                                                        <div class="title-text">
                                                                            <b>National Resident Session 1</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                09:40 AM to 10:52 AM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-103"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-103"
                                                                    data-bs-parent="#innerAccordion-0-4">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>09:40 AM – 09:52 AM</b> - Prediction
                                                                                of Difficulty of Visualization of Larynx
                                                                                by Modified Mallampati Test in Supine
                                                                                Position<br />
                                                                                <small><i>Rabin Kumar
                                                                                        Shrestha</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>09:52 AM – 10:04 AM</b> - Comparison
                                                                                of hemodynamics between Propofol and
                                                                                Ketofol as induction agents in patients
                                                                                undergoing general anesthesia<br />
                                                                                <small><i>Simrika Tamrakar</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>10:16 AM – 10:28 AM</b> - Correlation
                                                                                between ratio of trunk length to square
                                                                                of abdominal circumference and level of
                                                                                sensory block following spinal
                                                                                anesthesia in women undergoing cesarean
                                                                                section<br />
                                                                                <small><i>Manisha Poudel</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>10:28 AM – 10:40 AM</b> - A
                                                                                Randomized Comparative Study of Pudendal
                                                                                Nerve Block with Bupivacaine Alone and
                                                                                Bupivacaine with Methylene Blue for
                                                                                Postoperative Analgesia in Perianal
                                                                                Surgery<br />
                                                                                <small><i>Saurav Raj
                                                                                        Khatiwada</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>10:40 AM – 10:52 AM</b> -
                                                                                Intraoperative magnesium sulphate for
                                                                                post-operative pain in patients
                                                                                undergoing total abdominal hysterectomy
                                                                                under general anesthesia<br />
                                                                                <small><i>Priyanka Dahal</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>10:52 AM – 11:00 AM</b> - Break<br />
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Resident Session 3 -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-104">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-104"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-104">
                                                                        <div class="title-text">
                                                                            <b>National Resident Session 2</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                11:00 AM to 12:12 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-104"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-104"
                                                                    data-bs-parent="#innerAccordion-0-4">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>11:00 AM – 11:12 AM</b> -
                                                                                Preoperative Ultrasound Measurement of
                                                                                Lateral Parapharyngeal Wall Thickness
                                                                                (LPWT) To Predict Difficult Bag and Mask
                                                                                Ventilation<br />
                                                                                <small><i>Yashoda Khadka</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>11:12 AM – 11:24 AM</b> - Study of
                                                                                Depth of Skin to Subarachnoid Space
                                                                                Depth in Parturient in Tertiary
                                                                                Hospital<br />
                                                                                <small><i>Pankaj Dhungana</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>11:24 AM – 11:36 AM</b> -
                                                                                Effectiveness of Leg Elevation to
                                                                                Prevent Spinal Anesthesia-Induced
                                                                                Hypotension During Cesarean
                                                                                Section<br />
                                                                                <small><i>Sumit Paudel</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>11:36 AM – 11:48 AM</b> - The effect
                                                                                of passive leg elevation on the size of
                                                                                the internal jugular vein<br />
                                                                                <small><i>Dipak Shrestha</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>11:48 AM – 12:00 PM</b> - Measurement
                                                                                of Dural Sac Diameter and Its Effect on
                                                                                Subarachnoid Block<br />
                                                                                <small><i>Bikash Pandit</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>12:00 PM – 12:12 PM</b> -
                                                                                Preoperative Assessment of Gastric
                                                                                Content by Ultrasound in Fasted Patients
                                                                                Before Elective Laparoscopic
                                                                                Cholecystectomy: An Observational
                                                                                Study<br />
                                                                                <small><i>Nitendra
                                                                                        Bajracharya</i></small>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- General Session -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-100">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-100"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-100">
                                                                        <div class="title-text">
                                                                            <b>General Session</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                13:00 PM to 14:30 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-100"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-100"
                                                                    data-bs-parent="#innerAccordion-0-4">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>13:00 PM – 13:15 PM</b> - Laryngeal
                                                                                Mask Airway for Airway Management in
                                                                                Ex-Preterm Infants Undergoing Procedures
                                                                                for Retinopathy of Prematurity Under
                                                                                General Anaesthesia: A Single-Arm
                                                                                Clinical Trial<br />
                                                                                <small><i>Ram Singh</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>13:15 PM – 13:30 PM</b> - One Lung
                                                                                Ventilation for Robotic Left Hemithorax
                                                                                Pseudocyst Excision &
                                                                                Decortication<br />
                                                                                <small><i>Praveen Benjamin
                                                                                        Dennis</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>13:30 PM – 13:45 PM</b> - The Golden
                                                                                Treasure: New cellular Biomarker using
                                                                                immune fluorescence flow cytometry for
                                                                                diagnosis and monitoring of Anemia,
                                                                                inflammation, and infection<br />
                                                                                <small><i>Christian Honemann</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>13:45 PM – 14:00 PM</b> - Remimazolam
                                                                                ameliorates autism spectrum disorder via
                                                                                suppression of GPX4-dependent
                                                                                ferroptosis in VTA dopaminergic
                                                                                neurons<br />
                                                                                <small><i>Yuxin Zhang</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>14:00 PM – 14:15 PM</b> -
                                                                                Sevoflurane-induced neurotoxicity and
                                                                                protective effect of melatonin in
                                                                                neonatal rats<br />
                                                                                <small><i>Duygu Kara</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>14:15 PM – 14:30 PM</b> - Q and
                                                                                A<br />
                                                                            </li>
                                                                            <li>Break</li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-102">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-102"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-102">
                                                                        <div class="title-text">
                                                                            <b> National Resident Session 3</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                14:45 PM to 15:45 PM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-102"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-102"
                                                                    data-bs-parent="#innerAccordion-0-4">
                                                                    <div class="accordion-body">
                                                                        <ul>
                                                                            <li>
                                                                                <b>14:45 PM – 14:57 PM</b> -
                                                                                Sternomental displacement as a predictor
                                                                                of difficult laryngoscopy: an
                                                                                observational study<br />
                                                                                <small><i>Barsha Karki</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>14:57 PM – 15:09 PM</b> - A
                                                                                prospective study of preoperative
                                                                                fasting duration and associated factors
                                                                                in pediatric patients undergoing
                                                                                elective surgery<br />
                                                                                <small><i>Sandeep Khatri</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>15:09 PM - 15: 21 PM</b> - Effects of
                                                                                Dexamethasone as Adjuvant to Ropivacaine
                                                                                in Supraclavicular Brachial Plexus
                                                                                Block<br />
                                                                                <small><i>Pooja Pandeya</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>15: 21 PM - 15: 33 PM</b> - Incidence
                                                                                and Risk Factors for Delirium in
                                                                                Patients Admitted to Intensive Care Unit
                                                                                in a Tertiary Level Teaching Hospital in
                                                                                Nepal<br />
                                                                                <small><i>Rabi Paudel</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>15: 33 PM - 15: 45 PM</b> - Efficiency
                                                                                of Blood Utilization in Elective
                                                                                Surgical Patients in Tribhuvan
                                                                                University Teaching Hospital<br />
                                                                                <small><i>Pushkar
                                                                                        Bishwokarma</i></small>
                                                                            </li>

                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="content-0-b5" role="tabpanel"
                                                        aria-labelledby="tab-0-b5">
                                                        <div class="accordion mt-3" id="innerAccordion-0-5">
                                                            <!-- Session 1 -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-105">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-105"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-105">
                                                                        <div class="title-text">
                                                                            <b> Faculty Poster Session </b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                08:30 AM to 10:00 AM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-105"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-105"
                                                                    data-bs-parent="#innerAccordion-0-5">
                                                                    <div class="accordion-body">
                                                                        <!-- Screen 1 -->
                                                                        <p><b>Screen 1</b></p>
                                                                        <ul>

                                                                            <li>
                                                                                Emergence delirium in children
                                                                                undergoing day care procedures<br />
                                                                                <small><i>Madhavi Desai</i></small>
                                                                            </li>
                                                                            <li>
                                                                                Pneumonectomy in a Child due to
                                                                                Recurrent Endobronchial Tuberculosis: A
                                                                                Case Report<br />
                                                                                <small><i>Neyziel De Guzman
                                                                                        Mardo</i></small>
                                                                            </li>
                                                                            <li>
                                                                                Approaches to Airway Management in
                                                                                Tracheoesophageal Fistula: Challenges
                                                                                and Strategies<br />
                                                                                <small><i>Neha Garg</i></small>
                                                                            </li>
                                                                        </ul>

                                                                        <!-- Screen 2 -->
                                                                        <p><b>Screen 2</b></p>
                                                                        <ul>
                                                                            <li>
                                                                                A Prospective Comparison of
                                                                                Respiratory Mechanics Changes between
                                                                                Intraluminal and Extraluminal Placement
                                                                                of the 5-French Bronchial Blocker in
                                                                                Children under Mechanical
                                                                                Ventilation<br />
                                                                                <small><i>Rong Wei</i></small>
                                                                            </li>
                                                                            <li>
                                                                                Incidence of perioperative respiratory
                                                                                events in children with upper
                                                                                respiratory tract infections<br />
                                                                                <small><i>Darunee
                                                                                        Sripadungkul</i></small>
                                                                            </li>
                                                                            <li>
                                                                                Effectiveness of systemic transdermal
                                                                                diclofenac patch for postoperative pain
                                                                                management in children<br />
                                                                                <small><i>Takahiro Tasaki</i></small>
                                                                            </li>
                                                                            <li>
                                                                                Pulmonary hydatid cyst and
                                                                                intraoperative blockage of endobronchial
                                                                                tube: A case report<br />
                                                                                <small><i>Anjali Poudel</i></small>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Resident Session -->
                                                            <div class="accordion-item collapsed">
                                                                <h2 class="accordion-header" id="session-106">
                                                                    <button
                                                                        class="collapsed d-flex justify-content-between align-items-center"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#session-collapse-106"
                                                                        aria-expanded="true"
                                                                        aria-controls="session-collapse-106">
                                                                        <div class="title-text">
                                                                            <b> International Resident Session</b><br />
                                                                        </div>
                                                                        <div class="d-flex align-items-center ms-auto">
                                                                            <span class="session-time">
                                                                                10:00 AM to 10:30 AM
                                                                            </span>
                                                                            <span class="material-symbols-outlined">
                                                                                keyboard_arrow_down
                                                                            </span>
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="session-collapse-106"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="session-106"
                                                                    data-bs-parent="#innerAccordion-0-5">
                                                                    <div class="accordion-body">
                                                                        <!-- Screen 3 -->
                                                                        <p><b>Screen 3</b></p>
                                                                        <ul>
                                                                            <li>
                                                                                <b>10:00 AM - 10:10 AM</b> - Novel Positive
                                                                                Pressure Technique for
                                                                                Left-Sided DLT Insertion in Challenging
                                                                                Airway with Intermittent Bronchial
                                                                                Collapse<br />
                                                                                <small><i>Amisha Maroo</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>10:10 AM - 10:20 AM</b>- An early
                                                                                experience of nasal
                                                                                extraglottic airway device in pediatric
                                                                                patients undergoing oral surgery – A
                                                                                case series<br />
                                                                                <small><i>Salma Suman P</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>10:20 AM - 10:30 AM</b>- Tubeless airway
                                                                                surgery for type 2
                                                                                laryngeal cleft repair: combating the
                                                                                challenges<br />
                                                                                <small><i>Achinthya Roopa
                                                                                        Arul</i></small>
                                                                            </li>
                                                                        </ul>

                                                                        <!-- Screen 4 -->
                                                                        <p><b>Screen 4</b></p>
                                                                        <ul>
                                                                            <li>
                                                                                <b>10:00 AM - 10:10 AM</b> - Application of
                                                                                Enhanced Recovery
                                                                                Protocols (ERPs) in Thoracoscopic
                                                                                Mediastinal Mass Resection Surgery for
                                                                                Pediatric Patients: a pilot study<br />
                                                                                <small><i>Heqi Liu</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>10:10 AM - 10:20 AM</b>- Case of
                                                                                uncorrected Tetralogy of
                                                                                Fallot with Pulmonary atresia with Major
                                                                                Aorto Pulmonary Collaterals for
                                                                                Non-cardiac surgery<br />
                                                                                <small><i>Soumya Ranjan
                                                                                        Sahoo</i></small>
                                                                            </li>
                                                                            <li>
                                                                                <b>10:20 AM - 10:30 AM</b>- Effect Of I:E
                                                                                Optimization And
                                                                                Prolonged End Inspiratory Pause To
                                                                                Prevent Post-Operative Lung Atelectasis
                                                                                And Pulmonary Complications In Adults
                                                                                Undergoing Major Upper Abdominal
                                                                                Surgery: A Randomized Controlled
                                                                                Trial<br />
                                                                                <small><i>Amisha Maroo</i></small>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <style type="text/css">
        .accordion-item {}

        .title-text {
            font-size: 15px;
            text-align: left;
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs.nav-link {
            border-radius: 10px !important;
            background: #FF6354;
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            background: #FF6354 !important;
            color: #fff !important;
        }

        .accordion-body {
            margin-top: 0px !important;
            padding-top: 0px !important;
        }

        .accordion-body ul {
            padding: 0px;
        }

        .accordion-body ul li {
            padding: 10px 20px;
            background: #fff;
            list-style: none;
            color: #26268e;
            border-radius: 10px;
        }

        .accordion-body ul li b {
            background: #26268e;
            color: #fff;
            font-size: 12px;
            font-weight: normal;
            padding: 2px 2px 2px 5px;
            margin-right: 4px;
        }

        .accordion-body ul li small i {
            color: #FF6354;
        }

        .accordion-body ul li.nav-item {
            padding: 0px;
            font-weight: bold;
            margin-left: 0px;
            margin-right: 5px;
            border-radius: 10px !important;
        }

        .accordion-body ul li.nav-item a {
            color: #fff !important;
            padding: 8px 20px !important;
            border-radius: 10px !important;
            overflow: hidden !important;
            background-color: #26268e;
        }

        .accordion-button {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: left;
        }

        .accordion-button .ms-auto {
            display: flex;
            align-items: center;

        }

        .session-time {
            margin-right: 8px;
            font-size: 14px;
            color: #555;

        }

        .accordion-item.collapsed {
            background-color: rgba(38, 38, 142, 0.1) !important;

        }

        .accordion-arrow {
            transform: rotate(0deg);
            transition: transform 0.3s ease;

        }


        .accordion-button:not(.collapsed) .accordion-arrow {
            transform: rotate(180deg);
        }

        .nav-link.full-background {
            background-color: #007bff;

            color: #fff !important;
        }
    </style>


    <!-- Bootstrap JS -->
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>-->

    <script>
        function exportAllTabs() {
            const {
                jsPDF
            } = window.jspdf;
            const tabs = document.querySelectorAll(".tab-pane");

            tabs.forEach((tab) => {
                const tabId = tab.id;
                const tabName = document.querySelector(`a[href="#${tabId}"]`).innerText.trim();

                // Extract Hall Name from the tab (assuming it has a class "hall-name")
                const hallElement = tab.querySelector(".hall-name");
                const hallName = hallElement ? hallElement.innerText : null; // If no hall name, set to null

                // Temporarily show tab content
                tab.classList.add("show", "active");

                // Expand collapsed sections
                const collapses = tab.querySelectorAll(".collapse");
                collapses.forEach(collapse => collapse.classList.add("show"));

                // Wait for UI changes, then generate PDF
                setTimeout(() => {
                    html2canvas(tab, {
                        scale: 2
                    }).then(canvas => {
                        const imgData = canvas.toDataURL("image/png");

                        // Create PDF with multiple pages support
                        const pdf = new jsPDF({
                            orientation: "p",
                            unit: "mm",
                            format: "a4"
                        });

                        let imgWidth = 190;
                        let imgHeight = (canvas.height * imgWidth) / canvas.width;
                        const pageHeight = 297; // A4 height in mm
                        let position = 10;

                        // Add Hall Name at the top of the PDF if it exists
                        if (hallName) {
                            pdf.setFontSize(12);
                            pdf.text(`Hall: ${hallName}`, 10,
                            position); // Hall name at the top of the page
                            position += 10; // Adjust position for the next content
                        }

                        // Add Tab Name below the Hall Name
                        pdf.setFontSize(14);
                        pdf.text(tabName, 10, position); // Tab name below Hall name
                        position += 10; // Adjust position for the next content

                        // Calculate if content will fit on one page or needs to be split across multiple pages
                        if (imgHeight > pageHeight - position) {
                            let heightLeft = imgHeight;
                            pdf.addImage(imgData, "PNG", 10, position, imgWidth, imgHeight);
                            heightLeft -= (pageHeight -
                            position); // Subtract the space left on the first page
                            position = pageHeight;

                            // Add more pages for remaining content
                            while (heightLeft > 0) {
                                pdf.addPage();
                                position = 10; // Reset position for the new page
                                pdf.addImage(imgData, "PNG", 10, position, imgWidth, imgHeight);
                                heightLeft -=
                                pageHeight; // Subtract the full page height after adding content
                            }
                        } else {
                            // If content fits on a single page, add the image directly
                            pdf.addImage(imgData, "PNG", 10, position, imgWidth, imgHeight);
                        }

                        // Save the PDF with the Hall Name or Tab Name
                        pdf.save(`${hallName || tabName}.pdf`);
                    });

                    // Restore original collapsed state
                    collapses.forEach(collapse => collapse.classList.remove("show"));
                    tab.classList.remove("show", "active");

                }, 500); // Allow time for rendering before capture
            });
        }
    </script>
@endsection
