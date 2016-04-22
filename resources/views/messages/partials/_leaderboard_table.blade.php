<h2 class="heading -banner">Leaderboard</h2>

<table class="table">
    <thead>
        <tr class="table__header">
            <th class="table__cell">Rank</th>
            <th class="table__cell">Name</th>
            <th class="table__cell">Quantity</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($leaderboard as $user)
            <tr class="table__row">
                <td class="table__cell">{{ $user['rank'] }}</td>
                <td class="table__cell">{{ $user['first_name'] or 'Anonymous' }} {{ $user['last_initial'] or '' }}</td>
                <td class="table__cell">{{ $user['reportback']['quantity'] or 'n/a' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>