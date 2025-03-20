<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scientific Sessions</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .session {
            margin-bottom: 10px;
        }

        .category {
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }

        .time {
            font-size: 14px;
            color: gray;
        }
    </style>
</head>

<body>
    @php
        $latestConference = App\Models\Conference::latestConference();
        $startDate = \Carbon\Carbon::parse($latestConference->start_date);
        $endDate = \Carbon\Carbon::parse($latestConference->end_date);
        $dates = [];
        while ($startDate->lte($endDate)) {
            $dates[] = $startDate->toDateString();
            $startDate->addDay();
        }
        $currentDate = \Carbon\Carbon::parse($date);
        $dayNumber = array_search($currentDate->toDateString(), $dates) + 1;
    @endphp
    <div class="category-section">

        <div style="text-align: center; margin-bottom: 40px;">
            <h2 style="color: black; font-weight: bold; font-size: 24px;">Scientific Session Day {{ $dayNumber }}</h2>
            <h2 style="color: #CD5C5C; font-weight: bold; font-size: 32px; margin-bottom: 20px;">
                {{ $hall->hall_name }} -
                {{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</h2>
        </div>

        @foreach ($sessions as $category_id => $categorySessions)
            <table
                style="width: 100%; border: 2px solid #9d9d9d; border-radius: 8px; margin-bottom: 30px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                <thead>
                    <tr
                        style="background-color: #E6E6FA; color: black; text-align: left; border-top-left-radius: 8px; border-top-right-radius: 8px;">
                        <th style="padding: 15px; width: 70%; font-size: 18px; font-weight: 300;">
                            {{ $categorySessions->first()->category->category_name }}
                        </th>
                        <th
                            style="padding: 15px; width: 40%; text-align: right; font-size: 16px; font-weight: 300; padding-right: 30px;">
                            <span
                                style="background-color: #E6E6FA; color: black; padding: 5px 10px; border-radius: 5px;">
                                {{ $categorySessions->first()->category->duration }}
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if (
                        $categorySessions->first()->category->moderator ||
                            $categorySessions->first()->category->chairperson ||
                            $categorySessions->first()->category->co_chairperson)
                        <tr>
                            <td colspan="2" style="background-color: #f8f9fa;">
                                @if ($categorySessions->first()->category->moderator)
                                    <span
                                        style="font-size: 14px; color: #CD5C5C; font-style: italic;"><strong>Moderator:</strong>
                                        {{ $categorySessions->first()->category->moderator }}</span>
                                @endif
                                @if ($categorySessions->first()->category->chairperson)
                                    <span
                                        style="font-size: 14px; color: #CD5C5C; font-style: italic;"><strong>Chairperson:</strong>
                                        {{ $categorySessions->first()->category->chairperson }}</span>
                                @endif
                                @if ($categorySessions->first()->category->co_chairperson)
                                    <span
                                        style="font-size: 14px; color: #CD5C5C; font-style: italic;"><strong>Co-chairperson:</strong>
                                        {{ $categorySessions->first()->category->co_chairperson }}</span>
                                @endif
                            </td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="2" style="padding: 10px; border-top: 2px solid #9d9d9d;"></td>
                    </tr>
                    <!-- Inner Sessions -->
                    @foreach ($categorySessions as $session)
                        <tr style="border-top: 1px solid #ddd;">
                            <td style="padding: 15px; width: 80%; font-weight: bold; font-size: 16px;">
                                {{ $session->topic }}
                                @if ($session->participants)
                                    <br>
                                    <small style="color: #CD5C5C; font-style: italic; font-size: 12px;">Presenter:
                                        {{ trim($session->participants, '"') }}</small>
                                @endif
                            </td>
                            <td
                                style="padding: 15px; width: 20%; text-align: right; font-size: 16px; font-weight: 600;">
                                <span
                                    style="background-color: white; color: black; padding: 5px 10px; border-radius: 5px;">
                                    <small>{{ $session->duration }}</small>
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
</body>

</html>
<style>
    /* Overall Styling */
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #333;
        margin: 0;
        padding: 0;
    }

    h2,
    h3 {
        margin: 0;
        padding: 0;
    }

    /* Heading styles */
    h2 {
        font-size: 32px;
        color: #28a745;
        margin-bottom: 20px;
    }

    h3 {
        color: #ADD8E6;
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    /* Category Card */
    table {
        width: 100%;
        border: 2px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    table thead {
        background-color: #007bff;
        color: white;
        font-weight: 600;
    }

    table th {
        padding: 15px;
        font-size: 18px;
    }

    table td {
        padding: 15px;
        font-size: 16px;
    }

    table tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    /* Session info */
    table tbody tr {
        border-top: 1px solid #ddd;
    }

    table tbody td {
        padding: 15px;
        color: #343a40;
    }

    /* Badge styles */
    span {
        padding: 5px 10px;
        border-radius: 5px;
    }

    /* Responsive Design */
    @media print {
        body {
            padding: 0;
            font-size: 12px;
        }

        h2,
        h3 {
            text-align: center;
        }

        table th,
        table td {
            padding: 8px;
        }
    }

    /* Ensure categories do not break across pages */
    .category-section {
        page-break-inside: avoid;
        margin-bottom: 20px;
    }

    /* Prevent table rows from splitting */
    tr {
        page-break-inside: avoid;
    }

    /* If content still breaks, apply this to the entire table */
    table {
        page-break-inside: avoid;
    }
</style>
