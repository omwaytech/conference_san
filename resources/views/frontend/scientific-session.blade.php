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
    <!-- Search Button -->
    {{-- <button class="btn btn-primary mt-4" data-bs-toggle="modal" data-bs-target="#searchModal">
        Search Scientific Sessions
    </button> --}}

    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">Search Scientific Sessions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" id="searchInput" class="form-control" placeholder="Enter topic to search..."
                        onkeyup="searchSessions()">

                    <div id="searchResults" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function searchSessions() {
            let query = document.getElementById('searchInput').value.toLowerCase();
            let resultsContainer = document.getElementById('searchResults');
            resultsContainer.innerHTML = ''; // Clear previous results

            let allHalls = @json($halls); // Convert PHP data to JavaScript

            let foundSessions = [];

            allHalls.forEach(hall => {
                // Ensure scientific_session exists before iterating
                if (hall.scientific_session && Array.isArray(hall.scientific_session)) {
                    hall.scientific_session.forEach(session => {
                        if (session.topic && session.topic.toLowerCase().includes(query)) {
                            foundSessions.push(session);
                        }
                    });
                }
            });

            if (foundSessions.length === 0) {
                resultsContainer.innerHTML = '<p class="text-muted">No sessions found.</p>';
            } else {
                foundSessions.forEach(session => {
                    let sessionHTML = `
                    <div class="card mb-2">
                        <div class="card-body">
                            <h5 class="card-title">${session.topic}</h5>
                            <p class="card-text"><strong>Duration:</strong> ${session.duration}</p>
                            ${session.category ? `<p class="card-text"><strong>Category:</strong> ${session.category.category_name}</p>` : ''}
                        </div>
                    </div>
                `;
                    resultsContainer.innerHTML += sessionHTML;
                });
            }
        }
    </script>


    <div class="rts-section-gapBottom rts-blog-area-one">
        <div class="container">
            <div class="row g-48 mt--0 justify-content-sm-center justify-content-md-start">
                <div class="block_1">
                    <div class="schedule-warp">
                        @foreach ($dates as $dateIndex => $date)
                            <div class="col-lg-12">
                                <div class="accordion-faq-area-border-bottom-style style-four">
                                    <div class="accordion" id="accordionExample-{{ $dateIndex }}">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="heading-{{ $dateIndex }}">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse-{{ $dateIndex }}" aria-expanded="false"
                                                    aria-controls="collapse-{{ $dateIndex }}">
                                                    <div style="font-size:20px">
                                                        Day {{ $loop->index + 1 }}
                                                    </div>
                                                    <div class="d-flex align-items-center ms-auto">
                                                        <span class="session-time">
                                                            {{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}
                                                        </span>
                                                    </div>
                                                </button>
                                            </h2>
                                            <div id="collapse-{{ $dateIndex }}" class="accordion-collapse collapse show"
                                                aria-labelledby="heading-{{ $dateIndex }}">
                                                <div class="accordion-body">

                                                    <!-- Navigation Tabs -->
                                                    <ul class="nav nav-tabs" role="tablist"
                                                        id="hallTabs-{{ $dateIndex }}">
                                                        @foreach ($halls as $hallIndex => $hall)
                                                            <li class="nav-item">
                                                                <a class="nav-link @if ($loop->first) active @endif"
                                                                    id="tab-{{ $dateIndex }}-{{ $hallIndex }}"
                                                                    data-bs-toggle="tab"
                                                                    href="#content-{{ $dateIndex }}-{{ $hallIndex }}"
                                                                    role="tab"
                                                                    aria-controls="content-{{ $dateIndex }}-{{ $hallIndex }}"
                                                                    aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                                    {{ $hall['hall_name'] }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>

                                                    <div class="tab-content mt-3">
                                                        @foreach ($halls as $hallIndex => $hall)
                                                            <div class="tab-pane fade @if ($loop->first) show active @endif"
                                                                id="content-{{ $dateIndex }}-{{ $hallIndex }}"
                                                                role="tabpanel"
                                                                aria-labelledby="tab-{{ $dateIndex }}-{{ $hallIndex }}">
                                                                <div class="text-start">
                                                                    <a href="{{ route('front.export.pdf', ['hall_id' => $hall->id, 'date' => $date]) }}"
                                                                        class="btn btn-lg btn-success" target="_blank">
                                                                        Export PDF for {{ $hall->hall_name }}
                                                                    </a>
                                                                </div>
                                                                @foreach ($hall->scientificSession->where('day', $date)->sortBy(fn($session) => \Carbon\Carbon::createFromFormat('h:ia', $session->time))->groupBy('category_id') as $category_id => $sessions)
                                                                    {{-- @dd($sessions) --}}
                                                                    <div class="accordion mt-3"
                                                                        id="innerAccordion-{{ $dateIndex }}-{{ $hallIndex }}">
                                                                        <div class="accordion-item collapsed">
                                                                            <h2 class="accordion-header"
                                                                                id="category-{{ $dateIndex }}-{{ $hallIndex }}-{{ $category_id }}">
                                                                                <button
                                                                                    class="collapsed d-flex justify-content-between align-items-center"
                                                                                    type="button" data-bs-toggle="collapse"
                                                                                    data-bs-target="#category-collapse-{{ $dateIndex }}-{{ $hallIndex }}-{{ $category_id }}"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="category-collapse-{{ $dateIndex }}-{{ $hallIndex }}-{{ $category_id }}">
                                                                                    <div class="title-text">
                                                                                        {{ $sessions->first()->category->category_name }}

                                                                                        @if ($sessions->first()->category->moderator)
                                                                                            <br />Moderators:
                                                                                            <small>
                                                                                                <i>{{ $sessions->first()->category->moderator }}</i>
                                                                                            </small>
                                                                                        @endif
                                                                                        @if ($sessions->first()->category->co_chairperson)
                                                                                            <br />Co-chairperson:
                                                                                            <small>
                                                                                                <i>{{ $sessions->first()->category->co_chairperson }}</i>
                                                                                            </small>
                                                                                        @endif
                                                                                        @if ($sessions->first()->category->chairperson)
                                                                                            <br />Chairperson:
                                                                                            <small>
                                                                                                <i>{{ $sessions->first()->category->chairperson }}</i>
                                                                                            </small>
                                                                                        @endif
                                                                                    </div>
                                                                                    <div
                                                                                        class="d-flex align-items-center ms-auto">
                                                                                        <span class="session-time">
                                                                                            {{ $sessions->first()->category->duration }}
                                                                                        </span>
                                                                                        <span
                                                                                            class="material-symbols-outlined">
                                                                                            keyboard_arrow_down
                                                                                        </span>

                                                                                    </div>
                                                                                </button>
                                                                            </h2>
                                                                            <div id="category-collapse-{{ $dateIndex }}-{{ $hallIndex }}-{{ $category_id }}"
                                                                                class="accordion-collapse collapse"
                                                                                aria-labelledby="category-{{ $dateIndex }}-{{ $hallIndex }}-{{ $category_id }}"
                                                                                data-bs-parent="#innerAccordion-{{ $dateIndex }}-{{ $hallIndex }}">
                                                                                <div class="accordion-body">
                                                                                    @if ($hall->id == 6)
                                                                                        @foreach ($sessions->groupBy('screen') as $screen => $screenSessions)
                                                                                            <div class="screen-info">
                                                                                                <p>{{ $screen }}
                                                                                                </p>
                                                                                                <ul>
                                                                                                    @foreach ($screenSessions as $session)
                                                                                                        <li>
                                                                                                            <b>{{ $session->duration }}</b>
                                                                                                            -
                                                                                                            {{ $session->topic }}</br>
                                                                                                            @if ($session->participants)
                                                                                                                <small>
                                                                                                                    <i>{{ trim($session->participants, '"') }}</i>
                                                                                                                </small>
                                                                                                            @endif
                                                                                                        </li>
                                                                                                    @endforeach
                                                                                                </ul>
                                                                                            </div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <ul>
                                                                                            @foreach ($sessions as $session)
                                                                                                <li>
                                                                                                    <b>{{ $session->duration }}</b>
                                                                                                    -
                                                                                                    {{ $session->topic }}</br>
                                                                                                    @if ($session->participants)
                                                                                                        <small>
                                                                                                            <i>{{ trim($session->participants, '"') }}</i>
                                                                                                        </small>
                                                                                                    @endif
                                                                                                </li>
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @foreach ($dates as $date)
        <div>
            <h3>
                DAY {{ $loop->index + 1 }}:
                {{ \Carbon\Carbon::parse($date)->format('Y-m-d') }}
            </h3>
            @foreach ($halls as $hall)
                <div class="row">
                    <span>
                        <h4>{{ $hall->hall_name }}</h4>
                    </span>
                    @foreach ($sessions as $session)
                        <div class="row">
                            <span>-{{ $session->topic }}</span>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    @endforeach --}}

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
