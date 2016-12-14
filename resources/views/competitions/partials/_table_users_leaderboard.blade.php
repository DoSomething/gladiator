<div class="container">
    <div class="wrapper">
        <div class="container__block">
            <h2 class="heading -banner">Leaderboard</h2>

            <table class="table">
                <thead>
                    <tr class="table__header">
                        <th class="table__cell">Rank</th>
                        <th class="table__cell">Name</th>
                        {{-- <th class="table__cell">Email</th> --}}
                        <th class="table__cell">Quantity</th>
                        <th class="table__cell"># Promoted</th>
                        <th class="table__cell"># Approved</th>
                        <th class="table__cell"># Excluded</th>
                        <th class="table__cell"># Flagged</th>
                        <th class="table__cell"># Pending</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($leaderboard as $user)
                        <tr class="table__row">
                            <td class="table__cell">{{ $user->rank }}</td>
                            <td class="table__cell"><a href="{{ route('users.show', $user->northstar_id) }}" target="_blank">{{ $user->first_name or 'Anonymous' }} {{ $user->last_initial or '' }}</a></td>
                            {{-- <td class="table__cell">{{ $user->email or '' }}</td> --}}
                            <td class="table__cell">{{ $user->reportback->quantity or 'n/a' }}</td>
                            <td class="table__cell">{{ $user->reportback->reportback_items->count_by_status['promoted'] or 'n/a' }}</td>
                            <td class="table__cell">{{ $user->reportback->reportback_items->count_by_status['approved'] or 'n/a' }}</td>
                            <td class="table__cell">{{ $user->reportback->reportback_items->count_by_status['excluded'] or 'n/a' }}</td>
                            <td class="table__cell">{{ $user->reportback->reportback_items->count_by_status['flagged'] or 'n/a' }}</td>
                            <td class="table__cell">{{ $user->reportback->reportback_items->count_by_status['pending'] or 'n/a' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
