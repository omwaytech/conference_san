@extends('layouts.dash')


@section('content')
    <div class="container">
        <h2>Submissions</h2>

        <button class="btn btn-success mb-4" id="copy-all-btn">Copy All</button>

        @foreach ($submissions as $submission)
            <div class="card my-4">
                <div class="card-body">
                   
                    <button class="btn btn-primary copy-btn mb-3" data-target="submission-{{ $submission->id }}">Copy</button>
                    {{-- @dd($submission) --}}
                    {{-- <div class="d-flex gap-2">

                        <label>Artical Type:</label>
                        <h5 class="card-title" style="margin-left: 4px;">{{ $submission->presentation_type == 1 ?'Poster':'Oral' }}</h5>
                    </div> --}}
                    <div id="submission-{{ $submission->id }}">
                        <p style="font-size: 25px; font-weight: 700;">
                            {{ $submission->presentation_type == 1 ? 'Poster Submission' : 'Oral Submission' }}</p>
                        <h4 style="font-size: 25px; font-weight: 700;">{{ $submission->topic }}</h4>
                        {{-- <p><strong>Received Date:</strong>
                            {{ \Carbon\Carbon::parse($submission->submitted_date)->format('d M, Y') }}</p>

                        @if ($submission->expert)
                            <p><strong>Reviewer:</strong> {{ $submission->expert->fullName($submission, 'expert') }}</p>
                        @endif --}}

                        {{-- <h4>Authors</h4> --}}
                        @php
                            $names = '';
                            $affiliationList = [];
                            $superscripts = ['¹', '²', '³', '⁴', '⁵', '⁶', '⁷', '⁸', '⁹', '¹⁰', '¹¹', '¹²', '¹³', '¹⁴', '¹⁵', '¹⁶', '¹⁷', '¹⁸', '¹⁹', '²⁰'];

                            // Extend if needed
    
                            $groupedAuthors = $submission->authors->groupBy(['designation', 'institution', 'institution_address']);
                            $duplicatedData = [];
                            $nonDuplicatedData = [];
                            $i = 1;
    
                            foreach ($groupedAuthors as $designationGroup) {
                                foreach ($designationGroup as $institutionGroup) {
                                    foreach ($institutionGroup as $addressGroup) {
                                        foreach ($addressGroup as $record) {
                                            $data = [
                                                'designation' => $record->designation ?? '',
                                                'institution' => $record->institution ?? '',
                                                'institution_address' => $record->institution_address ?? '',
                                                'countValue' => $superscripts[$i-1] ?? $i,
                                            ];
    
                                            if ($addressGroup->count() > 1) {
                                                $duplicatedData[$record->name][] = $data;
                                            } else {
                                                $nonDuplicatedData[$record->name] = $data;
                                            }
                                        }
                                        $i++;
                                    }
                                }
                            }
    
                            $uniqueValues = [];
                            foreach ($duplicatedData as $key => $value) {
                                $names .= $key . ' ' . $value[0]['countValue'] . ', ';
                                if (!in_array($value[0]['countValue'], $uniqueValues)) {
                                    $affiliationList[] = "<strong>{$value[0]['countValue']}</strong> {$value[0]['designation']}, {$value[0]['institution']}, {$value[0]['institution_address']}";
                                    $uniqueValues[] = $value[0]['countValue'];
                                }
                            }
    
                            foreach ($nonDuplicatedData as $key => $value) {
                                $names .= $key . ' ' . $value['countValue'] . ', ';
                                $affiliationList[] = "<strong>{$value['countValue']}</strong> {$value['designation']}, {$value['institution']}, {$value['institution_address']}";
                            }
    
                            $names = rtrim($names, ', ');
                        @endphp
    
                        <p>{!! $names !!}</p>
                        <p>{!! implode('<br>', $affiliationList) !!}</p>

                        <h4 style="font-size: 20px; font-weight: 800">Correspondence</h4>
                        @if ($submission->authors->isNotEmpty())
                            @php $mainAuthor = $submission->authors->first(); @endphp
                            <p><strong>{{ $mainAuthor->name }}</strong></p>
                            <p>{{ $mainAuthor->designation }}</p>
                            <p>{{ $mainAuthor->institution }}</p>
                            <p>{{ $mainAuthor->institution_address }}</p>
                            <p><strong>Email:</strong> {{ $mainAuthor->email }}</p>
                            <p><strong>Phone:</strong> {{ $mainAuthor->phone }}</p>
                        @endif

                        <h4 style="font-size: 20px; font-weight: 800">Abstract</h4>
                        <div>{!! $submission->abstract_content !!}</div>

                        <p><strong style="font-size: 16px; font-weight: 800">Keywords:</strong> {{ $submission->keywords }}</p>

                 
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.copy-btn').forEach(button => {
                button.addEventListener('click', function() {
                    let targetId = this.getAttribute('data-target');
                    let content = document.getElementById(targetId).innerHTML;

                    copyToClipboard(content);
                    this.innerText = "Copied!";
                    setTimeout(() => {
                        this.innerText = "Copy";
                    }, 1500);
                });
            });

            document.getElementById('copy-all-btn').addEventListener('click', function() {
                let allContent = '';
                document.querySelectorAll('[id^="submission-"]').forEach(submission => {
                    allContent += submission.innerHTML + '\n\n';
                });

                copyToClipboard(allContent);
                this.innerText = "All Copied!";
                setTimeout(() => {
                    this.innerText = "Copy All";
                }, 1500);
            });

            function copyToClipboard(content) {
                let tempDiv = document.createElement('div');
                tempDiv.innerHTML = content;
                document.body.appendChild(tempDiv);

                let range = document.createRange();
                range.selectNodeContents(tempDiv);
                let selection = window.getSelection();
                selection.removeAllRanges();
                selection.addRange(range);

                document.execCommand('copy');
                document.body.removeChild(tempDiv);
            }
        });
    </script>
@endsection
