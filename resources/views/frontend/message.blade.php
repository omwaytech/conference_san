@extends('layouts.front')

@section('content')
    <div class="single-case-studies-bread-crumb-area area-2 pt--20 pb--40" style="border-top:#9699AF 1px solid;">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-inner">
                        <div class="pagimation">
                            <a href="{{ route('front.index') }}">Home</a><i class="fa-regular fa-chevron-right"></i>

                            <a href="#" class="current">Message</a>
                        </div>
                        <h2 class="title split-collab" style="font-size:50px; font-weight:none;">Message</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="">
        <div class="message-card">
            <div class="d-flex flex-column align-items-center text-center">
                <img src="https://conference.san.org.np/storage/users/173592013524.jpg" alt="Prof. Vrushali Ponde" class="profile-pic mb-3">
                <h2 class="message-header">Welcome to SANCON-ASPA 2025 Conference</h2>
            </div>
            <h4 class="welcome-text mt-3" >
                Dear friends,
            </h4>
            <p class="welcome-text">
                I warmly welcome each of you to join us at the SANCON-ASPA 2025 conference in Kathmandu, Nepal. It is an honor to be part of this amazing community.
            </p>
            <p class="welcome-text">
                ASPA stands as a beacon of teamwork, authenticity, and selflessness. The way we work together, supporting one another with friendship and fun, while remaining seriously dedicated to our vision, is truly remarkable.
            </p>
            <p class="welcome-text">
                ASPA is not just about in-person education; it is a beautiful blend of learning opportunities through webinars, special interest groups, and an unwavering commitment to advancing our field. This makes ASPA one of the most beautifully run organizations, built on a foundation of strong bonds and shared passion for excellence in pediatric anesthesia.
            </p>
            <p class="welcome-text">
                This year, ASPA is celebrating its 25th anniversary, marking a significant milestone in our shared history. It is a moment to reflect on how far we’ve come and look forward to the future with renewed commitment to advancing pediatric anesthesia across Asia and beyond.
            </p>
            <p class="welcome-text">
                As Chairperson of the Asian Society of Pediatric Anesthesia (ASPA), I am deeply fascinated by the field of pediatric anesthesia, which continues to evolve and expand in ways we never imagined. It is truly inspiring to witness how it reaches beyond the operating room to provide care to the most vulnerable patients. The rapid growth and progress of our specialty is a wonder, and I am thrilled to be part of this exciting journey.
            </p>
            <p class="welcome-text">
                This year's scientific program is the culmination of efforts from all of us, with special thanks to Dr. Josephine Tan, Dr. Serpil Ozen, and, of course, Dr. Utsav Acharya, whose contributions have been invaluable.
            </p>
            <p class="welcome-text">
                I look forward to seeing all of you soon in Kathmandu for an enriching and inspiring experience!
            </p>
            <p class="welcome-text text-end">
                In friendship,<br>
                <strong>Dr. Vrushali Ponde</strong><br>
                ASPA scientific chairperson
            </p>
        </div>
    </div>
    <style>
        .message-card {
            background: #f8f9fa;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 30px auto;
            max-width: 1000px;
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }
        .welcome-text {
            color: #343a40;
            font-size: 1.4rem;
            line-height: 1.7;
        }
        .message-header {
            font-weight: bold;
            color: #007bff;
            font-size: 1.5rem;
        }
    </style>
@endsection
