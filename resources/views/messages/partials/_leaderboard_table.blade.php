<p><strong>Leaderboard</strong></p>

<table class="table">
    <thead>
        <tr class="table__header" style="border-collapse: collapse; width: 100%">
            <th class="table__cell" style="border-bottom: 1px solid #ddd; padding: 10px 10px 10px 0px; text-align: left;">Rank</th>
            <th class="table__cell" style="border-bottom: 1px solid #ddd; padding: 10px 10px 10px 0px; text-align: left;">Name</th>
            <th class="table__cell" style="border-bottom: 1px solid #ddd; padding: 10px 10px 10px 0px; text-align: left;">{{ $reportbackInfo['noun'] . ' ' . $reportbackInfo['verb'] }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leaderboard as $user)
            <tr class="table__row">
                <td class="table__cell" style="border-bottom: 1px solid #ddd; padding: 10px 10px 10px 0px; text-align: left;">{{ $user['rank'] }}</td>
                <td class="table__cell" style="border-bottom: 1px solid #ddd; padding: 10px 10px 10px 0px; text-align: left;">{{ $user['first_name'] or 'Anonymous' }} {{ $user['last_initial'] or '' }}</td>
                <td class="table__cell" style="border-bottom: 1px solid #ddd; padding: 10px 10px 10px 0px; text-align: left;">{{ $user['reportback']['quantity'] or 'n/a' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
