<p><strong>Leaderboard</strong></p>

<table class="table">
    <thead>
        <tr class="table__header" style="border-collapse: collapse; width: 100%">
            <th class="table__cell" style="border-bottom: 1px solid #ddd; padding: 10px">Rank</th>
            <th class="table__cell" style="border-bottom: 1px solid #ddd; padding: 10px">Name</th>
            <th class="table__cell" style="border-bottom: 1px solid #ddd; padding: 10px">{{ $reportbackInfo['noun'] . ' ' . $reportbackInfo['verb'] }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leaderboard as $user)
            <tr class="table__row">
                <td class="table__cell" style="border-bottom: 1px solid #ddd; padding: 10px">{{ $user['rank'] }}</td>
                <td class="table__cell" style="border-bottom: 1px solid #ddd; padding: 10px">{{ $user['first_name'] or 'Anonymous' }} {{ $user['last_initial'] or '' }}</td>
                <td class="table__cell" style="border-bottom: 1px solid #ddd; padding: 10px">{{ $user['reportback']['quantity'] or 'n/a' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
